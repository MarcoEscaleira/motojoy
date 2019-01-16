<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $prod_id = Input::get('prod_id');

        $get = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
