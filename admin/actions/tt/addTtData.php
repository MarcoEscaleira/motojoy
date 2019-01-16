<?php
require ('../../core/configActions.php');

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $valid['success'] = array('success' => false, 'type' => 'warning', 'messages' => array(), 'path' => '');

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
                    $fileDestination = IMGS_PATH_LOCAL . 'tips/'.$NewFileName;

                    move_uploaded_file($fileTmpName, $fileDestination);
                    
                    $yt_top = "<iframe width='560' class='embed-responsive embed-responsive-16by9' height='315' src='";
                    $yt_bot = "' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                    
                    $video = $yt_top . Input::get('tt_video') . $yt_bot;

                    $insert = Db::getInstance()->insert('tips_tricks', array(
                        "tt_title"       => Input::get('tt_title'),
                        "tt_subtitle"    => Input::get('tt_subtitle'),
                        "tt_description" => nl2br(Input::get('tt_description')),
                        "tt_author"      => Input::get('tt_author'),
                        "tt_cat"         => Input::get('tt_cat'),
                        "tt_subcat"      => Input::get('tt_subcat'),
                        "tt_video"       => $video,
                        "tt_image"       => $NewFileName
                    ));

                    $check = Db::getInstance()->get('tips_tricks', array('tt_title', '=', Input::get('tt_title')));

                    if ($check->count()) {
                        $valid['success'] = true;
                        $valid['type'] = "success";
                        $valid['messages'] = "Dica criada!";
                        $valid['path'] = ADMIN_PATH . 'tips&tricks.php';

                    } else {
                        $valid['success'] = false;
                        $valid['type'] = "danger";
                        $valid['messages'] = "Houve um problema na criação da dica!";
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
