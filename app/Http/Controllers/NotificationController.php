<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        if (! request()->ajax()) {
            return redirect()->back()->with('info', 'Acción no válida');
        }
    }

    public function index()
    {
        return [
            'notifications' => auth()->user()->notifications,
            'unreadNotifications' => count(auth()->user()->unreadNotifications),
        ];
    }

    public function read($id)
    {
        DatabaseNotification::find($id)->markAsRead();
        return auth()->user()->notifications;
    }

    public function destroy($id)
    {
        DatabaseNotification::find($id)->delete();
    }
}
