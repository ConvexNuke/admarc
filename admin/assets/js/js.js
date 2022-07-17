//register
$("#registerForm").on('submit', function (e) {
    var form_data = $(this).serialize();

    var email = $("#email").val();
    var pass1 = $("#pass1").val();
    var pass2 = $("#pass2").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var phone = $("#phone").val();
    var city_name = $("#city_name").val();

    if (email !== '' && pass1 !== '' && pass2 !== '' && fname !== '' && lname !== '' && phone !== '' && city_name !== '') {
        if (pass1 !== pass2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Passwords do not match!",
            })
        } else {
            $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Validating...</span></div></div>');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/register.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('FINISH');
                var data = JSON.parse(dataResult);

                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "index.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occured",
                    })
                }

            });
        }


    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Fields with a * are required",
        })
    }


    e.stopImmediatePropagation();
    e.preventDefault();
});

//add user
$("#addUserForm").on('submit', function (e) {
    var form_data = $(this).serialize();

    var email = $("#email").val();
    var pass1 = $("#pass1").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var phone = $("#phone").val();
    var city_name = $("#city_name").val();

    // console.log(email + "----" + phone + '--' + fname + "--" + lname + '---' + city_name + '---' + pass1)

    if (email !== '' && pass1 !== '' && fname !== '' && lname !== '' && phone !== '' && city_name !== '') {

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Validating...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: "process/manage_user.php",
            type: "POST",
            //dataType:"json", //expect json value from server
            data: form_data
        }).done(function (dataResult) { //on Ajax success
            console.log(dataResult)
            $("#loginBtn").html('SAVE');
            var data = JSON.parse(dataResult);

            if (data.code == 1) {
                Swal.fire(
                    'Success!',
                    data.msg,
                    'success'
                )
                setTimeout(function () {
                    window.location = "users.php";
                }, 1000);
            } else if (data.code == 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.msg,
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Unknown error occured",
                })
            }

        });


    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Fields with a * are required",
        })
    }


    e.stopImmediatePropagation();
    e.preventDefault();
});

//add branch
$("#addBranchForm").on('submit', function (e) {
    var form_data = $(this).serialize();

    var branch_name = $("#branch_name").val();
    var branch_phone = $("#branch_phone").val();

    var city_name = $("#city_name").val();


    if (branch_name !== '' && branch_phone !== '' && city_name !== '') {

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: "process/manage_branch.php",
            type: "POST",
            //dataType:"json", //expect json value from server
            data: form_data
        }).done(function (dataResult) { //on Ajax success
            console.log(dataResult)
            $("#loginBtn").html('SAVE');
            var data = JSON.parse(dataResult);

            if (data.code == 1) {
                Swal.fire(
                    'Success!',
                    data.msg,
                    'success'
                )
                setTimeout(function () {
                    window.location = "branches.php";
                }, 1000);
            } else if (data.code == 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.msg,
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Unknown error occured",
                })
            }

        });


    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Fields with a * are required",
        })
    }


    e.stopImmediatePropagation();
    e.preventDefault();
});


//login
$("#loginForm").on('submit', function (e) {
    var form_data = $(this).serialize();

    var email = $("#email").val();
    var password = $("#password").val();
    if (email !== '' && password !== '') {

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Checking...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: "process/login.php",
            type: "POST",
            //dataType:"json", //expect json value from server
            data: form_data
        }).done(function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Login');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "index.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else if (data.code == 3) {

                    Swal.fire({
                        title: 'New system',
                        text: data.msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Configure'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "register.php";
                        }
                    })

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }

            }
        );

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Empty fields!"
        })
    }
    e.preventDefault();
});

//add product
$("#addProductForm").on('submit', function (e) {

    var prod_name = $("#prod_name").val();
    var prod_price = $("#prod_price").val();
    var prod_qty = $("#prod_qty").val();


    if (prod_name !== '' && prod_price !== '' && prod_qty !== '') {
        var form_data = new FormData(this); //Creates new FormData object

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: 'process/manage_product.php',
            type: 'post',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Save');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "products.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }
            },
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Please fill the required fields!",
        })
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});



//add to cart with function
function addToCart(product_id, product_name, price) {
    var qty = $("#prod_qty" + product_id).val();
    // $("#cartItems").html('d')
    // $("#cartCounter").html('d')
    $("#btn_cart_add" + product_id).html('Adding...')

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
            var dataResult = JSON.parse(data);
            $("#cartCounter").html(dataResult.count_cart);
            $("#cartItems").html(dataResult.htmlData)
            $("#cart_total").html(dataResult.cart_total)
            Swal.fire(
                'Success!',
                'Added',
                'success'
            )

            $("#btn_cart_add" + product_id).html('<span class="mdc-button__label">Add to Cart</span><div class="mdc-button__ripple"></div>');


        }
    });

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
            // alert(data);
            var dataResult = JSON.parse(data);
            $("#cartCounter").html(dataResult.count_cart);
            $("#cartItems").html(dataResult.htmlData)
            $("#cartItems2").html(dataResult.htmlData)
            $("#cart_total").html(dataResult.cart_total)
            if (dataResult.cart_total > 0) {
                $("#btnPay").html('<a href="#" onclick="finishPayment()" class="mdc-button mdc-button--outlined "><i class="mdi mdi-paypal"></i> PAY K(' + dataResult.cart_total + ')</a>')

            } else {
                $("#btnPay").html('')

            }

            Swal.fire(
                'Success!',
                'Removed',
                'success'
            )


        }
    });

}

//finish payment
function finishPayment() {
    var finish_payment = 's';
    $.ajax({
        url: "process/cart_manager.php",
        method: "POST",
        data: {
            finish_payment: finish_payment
        },

        success: function (dataResult) {
            // alert(data);
            console.log(dataResult)
            var data = JSON.parse(dataResult);
            if (data.code == 1) {
                Swal.fire(
                    'Success!',
                    data.msg,
                    'success'
                )
                setTimeout(function () {
                    window.location = "obtain_products.php";
                }, 1000);
            } else if (data.code == 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.msg,
                })

                setTimeout(function () {
                    window.location = "obtain_products.php";
                }, 1000)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Unknown error occurred!",
                })
            }


        }
    });

}

$("#admarcProductForm").on('submit', function (e) {

    var product_name = $("#product_name").val();
    var buying_price = $("#buying_price").val();
    var selling_price = $("#selling_price").val();
    var qty_obtained = $("#qty_obtained").val();
    var date_start_sale = $("#date_start_sale").val();
    var date_end_sale = $("#date_end_sale").val();
    var branch_id = $("#branch_id").val();


    if (branch_id !== '' && product_name !== '' && buying_price !== '' && selling_price !== '' && selling_price !== '' && qty_obtained !== '' && date_start_sale !== '' && date_end_sale !== '') {
        var form_data = new FormData(this); //Creates new FormData object

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: 'process/manage_product.php',
            type: 'post',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Save');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "manage_admarc_product.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }
            },
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Please fill the required fields!",
        })
    }
    e.preventDefault();
    e.stopImmediatePropagation();
})

//add to cart with form
$("#addCartForm").on('submit', function (e) {
    var form_data = $(this).serialize();

    $("#add-to-cart").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Adding...');
    $.ajax({ //make ajax request to cart_process.php
        url: "process/cart_manager.php",
        type: "POST",
        //dataType:"json", //expect json value from server
        data: form_data
    }).done(function (data) { //on Ajax success
//		   console.log(data);
        $("#add-to-cart").html('Add to cart');
        var dataResult = JSON.parse(data);

        if (dataResult.code == 1) {
            $("#cart_count").html(dataResult.count_cart);
            var cart = $('.shopping-cart');
            var imgtodrag = $("#mm").eq(0);
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left
                    })
                    .css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': '150px',
                        'width': '150px',
                        'z-index': '100'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 100,
                        'height': 100
                    }, 1000, 'easeInOutExpo');

                setTimeout(function () {
                    cart.effect("shake", {
                        times: 1
                    }, 200);
                }, 1500);

                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function () {
                    $(this).detach()
                });
            }
        }

    });


    e.preventDefault();
    e.stopImmediatePropagation();
});

//add product category
$("#addProductCategoryForm").on('submit', function (e) {

    var category_name = $("#category_name").val();


    if (category_name !== '') {
        var form_data = new FormData(this); //Creates new FormData object

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: 'process/manage_category.php',
            type: 'post',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Save');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "categories.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }
            },
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Please fill the required fields!",
        })
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});

//update user profile
$("#changeProfile").on('submit', function (e) {

    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var phone = $("#phone").val();
    var email = $("#email").val();


    if (fname !== '' && lname !== '' && phone !== '' && email !== '') {
        var form_data = new FormData(this); //Creates new FormData object

        $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
        $.ajax({ //make ajax request to cart_process.php
            url: 'process/manage_user.php',
            type: 'post',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('Save');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        // window.location = "products.php";
                        location.reload();

                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }
            },
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Please fill the required fields!",
        })
    }
    e.preventDefault();
    e.stopImmediatePropagation();
});


//add set customer city
function setCity() {
    $("#addCityForm").on('submit', function (e) {
        var form_data = $(this).serialize();
        var customer_city = $("#customer_city").val();

        if (customer_city !== '') {
            $("#addCityBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/location_session_manager.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success

                $("#addCityBtn").html('<i class="fas fa-map-marker-alt"></i> Find Food');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    setTimeout(function () {
                        window.location = "meals";
                    }, 500);
                } else {
                    $("#citySetResponse").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#citySetResponse").fadeOut();
                    }, 1500);
                }

            });

        } else {
            $("#citySetResponse").html('<p class="alert alert-danger text-center">Select Location</p>');
            setTimeout(function () {
                $("#citySetResponse").fadeOut();
            }, 1500);
        }
        e.preventDefault();
    });

}

//view meal
function toMealDetail(id) {
    startPreloader();
    $("#content").load("pages/meal_details.php", {id: id});
    $("#page_title1").html('Meal Details');
    $("#page_title2").html('<ul><li class="breadcrumb-item"><a href="index">Home</a></li><li class="breadcrumb-item"><a href="meals">All Meals</a></li><li class="breadcrumb-item active" aria-current="page">Meal Details</li></ul>');
}

//ordering calculate total
function calculateNewTotal() {

}

//remove product from cart
function removeFromCart(del_id) {
    var qty = parseInt($("#qty" + del_id).val());
    if (del_id !== '') {
        $.ajax({
            url: "process/cart_manager.php",
            method: "POST",
            data: {
                del_id: del_id,
                qty: qty
            },

            success: function (data) {
//                    alert(data);
                var dataResult = JSON.parse(data);
                if (dataResult.code == 1) {
                    $("#cart_count").html(dataResult.count_cart);
                    $("#total_para").html("MWK " + $.number(dataResult.new_total, 2));
                    $("#final_total").html(dataResult.new_total);
                    $("#cart_row" + del_id).remove();
                    if (dataResult.count_cart == 0) {
                        window.location = 'cart';
                    }
                } else {
                    $("#msg_title").html(dataResult.msg)
                    $("#modal_warning").modal("toggle");
                }
            }
        });
    }
}

//calculate subtotal
function calculateSubTotal(id) {
    var product_price = parseInt($("#prod_cart_price" + id).val());
    var delivery_fee = parseInt($("#prod_fee_price" + id).val());
    var tot_size = parseInt($("#tot_size" + id).val());
    var tot_options = parseInt($("#tot_options" + id).val());
    var qty = parseInt($("#qty" + id).val());

    var prod_curr_tot = parseInt($("#prod_curr_tot" + id).val());
    var curr_final_tot = parseInt($("#final_total").val());
    if (product_price !== '' && delivery_fee !== '' && qty !== '' && prod_curr_tot !== '' && curr_final_tot !== '') {
        var old_final = curr_final_tot - prod_curr_tot;

        var new_tot = ((product_price + tot_options + tot_size) * qty) + delivery_fee;


        var new_final = old_final + new_tot;


        $.ajax({
            url: "process/cart_manager.php",
            method: "POST",
            data: {
                id: id,
                new_tot: new_tot,
                qty: qty
            },

            success: function (data) {
//                    alert(data);
                var dataResult = JSON.parse(data);
                if (dataResult.code == 1) {
                    $("#subtotal" + id).html("MWK " + $.number(new_tot, 2));
                    $("#prod_curr_tot" + id).val(new_tot);
                    $("#final_total").val(new_final);
                    $("#total_para").html("MWK " + $.number(new_final, 2));
                } else {
                    $("#msg_title").html(dataResult.msg)
                    $("#modal_warning").modal("toggle");
                }
            }
        });


    } else {
        $("#msg_title").html("Oops, something went wrong!")
        $("#modal_warning").modal("toggle");
    }

}

//open view meals by restaurant
function setRestaurant(id) {
    if (id !== '') {

        setCookie('view_restaurant', id, 1);
        window.location = 'restaurant_menu';
    } else {
        alert('d');
    }

}

//open view meals by restaurant
function setMeal(id) {
    if (id !== '') {

        setCookie('meal_detail', id, 1);
        window.location = 'meals#meal_details';
    } else {
        alert('d');
    }

}

//RESETTING PASSWORD
function openResetPage() {
    $("#title").html("Password Reset");
    $("#formCont").load('pages/resetpassword1.php');
}

function next(email) {
    $("#formCont").load('pages/resetpassword2.php', {email: email});
}

function next2(email) {
    $("#formCont").load('pages/resetpassword3.php', {email: email});
}

//resetpassword
function sendResetEmail() {
    $("#resetForm1").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#reset_email").val();

        if (email !== '') {

            $("#reset1").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/password_reset_manager.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                $("#reset1Response").html('');
                $("#reset1Response").fadeIn();
                $("#reset1").html('Next');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    $("#reset1Response").html('<p class="alert alert-success text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        next(email);
                    }, 1000);
                } else if (data.code == 2) {
                    $("#reset1Response").html('<p class="alert alert-danger text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#reset1Response").fadeOut();
                    }, 1500);
                } else {
                    $("#reset1Response").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#reset1Response").fadeOut();
                    }, 1500);
                }

            });

        } else {
            $("#reset1Response").html('<p class="alert alert-danger text-center">All fields are required</p>');
            setTimeout(function () {
                $("#reset1Response").fadeOut();
            }, 1500);
        }
        e.preventDefault();
    });

}

function checkCode() {
    $("#resetForm2").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#cemail").val();
        var code = $("#code").val();
        if (email !== '' && code !== '') {

            $("#reset2Btn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/password_reset_manager.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                $("#reset2Response").html('');
                $("#reset2Response").fadeIn();
                $("#reset2Btn").html('Next');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    $("#reset2Response").html('<p class="alert alert-success text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        next2(email);
                    }, 1000);
                } else if (data.code == 2) {
                    $("#reset2Response").html('<p class="alert alert-danger text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#reset2Response").fadeOut();
                    }, 1500);
                } else {
                    $("#reset2Response").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#reset2Response").fadeOut();
                    }, 1500);
                }

            });

        } else {
            $("#reset2Response").html('<p class="alert alert-danger text-center">All fields are required</p>');
            setTimeout(function () {
                $("#reset2Response").fadeOut();
            }, 1500);
        }
        e.preventDefault();
    });

}

function resetFinish() {
    $("#resetForm3").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#remail").val();
        var pass1 = $("#pass1").val();
        var pass2 = $("#pass2").val();
        if (email !== '' && pass1 !== '' && pass2 !== '') {
            if (pass1 === pass2) {
                $("#reset3Btn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
                $.ajax({ //make ajax request to cart_process.php
                    url: "process/password_reset_manager.php",
                    type: "POST",
                    //dataType:"json", //expect json value from server
                    data: form_data
                }).done(function (dataResult) { //on Ajax success
                    $("#reset3Response").html('');
                    $("#reset3Response").fadeIn();
                    $("#reset2Btn").html('Next');
                    var data = JSON.parse(dataResult);
                    if (data.code == 1) {
                        $("#reset3Response").html('<p class="alert alert-success text-center">' + data.msg + '</p>');
                        setTimeout(function () {
                            window.location = "login";
                        }, 1000);
                    } else if (data.code == 2) {
                        $("#reset3Response").html('<p class="alert alert-danger text-center">' + data.msg + '</p>');
                        setTimeout(function () {
                            $("#reset3Response").fadeOut();
                        }, 1500);
                    } else {
                        $("#reset3Response").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                        setTimeout(function () {
                            $("#reset3Response").fadeOut();
                        }, 1500);
                    }

                });
            } else {
                $("#reset3Response").html('<p class="alert alert-danger text-center">Passwords do not match</p>');
                setTimeout(function () {
                    $("#reset3Response").fadeOut();
                }, 1500);
            }

        } else {
            $("#reset3Response").html('<p class="alert alert-danger text-center">All fields are required</p>');
            setTimeout(function () {
                $("#reset3Response").fadeOut();
            }, 1500);
        }
        e.preventDefault();
    });

}

//USER PROFILE
//profile update
function updatePersonalDetails() {
    $("#personaldetailsForm").on('submit', function (e) {
        var form_data = $(this).serialize();
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var personal_id = $("#personal_id").val();
        if (personal_id !== '' && phone !== '' && fname !== '' && lname !== '' && email !== '') {

            $("#btn_personal_details").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/profile_manager.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                $("#personalDetailsResponse").html('');
                $("#personalDetailsResponse").fadeIn();
                $("#btn_personal_details").html(' Save Changes');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    $("#personalDetailsResponse").html('<p class="alert alert-success text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        window.location = "profile";
                    }, 1000);
                } else if (data.code == 2) {
                    $("#personalDetailsResponse").html('<p class="alert alert-danger text-center">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#personalDetailsResponse").fadeOut();
                    }, 1500);
                } else {
                    $("#personalDetailsResponse").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#personalDetailsResponse").fadeOut();
                    }, 1500);
                }

            });

        } else {
            $("#personalDetailsResponse").html('<p class="alert alert-danger text-center">All fields are required</p>');
            setTimeout(function () {
                $("#personalDetailsResponse").fadeOut();
            }, 1500);
        }
        e.preventDefault();
    });

}

//password update
function updatePassword() {
    $("#passwordForm").on('submit', function (e) {
        var form_data = $(this).serialize();
        var cpass = $("#cpass").val();
        var npass = $("#npass").val();
        var pass_id = $("#pass_id").val();
        var cnpass = $("#cnpass").val();
        if (npass !== cnpass) {
            $("#passwordDetailsResponse").html('<p class="alert alert-danger text-center">New password and confirm do not match!</p>');
            setTimeout(function () {
                $("#passwordDetailsResponse").fadeOut();
            }, 1500);
        } else {
            if (pass_id !== '' && cpass !== '' && npass !== '') {

                $("#btn_password_details").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
                $.ajax({ //make ajax request to cart_process.php
                    url: "process/profile_manager.php",
                    type: "POST",
                    //dataType:"json", //expect json value from server
                    data: form_data
                }).done(function (dataResult) { //on Ajax success
                    $("#passwordDetailsResponse").html('');
                    $("#passwordDetailsResponse").fadeIn();
                    $("#btn_password_details").html(' Save Changes');
                    var data = JSON.parse(dataResult);
                    if (data.code == 1) {
                        $("#passwordDetailsResponse").html('<p class="alert alert-success text-center">' + data.msg + '</p>');
                        setTimeout(function () {
                            window.location = "profile";
                        }, 1000);
                    } else if (data.code == 2) {
                        $("#passwordDetailsResponse").html('<p class="alert alert-danger text-center">' + data.msg + '</p>');
                        setTimeout(function () {
                            $("#passwordDetailsResponse").fadeOut();
                        }, 1500);
                    } else {
                        $("#passwordDetailsResponse").html('<p class="alert alert-danger text-center">Unknown error occured try again later!</p>');
                        setTimeout(function () {
                            $("#passwordDetailsResponse").fadeOut();
                        }, 1500);
                    }

                });

            } else {
                $("#passwordDetailsResponse").html('<p class="alert alert-danger text-center">All fields are required</p>');
                setTimeout(function () {
                    $("#passwordDetailsResponse").fadeOut();
                }, 1500);
            }
        }


        e.preventDefault();
    });

}

//profile picture
function upload1() {
    $("#pictureForm").on('submit', function (e) {
        $("#dp1DetailsResponse").html('');
        $("#dp1DetailsResponse").fadeIn(500);

        var profile_id = $("#profile_id").val();
        var file_size = $('#profile1')[0].files[0].size;
        var f_size = true;
        var f_type = true;
        var ext = $('#profile1').val().split('.').pop().toLowerCase();
        //Allowed file types
        if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG']) == -1) {
            f_type = false;
            $("#profileChange").hide();
            $("#dp1DetailsResponse").html('<p class="text-center alert alert-danger" style="width:100%;">✖ File type not supported, try png,jpg or jpeg files!</p>');
            setTimeout(function () {
                $("#dp1DetailsResponse").fadeOut(500);
            }, 800);
        }

        if (file_size > 3000000) {

            f_size = false;
//                response("File size should not exceed 3mb!");
            $("#dp1DetailsResponse").html('<p class="text-center alert alert-danger" style="width:100%;">✖ File size should not exceed 3mb!</p>');
            setTimeout(function () {
                $("#dp1DetailsResponse").fadeOut(500);
            }, 800);
        }

        if (f_type == true && f_size == true && profile_id !== '') {
            $("#btn_prof_details").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Processing...');
            var fd = new FormData();
            var files = $('#profile1')[0].files[0];
            fd.append('profile1', files);
            fd.append('profile_id', profile_id);
            $.ajax({
                url: 'process/dp_manager.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
//                        alert(data);
                    $("#dp1DetailsResponse").fadeIn(500);
                    $("#btn_prof_details").html("Upload");
                    var dataResult = JSON.parse(data);
                    if (dataResult.code == 1) {
                        $("#dp1DetailsResponse").html('<span class="text-center alert alert-success" style="width:100%;">Success</span>');
                        $("#img").attr('src', 'uploads/' + dataResult.msg);
                        $("#image_name").val(dataResult.msg);
//                            $("#img").show(); // Display image element
                    } else {
                        $("#profileChange").hide();
//                            alert('file not uploaded');
                        $("#dp1DetailsResponse").html('<span class="text-center alert alert-danger" style="width:100%;">' + dataResult.msg + '</span>');

                    }
                },
            });
        } else {
            setTimeout(function () {
                $("#dp1DetailsResponse").fadeOut(500);
            }, 800);
            $("#dp1DetailsResponse").html('<span class="text-center alert alert-danger" style="width:100%;">✖ File type is invalid or size exceeds 3mb!</span>');
            $("#profileChange").hide();
        }
        e.preventDefault();
    });

}


//PAYMENT PART
function show_netsoft() {
    var location = $("#location").val();
    var manual_location = $("#manual_location").val();
    var longtude = $("#longtude").val();
    var latitude = $("#latitude").val();
    var place_id = $("#place_id").val();
    var total_pay = $("#total_pay").val();

    if (manual_location !== '') {
        if (location !== '' && manual_location !== '' && longtude !== '' && latitude !== '' && place_id !== '' && total_pay !== '') {
            $("#payBtnn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Checking...');
            $("#checkoutData").load("pages/netsoftmoney.php", {
                location: location,
                manual_location: manual_location,
                longtude: longtude,
                latitude: latitude,
                place_id: place_id,
                total_pay: total_pay
            });
        } else {
            $("#msg_title").html("Refresh the page, failed to get your location");
            $("#modal_warning").modal('toggle');
        }
    } else {
        $("#manual_location").focus();
        $("#msg_title").html("Enter your address");
        $("#modal_warning").modal('toggle');
    }
}


//ORDER HISTORY
//assign to orders
function toViewOrder(id) {
    startPreloader();
    $("#page_title1").html('View Order');
    $("#page_title2").html('View Order');
    $("#content").load("pages/view_order.php", {id: id});

}


//SEARCH PART
function search() {

    var searchValue = $("#searchValue").val();
    if (searchValue !== '') {
        $("#replaceSearch").hide();
        $("#searchedContent").show();
    }
}

//	 	load_data();
function load_data(query) {
    $('#search_btn').html('<div class="spinner-grow spinner-grow-sm" role="status">  <span class="sr-only">Loading...</span></div>');

    $("#replaceSearch").hide();
    $("#searchedContent").show();
    $.ajax({
        url: "process/fetch_search.php",
        method: "post",
        data: {query: query},
        success: function (data) {
            $('#searchedContent').html(data);
            $('#search_btn').html('<i class="fas fa-search"></i>');
        }
    });
}

$('#searchValue').keyup(function () {
    $('#searchedContent').html('<br/><br/><br/><div class="text-center"><span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Searching...</div><br/><br/><br/>');
    var search = $(this).val();
    if (search !== '') {
        load_data(search);
    } else {
        $("#replaceSearch").show();
        $("#searchedContent").hide();
        $('#search_btn').html('<i class="fas fa-search"></i>');


    }
});

//SUBSCRIBE NEWS LETTER
function subscribe() {
    $("#subscribeForm").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#newsletter").val();
        if (email !== '') {

            $("#subscribeBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Subscribing...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/subscribe.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                $("#subscribeResponse").fadeIn();
                $("#subscribeBtn").html('Subscribe');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    $("#subscribeResponse").html('<p class="alert alert-success text-center" style="color:#000;">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#subscribeResponse").fadeOut();
                    }, 1000);
                } else if (data.code == 2) {
                    $("#subscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#subscribeResponse").fadeOut();
                    }, 1000);
                } else {
                    $("#subscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#subscribeResponse").fadeOut();
                    }, 1000);
                }

            });

        } else {
            $("#subscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">Enter Email</p>');
            setTimeout(function () {
                $("#subscribeResponse").fadeOut();
            }, 1000);
        }
        e.preventDefault();
        e.stopImmediatePropagation();
    });
}

function unsubscribe() {
    $("#unsubscribeForm").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#email").val();
        if (email !== '') {

            $("#unsubscribeBtn").html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Removing email...');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/subscribe.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                console.log(dataResult);
                $("#unsubscribeResponse").fadeIn();
                $("#unsubscribeBtn").html('Unsubscribe');
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    $("#unsubscribeResponse").html('<p class="alert alert-success text-center" style="color:#000;">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#unsubscribeResponse").fadeOut();
                        window.location = "index";
                    }, 1000);
                } else if (data.code == 2) {
                    $("#unsubscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">' + data.msg + '</p>');
                    setTimeout(function () {
                        $("#unsubscribeResponse").fadeOut();
                    }, 1000);
                } else {
                    $("#unsubscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">Unknown error occured try again later!</p>');
                    setTimeout(function () {
                        $("#unsubscribeResponse").fadeOut();
                    }, 1000);
                }

            });

        } else {
            $("#unsubscribeResponse").html('<p class="alert alert-danger text-center" style="color:#000;">Enter Email</p>');
            setTimeout(function () {
                $("#unsubscribeResponse").fadeOut();
            }, 1000);
        }
        e.preventDefault();
        e.stopImmediatePropagation();
    });
}


function startPreloader() {

    preloader = new $.materialPreloader({
        position: 'top',
        height: '8px',
        col_1: '#159756',
        col_2: '#da4733',
        col_3: '#3b78e7',
        col_4: '#fdba2c',
        fadeIn: 200,
        fadeOut: 200
    });
    preloader.on();
    openNav();
}

function openNav() {
    document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.height = "0%";
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}










