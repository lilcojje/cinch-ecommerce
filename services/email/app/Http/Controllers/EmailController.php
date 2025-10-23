<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSummaryMail;

class EmailController extends Controller
{
    public function sendOrderSummary(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'items' => 'required|array',
            'total_amount' => 'required|numeric',
        ]);

        // Send email
        Mail::to($validated['email'])->send(new OrderSummaryMail(
            $validated['name'],
            $validated['items'],
            $validated['total_amount']
        ));

        return response()->json(['message' => 'Order summary email sent successfully.']);
    }
}
