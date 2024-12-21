<?php

namespace App\Livewire\Front\Customer;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderTransaction;

class OrderComponent extends Component
{
    public $showOrder = false;
    public $order;

    public function displayOrder($id)
    {
        $this->order = Order::with('products')->find($id);

        $this->showOrder = true;
    }

    public function requestReturnOrder($id)
    {
        $order = Order::whereId($id)->first();

        $order->update([
            'order_status' => Order::REFUNDED_REQUEST
        ]);

        $order->transactions()->create([
            'transaction' => OrderTransaction::REFUNDED_REQUEST,
            'transaction_number' => $order->transactions()->whereTransaction(OrderTransaction::PAYMENT_COMPLETED)->first()->transaction_number,
        ]);

        $this->alert('success', 'Your request is sent successfully');
    }


    public function render()
    {
        return view('livewire.front.customer.order-component', [

            'orders' => auth()->user()->orders,
        ]);
    }
}

