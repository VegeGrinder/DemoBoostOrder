require('./bootstrap');

$(function () {
    // $(document).on({
    //     ajaxStart: function () { $("body").addClass("loading"); },
    //     ajaxStop: function () { $("body").removeClass("loading"); }
    // });

    //Start of User Home
    $('.addToCartButton').on('click', function() {
        $("body").addClass("loading");  //modal starts spinning (loading)

        $id = $(this).parent().parent().find('td').eq(0).text();
        $name = $(this).parent().parent().find('td').eq(1).text();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/home',
            data: {
                product_id: $id,
                product_name: $name
            },
            dataType: 'json',
            success: function(response) {
                $("body").removeClass("loading");

                if(response.success === true) {
                    console.log('success');
                }
            }
        });
    });
    //End of User Home

    //Start of User Cart
    $('.deleteProductButton').on('click', function () {
        $("body").addClass("loading");  //modal starts spinning (loading)

        $id = $(this).parent().parent().find('td').eq(0).text();
        $var = $(this).parent().parent();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'DELETE',
            url: '/cart',
            data: {
                product_id: $id,
            },
            dataType: 'json',
            success: function (response) {
                $("body").removeClass("loading");

                $var.remove();

                $new_val = +$('#product_count').text() - 1;
                $('#product_count').text($new_val);

                if($('#product_count').text() === '0') {
                    $('.checkOutButton').prop('disabled', true);
                    $('.checkOutButton').toggleClass('btn-primary').toggleClass('btn-danger');
                }
            }
        });
    });

    $('.checkOutButton').on('click', function () {
        $("body").addClass("loading");  //modal starts spinning (loading)
    });
    //End of User Cart

    //Start of Orders
    $('.selectOrder').on('click', function () {
        $("body").addClass("loading");  //modal starts spinning (loading)
    });
    //End of Orders

    //Start of adminHome
    $('.adminHomeSelect').on('change', function () {
        $("body").addClass("loading");  //modal starts spinning (loading)

        $id = $(this).parent().parent().find('td').eq(0).text();
        $status = $(this).parent().parent().find('td').eq(3);
        $selected = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/changeStatus",
            data: {
                order_id: $id,
                status: $selected
            },
            dataType: "json",
            success: function (data) {
                $("body").removeClass("loading");

                if($selected == 1) {
                    $status.html("<span style='color:green'>Accepted</span>");
                } else if($selected == 2) {
                    $status.html("<span style='color:red'>Rejected</span>");
                }
            }
        });
    });
    //End of adminHome

    //Start of AdminShowOrder
    $('.adminOrderSelect').on('change', function () {
        $("body").addClass("loading");  //modal starts spinning (loading)

        $id = $('#order_id').html();
        $status = $('#status');
        $selected = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/changeStatus",
            data: {
                order_id: $id,
                status: $selected
            },
            dataType: "json",
            success: function (data) {
                $("body").removeClass("loading");

                if ($selected == 1) {
                    $status.html("<span style='color:green'>Accepted</span>");
                } else if ($selected == 2) {
                    $status.html("<span style='color:red'>Rejected</span>");
                }

                $('#alert').append("<div class='alert alert-success alert-dimissible fade show' role='alert'>Action successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            }
        });
    });
    //End of AdminShowOrder
});