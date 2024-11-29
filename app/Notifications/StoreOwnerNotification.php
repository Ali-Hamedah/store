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
        return ['database', 'broadcast', 'mail'];

        $channels = ['database'];
        if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;
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

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;

        return [
            'body' => "A new order (#{$this->order->number}) created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
