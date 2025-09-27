<?php

namespace App\Http\Controllers;

use App\DataTables\UserNotificationDataTable;
use App\Models\User;
use App\Notifications\UserPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(UserNotificationDataTable $datatable){
        return $datatable->render('notification.index');
    }

    public function notificationForm(Request $request)
    {
        $users = User::where('is_notification',1)->get();

        return view('notification.send', compact('users'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:marketing,invoices,system',
            'text' => 'required|string|max:255',
            'expires_at' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
        ]);
        $notification = new UserPostNotification(
            $validated['type'],
            $validated['text'],
            $validated['expires_at'] ?? null
        );

        if ($validated['user_id']) {
            User::findOrFail($validated['user_id'])->notify($notification);
        } else {
            User::where('is_notification',1)->get()->each(fn($user) => $user->notify($notification));
        }

        return redirect()->back()->with('success', 'Notification sent.');
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications->findOrFail($id);
        $notification->markAsRead();
        return back();
    }
}
