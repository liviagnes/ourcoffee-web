<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'stok' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoName = time() . '.' . $request->foto->extension();
        $request->foto->move(public_path('assets/img/products'), $fotoName);

        Product::create([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'foto' => $fotoName
        ]);

        return redirect('/admin/product')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'nama_produk' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('foto')) {
            if (File::exists(public_path('assets/img/products/' . $product->foto))) {
                File::delete(public_path('assets/img/products/' . $product->foto));
            }
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('assets/img/products'), $fotoName);
            $data['foto'] = $fotoName;
        }

        $product->update($data);

        return redirect('/admin/product')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (File::exists(public_path('assets/img/products/' . $product->foto))) {
            File::delete(public_path('assets/img/products/' . $product->foto));
        }
        $product->delete();

        return redirect('/admin/product')->with('success', 'Produk berhasil dihapus.');
    }
}
