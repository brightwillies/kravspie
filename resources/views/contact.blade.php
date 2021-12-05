<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contact | KravsPie</title>
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
                        <h1 style="color:white;">Contact Us</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->

    <!-- contact section start -->
    <div class="contact_page_section mb-100">
        <div class="container">
            <div class="contact_details">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="contact_info_content">

                            <div class="contact_info_details mb-45">
                                <h3>NOTICE</h3>
                                <p style="color: red;" >All orders on this website are to be picked up at Dallas Market on Saturdays</p>

                                <span class="text-center">See  Map below</span>
                            </div>

                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3354.5625629196925!2d-96.79151348481795!3d32.77733978097186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864e98e17bb9fbc1%3A0xbcf9f72cfca3498a!2sDallas%20Farmers%20Market!5e0!3m2!1sen!2sgh!4v1636887199281!5m2!1sen!2sgh" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="contact_form" data-bgimg="assets/img/others/contact-form-bg-shape.png">
                            <h2>Send A Message</h2>
                            <form id="contact-form" action="https://whizthemes.com/mail-php/other/mail.php">
                                <div class="form_input">
                                    <input name="con_name" placeholder="Name*" type="text">
                                </div>
                                <div class="form_input">
                                    <input name="con_email" placeholder="E-Mail*" type="text">
                                </div>
                                <div class="form_input">
                                    <input name="con_subject" placeholder="Subject" type="text">
                                </div>
                                <div class="form_textarea">
                                    <textarea name="con_message" placeholder="Message Hare"></textarea>
                                </div>
                                <div class="form_input_btn">
                                    <button type="submit" class="btn btn-link">send message</button>
                                </div>
                                <p class="form-message"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact section end -->



    <!--footer area start-->
 @include('includes.footer')
    <!--footer area end-->

    <!-- JS
============================================ -->

@include('includes.foot')

</body>

</html>
