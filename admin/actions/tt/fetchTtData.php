<?php
    require ('../../core/configActions.php');

    $tt = Db::getInstance()->query("SELECT * FROM tips_tricks ORDER BY tt_id");

    $output = array('data' => array());

    if ($tt->count()) {
      foreach ($tt->results() as $tt) {
          $button = '
          <a data-target="#edit_modal" data-toggle="modal" onclick="editTt('.$tt->tt_id.')" class="btn btn-outline-success"><i class="fa fa-cog"></i> Editar</a>

          <a data-target="#delete_modal" data-toggle="modal" onclick="deleteTt('.$tt->tt_id.')" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Eliminar</a>

          <a href="'.URL_PATH.'tiptrick?n='.$tt->tt_id.'" class="btn btn-outline-secondary"><i class="fa fa-check"></i> Visualizar</a>
          ';

          switch ($tt->tt_cat) {
              case 'limp':
                  $cat = 'Limpeza';
                  break;

              case 'manu':
                  $cat = 'Manutenção';
                  break;

              case 'cond':
                  $cat = 'Condução';
                  break;
          }

          switch ($tt->tt_subcat) {
              case 'motor':
                  $subcat = 'Motor';
                  break;

              case 'transmissao':
                  $subcat = 'Transmissão';
                  break;

              case 'pneus':
                  $subcat = 'Pneus';
                  break;

              default:
                  $subcat = '';
                  break;
          }


          $image = '<img src="'.IMGS_PATH.'tips/'.$tt->tt_image.'" alt="tt_image" class="img-fluid" width="250em" height: "150em">';

        $output['data'][] = array(
          $tt->tt_title,
          $tt->tt_subtitle,
          '<div class="container">'.$tt->tt_description.'</div>',
          $tt->tt_author,
          date('d-M-Y G:i',strtotime($tt->tt_date)),
          $cat,
          $subcat,
          $image,
          $tt->tt_views,
          $tt->tt_id,
          $button
        );

      }// foreach
    } // if
    echo json_encode($output);
?>
