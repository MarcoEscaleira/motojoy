<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('prod_id')) {
            $prod_id = Input::get('prod_id');

            $delete = Db::getInstance()->delete('products', array('prod_id', '=', $prod_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Produto eliminado!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação do produto!";
            }


            echo json_encode($valid);
        }
    }
?>
