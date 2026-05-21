<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash('sha512', $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));

        if ($notification->signature_key !== $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('kode_pesanan', $notification->order_id)->first();

        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }

        if ($notification->transaction_status == 'settlement' || $notification->transaction_status == 'capture') {
            $order->status = 'paid';
            $order->save();
        } elseif ($notification->transaction_status == 'cancel' || $notification->transaction_status == 'deny' || $notification->transaction_status == 'expire') {
            $order->status = 'cancelled';
            $order->save();
        }

        return response(['message' => 'Success'], 200);
    }
}
