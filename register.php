<?php
   require 'core/config.php';
   require_once (INCLUDES_PATH . 'header.php');



   if ($user->isLoggedIn()) {
       Redirect::to('index');
   }

   if (Input::exists()) { //Apenas verificar se o form foi postado
       if (Token::check(Input::get('token'))) {
           $validate = new Validate();
           $validation = $validate->check($_POST, array(
               'user_email' => array(
                   'show' => 'O <b>Email</b>',
                   'required' => true,
                   'min' => 10,
                   'max' => 100,
                   'unique' => 'users'
               ),
               'user_password' => array(
                   'show' => 'A <b>Password</b>',
                   'required' => true,
                   'min' => 6
               ),
               'password_again' => array(
                   'show' => 'A <b>Password de novo</b>',
                   'required' => true,
                   'matches' => 'user_password'
               ),
               'user_name' => array(
                   'show' => 'O <b>Nome</b>',
                   'required' => true,
                   'min' => 4,
                   'max' => 50
               )
           ));

           if ($validation->passed()) {
                $salt = Hash::salt(32);
                $confirm_code = Confirm::generate();

                try {

                       $insert_data = $user->create(array(
                            "user_email" => Input::get('user_email'),
                            "user_password" => Hash::make(Input::get('user_password'), $salt),
                            "user_salt" => $salt,
                            "user_name" => Input::get('user_name'),
                            "user_joined" => date('Y-m-d H:i:s'),
                            "user_confirm" => $confirm_code,
                            "group_id" => 1
                        ));

                        $check = Db::getInstance()->get('users', array('user_email', '=', Input::get('user_email')));

                        if ($check->count()) {
                            $user_id = $check->first()->user_id;
                        }

                        $path = URL_PATH.'activate';
                        $full_path = $path.'?u='.$user_id.'&c='.$confirm_code;

                        $confirm = Mail::send(Input::get('user_email'), 'Confirmar a conta no MotoJoy', MailType::casual('Bem-vindo ao Hub MotoJoy', 'Antes de começar precisa de ativa a sua conta. Para o fazer carregue no botão abaixo.', 'Ativar conta', $full_path));


                        Session::flash('homes', 'A sua conta foi registada! Por favor, verifique o seu e-mail.');
                        Redirect::to('index');
                } catch (Exception $e) {
                    die($e->getMessage());
                }


           } else {
               $print_errors[] = $validation->errors();
           }
       } /*else {
           var_dump(Token::check(Input::get('token')));
       }*/
   }
?>

<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
            <ol class="breadcrumb backbread">
                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registar</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2 class="text-center titles">Criar Nova Conta</h2>
            <hr>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_email">Endereço de Email</label>
                    <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Endereço de Email" value="<?php echo escape(Input::get('user_email')); ?>">
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Palavra passe">
                </div>
                <div class="form-group">
                    <label for="password_again">Password de novo</label>
                    <input type="password" id="password_again" name="password_again" class="form-control" placeholder="Palavra passe de novo">
                </div>
                <div class="form-group">
                    <label for="user_name">Nome</label>
                    <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Nome" value="<?php echo escape(Input::get('user_name')); ?>">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <input type="submit" class="uk-button uk-button-primary uk-width-1-1" value="Registar">
            </form>
                <a href="<?php echo URL_PATH . 'login'; ?>" class="uk-button uk-button-default uk-width-1-1 mt-3">Já tenho a minha conta!</a>
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
</div>

<script type="text/javascript">
    sr.reveal('.breadcrumb', {
    duration: 1000,
    origin:'bottom',
    distance: '20px'
    });
</script>

<?php
   require_once INCLUDES_PATH . 'footer.php';
?>
