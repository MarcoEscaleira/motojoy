<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $prom_id = Input::get('prom_id');

        $get = Db::getInstance()->get('promotions', array('prom_id', '=', $prom_id));

        if ($get->count()) {
            echo json_encode($get->first());
        }
    }
?>
