<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Events\OrderCreated;
use App\Events\SendOrderEmails;
use Illuminate\Support\Facades\DB;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeductProductQuantity
{
    public $cart;
    public $order;

    public function __construct(CartRepository $cart, Order $order)
    {
        $this->cart = $cart;
        $this->order = $order;
    }


    public function handle(OrderCreated $event): void
    {
        DB::beginTransaction();
        $cartItems = Cart::get();
        $productIds = $cartItems->pluck('product_id')->toArray();

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $isSuccess = true;
        foreach ($cartItems as $item) {
            $product = $products[$item->product_id] ?? null;
            if ($product && $product->quantity >= $item->quantity) {
                $product->decrement('quantity', $item->quantity);

                // $this->cart->empty();
                event(new SendOrderEmails($event->order));
            } else {
                session()->flash('error', "{$product->name} : " . __('messages.quantity_available'));
                $isSuccess = false;
                break;
            }
        }

        if ($isSuccess) {
            session()->flash('success', __('messages.purchase_completed'));
        }
        DB::commit();
    }
}
