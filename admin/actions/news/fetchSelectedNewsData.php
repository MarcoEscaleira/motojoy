<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $news_id = Input::get('news_id');

        $get = Db::getInstance()->get('newspapper', array('news_id', '=', $news_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
