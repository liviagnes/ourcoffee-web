@extends('layouts.app')

@section('content')
<section class="hero" id="home">
    <div class="hero-content">
        <div class="hero-text">
            <h1>A Coffee Ritual<br>for Every Mood</h1>
            <p>
                Crafted with passion, brewed with purpose.
                Discover coffee that brings warmth, balance,
                and comfort in every single cup at <strong>OurCoffee</strong>.
            </p>
            <a href="#menu" class="btn-primary">Order Now</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/hero-image.png') }}" alt="OurCoffee Hero Image">
        </div>
    </div>
</section>

<section class="best-seller" id="best-seller">
    <div class="container">
        <div class="best-seller-header">
            <h2>Best Seller Choices</h2>
            <p>Our most loved coffee and food, chosen by our loyal customers.</p>
        </div>

        <div class="best-seller-grid">
            @if($best_sellers->count() > 0)
                @foreach($best_sellers as $row)
                    <div class="menu-card" onclick="showDetail(
                        '{{ htmlspecialchars($row->nama_produk, ENT_QUOTES) }}', 
                        '{{ htmlspecialchars($row->deskripsi, ENT_QUOTES) }}', 
                        'Rp {{ number_format($row->harga, 0, ',', '.') }}', 
                        '{{ asset('assets/img/products/'.$row->foto) }}',
                        '{{ $row->id }}'
                    )">
                        <div class="card-img-wrapper">
                            <img src="{{ asset('assets/img/products/'.$row->foto) }}" alt="{{ $row->nama_produk }}">
                        </div>
                        <div class="card-content">
                            <h3>{{ htmlspecialchars($row->nama_produk) }}</h3>
                            <span class="price">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                            <div class="card-footer-simple">
                                <span class="link-text">View Details</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p style='text-align:center; width:100%; color:#999;'>No menu available yet.</p>
            @endif
        </div>
    </div>

    <div class="modal-overlay" id="productModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <img src="" alt="Product Image" class="modal-img" id="modalImg">
            <h3 class="modal-title" id="modalTitle">Product Name</h3>
            <span class="modal-price" id="modalPrice">Rp 0</span>
            <p class="modal-desc" id="modalDesc">Product Descript... </p>
            <div id="modalBtnContainer"></div>
        </div>
    </div>
</section>

<section class="our-menu" id="menu" style="background-color: #F9F4F0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 text-center mb-5 mb-lg-0">
                <div class="position-relative">
                    <img src="{{ asset('assets/img/ourmenu-img.png') }}"
                        alt="Menu Favorit"
                        class="img-fluid floating-animate"
                        style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1)); max-height: 450px;">
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1 text-start">
                <h2 class="section-title">Our Complete Menu</h2>
                <p class="section-desc">
                    Discover our carefully curated selections crafted to satisfy every taste. From warm pastries to premium coffee, we have everything to make your day better.
                </p>
                <div class="menu-action">
                    <a href="{{ url('/menu?kategori=minuman') }}" class="btn-outline">
                        Coffee & Drinks
                    </a>
                    <a href="{{ url('/menu?kategori=makanan') }}" class="btn btn-primary btn-lg rounded-pill px-4 border-0 shadow-sm" style="background: #8b5e3c;">
                        Food & Snacks
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery" id="gallery">
    <h2 class="section-title">Places</h2>
    <p class="section-desc">A glimpse of our cozy space at OurCoffee.</p>
    <div class="gallery-grid">
        <div class="gallery-item big">
            <img src="{{ asset('assets/img/gallery1.jpg') }}" alt="Interior 1">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('assets/img/gallery2.jpg') }}" alt="Interior 2">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('assets/img/gallery3.jpg') }}" alt="Detail Coffee">
        </div>
        <div class="gallery-item wide">
            <img src="{{ asset('assets/img/gallery4.jpg') }}" alt="Barista">
        </div>
    </div>
</section>

<section class="about-us" id="about">
    <div class="about-us-container">
        <div class="about-us-image">
            <img src="{{ asset('assets/img/about-img.jpg') }}" alt="About OurCoffee">
        </div>
        <div class="about-us-text">
            <h2>About OurCoffee</h2>
            <p class="about-preview">
                Founded in 2024, OurCoffee was built from a deep passion for crafting
                high-quality coffee and creating a warm, welcoming space.
            </p>
            <div class="about-more" id="aboutMore">
                <p>
                    We select premium beans from trusted farmers to ensure rich aroma.
                    Our mission is to build meaningful connections.
                </p>
            </div>
            <button class="about-toggle" onclick="toggleAbout()">Read More</button>
        </div>
    </div>
</section>

<section class="testimonial" id="testimonial">
    <h2 class="section-title">Customer Stories</h2>
    <p class="section-desc">Hear what they say about OurCoffee.</p>
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-avatar">
                <img src="{{ asset('assets/img/user1.jpg') }}" alt="User 1">
            </div>
            <p class="testi-text">"The atmosphere feels so warm and cozy!"</p>
            <h4>Sarah Johnson</h4>
        </div>
        <div class="testi-card">
            <div class="testi-avatar">
                <img src="{{ asset('assets/img/user2.jpg') }}" alt="User 2">
            </div>
            <p class="testi-text">"Best Americano in town. Friendly staff too."</p>
            <h4>Michael Lee</h4>
        </div>
    </div>
</section>

<section class="contact" id="contact">
    <h2>Contact Us</h2>
    <p>Have questions? Leave us a message.</p>
    <form class="contact-form">
        <div class="form-row">
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
        </div>
        <textarea placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</section>
@endsection

@section('scripts')
<script>
    const userLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

    function showDetail(nama, deskripsi, harga, gambar, productId) {
        document.getElementById('modalTitle').innerText = nama;
        document.getElementById('modalDesc').innerText = deskripsi;
        document.getElementById('modalPrice').innerText = harga;
        document.getElementById('modalImg').src = gambar;

        const btnContainer = document.getElementById('modalBtnContainer');

        if (userLoggedIn) {
            btnContainer.innerHTML = `
            <a href="{{ url('/cart/add') }}/${productId}" class="btn-modal-action">
                <i class="fas fa-shopping-cart me-2"></i> Order Now
            </a>
        `;
        } else {
            btnContainer.innerHTML = `
            <a href="{{ url('/login') }}" class="btn-modal-action">
                Login to Order
            </a>
        `;
        }

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
        if (event.target == modal) {
            closeModal();
        }
    }

    if (document.querySelector('#home')) {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.scroll-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    if (current !== '') {
                        link.classList.add('active');
                    }
                }
            });

            if (window.scrollY < 100) {
                navLinks.forEach(link => link.classList.remove('active'));
                document.querySelector('a[href*="#home"]').classList.add('active');
            }
        });
    }

    function toggleAbout() {
        const moreText = document.getElementById('aboutMore');
        const btnText = document.querySelector('.about-toggle');

        if (moreText.style.display === "none" || moreText.style.display === "") {
            moreText.style.display = "block";
            btnText.innerHTML = "Read Less";
        } else {
            moreText.style.display = "none";
            btnText.innerHTML = "Read More";
        }
    }

    const urlParams = new URLSearchParams(window.location.search);
    const pesan = urlParams.get('pesan');

    if (pesan === 'logout') {
        Swal.fire({
            icon: 'success',
            title: 'See You!',
            text: 'You have successfully logged out.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.history.replaceState(null, null, window.location.pathname);
        });
    }
</script>
@endsection
