<?php

namespace App\Http\Controllers\Api\User\Exercises;

use App\Support\QueryOptions;
use App\Traits\ResponseTrait;
use App\Models\IncentivePoint;
use App\Models\Programs\Level;
use App\Traits\PaginationTrait;
use App\Enums\IncentivePointType;
use App\Models\Programs\Exercise;
use Illuminate\Http\JsonResponse;
use App\Services\Core\BaseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Programs\LevelSubscription;
use App\Facades\BaseService as FacadeBaseService;
use App\Models\Programs\PhysicalActivityCompletion;
use App\Http\Resources\Api\User\DailyActivityResource;
use App\Http\Requests\Api\User\CompleteExerciseRequest;
use App\Http\Resources\Api\User\MyPlanSubscriptionResource;
use Carbon\Carbon;

class MyPlanController extends Controller
{
    use ResponseTrait, PaginationTrait;

    protected $myPlanService;
    public function __construct()
    {
        $this->myPlanService = new BaseService(LevelSubscription::class);
    }

    /**
     * إرجاع كل اشتراكات المستخدم المسجل حالياً (بطاقات خططي كما في الواجهة).
     */
    public function index(): JsonResponse
    {
        $options = (new QueryOptions())
            ->scopes('active')
            ->with(['level'])
            ->latest(true)
            ->conditions(['user_id' => auth('user')->id()]);
        $subscriptions = $this->myPlanService->limit($options);

        return $this->jsonResponse(data: [
            'subscriptions' => MyPlanSubscriptionResource::collection($subscriptions),
            'pagination' => $this->paginationModel($subscriptions),
        ]);
    }

    /**
     * عرض تفاصيل البلان: اليوم الحالي يظهر فقط إذا كان مسموحاً فتحه:
     * - إكمال الأربع تمارين لليوم السابق، وفتح اليوم الجديد في التاريخ اللي بعده فقط (يوم رياضي واحد لكل تاريخ).
     */
    public function show($id): JsonResponse
    {
        $subscription = $this->myPlanService->find($id, with: ['level'], conditions: ['user_id' => auth('user')->id()]);
        $today = Carbon::today();
        $currentDayNumber = min((int) $subscription->completed_days + 1, Level::DURATION_DAYS);

        $dayOpen = $this->isCurrentDayOpenForDate($subscription, $today);
        $subscription->level->loadMissing('days');
        $day = $subscription->level->days()->where('day_number', $currentDayNumber)->with('exercises')->first();

        $dailyActivities = [];
        $day_locked = false;
        $next_day_available_at = null;

        if ($dayOpen && $day) {
            $dailyActivities = DailyActivityResource::collection($day->exercises);
        } else {
            $day_locked = true;
            if ($subscription->completed_days === 0) {
                $next_day_available_at = Carbon::parse($subscription->created_at)->format('Y-m-d');
            } elseif ($subscription->last_completed_day_date) {
                $next_day_available_at = Carbon::parse($subscription->last_completed_day_date)->addDay()->format('Y-m-d');
            } else {
                $next_day_available_at = null;
            }
            // لما اليوم الجديد لسه مقفول، نرجع تمارين آخر يوم اكتمل (مش فاضية)
            $lastCompletedDay = $subscription->completed_days > 0
                ? $subscription->level->days()->where('day_number', $subscription->completed_days)->with('exercises')->first()
                : null;
            if ($lastCompletedDay) {
                $dailyActivities = DailyActivityResource::collection($lastCompletedDay->exercises);
            }
        }

        return $this->jsonResponse(data: [
            'subscription' => new MyPlanSubscriptionResource($subscription),
            'daily_activities' => $dailyActivities,
            'day_locked' => $day_locked,
            'next_day_available_at' => $next_day_available_at,
        ]);
    }

    /**
     * اليوم الحالي (completed_days + 1) مسموح فتحه في التاريخ المعطى فقط إذا:
     * - اليوم 1: من تاريخ بداية الاشتراك.
     * - اليوم 2+: من اليوم التالي لتاريخ إكمال اليوم السابق (لا يوم رياضي ثاني في نفس التاريخ).
     * - اشتراكات قديمة بدون last_completed_day_date: نسمح بالفتح للتوافق مع البيانات السابقة.
     */
    protected function isCurrentDayOpenForDate(LevelSubscription $subscription, Carbon $date): bool
    {
        if ($subscription->completed_days === 0) {
            return $date->isSameDay(Carbon::parse($subscription->created_at)) || $date->isAfter(Carbon::parse($subscription->created_at));
        }
        if (!$subscription->last_completed_day_date) {
            return true; // توافق مع اشتراكات قديمة قبل إضافة الحقل
        }
        $lastDate = Carbon::parse($subscription->last_completed_day_date);
        return $date->isAfter($lastDate);
    }

    /**
     * تسجيل اكتمال تمرين: إضافة نقاط التحفيز. إن اكتملت أنشطة اليوم (4) يحدَّث completed_days.
     */
    public function completionRate(CompleteExerciseRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $subscription = $this->myPlanService->find($request->validated()['id'], with: ['level'], conditions: ['user_id' => auth('user')->id()]);

                $data = $request->validated();
                $serviceClass = FacadeBaseService::setModel(PhysicalActivityCompletion::class);
                $serviceClass->create($data);

                $completedCount = $serviceClass->count((new QueryOptions())
                    ->conditions([
                        'user_id' => auth('user')->id(),
                        'level_id' => $subscription->level_id,
                        'level_day_id' => $data['level_day_id'],
                    ]));

                if ($completedCount >= Exercise::MAX_EXERCISES_PER_DAY) {
                    $subscription->increment('completed_days');
                    $subscription->update(['last_completed_day_date' => Carbon::today()]);
                }

                // تسجيل نقاط التحفيز (إكمال نشاط بدني) — القيمة من الريكويست
                FacadeBaseService::setModel(IncentivePoint::class)->create([
                    'user_id' => auth('user')->id(),
                    'level_id' => $subscription->level_id,
                    'points' => (int) ($data['points_earned'] ?? 0),
                    'type' => IncentivePointType::PhysicalActivity->value,
                ]);

                $subscription->refresh();
                return $this->show($subscription->id);
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
