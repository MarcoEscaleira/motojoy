<?php
    require ('../../core/configActions.php');

    $product = Db::getInstance()->query("SELECT * FROM products ORDER BY prod_id DESC");

    $output = array('data' => array());

    if ($product->count()) {
      foreach ($product->results() as $prod) {
          $button = '
          <a data-target="#edit_modal" data-toggle="modal" onclick="editProd('.$prod->prod_id.')" class="btn btn-outline-success"><i class="fa fa-cog"></i> Editar</a>

          <a data-target="#delete_modal" data-toggle="modal" onclick="deleteProd('.$prod->prod_id.')" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Eliminar</a>

          <a href="'.STORE_PATH.'product?p='.$prod->prod_id.'" class="btn btn-outline-secondary"><i class="fa fa-check"></i> Visualizar</a>
          ';
          $cat = Db::getInstance()->get('categories', array('cat_id', '=', $prod->cat_id))->first();
          $brand = Db::getInstance()->get('brands', array('brand_id', '=', $prod->brand_id))->first();
          $type = Db::getInstance()->get('typep', array('type_id', '=', $prod->type_id))->first();

          if ($prod->prod_stock == 0) {
              $stock = '<span class="badge badge-danger">Esgotado</span>';
          } else if ($prod->prod_stock >= 5) {
              $stock = '<span class="badge badge-success">Em Stock</span>';
          } else if ($prod->prod_stock < 5) {
              $stock = '<span class="badge badge-warning">Pouco Stock</span>';
          }

          //$image = '<img src="'.IMGS_PATH.'products/'.$prod->prod_image.'" alt="prod_image" class="img-fluid" width="250em" height: "150em">';

        $output['data'][] = array(
          $prod->prod_name,
          '<div class="container">'.$prod->prod_desc.'</div>',
          $stock,
          $prod->prod_price.' €',
          $brand->brand_name,
          $cat->cat_name,
          ucfirst($type->type_name),
          $prod->prod_views,
          $prod->prod_id,
          $prod->prod_keywords,
          $button
        );

      }// foreach
    } // if
    echo json_encode($output);
?>
