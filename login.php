<?php
    include 'core/config.php';
    require_once (INCLUDES_PATH . 'header.php');

    if ($user->isLoggedIn()) {
        Redirect::to('index');
    }

    if (Input::exists()) {
        $validation = new Validate();

        $validation->check($_POST, array(
            'user_email' => array(
                'show' => 'O <b>Email</b>',
                'required' => true
            ),
            'user_password' => array(
                'show' => 'A <b>Password</b>',
                'required' => true
            )
        ));

        if ($validation->passed()) {

            $remember = (Input::get('remember') === 'on') ? true : false;

            $email = Input::get('user_email');

            $check_mail = Db::getInstance()->query("SELECT `user_email` FROM `users`");

            if($check_mail->count()) {
                $check = Db::getInstance()->query("SELECT `user_password_recover` FROM `users` WHERE `user_email` = '$email'");

                $pr = $check->first()->user_password_recover;

                if ($pr == 0) {
                    $login = $user->login($email, Input::get('user_password'), $remember);

                    if ($login) {
                        Session::flash('homes', 'Sessão iniciada');
                        Redirect::to('index');
                    } else {
                        $print_errors[1][0] = 'Erros nos dados do login';
                    }
                } else {
                    $print_errors[1][0] = 'Recupere a sua password primeiro';
                }
            } else {
                $print_errors[1][0] = 'Email introduzido não existe';
            }
             
        } else {
            $print_errors[] = $validation->errors();
        }
    }
?>  
    <div class="row">
        <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
            <ol class="breadcrumb backbread">
                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2 class="text-center titles">Iniciar Sessão</h2>
            <hr>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_email">Endereço de Email</label>
                    <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Endereço de Email" value="<?php echo escape(Input::get('user_email')); ?>">
                </div>
                <div class="form-group">
                    <label for="user_password">Palavra passe</label>
                    <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Palavra passe">
                </div>

                <div class="form-group my-4">
                    <div class="checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Lembrar de mim</label>
                    </div>
                </div>

                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <input type="submit" class="uk-button uk-button-primary uk-width-1-1" value="Iniciar sessão">
            </form>
            <div class="row">
                <a href="<?php echo URL_PATH . 'passrecover'; ?>" class="uk-button uk-button-default mx-auto mt-3"><i class="fa fa-key"></i> Perdi a minha password</a>
                <a href="<?php echo URL_PATH . 'register'; ?>" class="uk-button uk-button-default mx-auto mt-3"><i class="fa fa-user-o"></i> Ainda não tenho conta</a>
            </div>
        </div>
        <div class="col-2 pt-5">
            <?php
                if (!empty($print_errors)) {
                    foreach ($print_errors as $print_values) {
                        foreach ($print_values as $value) {
                            echo '<div class="alert alert-danger" role="alert">'.$value.'</div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
    
    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
        duration: 1000,
        origin:'bottom',
        distance: '20px'
        });

        $(document).ready(function() {
            $('.alert').delay(4000).fadeOut();
            
        });
    </script>
<?php
    require_once (INCLUDES_PATH . 'footer.php');
?>
