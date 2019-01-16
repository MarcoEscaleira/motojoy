<?php
    require ('../../core/configActions.php');
    
    $brands = Db::getInstance()->query("SELECT * FROM brands ORDER BY brand_id DESC");

    $output = array('data' => array());

    if ($brands->count()) {
        foreach ($brands->results() as $brand) {
            $button = '
            <a data-target="#edit_modal" data-toggle="modal" onclick="editBrand('.$brand->brand_id.')" class="btn btn-success w-25 float-right text-white"><i class="fa fa-cog"></i> Editar</a>

            <a data-target="#delete_modal" data-toggle="modal" onclick="deleteBrand('.$brand->brand_id.')" class="btn btn-danger w-25 mr-2 float-right text-white"><i class="fa fa-trash-o"></i> Eliminar</a>
            '; 

            $categories = Db::getInstance()->get('categories', array('cat_id', '=', $brand->cat_id));
            if ($categories->count()) {
                $cat = $categories->first();
            }
            

            $output['data'][] = array(
                $brand->brand_name,
                $cat->cat_name,
                $button
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
