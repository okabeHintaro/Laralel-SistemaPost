<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = auth()->user()
        ->notifications()
        ->latest()
        ->get();

    return view('notifications.index', compact('notifications'));
}

public function markAsRead($id)
{
    $notification = Auth::user()->notifications()->findOrFail($id);

    $notification->update(['read' => true]);

    return redirect()->back()->with('success', 'Notificação marcada como lida.');
}

}
