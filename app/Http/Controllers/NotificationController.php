<?php

namespace App\Http\Controllers;

use App\DataTables\UserNotificationDataTable;
use App\Models\User;
use App\Notifications\UserPostNotification;
use Exception;
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

        try{
            $notification = new UserPostNotification(
                $validated['type'],
                $validated['text'],
                $validated['expires_at'] ?? null
            );

            if ($validated['user_id']) {
                $data = User::findOrFail($validated['user_id'])->notify($notification);
            } else {
                $data = User::where('is_notification',1)->get()->each(fn($user) => $user->notify($notification));
            }
            notify()->success('Notification sent successfully');
        }catch(Exception $e){
            notify()->error($e->getMessage());
        }
        return redirect()->back();
    }

    public function markAllRead()
    {
        try{
            Auth::user()->unreadNotifications->markAsRead();
            notify()->success('All marked notification as read successfully');
        }catch(Exception $e){
            notify()->error($e->getMessage());
        }
        return back();
    }

    public function markAsRead($id)
    {
        try{
            $notification = Auth::user()->notifications->findOrFail($id);
            $notification->markAsRead();
            notify()->success('Notification marked as read successfully');
        }catch(Exception $e){
            notify()->error($e->getMessage());
        }
        return back();
    }
}
