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


    <!-- <div class="img-fluid hero_banner_section  hero_banner2 align-items-center mb-60" data-bgimg="assets/img/bg/backgroundd.jpg">

        <div class="container">
            <div class="hero_banner_inner">
                <div class="row align-items-center">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="hero_content  hero_content2 newme">
                            <h3 class="wow fadeInUp text-white" data-wow-delay="0.1s" data-wow-duration="1.1s">
                            </h3>
                            <div class="text-center">
                                <a id="shopbutton" style="margin-top:100px;" class="btn btn-link wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s" href="/shop">Pre-order Now for local pickup</a>

                            </div>
                            <h1 class="wow fadeInUp  backcolor" data-wow-delay="0.2s" data-wow-duration="1.2s">HANDMADE GOURMET PIES INSPIRED BY GLOBAL FLAVORS</h1>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
    </div> -->
    <!--slider area end-->

    <div class="container" style="margin-top:20px; margin-bottom:20px;">
    <div class="row">
        <div class="col-lg-12 text-center" id="eventnotice">
            <h3>COMING TO AN EVENT NEAR YOU</h3>
        </div>
        <div class="col-lg-4">
            <img width="400px" height="300px" src="/assets/img/bg/events.jpg" alt="">
        </div>
        <div class="col-lg-8" id="borderdiv" style="padding-left:30px;">
            <h5 id="eventnotice"> Lucas Farmers Market</h5>
            <h5 id="eventnotice">665 Country Club Rd, Lucas, TX 75002 </h5>
            <h5 id="eventnotice">May 14th & May 28th </h5>
            <h5 id="eventnotice">8am – 12 noon </h5>
<hr style="margin-top:30px; margin-bottom:30px;">
<div class="eventnotice"></div>
            <h5 id="eventnotice">The Dallas Arboretum and Botanical Garden</h5>
            <h5 id="eventnotice">8525 Garland Rd, Dallas, TX 75218 </h5>
            <h5 id="eventnotice">May 14th & 15th  </h5>
            <h5 id="eventnotice">10am-4pm  </h5>
        </div>
    </div>
</div>







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
