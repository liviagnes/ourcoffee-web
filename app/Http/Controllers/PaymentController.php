<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function localSuccess($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'paid') {
            return redirect('/history')->with('success', 'Pesanan sudah dibayar.');
        }

        DB::beginTransaction();
        try {
            $order->status = 'paid';
            $order->save();

            // Kurangi stok produk berdasarkan order details
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            foreach ($orderDetails as $detail) {
                Product::where('id', $detail->product_id)->decrement('stok', $detail->jumlah);
            }

            DB::commit();
            return redirect('/history')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/history')->with('error', 'Terjadi kesalahan saat memproses pembayaran Anda.');
        }
    }
}
