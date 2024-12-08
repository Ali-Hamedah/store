<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
