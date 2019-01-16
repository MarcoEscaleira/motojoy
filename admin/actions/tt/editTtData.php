<?php
    require ('../../core/configActions.php');

    $valid['success'] = array('success' => false, 'messages' => array());

        if (Input::exists()) {
            $tt_id = Input::get('tt_id');

            $yt_top = "<iframe width='560' class='embed-responsive embed-responsive-16by9' height='315' src='";
            $yt_bot = "' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
            
            $video = $yt_top . Input::get('tt_video') . $yt_bot;

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
                            
                            $update = Db::getInstance()->update('tips_tricks', $tt_id, 'tt_id', array(
                                "tt_title"       => Input::get('tt_title'),
                                "tt_subtitle"    => Input::get('tt_subtitle'),
                                "tt_description" => nl2br(Input::get('tt_description')),
                                "tt_author"      => Input::get('tt_author'),
                                "tt_cat"         => Input::get('tt_cat'),
                                "tt_subcat"      => Input::get('tt_subcat'),
                                "tt_video"       => $video,
                                "tt_image"       => $NewFileName
                                ));

                            $valid['success'] = true;
                            $valid['messages'] = "Dica atualizada";
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

            $update = Db::getInstance()->update('tips_tricks', $tt_id, 'tt_id', array(
                  "tt_title"       => Input::get('tt_title'),
                  "tt_subtitle"    => Input::get('tt_subtitle'),
                  "tt_description" => nl2br(Input::get('tt_description')),
                  "tt_author"      => Input::get('tt_author'),
                  "tt_cat"         => Input::get('tt_cat'),
                  "tt_subcat"      => Input::get('tt_subcat'),
                  "tt_video"       => $video
                  ));

             $valid['success'] = true;
             $valid['messages'] = "Dica atualizada";

        } else {
            $valid['success'] = false;
            $valid['messages'] = "Problemas na atualização!";
        }

        echo json_encode($valid);
        //Redirect::adminTo('news.php');
?>
