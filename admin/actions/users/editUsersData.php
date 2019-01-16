<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        $user_id = Input::get('user_id');

        $update = Db::getInstance()->update('users', $user_id, 'user_id', array(
            "group_id"       => Input::get('group_id'),
            "user_confirmed" => Input::get('user_confirmed')
            ));
        
        if ($update) {
            $valid['success'] = true;
            $valid['messages'] = "Utilizador atualizado!";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Falha na atualização do utilizador!";
        }
        
        echo json_encode($valid);
        //Redirect::adminTo('news.php');
    }
?>
