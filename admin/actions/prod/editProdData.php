<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

        if (Input::exists()) {
            $prod_id = Input::get('prod_id');
            $prod_price_form = Input::get('prod_price');
            
            //Get actual prod_price
            $produ = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));
            $product = $produ->first();
            $prod_price = $product->prod_price;

            if ($prod_price_form != $prod_price) {
                $prod_old_price = $prod_price;
            } else {
                $prod_old_price = $prod_price_form;
            }

            if ($file = $_FILES['image']) {
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
                            $fileDestination = IMGS_PATH_LOCAL . 'tips/'.$NewFileName;

                            move_uploaded_file($fileTmpName, $fileDestination);
                            
                            $update = Db::getInstance()->update('products', $prod_id, 'prod_id', array(
                                "prod_name"     => Input::get('prod_name'),
                                "prod_desc"     => Input::get('prod_desc'),
                                "prod_price"    => $prod_price_form,
                                "prod_old_price"=> $prod_old_price,
                                "prod_stock"    => Input::get('prod_stock'),
                                "prod_keywords" => Input::get('prod_keywords'),
                                "cat_id"        => Input::get('cat_id'),
                                "brand_id"      => Input::get('brand_id'),
                                "type_id"       => Input::get('type_id'),
                                "prod_image"    => $NewFileName 
                            ));

                            $valid['success'] = true;
                            $valid['messages'] = "Produto atualizado";
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

            }

            $update = Db::getInstance()->update('products', $prod_id, 'prod_id', array(
                "prod_name"     => Input::get('prod_name'),
                "prod_desc"     => Input::get('prod_desc'),
                "prod_price"    => $prod_price_form,
                "prod_old_price" => $prod_old_price,
                "prod_stock"    => Input::get('prod_stock'),
                "prod_keywords" => Input::get('prod_keywords'),
                "cat_id"        => Input::get('cat_id'),
                "brand_id"      => Input::get('brand_id'),
                "type_id"       => Input::get('type_id')
            ));

            $valid['success'] = true;
            $valid['messages'] = "Produto atualizado";

        } else {
            $valid['success'] = false;
            $valid['messages'] = "Problemas na atualização!";
        }

        echo json_encode($valid);
        //Redirect::adminTo('news.php');
?>
