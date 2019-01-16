<?php
    require 'core/config.php';
    require_once '../includes/header.php';

    if (!$user->isLoggedIn()) {
        Redirect::to('index');
    }

    $tran_id      = $_GET['tx'];
    $order_status = $_GET['st'];
    $amount       = $_GET['amt'];
    $cc           = $_GET['cc'];
    $user_id      = $_GET['cm'];

    if (($_COOKIE['tc'] == $amount) && ($order_status == "Completed")) {

      $order_products = Db::getInstance()->get('customer_order', array('user_id', '=', $user_id));

      if ($order_products->count()) {
        
        foreach ($order_products->results() as $order_p) {
          $prod_id = $order_p->prod_id;
          $insert = Db::getInstance()->insert('received_payment', array(
            "user_id" => $user_id,
            "prod_id" => $prod_id,
            "pay_amount" => $order_p->order_amount,
            "pay_qty" => $order_p->order_qty,
            "tran_id" => $tran_id
          ));
          //Reduce product stock
          $product = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));
          $prod_stock = $product->first()->prod_stock;
          $new_prod_stock = $prod_stock - $order_p->order_qty;

          $update_prod_stock = Db::getInstance()->update('products', $prod_id, 'prod_id', array(
            "prod_stock" => $new_prod_stock
          ));
        }
        //Delete customer order
        $delete_co = Db::getInstance()->delete('customer_order', array('user_id', '=', $user_id));

        //Delete cart
        $delete_co = Db::getInstance()->delete('cart', array('user_id', '=', $user_id));

        $full_path= URL_PATH . 'index';
        //Send email to user
        $confirm = Mail::send($user->data()->user_email, 'Encomenda - nº '. $tran_id, MailType::casual('Obrigado', 'A sua encomenda foi processada com sucesso, verifique o seu histórico para saber mais.', 'Encomendas', $full_path));
      }
      
    }
?>

  <div class="container-fluid">
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <div class="card card-default">
          <div class="card-header">
            <h2 class="card-title titles">Obrigado <small class="text-muted">Encomenda efetuada com sucesso!</small></h2>
          </div>
          <div class="card-body">
            <p>Olá <?php echo $user->data()->user_name; ?>, o teu pagamento foi processado com sucesso.</p>
            <hr>
            <p>Id da encomenda: <b><?php echo $tran_id; ?></b></p>
          </div>
          <div class="card-footer">
          
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
    </script>
<?php
    require_once '../includes/footer.php';
?>