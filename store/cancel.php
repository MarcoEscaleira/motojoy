<?php
    require 'core/config.php';
    require_once '../includes/header.php';
    
    if (!$user->isLoggedIn()) {
        Redirect::to('index');
    }

    $user_id = $user->data()->user_id;

    //Delete customer order
    $delete_co = Db::getInstance()->delete('customer_order', array('user_id', '=', $user_id));
?>

    <div class="container-fluid">
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <div class="card card-default">
          <div class="card-header">
            <h2 class="card-title">Operação cancelada <small class="text-muted">Pagamento cancelado com sucesso!</small></h2>
          </div>
          <div class="card-body">
            <div class="row" style="padding-top: 45px;">
                <div class="col-2"></div>
                <div class="col-4"><a href="<?php echo STORE_PATH . 'cart'; ?>" class="btn btn-primary btn-block h-75">Carrinho <label class="badge badge-secondary cart_quantity">0</label></a></div>
                <div class="col-4"><a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-secondary btn-block h-75">Início</a></div>
                <div class="col-2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-2"></div>
    </div>
  </div>

<?php
    require_once '../includes/footer.php';
?>
