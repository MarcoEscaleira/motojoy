../<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('news_id')) {
            $news_id = Input::get('news_id');

            $delete = Db::getInstance()->delete('newspapper', array('news_id', '=', $news_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Notícia eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da notícia!";
            }


            echo json_encode($valid);
        }
    }
?>
