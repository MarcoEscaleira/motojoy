<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('cat_id')) {
            $cat_id = Input::get('cat_id');

            $delete = Db::getInstance()->delete('categories', array('cat_id', '=', $cat_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Categoria eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da categoria!";
            }


            echo json_encode($valid);
        }
    }
?>
