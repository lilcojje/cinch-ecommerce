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
            'user_id' => 'required|integer',
            'items'   => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity'   => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'total_amount' => $validated['total_amount'],
        ]);

        // Normally you'd also create order_items here
        foreach ($validated['items'] as $item) {
            $order->items()->create($item);
        }

        return response()->json($order, 201);
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
