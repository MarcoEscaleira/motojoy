<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $type_id = Input::get('type_id');

        $get = Db::getInstance()->get('typep', array('type_id', '=', $type_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
