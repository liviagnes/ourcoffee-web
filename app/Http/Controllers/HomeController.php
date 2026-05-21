<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $best_sellers = Product::inRandomOrder()->take(5)->get();
        return view('home', compact('best_sellers'));
    }
}
