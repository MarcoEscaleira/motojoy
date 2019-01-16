<?php
    require 'core/config.php';
    require_once (INCLUDES_PATH . 'header.php');

    /********  PARTE DE VERFICAÇÃO DE EMAIL E ENVIO DO MESMO COM O LINK  ********/
    if (Input::exists()) {
        if (Input::get('email')) {
            $email = Input::get('email');

            if ($check_email_db = Db::getInstance()->query("SELECT user_id FROM users WHERE user_email = '$email'")) {
              //Enviar email com link para recuperar
              $generated_code = substr(md5(microtime() + $email), 0, 50);
              $user_id = $check_email_db->first()->user_id;
              $nome = Db::getInstance()->query("SELECT user_name FROM users WHERE user_email = '$email'");
              $nome = $nome->first()->user_name;

              //Depois definir a flag do password_code gerado e ativar a flag com o password_recover
              $password_flag = Db::getInstance()->query("SELECT user_password_flag FROM users WHERE user_email = '$email'");
              $password_flag = $password_flag->first()->user_password_flag + 1;

              //Incrementar flag e ativar o password_recover
              $alterar = $user->update(array(
                  "user_password_recover" => 1,
                  "user_password_flag"    => $password_flag
              ), $user_id);
          	$inserir = $user->update(array(
                  "user_password_code" => $generated_code
              ), $user_id);

              $path = URL_PATH.'changepasswordd';
              $full_path = "$path?c=$generated_code&i=$user_id&f=$password_flag";
              Mail::send($email, 'Recuperação da password', MailType::casual('Recupere a sua password', 'Perdeu a sua password? Carregue no botão abaixo para recuperar.', 'Recuperar', $full_path));


              Session::flash("homes", "A recuperação da password foi enviada, por favor verifique o seu email.");
              Redirect::to('index');
              exit();
            } else {
              $print_errors[][1] = "Não conseguimos encontrar o email que introduziu...";
            }
        } else {
            $print_errors[][2] = "Introduza um <b>email</b>";
        }
    }
?>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-6">
                <div class="row">
                    <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recuperação da password</li>
                        </ol>
                    </nav>
                </div>
                <h2 class="text-center">Recupera a tua conta</h2>
                <hr>
                <form action="" autocomplete="on" method="post">
                    <div class="form-group">
                      <div class="row">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="text" class="form-control" placeholder="Email" name="email" id="email" autofocus="on">
                        </div>
                      </div>
                    </div>
                    <div class="row pt-3">
                        <button type="submit" name="submit" class="btn btn-outline-success w-50 mx-auto">Recuperar</button>
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
    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
        duration: 1000,
        origin:'bottom',
        distance: '20px'
        });
    </script>
<?php
    require_once (INCLUDES_PATH . 'footer.php');
?>
