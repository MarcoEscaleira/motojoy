<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('prom_id')) {
            $prom_id = Input::get('prom_id');
            
            $prod_id = Db::getInstance()->get('promotions', array('prom_id', '=', $prom_id))->first()->prod_id;

            $delete = Db::getInstance()->delete('promotions', array('prom_id', '=', $prom_id));
            $updateProd = Db::getInstance()->update('products', $prod_id, 'prod_id',array(
                            "prom_id" => ''
                        ));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Promoção eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da promoção!";
            }


            echo json_encode($valid);
        }
    }
?>
