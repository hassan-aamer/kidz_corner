    <!-- Favicons -->
    <link href="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}" rel="icon" />

    <!-- Preconnect لتحسين الأداء -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cairo:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('web/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <style>
        /* ===== MOBILE NAVBAR ===== */
.mobile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 18px;
    background: #ffffff;
    border-bottom: 1px solid #eee;
}

.mobile-header img.logo {
    height: 55px;
}

.mobile-header .menu-icon {
    font-size: 26px;
    color: #C73B65; /* لون موقعك */
    cursor: pointer;
}

/* ===== SIDE MENU ===== */
.side-menu {
    position: fixed;
    top: 0;
    right: -260px;
    width: 260px;
    height: 100%;
    background: #fff;
    box-shadow: -2px 0 8px rgba(0,0,0,0.1);
    padding: 25px 20px;
    transition: .4s ease;
    z-index: 9999;
}

.side-menu.active {
    right: 0;
}

.side-menu a {
    display: block;
    padding: 14px 0;
    font-size: 19px;
    font-weight: bold;
    color: #444;
    border-bottom: 1px solid #eee;
    transition: .2s;
}

.side-menu a:hover {
    color: #C73B65;
}

/* ===== OVERLAY ===== */
.menu-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    z-index: 9990;
}

.menu-overlay.active {
    display: block;
}

.mobile-header {
    border: none !important;
    box-shadow: none !important;
}

.mobile-header .logo {
    border: none !important;
}

.mobile-header .menu-icon {
    border: none !important;
}

.navbar,
.mobile-header {
    border-bottom: 0 !important;
}


/* Hide desktop navbar on mobile */
@media(max-width: 992px) {
    .desktop-nav { display: none !important; }
}

    </style>
    <style>
        .cart-float-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #1D9DB1;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            transition: all 0.3s ease-in-out;
        }

        .cart-float-btn:hover {
            background: #fff;
            transform: scale(1.05);
        }

        .cart-float-btn .cart-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: #fff;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 50%;
            font-weight: bold;
        }

        .back-to-top {
            position: fixed;
            bottom: 25px;
            left: 25px;
            right: auto;
            z-index: 9999;
        }
    </style>
