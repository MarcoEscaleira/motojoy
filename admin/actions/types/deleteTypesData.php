<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('type_id')) {
            $type_id = Input::get('type_id');

            $delete = Db::getInstance()->delete('typep', array('type_id', '=', $type_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Tipo eliminado!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação do tipo!";
            }


            echo json_encode($valid);
        }
    }
?>
