<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $cat_id = Input::get('cat_id');

        $get = Db::getInstance()->get('categories', array('cat_id', '=', $cat_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
