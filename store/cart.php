<?php
    require 'core/config.php';
    require_once '../includes/header.php';
?>

    <div class="container-fluid">
        <div class="row">
            <h5 class="display-4 mx-auto mt-4 mb-4">Carrinho de compras</h5>
        </div>
        <hr>
        <div class="row">
            <div class="w-75 mt-4 mx-auto" id="cart_messages"></div>
        </div>
        <div class="row">
            <div class="mx-auto" id="cart_products"></div>
        </div>
    </div>

    <script type="text/javascript">
        cart_checkout();

        function cart_checkout() {
            $.ajax({
                url: 'actions/cart.php',
                method: 'POST',
                data: {cart_checkout: 1},
                success:function(data) {
                    $("#cart_products").html(data);
                }
            });
        }

        $(document).on('click', '.quantity-right-plus', function(e) {
            e.preventDefault();
            var pid = $(this).attr("pid");
            var qty =$('#qty-'+pid).val();
            $('#qty-'+pid).val(++ qty);
            $('.qty').trigger("change");
        });
        $(document).on('click', '.quantity-left-minus', function(e) {
            e.preventDefault();
            var pid = $(this).attr("pid");
            var qty =$('#qty-'+pid).val();
            var sub = qty - 1;
            if(qty != 0) {
                $('#qty-'+pid).val(sub);
                $('.qty').trigger("change");
            }
        });

        $(document).on('change', '.qty', function(e) {
        //$("body").delegate('.qty', "change", function() {
            var pid = $(this).attr("pid");
            var qty = $("#qty-"+pid).val();
            var price = $("#price-"+pid);
            if(price.attr('prom')) {
                var subtotal = price.attr('prom');
            } else {
                var subtotal = $("#price-"+pid).text();
            }
            
            var total = qty * subtotal;
            
            if (qty != 0) {
                $.ajax({
                    url: 'actions/cart.php',
                    method: 'POST',
                    cache: false,
                    data: {cart_qty: 1, prod_id: pid, qty: qty, total: total},
                    success:function(data) {
                        $("#total-"+pid).val(total);
                        cart_checkout();

                        $('#checkout_prod_message').html(data).fadeIn('fast');
                        $('#checkout_prod_message').delay(1000).fadeOut('slow');
                    }
                });
            } else {
                qty = 1;
                var total = qty * price;

                $.ajax({
                    url: 'actions/cart.php',
                    method: 'POST',
                    cache: false,
                    data: {cart_qty: 1, prod_id: pid, qty: qty, price: price},
                    success:function(data) {
                        $("#qty-"+pid).val(1);
                        $("#total-"+pid).val(total);
                        cart_checkout();

                        $('#checkout_prod_message').html(data).fadeIn('fast');
                        $('#checkout_prod_message').delay(1000).fadeOut('slow');
                    }
                });
            }



        });

        $("body").delegate('.remove', 'click', function(event) {
            event.preventDefault();

            var remove_id = $(this).attr("remove_id");

            $.ajax({
                url: 'actions/cart.php',
                method: 'POST',
                data: {prod_remove: 1, remove_id: remove_id},
                success:function(data) {
                    cart_checkout();

                    $('#cart_messages').html(data).fadeIn('fast');
                    $('#cart_messages').delay(1000).fadeOut('slow');

                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            });
        });
    </script>
<?php
    require_once '../includes/footer.php';
?>
