
"use strict"

var cart = {

    'add': function (product_id, quantity) {

        // e.preventDefault();
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({
            type: 'POST',
            url: '/cart',
            data: {

                quantity: quantity,
                product_id: product_id,

            },
            success: function (data) {
                console.log(data.message);
                var total = data.total;
                var image = data.image;
                var name = data.pro_name;
                var message = data.message;

                // addProductNotice(' Product added ,' + '<img src=' + image + ' alt="">', '<h3> <a href="product.html">' + name + '</a>' + ' ' + message + ' ' + '<a href="cart.html"> shopping cart</a>!</h3>', 'success');
                addProductNotice(message);

                document.getElementById("totalqnt").innerHTML = total;
                updateCartTable();
                //	document.getElementById("totalout").innerHTML = total;
            }
        });


    },

    'reduce': function (cart_id) {
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({
            type: 'POST',
            url: '/cart/reduce',
            data: {
                cart_id: cart_id,

            },
            success: function (data) {
                // var total = data.total;
                // var image = data.image;
                // var name = data.pro_name;
                var message = data.message;
                addProductNotice(message);
                updateCartTable();
                location.reload();
                // addProductNotice(
                //     ' Item removed',
                //     '<img src=' + image + ' alt="">',
                //     '<h3><a href="product.html">' + name + '</a>' + ' ' + message + ' ' + '<a href="cart.html"> shopping cart</a>!</h3>',
                //     'success');
                // document.getElementById("totalout").innerHTML = total;
                // updateCartTable();
            }
        });

    },
    'increase': function (cart_id) {
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({
            type: 'POST',
            url: '/cart/increase',
            data: {
                cart_id: cart_id,

            },
            success: function (data) {
                // var total = data.total;
                // var image = data.image;
                // var name = data.pro_name;
                var message = data.message;
                addProductNotice(message);
                location.reload();
                updateCartTable();
                // addProductNotice(
                //     ' Item removed',
                //     '<img src=' + image + ' alt="">',
                //     '<h3><a href="product.html">' + name + '</a>' + ' ' + message + ' ' + '<a href="cart.html"> shopping cart</a>!</h3>',
                //     'success');
                // document.getElementById("totalout").innerHTML = total;
                // updateCartTable();
            }
        });

    }
}



function updateCartTable() {

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });


    // alert(product_id);
    // alert(product_size);

    $.ajax({
        type: 'GET',
        url: '/cart/get-cart-table',
        data: {},
        success: function (data) {

            var table = data.table;
            var cartSum = data.sum;


            document.getElementById("cartNew").innerHTML = table;
            document.getElementById("summm").innerHTML = cartSum;
        }
    });
}


function addProductNotice(
    message) {

    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right"
    };
    toastr.success(message);

    // location.reload();
}
