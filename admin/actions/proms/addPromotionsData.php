<?php
    require ('../../core/configActions.php');
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');
            
            $prod_id   = Input::get('prod_id');
            $prod_disc = Input::get('prom_discount');

            $insertProm = Db::getInstance()->insert('promotions', array(
                "prom_start"    => Input::get('prom_start'),
                "prom_end"      => Input::get('prom_end'),
                "prom_discount" => $prod_disc,
                "prod_id"       => $prod_id
            ));
            
            $getProm = Db::getInstance()->query("SELECT * FROM promotions WHERE `prod_id` = $prod_id AND `prom_discount` = $prod_disc");
            
            if ($getProm->count()) {
                $prom = $getProm->first();
                
                Db::getInstance()->update('products', $prod_id, 'prod_id',array(
                    "prom_id" => $prom->prom_id
                ));

                $valid['success'] = true;
                $valid['type'] = "success";
                $valid['messages'] = "Promoção criada!";
            } else {
                $valid['success'] = false;
                $valid['type'] = "warning";
                $valid['messages'] = "Erro ao criar a promoção!";
            }

            

            echo json_encode($valid);
        }
    }

?>