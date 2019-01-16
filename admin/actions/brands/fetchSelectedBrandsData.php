<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $brand_id = Input::get('brand_id');

        $get = Db::getInstance()->get('brands', array('brand_id', '=', $brand_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
