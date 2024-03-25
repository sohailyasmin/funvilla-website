<?php

namespace App\Http\ViewComposers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HeaderComposer
{

    public function compose(View $view)
    {
        $notifications = DB::table('notifications')
            ->join('users', 'notifications.notifiable_id', '=', 'users.id')
            ->select('notifications.*', 'users.name as user_name')
            ->orderBy('created_at', 'desc');

        if(Auth::user() && Auth::user()->roles()->first()->id !== 1){
            $notifications->where('users.id', '=', Auth::id());
        }

        $view->with([
           'notifications' => $notifications->limit(1000)->get(),
           'count' => $notifications->whereNull('read_at')->count()
        ]);
    }
}
