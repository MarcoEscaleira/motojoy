<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $user_id = Input::get('user_id');

        $get = Db::getInstance()->get('users', array('user_id', '=', $user_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
