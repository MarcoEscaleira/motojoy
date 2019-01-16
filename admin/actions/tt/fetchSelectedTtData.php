<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $tt_id = Input::get('tt_id');

        $get = Db::getInstance()->get('tips_tricks', array('tt_id', '=', $tt_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
