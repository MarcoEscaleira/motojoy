<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        $type_id = Input::get('type_id');

        $update = Db::getInstance()->update('typep', $type_id, 'type_id', array(
            "cat_id" => Input::get('cat_id'),
            "type_name" => Input::get('type_name')
        ));
        
        if ($update) {
            $valid['success'] = true;
            $valid['messages'] = "Tipo atualizado!";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Falha ao atualizar o tipo!";
        }
        
        echo json_encode($valid);
        //Redirect::adminTo('news.php');
    }
?>
