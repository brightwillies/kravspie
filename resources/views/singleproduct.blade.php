<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Kravs Pie </title>
    @include('includes.head')

    <style>
        .product_thumb img {
    width: 100%;
    height: 250px !important;
}

modifyhere ul{

    list-style: square !important;
}

#modifyhere ul{
    list-style: square !important;
}
    </style>
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

    <!-- breadcrumbs area start -->
    <div class="breadcrumbs_aree breadcrumbs_bg mb-100" data-bgimg="/assets/img/bg/inner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs_text">
                        <h1></h1>
                        <ul>
                            <li><a href="/"> </a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->

    <!-- single product section start-->
    <div class="single_product_section mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single_product_gallery">
                        <div class="product_gallery_inner d-flex">
                            <div class="product_gallery_main_img">
                                <!-- <div class="gallery_img_list">
                                    <img data-image="{{$product->image}}"
                                        src="{{$product->image}}" alt="">
                                </div> -->
                                <div class="gallery_img_list">
                                    <img  src="{{$product->image}}" alt="">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_details_sidebar">
                        <h2 class="product__title">{{$product->name}}</h2>
                        <div class="price_box">
                            <span class="current_price">

                         ${{number_format($product->price, 2, '.', '')}}
                            </span>
                        </div>

                        <p class="product_details_desc">
<div id="modifyhere">
                        {!!$product->description!!}
                        </div>
                        </p>
                        <div class="product_pro_button quantity d-flex align-items-center">
                            <!-- <div class="pro-qty border">
                                <input type="text" value="1">
                            </div> -->
                            <a  onclick="event.preventDefault(); cart.add({{$product->id}}, '1');" class="add_to_cart " href="#">add to cart</a>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details section end-->



    <!-- product section start -->
    <div class="product_section mb-80">
        <div class="container">
            <div class="section_title text-center mb-55">
                <h2>Related Products</h2>

            </div>
            <div class="row product_slick slick_navigation slick__activation" data-slick='{
                "slidesToShow": 4,
                "slidesToScroll": 1,
                "arrows": true,
                "dots": false,
                "autoplay": false,
                "speed": 300,
                "infinite": true ,
                "responsive":[
                  {"breakpoint":992, "settings": { "slidesToShow": 3 } },
                  {"breakpoint":768, "settings": { "slidesToShow": 2 } },
                  {"breakpoint":500, "settings": { "slidesToShow": 1 } }
                 ]
            }'>

            @if($products)
                    @foreach ($products as $key => $Sproduct)
                <div class="col-lg-3">
                    <article class="single_product">
                        <figure>
                            <div class="product_thumb">
                                <a href="/products/{{$Sproduct->id}}"><img   height="330px" id="offimage"   src="{{$Sproduct->image}}" alt=""></a>
                                <div class="action_links">
                                    <ul class="d-flex justify-content-center">
                                        <li class="add_to_cart"><a onclick="event.preventDefault(); cart.add({{$Sproduct->id}}, '1');" href="#" title="Add to cart"> <span
                                                    class="pe-7s-shopbag"></span></a></li>


                                    </ul>
                                </div>
                            </div>
                            <figcaption class="product_content text-center">
                                <h4><a href="/products/{{$Sproduct->id}}">{{$Sproduct->name}}</a></h4>
                                <div class="price_box">
                                    <span class="current_price">${{number_format($Sproduct->price, 2, '.', '')}}</span>
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
    <!-- product section end -->

    @include('includes.footer')



@include('includes.foot')

</body>

</html>
