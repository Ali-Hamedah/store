<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Events\OrderCreated;
use App\Models\ProductVariant;
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
    
        try {
            $cartItems = Cart::all();
            $isSuccess = true;
    
            foreach ($cartItems as $item) {
                $variant = ProductVariant::where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->where('color_id', $item->color_id)
                    ->first();
        
                if ($variant) {
                    if ($variant->quantity >= $item->quantity) {
                        $variant->decrement('quantity', $item->quantity);
                    } else {
                        $productName = $variant->product->name ?? 'غير معروف';
                        $sizeName = $variant->size->name ?? 'غير معروف';
                        $colorName = $variant->color->name ?? 'غير معروف';
                        session()->flash('error', "{$productName} - {$sizeName} - {$colorName} : " . __('messages.quantity_available'));
                        $isSuccess = false;
                        break; 
                    }
                } else {
                    session()->flash('error', __('messages.variant_not_found'));
                    $isSuccess = false;
                    break;
                }
            }
        
            if ($isSuccess) {
                session()->flash('success', __('messages.order_processed_successfully'));
                // Cart::truncate();
                event(new SendOrderEmails($event->order));
            }
    
            DB::commit(); // تأكيد العملية
        } catch (\Exception $e) {
            DB::rollBack(); // إلغاء العملية في حال وجود خطأ
            \Log::error($e->getMessage());
    
            if (config('app.debug')) {
                session()->flash('error', $e->getMessage());
            } else {
                session()->flash('error', __('messages.something_went_wrong'));
            }
        }
    }
    
}
