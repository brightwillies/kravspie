<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Checkout | KravsPie</title>
    @include('includes.head')
    <!-- <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script> -->
    <script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>

    <script>
        // const appId = 'sandbox-sq0idb-_jIaAsk0s2luLB6CRVuhQw';
   const appId = 'sq0idp-qcUGINR_epBSs95dMWeVbw';
        const locationId = 'L35RCSQ0E5DNT';

        async function initializeCard(payments) {
            const card = await payments.card();
            await card.attach('#card-container');

            return card;
        }

        async function createPayment(token) {

            const _token = this['token'].value;
            const ffamount = this['amountt'].value;
            const famount = (ffamount * 100);
            const dayy = this['pickupdate'].value;
            const pickuptime = this['pickuptime'].value;
            const items = this['items'].value;

            const typpe = this['typpe'].value;


            if (typpe === "guest") {
                console.log('guest');
                // if there is ty
                const first_name = this['first_name'].value;
                const last_name = this['last_name'].value;
                const email = this['email'].value;
                const telephone_number = this['telephone_number'].value;


                if (first_name == "" || last_name == "" || email == "" || telephone_number == "") {

                    alert('Please fill all the fields');
                    // return false;
                    const errorBody = await paymentResponse.text();
                    throw new Error(errorBody);
                } else {
                    const body = JSON.stringify({
                        locationId,
                        sourceId: token,
                        amount: famount,
                        pickupdate: dayy,
                        pickuptime: pickuptime,
                        items: items,
                        _token: _token,
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        telephone_number: telephone_number,
                        type: typpe,
                    });

                    const paymentResponse = await fetch('/payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body,
                    });

                    if (paymentResponse.ok) {
                        return paymentResponse.json();
                    }

                    const errorBody = await paymentResponse.text();
                    throw new Error(errorBody);
                }
            }


            if (typpe === "customer") {

                const body = JSON.stringify({
                    locationId,
                    sourceId: token,
                    amount: famount,
                    pickupdate: dayy,
                    pickuptime: pickuptime,
                    items: items,
                    _token: _token,
                    type: typpe,
                });


                const paymentResponse = await fetch('/payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body,
                });

                if (paymentResponse.ok) {
                    return paymentResponse.json();
                }

                const errorBody = await paymentResponse.text();
                throw new Error(errorBody);

            } //ending here



        }

        async function tokenize(paymentMethod) {
            const tokenResult = await paymentMethod.tokenize();
            if (tokenResult.status === 'OK') {
                return tokenResult.token;
            } else {
                let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                if (tokenResult.errors) {
                    errorMessage += ` and errors: ${JSON.stringify(
              tokenResult.errors
            )}`;
                }

                throw new Error(errorMessage);
            }
        }

        // status is either SUCCESS or FAILURE;
        function displayPaymentResults(status) {
            const statusContainer = document.getElementById(
                'payment-status-container'
            );
            if (status === 'SUCCESS') {

                console.log('Yes it went through');
                window.location.replace("/order-placed");
                statusContainer.classList.remove('is-failure');
                statusContainer.classList.add('is-success');
            } else {

                statusContainer.classList.remove('is-success');
                statusContainer.classList.add('is-failure');
                console.log('no it didnt');
            }

            statusContainer.style.visibility = 'visible';
        }

        document.addEventListener('DOMContentLoaded', async function() {
            if (!window.Square) {
                throw new Error('Square.js failed to load properly');
            }

            let payments;
            try {
                payments = window.Square.payments(appId, locationId);
            } catch {
                const statusContainer = document.getElementById(
                    'payment-status-container'
                );
                statusContainer.className = 'missing-credentials';
                statusContainer.style.visibility = 'visible';
                return;
            }

            let card;
            try {
                card = await initializeCard(payments);
            } catch (e) {
                console.error('Initializing Card failed', e);
                return;
            }

            // Checkpoint 2.
            async function handlePaymentMethodSubmission(event, paymentMethod) {
                event.preventDefault();

                try {
                    // disable the submit button as we await tokenization and make a payment request.
                    cardButton.disabled = true;
                    const token = await tokenize(paymentMethod);
                    const paymentResults = await createPayment(token);
                    displayPaymentResults('SUCCESS');

                    console.debug('Payment Success', paymentResults);
                } catch (e) {
                    cardButton.disabled = false;
                    displayPaymentResults('FAILURE');
                    console.error(e.message);
                }
            }

            const cardButton = document.getElementById('card-button');
            cardButton.addEventListener('click', async function(event) {
                await handlePaymentMethodSubmission(event, card);
            });
        });
    </script>
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
    <div class="breadcrumbs_aree breadcrumbs_bg mb-110" data-bgimg="/assets/img/bg/inner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs_text">
                        <h1></h1>
                        <ul>
                            <li><a href="/"></a></li>
                            <li> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs area end -->
    <div class="checkout-area">
        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-12">
                    <div class="your-order">
                        <h3>Your order</h3>
                        <div class="your-order-table table-responsive">
                            <table class="table">


                                <tfoot>

                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td><strong><span class="amount">$ {{number_format($cartSum, 2, '.', '')}}
                                                </span></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="#payment-1">
                                            <h5 class="panel-title">
                                                <a href="#" class="" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                                                    <span style="color:red;"> NOTICE </span>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <p class="mb-3">
                                                    Place the order Only If You Can Pickup Locally From <a target="_blank" href="https://www.google.com/maps/dir//jelly+queens/data=!4m6!4m5!1m1!4e2!1m2!1m1!1s0x8644d18e8ad497f5:0xc45322eb4ec2b458?sa=X&ved=2ahUKEwjBhd71j9D0AhXGyTgGHYmpBO8Q9Rd6BAhKEAU
                                                 "><b>The Jelly Queens, McKinney,TX on December 23 & 24 </b> </a>
                                                </p>
                                            </div>
                                        </div>
                                        @if($type == 'guest')
                                        <button class="btn btn-primary" style="width: 100%;">Login as Returning / New Customer</button>
                                        <div class="text-center">
                                            <h5>OR</h5>
                                        </div>
                                        <div class="text-center">
                                            <h5>Checkout as a guest</h5>
                                        </div>
                                        @endif
                                        @if($type == 'guest')

                                        <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                            <div class="card-body">

                                                <div class="login-form row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group ">
                                                            <label>First Name</label>
                                                            <input type="text" id="first_name" name="first_name" placeholder="First Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Last Name</label>
                                                        <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Email Address*</label>
                                                        <input id="email" name="email" type="email" placeholder="Email Address">

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Phone Number *</label>
                                                        <input type="text" id="telephone_number" name="telephone_number" placeholder="Telephone Number">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <form id="payment-form">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="pickupdate">Choose Pickup Date:</label><br>

                                                    <select class="custom-select" name="date" id="pickupdate">
                                                        @foreach ($days as $key => $day)
                                                        <option style="width: 100%;" value="{{$day}}">{{$day}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="pickupdate">Choose Pickup Time:</label><br>

                                                    <select class="custom-select" name="timedate" id="pickuptime">
                                                        <!-- <option style="width: 100%;" value="10:00-10:30">10:00-10:30</option>
                                                        <option style="width: 100%;" value="10:30-11:00">10:30-11:00</option>
                                                        <option style="width: 100%;" value="11:00-11:30">11:00-11:30</option>
                                                        <option style="width: 100%;" value="11:30-12:00">11:30-12:00</option>
                                                        <option style="width: 100%;" value="12:00-12:30">12:00-12:30</option>
                                                        <option style="width: 100%;" value="12:30-13:00">12:30-13:00</option>
                                                        <option style="width: 100%;" value="13:00-13:30">13:00-13:30</option>
                                                        <option style="width: 100%;" value="13:30-14:00">13:30-14:00</option>-->
                                                        <option style="width: 100%;" value="14:00-14:30">14:00-14:30</option>
                                                        <option style="width: 100%;" value="14:30-15:00">14:30-15:00</option>
                                                        <option style="width: 100%;" value="15:00-15:30">15:00-15:30
                                                        </option>
                                                        <option style="width: 100%;" value="15:30-16:00">15:30-16:00
                                                        </option>
                                                        <option style="width: 100%;" value="16:00-16:30">16:00-16:30
                                                        </option>
                                                        <option style="width: 100%;" value="16:30-17:00">16:30-17:00
                                                        </option>
                                                        <option style="width: 100%;" value="17:00-17:30">17:00-17:30
                                                        </option>
                                                        <option style="width: 100%;" value="17:30-18:00">17:30-18:00
                                                        </option>
                                                        <!-- <option style="width: 100%;" value="18:00-18:30">18:00-18:30
                                                        </option>
                                                        <option style="width: 100%;" value="18:30-19:00">18:30-19:00
                                                        </option> -->
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div id="card-container"></div>
                                            <div class="order-button-payment">
                                                <!-- <button id="card-button" style="width: 100%;" class="btn btn-primary" type="button">Pay ${{number_format($cartSum, 2, '.', '')}}</button> -->
                                            </div>
                                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                                            <input type="hidden" id="amountt" name="amountt" value="{{$cartSum}}">
                                            <input type="hidden" id="items" name="items" value="{{$idvaleues}}">
                                            <input type="hidden" id="typpe" name="typpe" value="{{$type}}">
                                        </form>
                                        <div id="payment-status-container">

                                        </div>

                                    </div>


                                </div>
                                <!-- <div class="order-button-payment">
                                    <input value="Place order" type="submit">
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <img src="/assets/img/bg/bbgg.jpg" alt="">
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
