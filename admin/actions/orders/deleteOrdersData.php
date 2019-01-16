<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

    if (Input::exists()) {
        if (Input::get('pay_id')) {
            $pay_id = Input::get('pay_id');

            $delete = Db::getInstance()->delete('received_payment', array('pay_id', '=', $pay_id));

            if (!$delete->error()) {
                $valid['success'] = true;
              	$valid['messages'] = "Encomenda eliminada!";
            } else {
                $valid['success'] = false;
              	$valid['messages'] = "Houve um problema na eliminação da encomenda!";
            }


            echo json_encode($valid);
        }
    }
?>
