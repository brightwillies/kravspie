<div class="offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="offcanvas_menu_wrapper">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                        </div>
                        <div class="welcome_text text-center">
                            <p>Welcome to KravsPie</p>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">

                                <li><a class="active" href="/">Home</a></li>
                                <li><a href="/about-us">About Us</a></li>
                                <li><a href="/shop">Pre-Order</a></li>

                                <li class="menu-item-has-children"><a href="/contact-us">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--offcanvas menu area end-->

    <!--header area start-->
    <header class="header_section">
        <div class="header_top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header_top_inner d-flex justify-content-between">
                            <div class="welcome_text">


                            <!-- <p class="text-center">Store is currently closed until May 11, 2022</p> -->
                            <p  class="text-center">
                            Attention Shoppers: Pre-order for pickup locally from
                            <a target="_blank"  style="color:#302020;"  href="https://www.google.com/maps/place/665+Country+Club+Rd,+Lucas,+TX+75002,+USA/@33.0934036,-96.5963304,17z/data=!3m1!4b1!4m5!3m4!1s0x864c107241af3093:0x9e62376278716331!8m2!3d33.0934036!4d-96.5941417">
                            665 Country Club Rd, Lucas, TX 75002.
                        </a>  </p>
                            <!-- <p  class="text-center">Attention Shoppers: Nationwide Shipping Only through GOLDBELLY Website! Preorder On Website Only If You Can Pickup Locally From the <a target="_blank"  style="color:#302020;" href="https://g.page/DFMDallasFarmersMarket_?share">Dallas Farmers Market</a>  , on Saturdays 10am - 3:30pm.</p> -->
                            </div>

                            <div class="header_top_sidebar d-flex align-items-center">
                                <ul class="d-flex">
                                    <li><i class="icofont-phone"></i> <a href="tel:+4693644405">+1(469) 364-4405</a>
                                    </li>

                                    <li class="account_link"> <i class="icofont-user-alt-7"></i><a href="#">Account</a>
                                        <ul class="dropdown_account_link">
                                            <!-- <li><a href="/my-account">My Account</a></li> -->

                                            {!!$check_aut!!}
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main_header d-flex justify-content-between align-items-center">
                        <div class="header_logo">
                            <a class="sticky_none" href="/"><img width="132px" height="50px" src="/assets/img/logo/logoo.png" alt=""></a>
                        </div>
                        <!--main menu start-->
                        <div class="main_menu d-none d-lg-block">
                            <nav>
                                <ul class="d-flex">


                                    <li><a    class="{{ (request()->is('/')) ? 'active' : '' }}"   class="active" href="/">Home</a></li>
                                    <li><a  class="{{ (request()->is('about-us')) ? 'active' : '' }}" href="/about-us">About</a></li>
                                    <li><a  class="{{ (request()->is('shop')) ? 'active' : '' }}"   href="/shop">Pre-Order</a></li>
                                    <li><a class="{{ (request()->is('contact-us')) ? 'active' : '' }}"  href="/contact-us">Contact</a></li>
                                    <li><a class="{{ (request()->is('event')) ? 'active' : '' }}"  href="/event">Events</a></li>

                                    <li><a  target="_blank" href="https://www.goldbelly.com/kravs-pie?__cf_chl_jschl_tk__=REcGOEP7hQz0HuRaKgt11guaxP2_mQUxyX7d21DvTK8-1636890421-0-gaNycGzNCL0"> <strong style="font-size:18px; font-weight: 800 !important;" > NationWide Delivery </strong></a></li>

                                </ul>
                            </nav>
                        </div>
                        <!--main menu end-->
                        <div class="header_account">
                            <ul class="d-flex">

                                <!-- <li class="header_search"><a href="javascript:void(0)"><i class="pe-7s-search"></i></a>
                                </li> -->

                                <li id="mright" class="shopping_cart"><a href="#" onclick="return false;"><i class="pe-7s-cart"></i>
                                    <span id="totalqnt"  class="item_count">{{$cart_total}}</span></a>
                                </li>
                            </ul>
                            <div id="mright" class="canvas_open">
                                <a href="#"  onclick="return false;"><i class="ion-navicon"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--mini cart-->
    <div class="mini_cart">
        <div class="cart_gallery">
            <div class="cart_close">
                <div class="cart_text">
                    <h3>cart</h3>
                </div>
                <div class="mini_cart_close">
                    <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                </div>
            </div>
            <div id="cartNew">
            @if($cartProducts)
            @foreach ($cartProducts as $key => $cProduct)
            <div class="cart_item">
                <div class="cart_img">
                    <a href="/products/{{$cProduct->slug}}"><img width="88px" height="100px" src="{{$cProduct->image}}" alt=""></a>
                </div>
                <div class="cart_info">
                    <a href="/products/{{$cProduct->slug}}">{{$cProduct->name}}</a>
                    <p>{{$cProduct->quantity}} x <span> $  {{number_format($cProduct->price, 2, '.', '')}}</span></p>
                </div>

            </div>
            @endforeach
            @endif
            </div>

        </div>
        <div class="mini_cart_table">
            <div class="cart_table_border">

                <div class="cart_total mt-10">
                    <span>total:</span>
                    <span id="summm" class="price">$ {{number_format($cartSum, 2, '.', '')}}</span>
                </div>
            </div>
        </div>
        <div class="mini_cart_footer">
            <div class="cart_button">
                <a href="/my-cart">View cart</a>
            </div>
            <div class="cart_button">
                <a href="/checkout"><i class="fa fa-sign-in"></i> Checkout</a>
            </div>
        </div>
    </div>
    <!--mini cart end-->
