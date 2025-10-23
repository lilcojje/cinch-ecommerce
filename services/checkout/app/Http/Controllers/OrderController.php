<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Create a new order
    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email',
        'total_amount' => 'required|numeric',
        'items' => 'required|array|min:1',
    ]);

    // Generate unique order number
    $lastOrder = Order::orderByRaw('CAST(SUBSTRING(order_number, 5) AS UNSIGNED) DESC')->first();

	$nextNumber = $lastOrder
		? intval(substr($lastOrder->order_number, 4)) + 1
		: 1;

	$orderNumber = 'ORD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

	$order = Order::create([
		'order_number' => $orderNumber,
		'customer_name' => $validated['customer_name'],
		'customer_email' => $validated['customer_email'],
		'total_amount' => $validated['total_amount'],
	]);

    foreach ($validated['items'] as $item) {
        $order->items()->create([
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'subtotal' => $item['subtotal'],
        ]);
    }

    return response()->json([
        'message' => 'Order created successfully',
        'order_number' => $orderNumber,
    ]);
}


    // Get order details
    public function show($id)
    {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
