<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    public function ReadAll()#
    {
       $user = Auth::user();
       $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    public function markAsRead($id)#
    {
        DB::table('notifications')
        ->where('id', $id)
        ->update(['read_at' =>  now()]);

    }
}
