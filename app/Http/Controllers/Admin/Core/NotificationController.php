<?php

namespace App\Http\Controllers\Admin\Core;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Core\Notification\SendRequest;
use App\Models\Core\AdminNotificationLog;
use App\Services\Core\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        return view('admin.notifications.index');
    }

    public function sendNotifications(SendRequest $request)
    {
        $this->notificationService->send($request);
        return response()->json();
    }

    public function log()
    {
        $logs = AdminNotificationLog::with('admin')->latest()->paginate(15);
        return view('admin.notifications.log', compact('logs'));
    }
}
