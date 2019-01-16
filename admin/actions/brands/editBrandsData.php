<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        $brand_id = Input::get('brand_id');

        $update = Db::getInstance()->update('brands', $brand_id, 'brand_id', array(
            "brand_name" => Input::get('brand_name'),
            "cat_id"     => Input::get('cat_id')
            ));
        
        if ($update) {
            $valid['success'] = true;
            $valid['messages'] = "Marca atualizada!";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Falha na atualização da marca!";
        }
        
        echo json_encode($valid);
        //Redirect::adminTo('news.php');
    }
?>
