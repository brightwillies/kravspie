<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home | KravsPie</title>
    @include('includes.head')
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
    <div class="img-fluid hero_banner_section hero_banner2 d-flex align-items-center mb-60" data-bgimg="assets/img/bg/backgroundd.jpg">
    <!-- <div class="img-fluid hero_banner_section hero_banner2 d-flex align-items-center mb-60" data-bgimg="https://kravspie.com/wp-content/uploads/2021/11/Picture-1-scaled.jpg"> -->
        <div class="container">
            <div class="hero_banner_inner">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="hero_content hero_content2">
                            <h3 class="wow fadeInUp text-white" data-wow-delay="0.1s" data-wow-duration="1.1s">
                                </h3>
                            <h1 class="wow fadeInUp text-white" data-wow-delay="0.2s" data-wow-duration="1.2s"> Not Your Average Pie</h1>
                            <h4>The proof is in the crust !</h4>
                            <a id="shopbutton" style="margin-top:40px;" class="btn btn-link wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1.3s" href="/shop">Shop Now</a>
                        </div>
                    </div>
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
                <p>We use real butter and the finest quality ingredients to bake pies that are addictive. Pies are flaky on the outside, full on the inside, yummy all the way.</p>
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
                                        <span class="current_price">$
                                            <!-- 268 x307-->
                                            {{number_format($product->price, 2, '.', '')}}
                                        </span>
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
 <div class="testimonial_section mb-110 wow fadeInUp" data-bgimg="/assets/img/bg/eatt.jpg" data-wow-delay="0.1s" data-wow-duration="1.1s">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4>People Love Our Pies & You Will Too!</h4>
                </div>

                <div class="col-12">
                    <div class="testimonial_wrapper slick__activation" data-slick='{
                        "slidesToShow": 1,
                        "slidesToScroll": 1,
                        "arrows": false,
                        "dots": false,
                        "autoplay": true,
                        "speed": 300,
                        "infinite": true ,
                        "responsive":[
                          {"breakpoint":500, "settings": { "slidesToShow": 1 } }
                         ]
                    }'>
                        <div class="testimonial_inner d-flex align-items-center">
                            <div class="testimonial_thumb">
                                <img src="assets/img/bg/eat.jpg" alt="">
                            </div>
                            <div class="testimonial_content">

                                <div class="testimonial_author">
                                    <h3>Kyra W.</h3>
                                    <h4>Customer</h4>
                                </div>
                                <div class="testimonial_desc">
                                    <p>The Almond pie is sooo good </p>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_inner d-flex align-items-center">
                            <div class="testimonial_thumb">
                                <img src="assets/img/bg/eat.jpg" alt="">
                            </div>
                            <div class="testimonial_content">

                                <div class="testimonial_author">
                                    <h3>Priscilla Shirer</h3>
                                    <h4>Customer</h4>
                                </div>
                                <div class="testimonial_desc">
                                    <p>Thank you for the delicious Pie</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial section end -->


    <!--footer area start-->
    @include('includes.footer')
    <!--footer area end-->






    @include('includes.foot')
</body>

</html>
