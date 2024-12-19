<?php

namespace App\Listeners;

use App\Models\User;

use App\Events\SendOrderEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StoreOwnerNotification;
use App\Notifications\OrderCreatedNotification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendOrderEmails $event)
    {
        
        //$store = $event->order->store;
        $order = $event->order;

        $admin = User::where('store_id', $order->store_id)->first();
        
        if ($admin) {  
            $admin->notify(new StoreOwnerNotification($order));
        }
        $user = Auth::User();
        if ($user) {
            $user->notify(new OrderCreatedNotification($order));
        }
        // $users = User::where('store_id', $order->store_id)->get();
        // Notification::send($users, new OrderCreatedNotification($order));

    }
}
