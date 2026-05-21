<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function checkoutView()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->count() == 0) {
            return redirect('/menu');
        }

        $grand_total = 0;
        foreach ($carts as $cart) {
            $grand_total += $cart->product->harga * $cart->qty;
        }

        return view('checkout', compact('grand_total'));
    }

    public function process(Request $request)
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->count() == 0) {
            return redirect('/menu')->with('error', 'Keranjang kosong.');
        }

        $total_harga_fix = 0;
        foreach ($carts as $cart) {
            $total_harga_fix += $cart->product->harga * $cart->qty;
        }

        $kode_pesanan = "ORD-" . time() . rand(100, 999);
        $status_awal = ($request->payment_method == 'cashier') ? 'paid' : 'pending';

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'no_meja' => $request->no_meja,
                'kode_pesanan' => $kode_pesanan,
                'total_harga' => $total_harga_fix,
                'payment_method' => $request->payment_method,
                'status' => $status_awal,
                'snap_token' => null
            ]);

            $item_details = [];

            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);
                
                if ($cart->qty > $product->stok) {
                    DB::rollBack();
                    return back()->with('error', 'Maaf, stok ' . $product->nama_produk . ' tidak mencukupi.');
                }

                // JIKA CASHIER: Kurangi stok saat itu juga.
                // JIKA QRIS: Jangan kurangi stok di sini, nanti dikurangi di local endpoint success.
                if ($request->payment_method == 'cashier') {
                    $product->decrement('stok', $cart->qty);
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'jumlah' => $cart->qty,
                    'harga_saat_ini' => $cart->product->harga
                ]);

                $item_details[] = [
                    'id'       => $cart->product_id,
                    'price'    => $cart->product->harga,
                    'quantity' => $cart->qty,
                    'name'     => substr($product->nama_produk, 0, 50)
                ];
            }

            Cart::where('user_id', Auth::id())->delete();

            // Integrasi Midtrans jika QRIS
            if ($request->payment_method == 'qris') {
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $customer_details = [
                    'first_name' => Auth::user()->full_name,
                    'email'      => Auth::user()->email,
                ];

                $params = [
                    'transaction_details' => [
                        'order_id'     => $kode_pesanan,
                        'gross_amount' => $total_harga_fix,
                    ],
                    'customer_details'    => $customer_details,
                    'item_details'        => $item_details
                ];

                $snapToken = Snap::getSnapToken($params);
                
                // Simpan $snapToken ke database
                $order->snap_token = $snapToken;
                $order->save();
            }

            DB::commit();

            return redirect('/order_success?code=' . $kode_pesanan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses pesanan Anda. ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $kode_pesanan = $request->query('code');
        $order = Order::where('kode_pesanan', $kode_pesanan)->where('user_id', Auth::id())->firstOrFail();
        
        return view('order_success', compact('order'));
    }

    public function history()
    {
        $orders = Order::with('orderDetails.product')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('history', compact('orders'));
    }

    public function cancel(Request $request)
    {
        $kode_pesanan = $request->query('code');
        $order = Order::where('kode_pesanan', $kode_pesanan)->where('user_id', Auth::id())->where('status', 'pending')->first();
        
        if ($order) {
            DB::beginTransaction();
            try {
                // Restore stok HANYA JIKA payment_method nya cashier,
                // karena jika qris, stok belum dikurangi sama sekali.
                if ($order->payment_method == 'cashier') {
                    $orderDetails = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($orderDetails as $detail) {
                        Product::where('id', $detail->product_id)->increment('stok', $detail->jumlah);
                    }
                }

                $order->status = 'cancelled';
                $order->save();

                DB::commit();
                return redirect('/history')->with('success', 'Pesanan berhasil dibatalkan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect('/history')->with('error', 'Gagal membatalkan pesanan.');
            }
        }
        return redirect('/history')->with('error', 'Gagal membatalkan atau pesanan sudah diproses.');
    }
}
