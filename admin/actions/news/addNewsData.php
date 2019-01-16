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
                        $fileDestination = IMGS_PATH_LOCAL . 'news/'.$NewFileName;

                        move_uploaded_file($fileTmpName, $fileDestination);
                        
                        $insert = Db::getInstance()->insert('newspapper', array(
                            "news_title"       => Input::get('news_title'),
                            "news_subtitle"    => Input::get('news_subtitle'),
                            "news_description" => nl2br(Input::get('news_description')),
                            "news_author"      => Input::get('news_author'),
                            "news_cat"         => Input::get('news_cat'),
                            "news_image"       => $NewFileName 
                        ));

                        $check = Db::getInstance()->get('newspapper', array('news_title', '=', Input::get('news_title')));

                        if ($check->count()) {
                            $valid['success'] = true;
                            $valid['type'] = "success";
                            $valid['messages'] = "Notícia criada!";
                            $valid['path'] = ADMIN_PATH . 'news';

                        } else {
                            $valid['success'] = false;
                            $valid['type'] = "danger";
                            $valid['messages'] = "Houve um problema na criação da notícia!";
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
