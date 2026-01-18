<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->site_title ?: 'TextilOne' }}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
       
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #000000;
            color: #ffffff;
            line-height: 1.6;
        }
       
        .poster-container {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            background: #000000;
            position: relative;
            overflow: hidden;
        }
       
        .background-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.3;
        }
       
        .shape-1 {
            width: 400px;
            height: 400px;
            background-color: #ff0000;
            top: -100px;
            right: -100px;
        }
       
        .shape-2 {
            width: 300px;
            height: 300px;
            background-color: #ff0000;
            bottom: 100px;
            left: -50px;
        }
       
        .grid-texture {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: 1;
        }
       
        .content {
            position: relative;
            z-index: 2;
            padding: clamp(18px, 3vw, 48px);
            width: 100%;
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }
       
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 16px;
            flex-wrap: wrap;
        }
       
        .logo {
            font-size: 32px;
            font-weight: 900;
            color: #ffffff;
            display: flex;
            align-items: center;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .logo img {
            width: clamp(160px, 25vw, 250px);
            height: auto;
            max-width: 100%;
            display: block;
        }
       
        .logo i {
            margin-right: 10px;
            font-size: 36px;
            color: #ff0000;
        }
       
        .nav {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
       
        .nav-item {
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
            text-decoration: none;
            display: inline-block;
        }
       
        .nav-item:hover {
            color: #ff0000;
        }
       
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ff0000;
            transition: width 0.3s;
        }
       
        .nav-item:hover::after {
            width: 100%;
        }
       
        .hero {
            text-align: center;
            margin-bottom: 40px;
            padding: clamp(20px, 4vw, 44px);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
       
        .hero h1 {
            font-size: clamp(28px, 4.2vw, 56px);
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 15px;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
       
        .hero p {
            font-size: clamp(16px, 1.6vw, 20px);
            margin-bottom: 25px;
            color: #cccccc;
        }
       
        .cta-button {
            display: inline-block;
            background-color: #ff0000;
            color: white;
            padding: 15px 35px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
       
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.5);
        }
       
        .section {
            margin-bottom: 40px;
        }
       
        .section-title {
            font-size: clamp(22px, 2.4vw, 32px);
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }
       
        .section-title i {
            margin-right: 15px;
            color: #ff0000;
            font-size: 36px;
        }
       
        .services {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }
       
        .service-card {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, background 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
       
        .service-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }
       
        .service-card i {
            font-size: 48px;
            color: #ff0000;
            margin-bottom: 20px;
        }
       
        .service-card h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #ffffff;
            text-transform: uppercase;
        }
       
        .service-card p {
            font-size: 16px;
            color: #cccccc;
        }
       
        .promotions {
            margin-bottom: 40px;
        }

        .promo-carousel-wrap {
            position: relative;
        }

        .promo-carousel-wrap + .promo-carousel-wrap {
            margin-top: 18px;
        }

        .promo-carousel {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            padding: 4px 4px 14px;
        }

        .promo-carousel::-webkit-scrollbar {
            display: none;
        }

        .promo-track {
            display: flex;
            gap: 20px;
            padding: 4px 0;
        }

        .promo-carousel .promo-card {
            flex: 0 0 calc(100% - 8px);
            margin-bottom: 0;
            scroll-snap-align: start;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(10px);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 5;
            transition: background 0.2s, transform 0.2s, opacity 0.2s;
        }

        .carousel-btn:hover {
            background: rgba(255, 0, 0, 0.35);
            transform: translateY(-50%) scale(1.03);
        }

        .carousel-btn:disabled {
            opacity: 0.35;
            cursor: default;
        }

        .carousel-btn:disabled:hover {
            background: rgba(0, 0, 0, 0.35);
            transform: translateY(-50%);
        }

        .carousel-btn.prev {
            left: -12px;
        }

        .carousel-btn.next {
            right: -12px;
        }
       
        .promo-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-left: 5px solid #ff0000;
            transition: transform 0.3s, background 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
        }
       
        .promo-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.08);
        }
       
        .promo-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 16px;
            flex-wrap: wrap;
        }
       
        .promo-image {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 0;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
       
        .promo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
       
        .promo-image i {
            font-size: 48px;
            color: rgba(255, 255, 255, 0.3);
        }
       
        .promo-content {
            flex: 1;
        }
       
        .promo-card h3 {
            font-size: 24px;
            font-weight: 700;
            color: #ff0000;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            text-transform: uppercase;
        }
       
        .promo-card h3 i {
            margin-right: 10px;
        }
       
        .promo-card p {
            font-size: 18px;
            color: #ffffff;
            margin-bottom: 15px;
        }
       
        .promo-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
       
        .promo-detail {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #cccccc;
            background: rgba(255, 255, 255, 0.05);
            padding: 8px 15px;
            border-radius: 20px;
        }
       
        .promo-detail i {
            font-size: 20px;
            margin-right: 8px;
            color: #ff0000;
        }
       
        .products {
            margin-bottom: 40px;
        }
       
        .product-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 14px;
        }
       
        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, background 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
       
        .product-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.08);
        }

        .product-media {
            appearance: none;
            background: transparent;
            border: 0;
            padding: 0;
            width: 100%;
            display: block;
            text-align: left;
            cursor: pointer;
        }
       
        .product-image {
            position: relative;
            aspect-ratio: 4 / 3;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            padding: 10px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.25);
        }

        .product-caption {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.85) 100%);
        }

        /* Product lightbox */
        .lightbox {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .lightbox[hidden] {
            display: none;
        }

        .lightbox-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
        }

        .lightbox-dialog {
            position: relative;
            z-index: 2;
            width: min(980px, 92vw);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

        .lightbox-close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.35);
            color: #ffffff;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
        }

        .lightbox-close:hover {
            background: rgba(255, 0, 0, 0.35);
        }

        .lightbox-image {
            display: block;
            width: 100%;
            max-height: 78vh;
            object-fit: contain;
            background: rgba(0, 0, 0, 0.35);
        }

        .lightbox-title {
            padding: 12px 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #ffffff;
        }
       
        .guarantee {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s, background 0.3s;
        }
       
        .guarantee:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.08);
        }
       
        .guarantee i {
            font-size: 48px;
            color: #ff0000;
        }
       
        .guarantee-content h3 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
       
        .guarantee-content p {
            font-size: 18px;
            color: #cccccc;
        }
       
        .footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: #cccccc;
            font-size: 16px;
        }
       
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
       
        .contact-item {
            display: flex;
            align-items: center;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 20px;
            transition: background 0.3s;
            max-width: 100%;
        }
       
        .contact-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
       
        .contact-item i {
            margin-right: 8px;
            font-size: 20px;
            color: #ff0000;
        }
       
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
       
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, transform 0.3s;
        }
       
        .social-link:hover {
            background-color: #ff0000;
            transform: translateY(-3px);
        }
       
        .highlight {
            background: linear-gradient(transparent 60%, rgba(255, 0, 0, 0.3) 40%);
            padding: 0 3px;
        }
       
        .admin-link {
            display: inline-flex;
            align-items: center;
            color: #666;
            font-size: 14px;
            margin-top: 15px;
            text-decoration: none;
            transition: color 0.3s;
        }
       
        .admin-link:hover {
            color: #ff0000;
        }
       
        .admin-link i {
            font-size: 16px;
            margin-right: 5px;
        }

        /* Responsive breakpoints (mobile-first) */
        @media (min-width: 768px) {
            .services {
                grid-template-columns: repeat(2, 1fr);
            }

            .carousel-btn.prev {
                left: -16px;
            }

            .carousel-btn.next {
                right: -16px;
            }
        }

        @media (min-width: 1024px) {
            .services {
                grid-template-columns: repeat(3, 1fr);
            }

        }

        @media (max-width: 640px) {
            .header {
                justify-content: center;
                text-align: center;
            }

            .logo {
                justify-content: center;
            }

            .promo-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .promo-image {
                width: 96px;
                height: 96px;
            }

            .carousel-btn.prev {
                left: 4px;
            }

            .carousel-btn.next {
                right: 4px;
            }

            .guarantee {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        /* Companies carousel styles */
        .companies-carousel-wrap {
            position: relative;
            margin-bottom: 32px;
        }

        .companies-carousel-wrap::before,
        .companies-carousel-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 64px;
            pointer-events: none;
            z-index: 3;
        }

        .companies-carousel-wrap::before {
            left: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
        }

        .companies-carousel-wrap::after {
            right: 0;
            background: linear-gradient(270deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
        }

        .companies-carousel {
            overflow: hidden;
            width: 100%;
        }

        .companies-track {
            display: flex;
            gap: 28px;
            align-items: center;
            padding: 14px 68px;
            will-change: transform, scroll-position;
            width: max-content;
            animation: companies-marquee 40s linear infinite;
        }

        .companies-carousel-wrap:hover .companies-track,
        .companies-carousel-wrap:focus-within .companies-track {
            animation-play-state: paused;
        }

        @keyframes companies-marquee {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .companies-track {
                animation: none;
            }
        }

        .company-item {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            max-width: 180px;
        }

        .company-logo img {
            max-height: 56px;
            max-width: 170px;
            object-fit: contain;
            filter: grayscale(100%) opacity(0.85);
            transition: filter 0.25s ease, opacity 0.25s ease, transform 0.25s ease;
        }

        .company-logo img:hover {
            filter: none;
            opacity: 1;
            transform: translateY(-3px);
        }

        .company-name {
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            opacity: 0.85;
        }
    </style>
</head>
<body>
    <div class="poster-container">
        <div class="background-shape shape-1"></div>
        <div class="background-shape shape-2"></div>
        <div class="grid-texture"></div>
       
        <div class="content">
            <header class="header">
                <div class="logo">
                    <img src="{{ $logoUrl }}" alt="TextilOne Logo">
                </div>
                <nav class="nav">
                    <a class="nav-item" href="#services">{{ $settings->nav_services ?: 'Servicios' }}</a>
                    <a class="nav-item" href="#promotions">{{ $settings->nav_promotions ?: 'Promociones' }}</a>
                    <a class="nav-item" href="#contact">{{ $settings->nav_contact ?: 'Contacto' }}</a>
                </nav>
            </header>
           
            <section class="hero">
                <h1>{{ $settings->hero_title ?: 'Personalización de Textiles de Alta Calidad' }}</h1>
                <p>{{ $settings->hero_subtitle ?: 'Especialistas en estampados, bordados y sublimación para tu empresa' }}</p>
                <a href="{{ $settings->cta_url ?: '#' }}" class="cta-button">{{ $settings->cta_text ?: 'Cotiza ahora' }}</a>
            </section>
           
            <section class="section" id="services">
                <h2 class="section-title">
                    <i class="material-icons">category</i>
                    {{ $settings->services_title ?: 'Nuestros Servicios' }}
                </h2>
                <div class="services">
                    @foreach ($services as $service)
                        <div class="service-card">
                            <i class="material-icons">{{ $service->icon }}</i>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
           
            <section class="section promotions" id="promotions">
                <h2 class="section-title">
                    <i class="material-icons">local_offer</i>
                    {{ $settings->promotions_title ?: 'Promociones Exclusivas' }}
                </h2>
                @foreach ($promotions as $groupIndex => $group)
                    <div class="promo-carousel-wrap" data-carousel="promo-{{ $groupIndex }}">
                        <button type="button" class="carousel-btn prev" aria-label="Promoción anterior">
                            <i class="material-icons">chevron_left</i>
                        </button>

                        <div class="promo-carousel" role="region" aria-label="Promociones" tabindex="0">
                            <div class="promo-track">
                                @foreach ($group as $promo)
                                    <div class="promo-card">
                                        <div class="promo-header">
                                            <div class="promo-image">
                                                @if ($promo->image_media_id)
                                                    <img src="{{ route('media.show', $promo->image_media_id) }}" alt="{{ $promo->title }}">
                                                @elseif ($promo->image_path)
                                                    <img src="{{ asset('storage/' . $promo->image_path) }}" alt="{{ $promo->title }}">
                                                @else
                                                    <i class="material-icons">image</i>
                                                @endif
                                            </div>
                                            <div class="promo-content">
                                                <h3><i class="material-icons">{{ $promo->badge_icon ?: 'star' }}</i> {{ $promo->title }}</h3>
                                                <p>{{ $promo->description }}</p>
                                            </div>
                                        </div>
                                        <div class="promo-details">
                                            @foreach ($promo->details as $detail)
                                                <div class="promo-detail"><i class="material-icons">{{ $detail->icon }}</i>{{ $detail->text }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="button" class="carousel-btn next" aria-label="Siguiente promoción">
                            <i class="material-icons">chevron_right</i>
                        </button>
                    </div>
                @endforeach
            </section>
           
            <section class="section products">
                <h2 class="section-title">
                    <i class="material-icons">shopping_bag</i>
                    {{ $settings->products_title ?: 'Nuestros Productos' }}
                </h2>
                <div class="product-gallery">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <button
                                type="button"
                                class="product-media"
                                data-product-src="{{ $product->image_media_id ? route('media.show', $product->image_media_id) : ($product->image_path ? asset('storage/' . $product->image_path) : '') }}"
                                data-product-title="{{ $product->title }}"
                                aria-label="Ver {{ $product->title }}">
                                <div class="product-image">
                                    @if ($product->image_media_id)
                                        <img src="{{ route('media.show', $product->image_media_id) }}" alt="{{ $product->title }}">
                                    @elseif ($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
                                    @else
                                        {{ $product->image_text ?: 'Producto' }}
                                    @endif
                                    <div class="product-caption">{{ $product->title }}</div>
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>
           
            @if(isset($companies) && $companies->count())
            <section class="section companies" id="companies">
                <h2 class="section-title">
                    <i class="material-icons">business</i>
                    {{ $settings->companies_title ?: 'Empresas que confían en TextilOne' }}
                </h2>

                <div class="companies-carousel-wrap">
                    <div class="companies-carousel" role="region" aria-label="Empresas que trabajan con TextilOne" tabindex="0">
                        <div class="companies-track">
                            @foreach ($companies as $company)
                                <div class="company-item" role="listitem">
                                    <div class="company-logo">
                                        @if ($company->logo_media_id)
                                            <img src="{{ route('media.show', $company->logo_media_id) }}" alt="{{ $company->name }}">
                                        @elseif ($company->logo_path)
                                            <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}">
                                        @else
                                            <span class="company-name">{{ $company->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            {{-- duplicamos para un scroll continuo sin saltos --}}
                            @foreach ($companies as $company)
                                <div class="company-item" aria-hidden="true">
                                    <div class="company-logo">
                                        @if ($company->logo_media_id)
                                            <img src="{{ route('media.show', $company->logo_media_id) }}" alt="{{ $company->name }}">
                                        @elseif ($company->logo_path)
                                            <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}">
                                        @else
                                            <span class="company-name">{{ $company->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <section class="guarantee">
                <i class="material-icons">verified</i>
                <div class="guarantee-content">
                    <h3>{{ $settings->guarantee_title ?: 'Garantía' }}</h3>
                    <p>{{ $settings->guarantee_text ?: 'Calidad asegurada en todos nuestros productos.' }}</p>
                </div>
            </section>
           
            <footer class="footer" id="contact">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="material-icons">phone</i>
                        {{ $settings->phone ?: '+56 9 XXXX XXXX' }}
                    </div>
                    <div class="contact-item">
                        <i class="material-icons">email</i>
                        {{ $settings->email ?: 'contacto@textilonechile.cl' }}
                    </div>
                    <div class="contact-item">
                        <i class="material-icons">location_on</i>
                        {{ $settings->location ?: 'Santiago, Chile' }}
                    </div>
                </div>
                <div class="social-links">
                    @foreach ($socialLinks as $socialLink)
                        <a href="{{ $socialLink->url }}" class="social-link" target="_blank" rel="noopener noreferrer">
                            <i class="material-icons">{{ $socialLink->icon }}</i>
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('login') }}" class="admin-link">
                    <i class="material-icons">admin_panel_settings</i>
                </a>
                <p>{{ $settings->copyright_text ?: '© ' . date('Y') . ' TextilOne. Todos los derechos reservados.' }}</p>
            </footer>
        </div>
    </div>

    <div class="lightbox" id="product-lightbox" hidden aria-hidden="true">
        <div class="lightbox-backdrop" data-lightbox-close></div>
        <div class="lightbox-dialog" role="dialog" aria-modal="true" aria-label="Vista previa de producto">
            <button type="button" class="lightbox-close" aria-label="Cerrar" data-lightbox-close>×</button>
            <img class="lightbox-image" alt="">
            <div class="lightbox-title"></div>
        </div>
    </div>

    <script>
        (function () {
            const wraps = document.querySelectorAll('.promo-carousel-wrap');
            if (!wraps.length) return;

            const clamp = (n, min, max) => Math.max(min, Math.min(max, n));

            const initCarousel = (wrap) => {
                const carousel = wrap.querySelector('.promo-carousel');
                const prevBtn = wrap.querySelector('.carousel-btn.prev');
                const nextBtn = wrap.querySelector('.carousel-btn.next');
                if (!carousel || !prevBtn || !nextBtn) return;

                // Infinite (wrap-around) arrows
                const scrollByPage = (direction) => {
                    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;
                    const amount = Math.max(240, Math.floor(carousel.clientWidth * 0.9));

                    const nearStart = carousel.scrollLeft <= 2;
                    const nearEnd = carousel.scrollLeft >= maxScrollLeft - 2;

                    if (direction < 0 && nearStart) {
                        carousel.scrollTo({ left: maxScrollLeft, behavior: 'smooth' });
                        return;
                    }

                    if (direction > 0 && nearEnd) {
                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                        return;
                    }

                    const target = carousel.scrollLeft + direction * amount;
                    carousel.scrollTo({ left: clamp(target, 0, maxScrollLeft), behavior: 'smooth' });
                };

                prevBtn.disabled = false;
                nextBtn.disabled = false;

                prevBtn.addEventListener('click', () => scrollByPage(-1));
                nextBtn.addEventListener('click', () => scrollByPage(1));

                carousel.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        scrollByPage(-1);
                    }
                    if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        scrollByPage(1);
                    }
                });
            };

            wraps.forEach(initCarousel);
        })();
    </script>
    <script>
        (function () {
            const lightbox = document.getElementById('product-lightbox');
            if (!lightbox) return;

            const img = lightbox.querySelector('.lightbox-image');
            const titleEl = lightbox.querySelector('.lightbox-title');
            const closeEls = lightbox.querySelectorAll('[data-lightbox-close]');

            let lastActive = null;

            const open = (src, title) => {
                if (!src) return;

                lastActive = document.activeElement;
                img.src = src;
                img.alt = title || 'Producto';
                titleEl.textContent = title || '';

                lightbox.hidden = false;
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';

                const closeBtn = lightbox.querySelector('.lightbox-close');
                if (closeBtn) closeBtn.focus();
            };

            const close = () => {
                lightbox.hidden = true;
                lightbox.setAttribute('aria-hidden', 'true');
                img.src = '';
                img.alt = '';
                titleEl.textContent = '';
                document.body.style.overflow = '';

                if (lastActive && typeof lastActive.focus === 'function') {
                    lastActive.focus();
                }
                lastActive = null;
            };

            document.addEventListener('click', (e) => {
                const trigger = e.target.closest('[data-product-src]');
                if (!trigger) return;

                const src = trigger.getAttribute('data-product-src') || '';
                const title = trigger.getAttribute('data-product-title') || '';
                if (!src) return;

                e.preventDefault();
                open(src, title);
            });

            closeEls.forEach((el) => el.addEventListener('click', close));

            document.addEventListener('keydown', (e) => {
                if (lightbox.hidden) return;
                if (e.key === 'Escape') {
                    e.preventDefault();
                    close();
                }
            });
        })();
    </script>
</body>
</html>