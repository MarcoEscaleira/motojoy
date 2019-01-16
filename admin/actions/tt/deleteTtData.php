<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('tt_id')) {
            $tt_id = Input::get('tt_id');

            $delete = Db::getInstance()->delete('tips_tricks', array('tt_id', '=', $tt_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Dica eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da dica!";
            }


            echo json_encode($valid);
        }
    }
?>
