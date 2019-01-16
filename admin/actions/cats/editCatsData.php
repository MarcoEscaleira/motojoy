<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        $cat_id = Input::get('cat_id');

        $update = Db::getInstance()->update('categories', $cat_id, 'cat_id', array(
            "cat_name" => Input::get('cat_name')
            ));
        
        if ($update) {
            $valid['success'] = true;
            $valid['messages'] = "Categoria atualizada!";
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Falha na atualização da categoria!";
        }
        
        echo json_encode($valid);
        //Redirect::adminTo('news.php');
    }
?>
