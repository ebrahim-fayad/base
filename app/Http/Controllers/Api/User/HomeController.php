<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\UserMainInfoResource;
use App\Services\ActivityProgressService;

class HomeController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function __construct(
        private readonly ActivityProgressService $activityProgressService
    ) {
    }

    public function index(Request $request)
    {
        try {
            return $this->jsonResponse(data: [
                'progress_chart' => $this->getProgressRate($request),
                'user_info' => UserMainInfoResource::make(auth('user')->user()),
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    /**
     * Get activity progress chart data for the authenticated user.
     * Supports range: daily, weekly, monthly, yearly (default: weekly).
     */
    private function getProgressRate(Request $request): array
    {
        $userId = auth('user')->id();
        $range = $request->input('range', 'weekly');

        return $this->activityProgressService->getProgressChart($userId, $range);
    }
}
