<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'nama_produk' => 'Cake Roll',
                'kategori' => 'makanan',
                'harga' => 15000,
                'foto' => '1767185855_cake-roll.png',
                'deskripsi' => 'A soft rolled cake filled with sweet cream, perfect as a light dessert or afternoon treat.',
                'stok' => 30
            ],
            [
                'nama_produk' => 'Strawberry Cake',
                'kategori' => 'makanan',
                'harga' => 13500,
                'foto' => '1767185906_pink-cake.png',
                'deskripsi' => 'A soft and sweet cake with a charming pink color, offering a light and delightful flavor.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Chocolate Cake',
                'kategori' => 'makanan',
                'harga' => 15000,
                'foto' => '1767185950_chocolate-cake.png',
                'deskripsi' => 'A rich and moist chocolate cake with a deep cocoa flavor, ideal for chocolate lovers.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Dip Doughnut',
                'kategori' => 'makanan',
                'harga' => 16000,
                'foto' => '1767186007_dip-doughnut.png',
                'deskripsi' => 'A fluffy doughnut topped with a sweet glaze, combining a soft texture with a delicious sweetness.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Crossaint',
                'kategori' => 'makanan',
                'harga' => 12000,
                'foto' => '1767186039_crossaint.png',
                'deskripsi' => 'A classic French pastry with a flaky, buttery exterior and a soft inside, perfect for breakfast.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Lemon Tea',
                'kategori' => 'minuman',
                'harga' => 10000,
                'foto' => '1767186091_lemon-tea.png',
                'deskripsi' => 'A refreshing tea infused with lemon, offering a balanced sweet and tangy taste.',
                'stok' => 100
            ],
            [
                'nama_produk' => 'Cup Of Ice Cream',
                'kategori' => 'minuman',
                'harga' => 10000,
                'foto' => '1767186130_icecream-cup.png',
                'deskripsi' => 'Creamy ice cream served in a cup, available in various flavors and perfect for cooling down.',
                'stok' => 100
            ],
            [
                'nama_produk' => 'Waffles',
                'kategori' => 'makanan',
                'harga' => 18000,
                'foto' => '1767186176_waffles.png',
                'deskripsi' => 'Crispy on the outside and soft on the inside, best enjoyed with sweet toppings or syrup.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Cromboloni',
                'kategori' => 'makanan',
                'harga' => 18000,
                'foto' => '1767186223_cromboloni.png',
                'deskripsi' => 'A modern pastry with a round shape and creamy filling inside, offering a sweet and indulgent bite.',
                'stok' => 50
            ],
            [
                'nama_produk' => 'Milkshake',
                'kategori' => 'minuman',
                'harga' => 15000,
                'foto' => '1767186259_milkshake.png',
                'deskripsi' => 'A thick and creamy milk-based drink, blended with sweet flavors and served cold.',
                'stok' => 100
            ],
            [
                'nama_produk' => 'Tea',
                'kategori' => 'minuman',
                'harga' => 8000,
                'foto' => '1767186296_tea.png',
                'deskripsi' => 'A simple and comforting tea with a light, smooth taste, suitable for any time of day.',
                'stok' => 100
            ],
            [
                'nama_produk' => 'Americano',
                'kategori' => 'minuman',
                'harga' => 10000,
                'foto' => '1767186339_americano.png',
                'deskripsi' => 'A bold black coffee with a smooth and clean taste, ideal for those who enjoy coffee without milk.',
                'stok' => 100
            ],
            [
                'nama_produk' => 'Capuccino',
                'kategori' => 'minuman',
                'harga' => 15000,
                'foto' => '1767186472_capuccino.png',
                'deskripsi' => 'A balanced blend of espresso, steamed milk, and milk foam, creating a creamy and satisfying coffee experience.',
                'stok' => 100
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
