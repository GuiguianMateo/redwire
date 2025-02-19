<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->get();
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('{{ modelVariable}}.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Notification $notification)
    {
        $notification->update(['is_read' => true]);


        return redirect()->route('notifications.index');
    }

    public function edit(Notification $notification)
    {
        //
    }

    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy(Notification $notification)
    {
        //
    }

    public function markAsRead(Notification $notification) {
        $notification->update(['is_read' => true]);
        return redirect()->route('notifications.index');
    }
}
