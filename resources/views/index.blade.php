<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artbox</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/ab-favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" href="{{ asset('frontend/index.css') }}">
</head>

<body>

<header>
    <div class="header">
        <div class="header-wrapper">
            <div class="logo" onclick="scrollToTop()">
                <a href="#">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="" class="image-logo">
                </a>
            </div>
            <div class="nav">
                <li><a href="#index" class="scroll-link active" onclick="scrollToTop()">trang chủ</a></li>
                <li><a href="#introduction" class="scroll-link" onclick="scrollToCenter('introduction')">giới
                        thiệu</a></li>
                <li><a href="#job" class="scroll-link" onclick="scrollToCenter('project-category')">công trình</a>
                </li>
                <li><a href="#contact" class="scroll-link" onclick="scrollToCenter('contact')">liên hệ</a></li>
            </div>
            <div class="toggle-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </div>
    </div>
</header>

<main>
    <section id="banner">
        <div class="askew banner-wrapper">
            <img src="{{ asset('storage/') . '/' .$banner->image }}" alt="" class="banner-image">
            <img src="{{ asset('storage/') . '/' .$banner->image_mobile }}" alt="" class="banner-mobile">

            <div class="banner-content">
                <span class="heading">{{ $banner->title }}</span>
                <span class="desc"> {{ $banner->short_desc }}</span>
            </div>
        </div>
    </section>
    <section class="section-fade-in" id="introduction">
        <div class="introduction-wrapper">
            <div class="line"></div>
            <h1 class="heading">01. Giới thiệu</h1>
            <div class="introduction-content">
                <div class="introduction-image">
                    <img src="{{ asset('storage/') . '/' .$setting->introduce_image }}" alt="team">
                </div>
                <div class="intro-text">
                    <p>
                        {{ $setting->introduce_text }}
                    </p>

                </div>
            </div>
        </div>
    </section>
    <section class="section-fade-in" id="project-category">
        <div class="project-category-wrapper">
            <div class="line"></div>
            <h1 class="heading">02. Công trình</h1>
            <div class="project-list">
                @foreach($constructions as $item)
                    <div class="project-item section-fade-in" data-id="{{ $item->id }}">
                        <div class="thumb">
                            @isset($item->images)
                                <img src=" {{ asset('storage/' . $item->images->first()->path) }}" alt=""
                                     class="item-image">
                            @endisset
                        </div>
                        <div class="content">
                            <span class="name">{{ $item->title }}</span>
                            <span class="area">{{ $item->area }}</span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="section-fade-in" id="contact">
        <div class="contact-wrapper">
            <div class="line"></div>
            <h1 class="heading">03. Liên hệ</h1>
            <div class="contact-info">
                <a class="mail" href="{{ $setting->email }}">{{ $setting->email }}</a>
                <span class="hotline"> Hotline: {{ substr($setting->phone_number, 0, 4) . '.' . substr($setting->phone_number, 4, 3) . '.' . substr($setting->phone_number, 7) }}</span>
                <span class="address">{{ $setting->address }}</span>
            </div>
        </div>
    </section>

    <button class="scroll-top-mobile" id="scrollToTopBtn" onclick="scrollToTop()">
        <i class="fa-solid fa-caret-up"></i>
    </button>
</main>
<footer>
    <div class="footer">
        <div class="footer-wrapper">
            <div class="social-link">
                <a href="{{ $setting->facebook_url }}" target="_blank">
                    <img src="{{ asset('frontend/images/icon-fb.png') }}" alt="facebook">
                </a>
                <a href="{{ $setting->instagram_url }}" target="_blank">
                    <img src="{{ asset('frontend/images/icon-instagram.png')}}" alt="instagram">
                </a>
            </div>
            <span class="copyright">© 2024 bản quyền của Artbox</span>
        </div>
    </div>
</footer>

<x-construction-modal-component/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function () {
        $('.list-images').slick({
            initialSlide: 0, // Start with the first slide on the left
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            adaptiveHeight: true,
            prevArrow: $('.slick-prev'),
            nextArrow: $('.slick-next')
        });
    });
</script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/banner-scroll.js') }}"></script>
</body>

</html>
