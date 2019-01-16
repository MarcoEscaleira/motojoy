<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('user_id')) {
            $user_id = Input::get('user_id');

            $delete = Db::getInstance()->delete('users', array('user_id', '=', $user_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Utilizador eliminado!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação do utilizador!";
            }


            echo json_encode($valid);
        }
    }
?>
