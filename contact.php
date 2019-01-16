<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';

    if (!$user->isLoggedIn()) {
      Session::flash('homew', 'Faça login primeiro para puder falar connosco');
      Redirect::to('index');
    }
    
    if (Input::exists()) {
      if (Token::check(Input::get('token'))) {
        $user_email = $user->data()->user_email;
        $user_name = $user->data()->user_name;
        $subject = Input::get('subject');
        $message = nl2br(Input::get('message'));

        if (!empty($subject) && !empty($message)) {
          if( Mail::send('marcoescaleira2000@gmail.com', 'MotoJoy - ' . $subject, MailType::contact($message, $user_name, $user_email)) ) {
            if (Input::get('check_copy')) {
              if (Mail::send($user_email, 'MotoJoy - ' . $subject, MailType::contact($message, $user_name, $user_email))) {
                echo '<div class="alert alert-success w-50 mx-auto" role="alert">
                      <div class="container text-center">
                          <div class="alert-icon">
                              <i class="now-ui-icons ui-2_like"></i>
                          </div>
                          <strong>SUCESSO!</strong> Mail e cópia enviados com sucesso
                      </div>
                  </div>';
              } else {
                echo '<div class="alert alert-warning w-50 mx-auto" role="alert">
                      <div class="container text-center">
                          <div class="alert-icon">
                              <i class="now-ui-icons ui-2_like"></i>
                          </div>
                          <strong>AVISO!</strong> Erro ao enviar a cópia do mail
                      </div>
                  </div>';
              }
            } else {
              echo '<div class="alert alert-success w-50 mx-auto" role="alert">
                        <div class="container text-center">
                            <div class="alert-icon">
                                <i class="now-ui-icons ui-2_like"></i>
                            </div>
                            <strong>SUCESSO!</strong> Mail enviado com sucesso
                        </div>
                    </div>';
            }
          } else {
            echo '<div class="alert alert-warning w-50 mx-auto" role="alert">
                      <div class="container text-center">
                          <div class="alert-icon">
                              <i class="now-ui-icons ui-2_like"></i>
                          </div>
                          <strong>AVISO!</strong> Erro ao enviar a mail
                      </div>
                  </div>';
          }
        }
      }
    }
?>

  <div class="container">
    <div class="row">
      <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
        <ol class="breadcrumb backbread">
          <li class="breadcrumb-item"><a href="<?php echo URL_PATH .'index'; ?>">Início</a></li>
          <li class="breadcrumb-item active" aria-current="page">Contatos</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-7">
          <img src="<?php echo IMGS_PATH . 'gp-cel.jpg'; ?>" class="img-fluid rounded mx-auto d-block mt-5" width="500em">
      </div>
      <div class="col-5">
        <h4 id="contact_title" class="text-right"><i class="fa fa-envelope"></i> Entre em contacto</h4>
        <form method="post" id="contact_form" class="mt-5">
            <div class="form-group">
              <input type="text" name="subject" id="subject" placeholder="Assunto" class="form-control">
            </div>
            <hr class="mb-3">
            <div class="form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Mensagem" rows="5"></textarea>
            </div>
            <div class="checkbox" style="font-family: 'Lato'; margin-top: 25px;">
              <input id="check_copy" name="check_copy" type="checkbox">
              <label for="check_copy">
                Pretende receber uma cópia para o seu email?
              </label>
            </div>
            <div class="form-group">
              <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
              <input type="submit" class="btn btn-primary w-50 btn-round" value="Enviar">
            </div>
        </form>
      </div>
    </div>
  </div>

  <?php
    Assets::loadJS_Assets('validation/dist/jquery.validate.min');
    Assets::loadJS_Assets('validation/dist/additional-methods.min');
  ?>

  <script>
    $(document).ready(function () {
        $('.alert-warning').delay(4500).slideUp('slow');
        $('.alert-success').delay(3500).slideUp('slow');
        
        $("#contact_form").validate({
        rules: {
          'subject': {
              required: true
          },
          'message': {
              required: true,
          }
        },
        messages: {
            'subject': {
                required: 'É necessário escrever um assunto'
            },
            'message': {
                required: 'É necessário escrever uma mensagem',
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#contact_form')[0]);

            $.ajax({
                type: 'post',
                data: formData
            });

            return false;
        },
        highlight: function(element) {
            $(element).closest('.form-control').addClass('is-invalid');
            $(element).closest('.custom-select').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.custom-select').removeClass('is-invalid');
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback mb-3',
        errorPlacement: function(error, element) {
            if(element.parent('.form-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
      });
    });
  </script>

<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
