<?php

namespace App\Http\Controllers\Api\General;

use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Core\NotificationService;
use App\Http\Resources\Api\General\Notifications\NotificationsResource;
use App\Http\Resources\Api\General\Notifications\NotificationsCollection;

class NotificationController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function __construct(private NotificationService $notificationService)
    {
    }

    public function switchNotificationStatus(): JsonResponse
    {
        $data = $this->notificationService->switchNotificationStatus(user: auth()->user());
        return $this->jsonResponse(msg:$data['msg'], data:$data['data']);
    }

    public function getNotifications(): JsonResponse
    {
        $this->notificationService->markAsReadNotifications(user: auth()->user());
        $notifications = $this->notificationService->all(user: auth()->user(), paginateNum: $this->paginateNum());

        return $this->jsonResponse(data:[
            'notifications' => NotificationsResource::collection($notifications['notifications']),
            'pagination' => $this->paginationModel($notifications['notifications']),
        ]);
    }

    public function countUnreadNotifications(): JsonResponse
    {
        $data = $this->notificationService->unreadNotificationsCount(user: auth()->user());

        return $this->jsonResponse(data:['count' => $data['count']]);
    }

    public function deleteNotification($notification_id): JsonResponse
    {
        $data = $this->notificationService->deleteOne(user: auth()->user(), id: $notification_id);
        return $this->jsonResponse(msg:$data['msg']);
    }

    public function deleteNotifications(): JsonResponse
    {
        $data = $this->notificationService->deleteAll(user: auth()->user());
        return $this->jsonResponse(msg:$data['msg']);
    }
}
