<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'customer_name'=>'required|string',
            'customer_email'=>'required|email',
            'items'=>'required|array|min:1',
            'items.*.product_id'=>'required|integer',
            'items.*.quantity'=>'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // compute total and verify stock
            $total = 0;
            $order = Order::create([
                'order_number' => 'ORD-'.Str::upper(Str::random(8)),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'total_amount' => 0
            ]);

            foreach($data['items'] as $it) {
                $prod = Product::lockForUpdate()->findOrFail($it['product_id']);
                if ($prod->stock < $it['quantity']) {
                    throw new \Exception("Product {$prod->id} out of stock");
                }
                $subtotal = $prod->price * $it['quantity'];
                $order->items()->create([
                    'product_id' => $prod->id,
                    'quantity' => $it['quantity'],
                    'unit_price' => $prod->price,
                    'subtotal' => $subtotal
                ]);
                $prod->decrement('stock', $it['quantity']);
                $total += $subtotal;
            }
            $order->update(['total_amount' => $total]);
            DB::commit();

            // send to SQS (pseudo)
            dispatch(new SendOrderToQueueJob($order->id));

            return response()->json($order->load('items'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()], 400);
        }
    }
}