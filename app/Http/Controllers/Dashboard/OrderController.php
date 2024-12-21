<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:view order|create order|edit order|delete order'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create order'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update order'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete order'], ['only' => ['destroy']]);
    }

    public function index()
    {
        
        $orders = Order::paginate(10);
        return view('dashboard.orders.index', compact('orders'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
    
        $order_status_array = [
            '0' => 'New order',
            '1' => 'Paid',
            '2' => 'Under process',
            '3' => 'Finished',
            '4' => 'Rejected',
            '5' => 'Canceled',
            '6' => 'Refund requested',
            '7' => 'Returned order',
            '8' => 'Refunded',
        ];

        $key = array_search($order->order_status, array_keys($order_status_array));
        foreach ($order_status_array as $k => $v) {
            if ($k < $key) {
                unset($order_status_array[$k]);
            }
        }

        return view('dashboard.orders.show', compact('order', 'order_status_array'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // if (!auth()->user()->ability('admin', 'update_orders')) {
        //     return redirect('admin/index');
        // }
        $customer = User::find($order->user_id);

        if ($request->order_status == Order::REFUNDED){
            $omniPay = new OmnipayService('PayPal_Express');
            $response = $omniPay->refund([
                'amount' => $order->total,
                'transactionReference' => $order->transactions()->where('transaction', OrderTransaction::PAYMENT_COMPLETED)->first()->transaction_number,
                'cancelUrl' => $omniPay->getCancelUrl($order->id),
                'returnUrl' => $omniPay->getReturnUrl($order->id),
                'notifyUrl' => $omniPay->getNotifyUrl($order->id),
            ]);

            if ($response->isSuccessful()) {
                $order->update(['order_status' => Order::REFUNDED]);
                $order->transactions()->create([
                    'transaction' => OrderTransaction::REFUNDED,
                    'transaction_number' => $response->getTransactionReference(),
                    'payment_result' => 'success'
                ]);

                // $customer->notify(new OrderNotification($order));

                return back()->with([
                    'message' => 'Refunded updated successfully',
                    'alert-type' => 'success',
                ]);

            }

        } else {

            $order->update(['order_status'=> $request->order_status]);

            $order->transactions()->create([
                'transaction' => $request->order_status,
                'transaction_number'=> null,
                'payment_result'=> null,
            ]);

            // $customer->notify(new OrderNotification($order));

            return back()->with([
                'message' => 'updated successfully',
                'alert-type' => 'success',
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
