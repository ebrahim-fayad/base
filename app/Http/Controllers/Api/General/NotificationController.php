<?php

namespace App\Http\Controllers\Api\General;

use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Core\NotificationService;
use App\Http\Resources\Api\General\Notifications\NotificationsCollection;

class NotificationController extends Controller
{
    use ResponseTrait;

    public function __construct(private NotificationService $notificationService)
    {
    }

    public function switchNotificationStatus(): JsonResponse
    {

        $data = $this->notificationService->switchNotificationStatus(user: auth()->user());
        return $this->jsonResponse(msg: $data['msg'], data: $data['data']);
    }

    public function getNotifications(): JsonResponse
    {
        $this->notificationService->markAsReadNotifications(user: auth()->user());
        $notifications = $this->notificationService->all(user: auth()->user(), paginateNum: $this->paginateNum());

        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: ['notifications' => new NotificationsCollection($notifications['notifications'])]);
    }

    public function countUnreadNotifications(): JsonResponse
    {
        $data = $this->notificationService->unreadNotificationsCount(user: auth()->user());

        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: ['count' => $data['count']]);
    }

    public function deleteNotification($notification_id): JsonResponse
    {
        $data = $this->notificationService->deleteOne(user: auth()->user(), id: $notification_id);
        return $this->jsonResponse(msg: $data['msg'], data: []);
    }

    public function deleteNotifications(): JsonResponse
    {
        $data = $this->notificationService->deleteAll(user: auth()->user());
        return $this->jsonResponse(msg: $data['msg'], data: []);
    }
}
