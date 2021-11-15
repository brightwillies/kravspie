<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cart | KravsPie</title>
    @include('includes.head')


    <style>
        .pro-qtyy {
            padding: 0 10 px;
            border-radius: 7 px;
            padding: 0 18 px;
            background: #505050;
            display: inline-block;
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
    <div class="breadcrumbs_aree breadcrumbs_bg mb-110" data-bgimg="assets/img/bg/inner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs_text">
                        <h1>Cart</h1>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li> // Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->
    <div class="cart-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th class="product_remove">remove</th> -->
                                        <th class="product-thumbnail">image</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="product-price">Unit Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($cartProducts)
                                    @foreach ($cartProducts as $key => $ccProduct)
                                    <tr>

                                        <td class="product-thumbnail">
                                            <a href="#">
                                                <img width="100px" height="100px" src="{{$ccProduct->image}}" alt="Cart Thumbnail">
                                            </a>
                                        </td>
                                        <td class="product-name"><a href="/products/{{$ccProduct->slug}}">{{$ccProduct->name}}</a>
                                        </td>
                                        <td class="product-price"><span class="amount">$ {{number_format($ccProduct->price, 2, '.', '')}}</span></td>

                                        <td class="product_pro_button quantity">
                                            <div class="pro-qty  border">
                                                <a  onclick="event.preventDefault(); cart.reduce({{$ccProduct->id}});"  href="" class="dec qty-btn">-</a>
                                                <input type="text" value="{{$ccProduct->quantity}}">
                                                <a  onclick="event.preventDefault(); cart.increase({{$ccProduct->id}});"  href="" class="inc qty-btn">+ </a>
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">$ {{number_format($ccProduct->subprice, 2, '.', '')}}</span></td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-7"></div>
                            <div class="col-md-5 mr-auto">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul>

                                        <li>Total <span>$ {{number_format($cartSum, 2, '.', '')}}</span></li>
                                    </ul>
                                    <div class="text-center">
                                    <a href="/checkout">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--footer area start-->
    @include('includes.footer')
    <!--footer area end-->

    <!-- JS
============================================ -->

    @include('includes.foot')

</body>

</html>
