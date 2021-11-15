<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bucker – Login | Register</title>
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
    <div class="breadcrumbs_aree breadcrumbs_bg mb-110" data-bgimg="/assets/img/bg/inner.png">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs_text">
                        <h1>Login | Register</h1>
                        <ul>
                            <li><a href="/">Home </a></li>
                            <li> // Forgot Password</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->
    <div class="login-register-area">
        <div class="container">
            <div class="row">
            @if (session('message')) <div class="alert alert-success"> {{ session('message') }} </div> @endif
            @if($errors->any())<div class="alert alert-danger"><h4>{{$errors->first()}}</h4>  </div> @endif
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <form method="POST"  action="/customer/forgot-password">
                    @csrf
                        <div class="login-form">
                            <h4 class="login-title">Enter your email for password</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Email Address*</label>
                                    <input name="email" type="email" placeholder="Email Address">
                                </div>


                                <div class="col-lg-12 pt-5">
                                    <button type="submit" class="btn custom-btn md-size">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
<div class="col-lg-4"></div>
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
