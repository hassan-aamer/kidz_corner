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
        .cart-float-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #d72864;
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
            background: #000;
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
