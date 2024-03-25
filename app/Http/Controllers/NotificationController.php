<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Models\User;
use App\Notifications\SendUserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index(){
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/notifications',
                'active' => false
            ],
            [
                'name' => 'Notifications',
                'url' => route('notifications.index'),
                'active' => true
            ],
        ];

        $notifications = DB::table('notifications')
            ->join('users', 'notifications.notifiable_id', '=', 'users.id')
            ->select('notifications.*', 'users.name as user_name')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', [
            'breadcrumbItems' => $breadcrumbsItems,
            'notifications' => $notifications,
            'pageTitle' => 'Notifications'
        ]);
    }

    public function create(){
        $breadcrumbsItems = [
            [
                'name' => 'Notifications',
                'url' => route('notifications.index'),
                'active' => false
            ],
            [
                'name' => 'Create',
                'url' => route('notifications.create'),
                'active' => true
            ],
        ];

        return view('notifications.create', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Notifications'
        ]);
    }

    public function store(Request $request){
        $notificationData = $request->all('message', 'title');

        $users = User::all();

        Notification::send($users, new SendUserNotification($notificationData));

        $data = [
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'sender_id' => Auth::user()->id,
            'created_at' => Carbon::now()->diffForHumans(),
        ];

        event(new PushNotificationEvent($data));

        return redirect()->route('notifications.index')->with('message', 'Notification sent successfully');
    }

    public function update($notificationId){
        auth()->user()->unreadNotifications->where('id', $notificationId)->markAsRead();

        return response()->json(['status' => 'Success']);
    }
}
