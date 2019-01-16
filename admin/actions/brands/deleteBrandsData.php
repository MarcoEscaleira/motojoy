<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('brand_id')) {
            $brand_id = Input::get('brand_id');

            $delete = Db::getInstance()->delete('brands', array('brand_id', '=', $brand_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Marca eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da marca!";
            }


            echo json_encode($valid);
        }
    }
?>
