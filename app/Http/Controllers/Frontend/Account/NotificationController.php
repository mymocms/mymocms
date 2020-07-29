<?php

namespace App\Http\Controllers\Frontend\Account;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index() {
        $user = \Auth::user();
        $notifications = $user->notifications()
            ->paginate(10);
        
        return view('themes.mymo.account.notification.index', [
            'title' => trans('app.notification'),
            'user' => $user,
            'notifications' => $notifications
        ]);
    }
    
    public function detail($id) {
        $user = \Auth::user();
        $notification = $user->notifications()
            ->where('id', '=', $id)
            ->firstOrFail();
        
        return view('themes.mymo.profile.notification.detail', [
            'title' => trans('app.notification'),
            'user' => $user,
            'notification' => $notification
        ]);
    }
}
