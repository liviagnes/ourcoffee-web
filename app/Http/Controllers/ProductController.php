<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = Product::orderBy('id', 'DESC');

        $title_menu = "All Menu";
        if ($kategori == 'minuman') {
            $query->where('kategori', 'minuman');
            $title_menu = "Coffee & Drinks";
        } elseif ($kategori == 'makanan') {
            $query->where('kategori', 'makanan');
            $title_menu = "Food & Snacks";
        }

        $products = $query->get();

        $cart_map = [];
        $total_item_cart = 0;

        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())->get();
            foreach ($carts as $cart) {
                $cart_map[$cart->product_id] = $cart->qty;
                $total_item_cart += $cart->qty;
            }
        }

        return view('menu', compact('products', 'kategori', 'title_menu', 'cart_map', 'total_item_cart'));
    }
}
