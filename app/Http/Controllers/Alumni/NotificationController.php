<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, string $id)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return back();
        }

        $notification = DatabaseNotification::query()
            ->where('id', $id)
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', $user->getMorphClass())
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
