<?php
    require ('../../core/configActions.php');
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');
                        
            $insert = Db::getInstance()->insert('typep', array(
                "cat_id"    => Input::get('cat_id'),
                "type_name" => Input::get('type_name')
            ));

            $check = Db::getInstance()->get('typep', array('type_name', '=', Input::get('type_name')));

            if ($check->count()) {
                $valid['success'] = true;
                $valid['type'] = "success";
                $valid['messages'] = "Tipo criado!";
                $valid['path'] = ADMIN_PATH . 'types';

            } else {
                $valid['success'] = false;
                $valid['type'] = "danger";
                $valid['messages'] = "Houve um problema na criação do tipo!";
            }

            echo json_encode($valid);
        }
    }

?>
