<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OurCoffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('head')
</head>
<body>
    @php
        $current_page = request()->path();
        $link_prefix = ($current_page == '/' || $current_page == 'home') ? '' : url('/');
    @endphp

    <nav class="navbar">
      <div class="logo">OurCoffee</div>
      <div class="menu-toggle" onclick="toggleMenu()">☰</div>
      <ul class="nav-menu" id="navMenu">
        <li><a href="{{ $link_prefix }}#home" class="scroll-link">Home</a></li>
        <li><a href="{{ $link_prefix }}#best-seller" class="scroll-link">Best Seller</a></li>
        <li>
          <a href="{{ url('/menu') }}" class="{{ request()->is('menu') ? 'active' : '' }}">
            Our Menu
          </a>
        </li>
        <li><a href="{{ $link_prefix }}#gallery" class="scroll-link">Places</a></li>
        <li><a href="{{ $link_prefix }}#contact" class="scroll-link">Contact Us</a></li>
        @auth
          <li class="cart-icon">
            <a href="{{ url('/cart') }}" class="cart-icon-bubble {{ request()->is('cart') ? 'active' : '' }}">
              <i class="fas fa-shopping-cart" style="color: #3e2723; font-size: 18px;"></i>
              @php
                  $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('qty');
              @endphp
              @if($cartCount > 0)
                  <span class="cart-count-badge">{{ $cartCount }}</span>
              @endif
            </a>
          </li>
          <li class="dropdown">
            <div onclick="toggleProfile()" class="profile-btn">
              <i class="fas fa-user-circle" style="font-size: 22px;"></i>
              <span>{{ explode(' ', Auth::user()->full_name)[0] }}</span>
              <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
            </div>
            <div id="profileDropdown" class="dropdown-menu">
              @if(Auth::user()->role === 'admin')
                  <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
              @elseif(Auth::user()->role === 'kasir')
                  <a href="{{ url('/kasir/dashboard') }}">Dashboard</a>
              @endif
              <a href="{{ url('/history') }}">Order History</a>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">Logout</a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </li>
        @else
          <li><a href="{{ url('/login') }}" class="btn-sign">Sign In</a></li>
        @endauth
      </ul>
    </nav>

    @yield('content')

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-brand">
          <h3 class="footer-logo">OurCoffee</h3>
          <p class="footer-desc">Crafting warmth in every cup. Bringing the best coffee to accompany your day.</p>
        </div>
        <div class="footer-nav">
          <h4>Explore</h4>
          <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/menu') }}">Our Menu</a></li>
            <li><a href="{{ url('/') }}#best-seller">Best Seller</a></li>
            <li><a href="{{ url('/') }}#contact">Contact</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h4>Visit Us</h4>
          <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Coffee Street No. 12, Jakarta</p>
          <p><i class="fas fa-phone me-2"></i> +62 812 3456 789</p>
          <p><i class="fas fa-envelope me-2"></i> hello@ourcoffee.com</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© {{ date('Y') }} OurCoffee. All rights reserved.</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <script>
      function toggleMenu() {
        const navMenu = document.getElementById('navMenu');
        if (navMenu) {
            navMenu.classList.toggle('active');
        }
      }
      function toggleProfile() {
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileDropdown) {
            profileDropdown.classList.toggle('show-dropdown');
        }
      }
      window.onclick = function(event) {
        if (!event.target.closest('.profile-btn')) {
          const dropdowns = document.getElementsByClassName("dropdown-menu");
          for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show-dropdown')) {
              openDropdown.classList.remove('show-dropdown');
            }
          }
        }
      }
    </script>
    
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#8b5e3c'
            });
        </script>
    @endif
    
    @yield('scripts')
</body>
</html>
