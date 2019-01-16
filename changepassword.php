<?php
    require 'core/config.php';

    include INCLUDES_PATH . 'header.php';



    if (!$user->isLoggedIn()) {
        Redirect::to('index');
    }

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $validate = new Validate();

            $validation = $validate->check($_POST, array(
                'current_password' => array(
                    'show' => 'A <b>Password atual</b>',
                    'required' => true
                ),
                'new_password' => array (
                    'show' => 'A <b>Nova password</b>',
                    'required' => true,
                    'min' => 6
                ),
                'password_again' => array (
                    'show' => 'A <b>Password de novo</b>',
                    'required' => true,
                    'matches' => 'new_password'
                )
            ));

            if ($validation->passed()) {
                if ((Hash::make(Input::get('current_password'), $user->data()->user_salt)) !== $user->data()->user_password) {
                    $print_errors[1][0] = 'Password incorreta';
                } else {
                    $salt = Hash::salt(32);

                    $user->update(array(
                        'user_password' => Hash::make(Input::get('new_password'), $salt),
                        'user_salt'     => $salt
                    ));

                    Session::flash('homes', 'Password foi atualizada');
                    Redirect::to('index');
                }
            } else {
                $print_errors[] = $validation->errors();
            }
        }
    }
?>
    <div class="container">

            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="row">
                        <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                            <ol class="breadcrumb backbread">
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'panel'; ?>">Painel do Utilizador</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Definições</li>
                            </ol>
                        </nav>
                    </div>
                    <h2 class="titles mx-auto text-center">Alterar a password</h2>
                    <hr>
                    <form action="" method="post">
                       <div class="form-group">
                          <label for="current_password">Password atual</label>
                          <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Password">
                       </div>

                       <div class="form-group">
                          <label for="new_password">Nova password</label>
                          <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Nova Password">
                       </div>

                       <div class="form-group">
                          <label for="password_again">Nova password de novo</label>
                          <input type="password" id="password_again" name="password_again" class="form-control" placeholder="Nova Password de novo">
                       </div>

                       <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                       <div class="row pt-3">
                           <input type="submit" class="uk-button uk-button-primary w-50 mx-auto" value="Alterar">
                       </div>
                    </form>
                </div>
                <div class="col-3 pt-5">
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
    </div>
<?php
    include INCLUDES_PATH . 'footer.php';
?>
