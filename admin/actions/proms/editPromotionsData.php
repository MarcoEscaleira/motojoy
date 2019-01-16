<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        $prom_id = Input::get('prom_id');

        $update = Db::getInstance()->update('promotions', $prom_id, 'prom_id', array(
            "prom_start"    => Input::get('prom_start'),
            "prom_end"      => Input::get('prom_end'),
            "prom_discount" => Input::get('prom_discount')
        ));
        
        if ($update) {
            $valid['success'] = true;
            $valid['messages'] = "Promoção atualizada!";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Falha na atualização da promoção!";
        }
        
        echo json_encode($valid);
        //Redirect::adminTo('news.php');
    }
?>
