<?php
    require 'core/config.php';
    require_once (INCLUDES_PATH . 'header.php');

    if (Input::exists('get')) {
        if (!empty(Input::get('c')) && !empty(Input::get('i')) && !empty(Input::get('f'))) {
            $generated_code = Input::get('c');
            $user_id = Input::get('i');
            $password_flag = Input::get('f');

        if (Db::getInstance()->query("SELECT user_id FROM users WHERE user_id = $user_id AND user_password_code = '$generated_code' AND user_password_flag = $password_flag AND user_password_recover = 1")) {

            if (Input::exists()) {
                $validate = new Validate();

                $validation = $validate->check($_POST, array(
                    'user_password' => array(
                        'show' => 'A <b>Password</b>',
                        'required' => true,
                        'min' => 6
                    ),
                    'password_again' => array(
                        'show' => 'A <b>Password de novo</b>',
                        'required' => true,
                        'matches' => 'user_password'
                    )
                ));


                if ($validation->passed()) {
                    try {
                        $salt = Hash::salt(32);

                        $update = $user->update(array(
                            "user_password" => Hash::make(Input::get('user_password'), $salt),
                            "user_salt" => $salt
                        ), $user_id);


                        $reset = $user->update(array(
                            "user_password_recover" => 0,
                            "user_password_code"    => ''
                        ), $user_id);

                        Session::flash('homes', 'Password recuperada');
                        Redirect::to('index');
                    }  catch (Exception $e) {
                        die($e->getMessage());
                    }

                } else {
                    $print_errors[] = $validation->errors();
                }
            }
        }
        } else {
            Redirect::to(404);
        }
    } else {
        Redirect::to(404);
    }
?>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-6">
                <h2 class="text-center">Recupera a tua password</h2>
                <hr>
                <form action="" autocomplete="on" method="post">
                    <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-key"></i></span>
                          <input type="password" class="form-control" placeholder="Password" name="user_password" id="user_password" autofocus="on">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-key"></i></span>
                          <input type="password" class="form-control" placeholder="Password de novo" name="password_again" id="password_again">
                        </div>
                    </div>
                    <div class="row pt-3">
                        <button type="submit" name="submit" class="btn btn-warning w-50 mx-auto"><i class="fa fa-unlock"></i> Recuperar</button>
                    </div>
                </form>
            </div>
            <div class="col pt-5">
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
    require_once (INCLUDES_PATH . 'footer.php');
?>
