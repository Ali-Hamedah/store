<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Notifications extends Component
{
    public $count;
    public $notifications;
    public $newCount;

    public function __construct()
    {
        $user = Auth::user();
        $this->notifications = $user->unreadNotifications()->latest()->take(4)->get();
        $this->count = $this->notifications->count();
        $this->newCount = $user->unreadNotifications()->count();
    }
    

    public function render()
    {
        return view('components.Dashboard.notifications');
    }
}
