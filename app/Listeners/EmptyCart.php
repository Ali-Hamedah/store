<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmptyCart
{
    public $cart;
    /**
     * Create the event listener.
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $this->cart->empty();
    }
}
