<?php

namespace App\Services\Core;

use App\Jobs\AdminNotify;
use App\Jobs\Notify;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSms;
use App\Models\AllUsers\Admin;
use App\Models\AllUsers\User;
use App\Models\Core\AdminNotificationLog;
use App\Models\PublicSections\Complaint;

class NotificationService
{

    public function send($request): array
    {

        if ($request->user_type === 'all') {
            $recipientsCount = $this->sendNotificationToAll($request);
        } else {
            $rows = $this->getRows($request->user_type, $request->id);
            $recipientsCount = $rows instanceof \Illuminate\Database\Eloquent\Model ? 1 : $rows->count();
            match ($request->type) {
                'notify' => $this->sendNotification($rows, $request->user_type, $request),
                'email' => $this->sendMail($rows, $request),
                'sms' => $this->sendSms($rows->pluck('phone')->toArray(), $request->message ?? $request->body),
                default => $this->sendNotification($rows, $request->user_type, $request),
            };
        }

        $this->logNotification($request, $recipientsCount ?? 0);

        return ['key' => 'success', 'msg' => __('apis.success')];
    }

    protected function sendNotificationToAll($request): int
    {
        $users = User::all();
        $admins = Admin::all();
        dispatch(new Notify($users, $request));
        dispatch(new AdminNotify($admins, $request));
        return $users->count() + $admins->count();
    }

    public function all($user, $paginateNum = 10): array
    {
        $notifications = $user->notifications()->paginate($paginateNum);
        return ['key' => 'success', 'notifications' => $notifications, 'msg' => __('apis.success')];
    }

    protected function getRows($type, $id = null)
    {
        return match ($type) {
            'users' => $id ? User::findOrFail($id) : User::all(),
            'users_with_subscription' => User::whereHas('levelSubscriptions', fn($q) => $q->active())->get(),
            'users_without_subscription' => User::whereDoesntHave('levelSubscriptions', fn($q) => $q->active())->get(),
            'admins' => Admin::where('type', 'admin')->get(),
            default => collect(),
        };
    }

    protected function sendNotification($rows, $type, $request): void
    {
        $rows = $rows instanceof \Illuminate\Database\Eloquent\Model ? collect([$rows]) : $rows;
        $job = $type === 'admins' ? new AdminNotify($rows, $request) : new Notify($rows, $request);
        dispatch($job);
    }

    protected function sendMail($rows, $request): void
    {
        $rows = $rows instanceof \Illuminate\Database\Eloquent\Model ? collect([$rows]) : $rows;
        dispatch(new SendEmailJob($rows->pluck('email'), $request));
    }

    protected function sendSms($phones, $message): void
    {
        dispatch(new SendSms($phones, $message));
    }

    protected function logNotification($request, int $recipientsCount): void
    {
        AdminNotificationLog::create([
            'admin_id' => auth('admin')->id(),
            'type' => $request->type,
            'user_type' => $request->user_type,
            'title_ar' => $request->title_ar ?? null,
            'title_en' => $request->title_en ?? null,
            'body_ar' => $request->body_ar ?? null,
            'body_en' => $request->body_en ?? null,
            'body' => $request->body ?? $request->message ?? null,
            'recipients_count' => $recipientsCount,
        ]);
    }

    public function markAsReadNotifications($user): array
    {
        $notifications = $user->unreadNotifications()->take(50)->get();
        $notifications->markAsRead();
        $notifications->each(fn($notification) => $notification->route = isset($notification->data['class']) ? $this->getRouteName($notification->data) : null);
        return ['key' => 'success', 'notifications' => $notifications, 'msg' => __('apis.success')];
    }

    private function getRouteName($data)
    {
        return match ($data['class']) {
            Complaint::class => route('admin.complaints.show', $data['id']),
            //TODO: add other classes here
            default => null,
        };
    }

    public function unreadNotificationsCount($user): array
    {
        $notificationsCount = $user->unreadNotifications->count();
        return ['key' => 'success', 'count' => $notificationsCount, 'msg' => __('apis.success')];
    }

    public function deleteSelected($user, $request): array
    {
        $requestIds = array_column(json_decode($request->data), 'id');
        $user->notifications()->whereIn('id', $requestIds)->delete();
        return ['msg' => __('apis.deleted'), 'key' => 'success'];
    }

    public function deleteAll($user): array
    {
        $user->notifications()->delete();
        return ['msg' => __('apis.deleted'), 'key' => 'success'];
    }

    public function switchNotificationStatus($user): array
    {
        $user->update(['is_notify' => !$user->is_notify]);
        return ['key' => 'success', 'msg' => __('apis.updated'), 'data' => ['is_notify' => (int)$user->refresh()->is_notify]];
    }

    public function deleteOne($user, $id): array
    {
        $user->notifications()->whereId($id)->delete();
        return ['msg' => __('apis.deleted'), 'key' => 'success'];
    }
}
