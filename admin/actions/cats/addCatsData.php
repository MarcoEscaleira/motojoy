<?php
    require ('../../core/configActions.php');
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');
                        
            $insert = Db::getInstance()->insert('categories', array(
                "cat_name" => Input::get('cat_name')
            ));

            $check = Db::getInstance()->get('categories', array('cat_name', '=', Input::get('cat_name')));

            if ($check->count()) {
                $valid['success'] = true;
                $valid['type'] = "success";
                $valid['messages'] = "Categoria criada!";
                $valid['path'] = ADMIN_PATH . 'brands';

            } else {
                $valid['success'] = false;
                $valid['type'] = "danger";
                $valid['messages'] = "Houve um problema na criação da categoria!";
            }

            echo json_encode($valid);
        }
    }

?>
