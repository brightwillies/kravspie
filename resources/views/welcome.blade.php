<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home | KravsPie</title>
    @include('includes.head')

    <!-- <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css"> -->
    <style>
        .backcolor {
            /* background: beige; */
            /* font-family: Quando"; */
            font-weight: 800;
            font-family: "Quando";
            text-shadow: 0px -2px 0px #ffffff;
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .hero_content2 {
                margin-top: 200px !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .hero_content2 {
                margin-top: 200px !important;
            }
        }

        #movedownmore {
            margin-top: 40px !important;
        }
    </style>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
    <link rel="stylesheet" href="/assets/css/swiper-bundle.min.css">
</head>

<body>


    <!--offcanvas menu area start-->
    <div class="body_overlay">

    </div>

    @include('includes.header')



    <!-- page search box -->
    <div class="page_search_box">
        <div class="search_close">
            <i class="ion-close-round"></i>
        </div>
        <form class="border-bottom" action="#">
            <input class="border-0" placeholder="Search products..." type="text">
            <button type="submit"><span class="pe-7s-search"></span></button>
        </form>
    </div>

    <!--slide banner section start-->
    <div class="img-fluid hero_banner_section  hero_banner2 align-items-center mb-60" data-bgimg="assets/img/bg/backgroundd.jpg">
        <!-- <div class="img-fluid hero_banner_section  hero_banner2 align-items-center mb-60" data-bgimg="assets/img/bg/christmas.jpg"> -->
        <!-- <div class="img-fluid hero_banner_section hero_banner2 d-flex align-items-center mb-60" data-bgimg="https://kravspie.com/wp-content/uploads/2021/11/Picture-1-scaled.jpg"> -->
        <div class="container">
            <div class="hero_banner_inner">
                <div class="row align-items-center">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="hero_content  hero_content2 newme">
                            <h3 class="wow fadeInUp text-white" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            </h3>
<div class="text-center">
<a id="shopbutton" style="margin-top:100px;" class="text-center btn btn-link wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s" href="/products/9">Pre-order Now</a>

</div>
                               <h1 style="margin-top:90px;"  class="wow fadeInUp  backcolor" data-wow-delay="0.2s" data-wow-duration="1.2s"> A Ghanaian inspired crust filled with global flavors</h1>
                            <!-- <h1 class="wow fadeInUp  backcolor" data-wow-delay="0.2s" data-wow-duration="1.2s"> ‘Tis the season for Gifts!</h1> -->
                            <!-- <h4  style="font-size: 2.5rem;" class="text-center  backcolor">The proof is in the crust !</h4> -->

                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>
    <!--slider area end-->


    <!-- product section start -->
    <div class="product_section mb-80 wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
        <div class="container text-center">
            <div class="product_header">
                <div class="section_title text-center">
                    <h2>HANDMADE GOURMET PIES</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <p style="font-weight: 600;">We use real butter and the finest quality ingredients to bake pies that are addictive. Pies are flaky on the outside, full on the inside, yummy all the way.</p>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </div>
    <!-- product section end -->


    <!-- product section start -->
    <div class="product_section mb-80 wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
        <div class="container">
            <div class="product_header">
                <div class="section_title text-center">
                    <h2>FEATURED PRODUCTS</h2>
                </div>
            </div>
            <div class="product_gallery">
                <div class="row">
                    @if($products)
                    @foreach ($products as $key => $product)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a href="/products/{{$product->id}}"><img src="{{$product->image}}" alt=""></a>
                                    <div class="action_links">
                                        <!-- <ul class="d-flex justify-content-center">
                                            <li class="add_to_cart"><a onclick="event.preventDefault(); cart.add({{$product->id}}, '1');" href="home/title" title="Add to cart">
                                                    <span class="pe-7s-shopbag"></span></a></li>

                                        </ul> -->
                                    </div>
                                </div>
                                <figcaption class="product_content text-center">
                                    <h4><a href="/products/{{$product->id}}">{{$product->name}}</a></h4>
                                    <div class="price_box">

                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                    </div>

                    @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!-- product section end -->






    <!-- testimonial section start -->
    <!-- <div class="testimonial_section mb-110 wow fadeInUp" data-bgimg="/assets/img/bg/eat.jpg" data-wow-delay="0.1s" data-wow-duration="1.1s"> -->
    <div class="testimonial_section mb-110 wow fadeInUp" data-wow-delay="0.1s" data-wow-duration="1.1s">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>People Love Our Pies and You Will Too!</h1>
                </div>

                <div class="col-lg-12">

                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide text-center">

                                    <i style="padding-left: 20px; font-size:25px;">The Almond pie is sooo good </i>
                                    <h5>Kray W.</h5>
                                </div>
                                <div class="swiper-slide text-center">

                                    <i style="padding-left: 20px; font-size:25px;"> Thank you for the delicious pie </i>
                                    <h5>Priscilla Shirer</h5>
                                </div>
                            </div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <!-- testimonial section start -->
    <!-- <button type="button" onclick="deviceType()"> Click me</button> -->
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-12 text-center">
                <h1>In The News</h1>
            </div>
            <div class="col-lg-4 col-sm-12">
                <a href="https://www.dallasnews.com/food/restaurant-news/2021/07/12/dallas-based-ghanaian-bakers-pie-shop-tells-a-story-of-west-africa/">
                    <img src="/assets/img/bg/news1.png" alt="">
                </a>
            </div>
            <div class="col-lg-4 col-sm-12">
                <a href="https://vegoutmag.com/food-and-drink/10-vegan-desserts-you-need-to-try-on-goldbelly">
                    <img src="/assets/img/bg/news2.png" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-12">
                <a href="http://voyagedallas.com/interview/check-joseline-ballards-story/">
                    <img src="/assets/img/bg/news3.png" alt="">

                </a>
            </div>

        </div>
    </div>
    <!-- testimonial section end -->


    <!--footer area start-->
    @include('includes.footer')
    <!--footer area end-->

    @include('includes.foot')





    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            // Optional parameters

            grabCursor: true,
            cubeEffect: {
                shadow: true,
                slideShadows: true,
                shadowOffset: 20,
                shadowScale: 0.94,
            },
            autoplay: {
                delay: 4000,

                disableOnInteraction: false,
            },
            loop: true,


            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },


        });
    </script>





</body>

</html>
