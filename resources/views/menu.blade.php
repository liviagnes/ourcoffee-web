@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
@endsection

@section('content')
<div class="menu-header">
    <h1>{{ $title_menu }}</h1>
    <p>Discover your favorite flavors from our selection of the finest coffee beans and delicious snacks.</p>

    <div class="filter-container">
        <a href="{{ url('/menu') }}" class="filter-btn {{ ($kategori == '') ? 'active' : '' }}">All Menus</a>
        <a href="{{ url('/menu?kategori=minuman') }}" class="filter-btn {{ ($kategori == 'minuman') ? 'active' : '' }}">Coffee & Drinks</a>
        <a href="{{ url('/menu?kategori=makanan') }}" class="filter-btn {{ ($kategori == 'makanan') ? 'active' : '' }}">Food & Snacks</a>
    </div>
</div>

<div class="menu-container">
    @if($products->count() > 0)
        @foreach($products as $row)
            @php
                $p_id = $row->id;
                $in_cart = isset($cart_map[$p_id]);
                $qty_now = $in_cart ? $cart_map[$p_id] : 0;
            @endphp
            <div class="product-card" onclick="showDetail(
                '{{ htmlspecialchars($row->nama_produk, ENT_QUOTES) }}', 
                '{{ htmlspecialchars($row->deskripsi, ENT_QUOTES) }}', 
                'Rp {{ number_format($row->harga, 0, ',', '.') }}', 
                '{{ asset('assets/img/products/'.$row->foto) }}'
            )">
                <div class="product-img-box">
                    <img src="{{ asset('assets/img/products/'.$row->foto) }}" alt="{{ $row->nama_produk }}">
                    <span class="category-badge">{{ ucfirst($row->kategori) }}</span>
                </div>
                <div class="product-info">
                    <h3 class="product-title">{{ htmlspecialchars($row->nama_produk) }}</h3>
                    <p class="product-desc">{{ htmlspecialchars(substr($row->deskripsi, 0, 60)) }}...</p>
                    <div class="product-footer">
                        <span class="product-price">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                        <div class="product-actions" onclick="event.stopPropagation()">
                            @auth
                                @if($in_cart)
                                    <div class="qty-control-card">
                                        <a href="{{ url('/cart/decrease/'.$p_id) }}" class="btn-qty-card">
                                            <i class="fas fa-minus"></i>
                                        </a>
                                        <span class="qty-val-card">{{ $qty_now }}</span>
                                        <a href="{{ url('/cart/add/'.$p_id) }}" class="btn-qty-card">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ url('/cart/add/'.$p_id) }}" class="btn-action-cart">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endif
                            @else
                                <a href="{{ url('/login') }}" class="btn-action-cart" onclick="alertLogin(event)">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-mug-hot fa-3x" style="margin-bottom: 15px; opacity: 0.3;"></i>
            <h3>Menu tidak ditemukan</h3>
            <p>Belum ada produk untuk kategori ini.</p>
            <a href="{{ url('/menu') }}" style="color: #8b5e3c;">Lihat semua menu</a>
        </div>
    @endif
</div>

@auth
    @if($total_item_cart > 0)
        <a href="{{ url('/cart') }}" class="floating-cart">
            <div class="cart-icon-bubble">
                <i class="fas fa-shopping-basket"></i>
                <span class="cart-count-badge">{{ $total_item_cart }}</span>
            </div>
            <div class="cart-text-info">
                <span class="total-items-text">{{ $total_item_cart }} Item</span>
                <span class="view-cart-text">See My Cart</span>
            </div>
        </a>
    @endif
@endauth

<div class="modal-overlay" id="productModal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <img src="" alt="Product Image" class="modal-img" id="modalImg">
        <h3 class="modal-title" id="modalTitle">Nama Produk</h3>
        <span class="modal-price" id="modalPrice">Rp 0</span>
        <p class="modal-desc" id="modalDesc"></p>

        @auth
            <a href="{{ url('/cart') }}" class="filter-btn active w-100" style="display:block; text-align:center; text-decoration:none; border:none;">Lihat di Keranjang</a>
        @else
            <a href="{{ url('/login') }}" class="filter-btn active w-100" style="display:block; text-align:center; text-decoration:none; border:none;">Login untuk Pesan</a>
        @endauth
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scrollPos = localStorage.getItem('scrollPosition');
        if (scrollPos) {
            window.scrollTo(0, parseInt(scrollPos));
            localStorage.removeItem('scrollPosition');
        }
        const actionButtons = document.querySelectorAll('.btn-action-cart, .btn-qty-card');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                localStorage.setItem('scrollPosition', window.scrollY);
            });
        });
    });

    function showDetail(nama, deskripsi, harga, gambar) {
        document.getElementById('modalTitle').innerText = nama;
        document.getElementById('modalDesc').innerText = deskripsi;
        document.getElementById('modalPrice').innerText = harga;
        document.getElementById('modalImg').src = gambar;

        const modal = document.getElementById('productModal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('productModal');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    window.onclick = function(event) {
        const modal = document.getElementById('productModal');
        if (event.target == modal) closeModal();
    }

    function alertLogin(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Belum Login',
            text: "Silahkan login terlebih dahulu untuk memesan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Login Sekarang',
            confirmButtonColor: '#8b5e3c'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = '{{ url('/login') }}';
        });
    }
</script>
@endsection
