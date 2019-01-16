<?php
    require ('../../core/configActions.php');
    
    $types = Db::getInstance()->query("SELECT * FROM typep ORDER BY type_id DESC");

    $output = array('data' => array());

    if ($types->count()) {
        foreach ($types->results() as $type) {
            $button = '
            <a data-target="#edit_modal" data-toggle="modal" onclick="editType('.$type->type_id.')" class="btn btn-success w-25 float-right text-white"><i class="fa fa-cog"></i> Editar</a>

            <a data-target="#delete_modal" data-toggle="modal" onclick="deleteType('.$type->type_id.')" class="btn btn-danger w-25 mr-2 float-right text-white"><i class="fa fa-trash-o"></i> Eliminar</a>
            ';

            $categories = Db::getInstance()->get('categories', array('cat_id', '=', $type->cat_id));
            if ($categories->count()) {
                $cat = $categories->first();
            }

            $output['data'][] = array(
                ucfirst($type->type_name),
                $cat->cat_name,
                $button
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
