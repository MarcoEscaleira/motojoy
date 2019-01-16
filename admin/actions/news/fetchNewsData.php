<?php
    require ('../../core/configActions.php');
    
    $new = Db::getInstance()->query("SELECT * FROM newspapper ORDER BY news_id");

    $output = array('data' => array());

    if ($new->count()) {
      foreach ($new->results() as $new) {
          $button = '
          <a data-target="#edit_modal" data-toggle="modal" onclick="editNew('.$new->news_id.')" class="btn btn-outline-success"><i class="fa fa-cog"></i> Editar</a>

          <a data-target="#delete_modal" data-toggle="modal" onclick="deleteNew('.$new->news_id.')" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Eliminar</a>

          <a href="'.URL_PATH.'new?n='.$new->news_id.'" class="btn btn-outline-secondary"><i class="fa fa-check"></i> Visualizar</a>
          ';

          switch ($new->news_cat) {
              case 'lan':
                  $cat = 'Lançamentos';
                  break;

              case 'gp':
                  $cat = 'Moto GP';
                  break;

              case 'up':
                  $cat = 'Atualizações';
                  break;
          }

          $image = '<img src="'.IMGS_PATH.'news/'.$new->news_image.'" alt="news_image" class="img-fluid" width="250em" height: "150em">';

        $output['data'][] = array(
          $new->news_title,
          $new->news_subtitle,
          '<div class="container">'.$new->news_description.'</div>',
          $new->news_author,
          date('d-M-Y G:i',strtotime($new->news_date)),
          $cat,
          $image,
          $new->news_id,
          $button
        );

      }// foreach
    } // if
    echo json_encode($output);
?>
