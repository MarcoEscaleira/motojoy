<?php
    require ('../../core/configActions.php');
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');
                        
            $insert = Db::getInstance()->insert('brands', array(
                "brand_name" => Input::get('brand_name'),
                "cat_id"     => Input::get('cat_id'),
            ));

            $check = Db::getInstance()->get('brands', array('brand_name', '=', Input::get('brand_name')));

            if ($check->count()) {
                $valid['success'] = true;
                $valid['type'] = "success";
                $valid['messages'] = "Marca criada!";
                $valid['path'] = ADMIN_PATH . 'brands';

            } else {
                $valid['success'] = false;
                $valid['type'] = "danger";
                $valid['messages'] = "Houve um problema na criação da marca!";
            }

            echo json_encode($valid);
        }
    }

?>
