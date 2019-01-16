<?php
    require ('../../core/configActions.php');
    
    $cats = Db::getInstance()->query("SELECT * FROM categories ORDER BY cat_id DESC");

    $output = array('data' => array());

    if ($cats->count()) {
        foreach ($cats->results() as $cat) {
            $button = '
            <a data-target="#edit_modal" data-toggle="modal" onclick="editCat('.$cat->cat_id.')" class="btn btn-success w-25 float-right text-white"><i class="fa fa-cog"></i> Editar</a>

            <a data-target="#delete_modal" data-toggle="modal" onclick="deleteCat('.$cat->cat_id.')" class="btn btn-danger w-25 mr-2 float-right text-white"><i class="fa fa-trash-o"></i> Eliminar</a>
            ';

            $output['data'][] = array(
                $cat->cat_name,
                $button
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
