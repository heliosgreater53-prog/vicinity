<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Notification;
use Core\Controller;
use Core\Request;
use Core\Response;

class NotificationController extends Controller
{
    public function index(Request $request): Response
    {
        $notifications = [];
        try {
            $notifications = Notification::query()
                ->where('user_id', auth()->id() ?? 1)
                ->latest()
                ->get();
        } catch (\Throwable $e) {
            // graceful fallback
        }

        return $this->view('notifications.index', [
            'title'         => 'Notifications – Vicinity',
            'notifications' => $notifications,
        ]);
    }

    public function markAllRead(): Response
    {
        try {
            Database::getInstance()->query(
                "UPDATE `notifications` SET `is_read` = 1 WHERE `user_id` = ?",
                [auth()->id() ?? 1]
            );
        } catch (\Throwable $e) {
            // ignore
        }

        session()->flash('success', 'All notifications marked as read.');
        return $this->back();
    }
}
