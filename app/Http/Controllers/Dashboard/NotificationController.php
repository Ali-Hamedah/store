<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    
    public function index()#
    {
        DB::table('notifications')->where('id', $id)->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAsRead($id)#
    {
        DB::table('notifications')
        ->where('id', $id)
        ->update(['read_at' =>  now()]);

    }
}
