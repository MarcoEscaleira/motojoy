<?php
    require '../core/configIn.php';

    $user = new User();
    $user_id = $user->data()->user_id;

    $orders = Db::getInstance()->query("SELECT * FROM `received_payment` WHERE `user_id` = $user_id ORDER BY `pay_id` DESC");

    $output = array('data' => array());

    if ($orders->count()) {
        foreach ($orders->results() as $order) {
            $userd = Db::getInstance()->get('users', array('user_id', '=', $order->user_id));
            if ($userd->count()) {
                $u = $userd->first();
            }

            $product = Db::getInstance()->get('products', array('prod_id', '=', $order->prod_id));
            if ($product->count()) {
                $prod = $product->first();
            }

            $button = '
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <a href="'.STORE_PATH.'product?p='.$order->prod_id.'" class="btn btn-default text-white"><i class="fa fa-check"></i> Ver produto</a>
                    </div>
                </div>
            </div>
            '; 
            
            $price = $order->pay_amount / $order->pay_qty;
            
            $image = '<img src="'.IMGS_PATH.'products/'.$prod->prod_image.'" alt="prod_image" class="img-fluid" width="112.5em" height: "67.5em">';

            $output['data'][] = array(
                $order->tran_id,
                $image,
                '<a href="'.STORE_PATH.'product?p='.$prod->prod_id.'">'.$prod->prod_name.'</a>',
                $price.' €',
                $order->pay_qty,
                $order->pay_amount.' €',
                ''
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
