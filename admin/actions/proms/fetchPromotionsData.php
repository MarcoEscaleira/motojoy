<?php
    require ('../../core/configActions.php');
    
    $promotions = Db::getInstance()->query("SELECT * FROM promotions ORDER BY prom_id DESC");

    $output = array('data' => array());

    if ($promotions->count()) {
        foreach ($promotions->results() as $prom) {
            $button = '
            <a data-target="#edit_modal" data-toggle="modal" onclick="editPromotion('.$prom->prom_id.')" class="btn btn-outline-success"><i class="fa fa-cog"></i> Editar</a>

            <a data-target="#delete_modal" data-toggle="modal" onclick="deletePromotion('.$prom->prom_id.')" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Eliminar</a>

            <a href="'.STORE_PATH.'product?p='.$prom->prod_id.'" class="btn btn-outline-secondary"><i class="fa fa-check"></i> Produto</a>
            ';

            $product = Db::getInstance()->get('products', array('prod_id', '=', $prom->prod_id));
            if ($product->count()) {
                $prod = $product->first();
            }

            $typep = Db::getInstance()->get('typep', array('type_id', '=', $prod->type_id));
            if ($typep->count()) {
                $type = $typep->first();
            }

            $output['data'][] = array(
                $prod->prod_name,
                $type->type_name,
                $prom->prom_discount.' %',
                $prom->prom_start,
                $prom->prom_end,
                $button
            );

        }// foreach
    } // if
    echo json_encode($output);
?>
