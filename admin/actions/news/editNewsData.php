<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

        if (Input::exists()) {
            $news_id = Input::get('news_id');

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
                            $fileDestination = IMGS_PATH_LOCAL . 'news/'.$NewFileName;

                            move_uploaded_file($fileTmpName, $fileDestination);
                            
                            $update = Db::getInstance()->update('newspapper', $news_id, 'news_id', array(
                                "news_title"       => Input::get('news_title'),
                                "news_subtitle"    => Input::get('news_subtitle'),
                                "news_description" => nl2br(Input::get('news_description')),
                                "news_author"      => Input::get('news_author'),
                                "news_cat"         => Input::get('news_cat'),
                                "news_image"       => $NewFileName
                                ));

                            $valid['success'] = true;
                            $valid['messages'] = "Notícia atualizada!";
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

            $update = Db::getInstance()->update('newspapper', $news_id, 'news_id', array(
                  "news_title"       => Input::get('news_title'),
                  "news_subtitle"    => Input::get('news_subtitle'),
                  "news_description" => nl2br(Input::get('news_description')),
                  "news_author"      => Input::get('news_author'),
                  "news_cat"         => Input::get('news_cat')
                  ));

             $valid['success'] = true;
             $valid['messages'] = "Notícia atualizada!";

        } else {
            $valid['success'] = false;
            $valid['messages'] = "Problemas na atualização!";
        }

        echo json_encode($valid);
        //Redirect::adminTo('news.php');
?>
