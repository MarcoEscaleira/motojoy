<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';


    if (!$user->isLoggedIn()) {
        Redirect::to('index');
    }

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();

            $validation = $validate->check($_POST, array(
                'user_name' => array(
                    'show' => 'O <b>Nome</b>',
                    'required' => true
                ),
                'user_username' => array(
                    'show' => 'O <b>Username</b>',
                    'required' => true
                ),
                'user_phone' => array(
                    'show' => 'O <b>Telemóvel</b>',
                    'required' => true
                ),
                'user_nif' => array(
                    'show' => 'O <b>NIF</b>',
                    'required' => true
                ),
                'user_address' => array(
                    'show' => 'O <b>Endereço</b>',
                    'required' => true
                ),
                'user_postcode' => array(
                    'show' => 'O <b>Código de Postal</b>',
                    'required' => true
                ),
                'user_email' => array(
                    'show' => 'O <b>Email</b>',
                    'required' => true
                )
            ));

            if ($validation->passed()) {
                if (Input::get('user_username') != $user->data()->user_username || Input::get('user_email') != $user->data()->user_email) {
                    if (Input::get('user_username') != $user->data()->user_username) {
                        $checkUsername = Db::getInstance()->get('users', array('user_username', '=', Input::get('user_username')));
                        if ($checkUsername->count()) {
                            $print_errors[1][] ="O <b>Username</b> já existe";
                        } else {
                            if (Input::get('image')) {
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
                                            $fileDestination = IMGS_PATH_LOCAL . 'accounts/'.$NewFileName;

                                            move_uploaded_file($fileTmpName, $fileDestination);

                                            $user->update(array(
                                                'user_name'      => Input::get('user_name'),
                                                'user_username'  => Input::get('user_username'),
                                                'user_phone'     => Input::get('user_phone'),
                                                'user_nif'       => Input::get('user_nif'),
                                                'user_address'   => Input::get('user_address'),
                                                'user_postcode'  => Input::get('user_postcode'),
                                                'user_email'     => Input::get('user_email'),
                                                'user_image'       => $NewFileName 
                                            ));

                                            Session::flash('success', 'A tua conta foi atualizada com <b>sucesso</b>!');
                                            Redirect::to('settings');

                                        } else {
                                            $print_errors[2][] ="A imagem e demasiado grande. ( 20 MBs maximo )";
                                        }
                                    
                                    } else {
                                        $print_errors[2][] ="Erro no upload da imagem";
                                    }

                                } else {
                                    $print_errors[2][] ="Formato da imagem errado. ( jpg, jpeg e png )";
                                }
                            } else {
                                try {
                                    $user->update(array(
                                        'user_name'      => Input::get('user_name'),
                                        'user_username'  => Input::get('user_username'),
                                        'user_phone'     => Input::get('user_phone'),
                                        'user_nif'       => Input::get('user_nif'),
                                        'user_address'   => Input::get('user_address'),
                                        'user_postcode'  => Input::get('user_postcode'),
                                        'user_email'     => Input::get('user_email')
                                    ));

                                    Session::flash('success', 'A tua conta foi atualizada com <b>sucesso</b>!');
                                    Redirect::to('settings');
                                } catch (Exception $e) {
                                    die($e->getMessage());
                                }
                            }
                        }
                    }

                    if (Input::get('user_email') != $user->data()->user_email) {
                        $checkEmail = Db::getInstance()->get('users', array('user_email', '=', Input::get('user_email')));
                        if ($checkEmail->count()) {
                            $print_errors[1][] ="O <b>Email</b> já existe";
                        } else {
                            try {
                                $user->update(array(
                                    'user_name'      => Input::get('user_name'),
                                    'user_username'  => Input::get('user_username'),
                                    'user_phone'     => Input::get('user_phone'),
                                    'user_nif'       => Input::get('user_nif'),
                                    'user_address'   => Input::get('user_address'),
                                    'user_postcode'  => Input::get('user_postcode'),
                                    'user_email'     => Input::get('user_email')
                                ));

                                Session::flash('success', 'Conta foi atualizada com <b>sucesso</b>!');
                                Redirect::to('settings');
                            } catch (Exception $e) {
                                die($e->getMessage());
                            }
                        }
                    }

                } else {
                    try {
                        $user->update(array(
                            'user_name'      => Input::get('user_name'),
                            'user_username'  => Input::get('user_username'),
                            'user_phone'     => Input::get('user_phone'),
                            'user_nif'       => Input::get('user_nif'),
                            'user_address'   => Input::get('user_address'),
                            'user_postcode'  => Input::get('user_postcode'),
                            'user_email'     => Input::get('user_email'),
                            'user_news'      => Input::get('user_news')
                        ));

                        Session::flash('success', 'Conta foi atualizada com <b>sucesso</b>!');
                        Redirect::to('settings');
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }

            } else {
                $print_errors[] = $validation->errors();
            }
        }
    }
?>

    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                <ol class="breadcrumb backbread">
                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'panel'; ?>">Painel do Utilizador</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Definições</li>
                </ol>
            </nav>
        </div>
        
        <main class="settings">
            <form action="" method="post" enctype="multipart/form-data">
                <h1><i class="fa fa-cogs"></i> Definições</h1>
                <div class="settings-options">
                    <label for="profile"><i class="fa fa-user"></i> Perfil</label>
                    <label for="preferences"><i class="fa fa-cog"></i> Preferências</label>
                    <label for="account"><i class="fa fa-wrench"></i> Conta</label>
                </div>
                <input type="radio" class="helper-input" name="settings-page" id="profile" checked="checked">
                <div class="panel profile">
                    <h2 class="pb-4"><i class="fa fa-user"></i> Perfil</h2>
                    <?php
                        if (Session::exists('success')) {
                            echo '  
                            <div class="alert alert-success w-75 mx-auto" role="alert">
                                <div class="container text-center">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-2_like"></i>
                                    </div>
                                    <strong>SUCESSO!</strong> '.Session::flash('success').'
                                </div>
                            </div>';
                        }
                        if (!empty($print_errors)) {
                            foreach ($print_errors as $print_values) {
                                foreach ($print_values as $value) {
                                    echo '<div class="alert alert-danger" role="alert">'.$value.'</div>';
                                }
                            }
                        }
                    ?>

                    <input type="text" class="mt-3" id="user_name" name="user_name" placeholder="Nome" value="<?php echo escape($user->data()->user_name); ?>">
                    <label for="name" class="text-label">Nome</label>

                    <hr>

                    <input type="text" id="user_username" name="user_username"  placeholder="Username" value="<?php echo escape($user->data()->user_username); ?>">
                    <label for="user_username" class="text-label">Username</label>

                    <hr>

                    <input type="text" id="user_phone" name="user_phone" placeholder="Telemóvel" value="<?php echo escape($user->data()->user_phone); ?>">
                    <label for="user_phone" class="text-label">Telemóvel</label>

                    <hr>

                    <input type="text" id="user_nif" name="user_nif"  placeholder="NIF" value="<?php echo escape($user->data()->user_nif); ?>">
                    <label for="user_nif" class="text-label">NIF</label>

                    <hr>

                    <input type="text" id="user_address" name="user_address"  placeholder="Endereço" value="<?php echo escape($user->data()->user_address); ?>">
                    <label for="user_address" class="text-label">Endereço</label>

                    <hr>

                    <input type="text" id="user_postcode" name="user_postcode"  placeholder="Código de postal" value="<?php echo escape($user->data()->user_postcode); ?>">
                    <label for="user_postcode" class="text-label">Código de postal</label>

                    <hr>

                    <input type="file" name="image" id="image" class="form-control-file">
                </div>

                <input type="radio" class="helper-input" name="settings-page" id="preferences">
                <div class="panel preferences">
                    <h2 class="pb-4"><i class="fa fa-cog"></i> Preferências</h2>

                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input class="uk-checkbox" type="checkbox" id="user_news" name="user_news" value="1" <?php if($user->data()->user_news == 1) echo 'checked';?>> Receber emails com novidades</label>
                    </div>
                                                            
                </div>

                <input type="radio" class="helper-input" name="settings-page" id="account">
                <div class="panel account">
                    <h2 class="pb-4"><i class="fa fa-wrench"></i> Conta</h2>

                    <?php
                        if (!empty($print_errors)) {
                            foreach ($print_errors as $print_values) {
                                foreach ($print_values as $value) {
                                    echo '<div class="alert alert-danger" role="alert">'.$value.'</div>';
                                }
                            }
                        }
                    ?>

                    <input type="text" id="user_email" name="user_email" placeholder="Email" value="<?php echo escape($user->data()->user_email); ?>">
                    <label for="user_email" class="text-label">Email</label>
                </div>

                <hr>

                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <div class="row">
                    <button type="submit" class="btn btn-outline-danger w-50 mx-auto">
                    <i class="fa fa-cloud"></i>
                    Guardar
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
        duration: 1000,
        origin:'bottom',
        distance: '20px'
        });

        $(document).ready(function () {
            $('.alert-success').delay(2500).slideUp('slow');
            $('.alert-danger').delay(2500).slideUp('slow');
        });
    </script>

<?php

    //Código html
    /*
    <label>Email Alerts</label>
    <p>You may select multiple options</p>

    <input type="checkbox" class="helper-input" name="email-input" id="email-input">
    <label for="email-input" class="select-toggle"><span class="screen-reader-text">Show Email Options</span></label>
    <div class="select">
        <input type="checkbox" name="email" id="daily"> <label for="daily">Daily</label>
        <input type="checkbox" name="email" id="weekly" checked="checked"> <label for="weekly">Weekly</label>
        <input type="checkbox" name="email" id="monthly"> <label for="monthly">Monthly</label>
        <input type="checkbox" name="email" id="yearly"> <label for="yearly">Yearly</label>
    </div>

    <label>Sex</label>
    <input type="checkbox" class="helper-input" name="email-input" id="sex-input">
    <label for="sex-input" class="select-toggle"><span class="screen-reader-text">Show Sex Options</span></label>
    <div class="select">
        <input type="radio" name="sex" id="male"> <label for="male">Male</label>
        <input type="radio" name="sex" id="female"> <label for="female">Female</label>
        <input type="radio" name="sex" id="na" checked="checked"> <label for="na">N/A</label>
    </div>

    <hr>

    <label for="bio">Bio</label>
    <textarea name="bio" id="bio" placeholder="What makes you tick?"></textarea>
    */
    require_once INCLUDES_PATH . 'footer.php'
?>
