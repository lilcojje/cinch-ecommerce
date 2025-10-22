<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessOrderEmail
{
    public function handle($message)
    {
        $payload = json_decode($message->body, true);
        $orderId = $payload['order_id'];
        $order = Order::with('items.product')->find($orderId);
        Mail::to($order->customer_email)->send(new OrderSummaryMail($order));
    }
}