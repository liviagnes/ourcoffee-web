@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    <style>
        .cart-section {
            padding: 60px 0;
            background-color: #fcf9f5;
            min-height: 80vh;
        }
        .cart-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0e6d2;
        }
        .cart-item {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #f0e6d2;
            box-shadow: 0 5px 15px rgba(139, 94, 60, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            box-shadow: 0 8px 25px rgba(139, 94, 60, 0.1);
            transform: translateY(-2px);
        }
        .cart-img-wrapper img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
        }
        .cart-details {
            flex-grow: 1;
        }
        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #4a3228;
            margin-bottom: 5px;
        }
        .product-price {
            color: #8b5e3c;
            font-weight: 600;
            margin: 0;
        }
        .cart-qty-control {
            display: flex;
            align-items: center;
            background: #fcf9f5;
            border-radius: 50px;
            padding: 5px;
            border: 1px solid #e6dace;
        }
        .qty-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #4a3228;
            text-decoration: none;
            transition: all 0.2s;
        }
        .qty-btn:hover {
            background: #8b5e3c;
            color: #fff;
        }
        .qty-val {
            width: 40px;
            text-align: center;
            font-weight: bold;
            color: #4a3228;
        }
        .cart-action-right {
            text-align: right;
            min-width: 120px;
        }
        .subtotal-text {
            font-weight: 800;
            color: #4a3228;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        .btn-delete {
            color: #e74c3c;
            background: #fdf3f2;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-delete:hover {
            background: #e74c3c;
            color: #fff;
            transform: scale(1.1);
        }
        .cart-summary {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #f0e6d2;
            box-shadow: 0 10px 30px rgba(139, 94, 60, 0.08);
            position: sticky;
            top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #6c757d;
        }
        .summary-row.total {
            font-size: 1.25rem;
            font-weight: 800;
            color: #4a3228;
            margin-top: 20px;
        }
        .btn-checkout {
            display: block;
            width: 100%;
            background: #8b5e3c;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 25px;
            transition: all 0.3s;
        }
        .btn-checkout:hover {
            background: #6a442a;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 94, 60, 0.3);
        }
        .btn-header-back {
            color: #8b5e3c;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 50px;
            background: #fff;
            border: 1px solid #e6dace;
            transition: all 0.3s;
        }
        .btn-header-back:hover {
            background: #8b5e3c;
            color: #fff;
            border-color: #8b5e3c;
        }
    </style>
@endsection

@section('content')
<section class="cart-section">
    <div class="container">
        @php
            $total_bayar = 0;
        @endphp

        @if($carts->count() > 0)
            <div class="cart-header-row">
                <div class="cart-title-block">
                    <h1 class="cart-title">Your Cart</h1>
                    <p class="cart-subtitle">Complete your order and enjoy your coffee.</p>
                </div>
                <a href="{{ url('/menu') }}" class="btn-header-back">
                    <i class="fas fa-times"></i>
                    <span class="d-none d-md-inline ms-2">Back to Menu</span>
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-list">
                        @foreach($carts as $row)
                            @php
                                $subtotal = $row->product->harga * $row->qty;
                                $total_bayar += $subtotal;
                            @endphp
                            <div class="cart-item">
                                <div class="cart-img-wrapper">
                                    <img src="{{ asset('assets/img/products/'.$row->product->foto) }}" alt="{{ $row->product->nama_produk }}">
                                </div>
                                <div class="cart-details">
                                    <h3 class="product-name">{{ $row->product->nama_produk }}</h3>
                                    <p class="product-price">Rp {{ number_format($row->product->harga, 0, ',', '.') }}</p>
                                </div>
                                <div class="cart-qty-control">
                                    <a href="{{ url('/cart/update/'.$row->id.'/minus') }}" class="qty-btn minus"><i class="fas fa-minus"></i></a>
                                    <span class="qty-val">{{ $row->qty }}</span>
                                    <a href="{{ url('/cart/update/'.$row->id.'/plus') }}" class="qty-btn plus"><i class="fas fa-plus"></i></a>
                                </div>
                                <div class="cart-action-right">
                                    <p class="subtotal-text">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                    <a href="{{ url('/cart/delete/'.$row->id) }}" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <hr>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ url('/checkout') }}" class="btn-checkout">Checkout Now</a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart-wrapper">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h3 class="empty-cart-title">Your Cart Is Still Empty</h3>
                <p class="empty-cart-desc">
                    Browse our menu and add your favorite items to the cart.
                </p>
                <a href="{{ url('/menu') }}" class="btn-back-menu">
                    <i class="fas fa-mug-hot"></i> See Menu
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Item ini akan dihapus dari keranjangmu.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = href;
            });
        });
    });
</script>
@endsection
