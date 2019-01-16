<?php
    require ('../../core/configActions.php');
    
    $orders = Db::getInstance()->query("SELECT * FROM received_payment ORDER BY pay_id DESC");

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
                        <a href="'.STORE_PATH.'product?p='.$order->prod_id.'" target="_blank" class="btn btn-success text-white"><i class="fa fa-file-o"></i> Produto</a>
                    </div>
                    <div class="col-6">
                        <a data-target="#delete_modal" data-toggle="modal" onclick="deleteOrder('.$order->pay_id.')" class="btn btn-danger text-white"><i class="fa fa-trash-o"></i> Eliminar</a>
                    </div>
                </div>
            </div>
            '; 
            
            $price = $order->pay_amount / $order->pay_qty;

            $output['data'][] = array(
                $order->tran_id,
                $u->user_email,
                $prod->prod_name,
                $price,
                $order->pay_qty,
                $order->pay_amount,
                $button
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
