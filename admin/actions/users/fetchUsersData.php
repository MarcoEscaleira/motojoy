<?php
    require ('../../core/configActions.php');
    
    $users = Db::getInstance()->query("SELECT * FROM users ORDER BY user_id DESC");

    $output = array('data' => array());

    if ($users->count()) {
        foreach ($users->results() as $user) {
            $button = '
                <a data-target="#edit_modal" data-toggle="modal" onclick="editUser('.$user->user_id.')" class="btn btn-outline-success"><i class="fa fa-cog"></i> Editar</a>

                <a data-target="#delete_modal" data-toggle="modal" onclick="deleteUser('.$user->user_id.')" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Eliminar</a>
            '; 

            switch ($user->user_confirmed) {
                case 1:
                    $active = '<span class="badge badge-success">Ativada</span>';
                    break;
                
                case 0:
                    $active = '<span class="badge badge-danger">Desactivada</span>';
                    break;
            }
            
            switch ($user->group_id) {
                case 1:
                    $group = '<span class="badge badge-success">Comum</span>';
                    break;
                
                case 2:
                    $group = '<span class="badge badge-warning">Administrador</span>';
                    break;
            }

            $output['data'][] = array(
                $user->user_email,
                $user->user_username,
                $user->user_name,
                $user->user_joined,
                $user->user_nif,
                $user->user_phone,
                $user->user_address,
                $user->user_postcode,
                $active,
                $group,
                $user->cart_prods,
                $button
            );
        }// foreach
    } // if
    echo json_encode($output);
?>
