<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shop | KravsPie</title>
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

    <!-- breadcrumbs area start -->
    <div class="breadcrumbs_aree breadcrumbs_bg mb-100" data-bgimg="/assets/img/bg/inner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs_text">
                        <h1></h1>
                        <ul>
                            <li><a href="/"> </a></li>
                            <li> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->

    <!-- product page section start -->
    <div class="product_page_section mb-100">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 order-1 order-lg-2">
                    <div class="product_page_wrapper">
                        <!--shop toolbar area start-->

                        <!--shop toolbar area end-->


                        <!--shop gallery start-->
                        <div class="product_page_gallery">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="grid">
                                    <div class="row grid__product">
                                    @if($products)
                    @foreach ($products as $key => $product)
                                        <div class="col-lg-4 col-md-4 col-sm-6">
                                            <article class="single_product wow fadeInUp" data-wow-delay="0.1s"
                                                data-wow-duration="1.1s">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="/products/{{$product->id}}"><img
                                                                src="{{$product->image}}" alt=""></a>
                                                        <div class="action_links">
                                                            <ul class="d-flex justify-content-center">
                                                                <li class="add_to_cart"><a  onclick="event.preventDefault(); cart.add({{$product->id}}, '1');" href="#"
                                                                        title="Add to cart">
                                                                        <span class="pe-7s-shopbag"></span></a></li>


                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content text-center">
                                                        <h4><a href="/products/{{$product->id}}">{{$product->name}}</a></h4>
                                                        <div class="price_box">
                                                            <span class="current_price">  {{number_format($product->price, 2, '.', '')}}</span>
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

                        <!--shop gallery end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product page section end -->

    <!--footer area start-->
    @include('includes.footer')
    <!--footer area end-->




    <!-- JS
============================================ -->
@include('includes.foot')
</body>

</html>
