<?php
    require 'core/config.php';
    require_once '../includes/header.php';

    if (!$user->isLoggedIn()) {
        Redirect::to('index');
    }

    $user = new User();
?>

  <div class="container-fluid">
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <div class="card card-default">
          <div class="card-header">

          </div>
          <div class="card-body">
            <h1 class="card-title titles">Detalhes da encomenda</h1>
            <hr>
            <div id="order_products"></div> 
          </div>
          <div class="card-footer">
            <div class="row">
              <form id="paypal_check" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="width:100%;">
                  <input type="hidden" name="cmd" value="_cart">
                  <input type="hidden" name="business" value="motojoy@gmail.com">
                  <input type="hidden" name="upload" value="1">
                  <input type="hidden" name="charset" value="utf-8">';

                  <?php 
                  $user_id = $user->data()->user_id;

                  //Eliminate last customer order
                  $delete_co = Db::getInstance()->delete('customer_order', array('user_id', '=', $user_id));
                  
                  $x = 0;
                  $get_cart = Db::getInstance()->get('cart', array('user_id', '=', $user_id));
                  foreach ($get_cart->results() as $row) {
                      $x++;
                      $cart_qty = $row->cart_prod_qty;

                      $get_product = Db::getInstance()->get('products', array('prod_id', '=', $row->prod_id))->first();
                      echo '
                      <input type="hidden" name="item_name_'.$x.'" value="'.$get_product->prod_name.'">
                      <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
                      <input type="hidden" name="amount_'.$x.'" value="'.$row->cart_prod_total/$cart_qty.'">
                      <input type="hidden" name="quantity_'.$x.'" value="'.$cart_qty.'">
                      ';
                  } ?>

                  <input type="hidden" name="return" value="<?php echo STORE_PATH; ?>payment_success.php">
                  <input type="hidden" name="cancel_return" value="<?php echo STORE_PATH; ?>cancel.php">
                  <input type="hidden" name="currency_code" value="EUR">
                  <input type="hidden" name="custom" value="<?php echo $user_id; ?>">
                  <input type="image" name="submit" style="width: 30%; float:right; padding-right: 7px;"
                      src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/blue-rect-paypalcheckout-60px.png"
                      alt="PayPal - Checkout">
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-2"></div>
    </div>
  </div>
    

    <script src="<?php echo STORE_PATH . 'includes/filters.js' ?>"></script>
    <script>
        sr.reveal('.breadcrumb', {
           duration: 1000,
           origin:'right',
           distance: '20px'
        });


        $(document).ready(function () {
          order_checkout();

          function order_checkout() {
              $.ajax({
                  url: 'actions/checkout.php',
                  method: 'POST',
                  data: {order_checkout: 1},
                  success:function(data) {
                      $("#order_products").html(data);
                  }
              });
          }

            $('body').delegate('#paypal_check', 'submit', function(e) {
                
                $.ajax({
                    url: 'actions/checkout.php',
                    method: 'POST',
                    data: {paypal_checkout: 1},
                    dataType: 'json'
                });
            });
        });
    </script>
<?php
    require_once '../includes/footer.php';
?>