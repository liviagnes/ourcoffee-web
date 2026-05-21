<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('cart', compact('carts'));
    }

    public function add($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $product_id)->first();
        if ($cart) {
            $cart->qty += 1;
            $cart->save();
            $msg = "Jumlah pesanan ditambah!";
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'qty' => 1
            ]);
            $msg = "Produk masuk keranjang!";
        }
        return back()->with('success', $msg);
    }

    public function updateQty($cart_id, $type)
    {
        $cart = Cart::where('id', $cart_id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($type == 'plus') {
            $cart->qty += 1;
            $cart->save();
        } elseif ($type == 'minus') {
            if ($cart->qty > 1) {
                $cart->qty -= 1;
                $cart->save();
            }
        }
        return back();
    }

    public function decreaseProduct($product_id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $product_id)->first();
        if ($cart) {
            if ($cart->qty > 1) {
                $cart->qty -= 1;
                $cart->save();
            } else {
                $cart->delete();
            }
        }
        return back();
    }

    public function delete($cart_id)
    {
        $cart = Cart::where('id', $cart_id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
