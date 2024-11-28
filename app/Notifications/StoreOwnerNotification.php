<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StoreOwnerNotification extends Notification
{
    use Queueable;
    protected $order;
   
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
  
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress;
        $productNames = $this->order->products->pluck('order_item.product_name')->join(', ');
        $store = $this->order->store->pluck('name')->first();
        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->greeting("Hi " .  $store)
            ->line("A new order (#{$this->order->number}) products: {$productNames} created by {$addr->name} from {$addr->country_name}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
