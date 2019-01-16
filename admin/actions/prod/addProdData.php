<?php
    require ('../../core/configActions.php');
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');
            
            /* Image upload vars 
            PHP.ini : upload_max_filesize
            */
            $file = $_FILES['image'];
            
            $fileName    = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize    = $file['size'];
            $fileError   = $file['error'];
            $fileType    = $file['type'];
            
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowedExt = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowedExt)) {
                if ($fileError === 0) {

                    if ($fileSize <= 20000000) {
                        
                        $NewFileName = Hash::unique().".".$fileActualExt;
                        $fileDestination = IMGS_PATH_LOCAL . 'products/'.$NewFileName;

                        move_uploaded_file($fileTmpName, $fileDestination);
                        
                        $insert = Db::getInstance()->insert('products', array(
                            "prod_name"       => Input::get('prod_name'),
                            "prod_desc"    => Input::get('prod_desc'),
                            "prod_price" => Input::get('prod_price'),
                            "prod_old_price" => Input::get('prod_price')+5,
                            "prod_stock"    => Input::get('prod_stock'),
                            "prod_keywords"      => Input::get('prod_keywords'),
                            "cat_id"         => Input::get('cat_id'),
                            "brand_id"         => Input::get('brand_id'),
                            "type_id"         => Input::get('type_id'),
                            "prod_image"       => $NewFileName 
                        ));

                        $check = Db::getInstance()->get('products', array('prod_name', '=', Input::get('prod_name')));

                        if ($check->count()) {
                            $valid['success'] = true;
                            $valid['type'] = "success";
                            $valid['messages'] = "Produto criado!";
                            $valid['path'] = ADMIN_PATH . 'news';

                        } else {
                            $valid['success'] = false;
                            $valid['type'] = "danger";
                            $valid['messages'] = "Houve um problema na criação do produto!";
                        }
                    } else {
                        $valid['success'] = false;
                        $valid['type'] = "danger";
                        $valid['messages'] = "A imagem e demasiado grande. ( 20 MBs maximo )";
                    }
                
                } else {
                    $valid['success'] = false;
                    $valid['type'] = "danger";
                    $valid['messages'] = "Erro no upload da imagem";
                }

            } else {
                $valid['success'] = false;
                $valid['type'] = "danger";
                $valid['messages'] = "Formato da imagem errado. ( jpg, jpeg e png )";
            }

            echo json_encode($valid);
        }
    }

?>
