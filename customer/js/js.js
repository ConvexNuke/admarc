//add to cart with function
function addToCart(product_id, product_name, price, type) {
    var qty = '';
    if (type == 'input') {
        qty = $("#quantity").val();
    } else {
        var qty = 1;
    }

    if (price != '') {
        // $("#cartItems").html('d')
        // $("#cartCounter").html('d')
        $("#btn_cart_add" + product_id).html('...')

        $.ajax({
            url: "process/cart_manager.php",
            method: "POST",
            data: {
                add_id: product_id,
                qty: qty,
                product_name: product_name,
                price: price
            },

            success: function (data) {
                // alert(data);
                console.log(data)
                var dataResult = JSON.parse(data);
                $("#cartCounter").html(dataResult.count_cart);
                alert('Added to cart')
                $("#btn_cart_add" + product_id).html('<span><i class="ion-ios-cart"></i></span>');


            }
        });
    } else {
        alert('Price is invalid for ' + product_name);
    }


}

// delete from cart
function deleteFromCart(prod_id) {

    $.ajax({
        url: "process/cart_manager.php",
        method: "POST",
        data: {
            del_id: prod_id
        },

        success: function (data) {
            var dataResult = JSON.parse(data);
            $("#cartCounter").html(dataResult.count_cart);
            $("#cart_total").html(dataResult.cart_total);
            // alert(data);
            // console.log(dataResult)
            alert("Product removed!")

            if (dataResult.count_cart == 0) {


                window.location = 'cart.php'

            } else {
                console.log("HAHAHAHAH")
                // $("#cart-list").html('<p class="text-center alert alert-warning">No products in cart!</p>')
                $('#cartRow' + prod_id).remove();
            }


        }
    });

}

$(".buy-now").click(function (evt) {
    evt.preventDefault();       // prevents browser's default anchor behavior
});
$(".rmCrt").click(function (evt) {
    evt.preventDefault();       // prevents browser's default anchor behavior
});

$("input[name='optradio']").change(function (e) {
    // Do something interesting here
    if ($(this).val() === 'create') {
        alert('guest')
    } else if ($(this).val() === 'guest') {
        alert('create')
    }
});

//submit checkout form
$("#checkoutForm1").on('submit', function (e) {
    var form_data = $(this).serialize();


    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var phone = $("#phone").val();
    var address = $("#address").val();


    if (fname !== '' && lname !== '' && phone !== '' && address !== '') {

        $("#loginBtn").html('Saving...');
        $.ajax({ //make ajax request to cart_process.php
            url: "process/checkout.php",
            type: "POST",
            //dataType:"json", //expect json value from server
            data: form_data
        }).done(function (dataResult) { //on Ajax success
            console.log(dataResult)
            $("#loginBtn").html('Place an order');
            var data = JSON.parse(dataResult);

            if (data.code == 1) {
                $("#response").html('<span class="text-center alert alert-success" >' + data.msg + '</span>')
                setTimeout(function () {
                    window.location = "shop.php";
                }, 1500);
            } else if (data.code == 2) {
                $("#response").html('<span class="text-center alert text-danger">' + data.msg + '</span>')
            } else {
                $("#response").html('<span class="text-center alert alert-danger">Unknown error occured while saving, please try again later!</span>')
            }

        });


    } else {
        $("#response").html('<span class="text-center alert alert-danger">Fill all fields!</span>')

    }


    e.stopImmediatePropagation();
    e.preventDefault();
});


$("#checkoutForm").on('submit', function (e) {

    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var phone = $("#phone").val();
    var address = $("#address").val();


    if (fname !== '' && lname !== '' && phone !== '' && address !== '') {
        var form_data = new FormData(this); //Creates new FormData object

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: 'process/checkout.php',
            type: 'post',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Place an order');
                var data = JSON.parse(dataResult);

                if (data.code == 1) {
                    $("#response").html('<span class="text-center alert alert-success" >' + data.msg + '</span>')
                    setTimeout(function () {
                        window.location = "shop.php";
                    }, 1500);
                } else if (data.code == 2) {
                    $("#response").html('<span class="text-center alert text-danger">' + data.msg + '</span>')
                } else {
                    $("#response").html('<span class="text-center alert alert-danger">Unknown error occured while saving, please try again later!</span>')
                }
            },
        });

    } else {
        $("#response").html('<span class="text-center alert alert-danger">Fill all fields!</span>')

    }
    e.preventDefault();
    e.stopImmediatePropagation();
});




