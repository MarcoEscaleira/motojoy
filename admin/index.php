<?php
    require ('core/config.php');
    require_once 'includes/header.php';

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            $user_email = $user->data()->user_email;
            $user_name = $user->data()->user_name;
            $subject = Input::get('subject');
            $message = nl2br(Input::get('message'));
            

            if (!empty($subject) && !empty($message)) {
                $users = Db::getInstance()->query("SELECT * FROM users");
                $check = 0;
                foreach ($users->results() as $key => $u) {
                    if(Mail::send($u->user_email, 'MotoJoy - ' . $subject, MailType::contact($message, 'Administrador', 'MotoJoy'))) {
                        $check = 1;
                    } else {
                        $check = 0;
                    }
                }

                if( $check == 1 ) {
                    echo '<div class="alert alert-success w-50 mx-auto" role="alert">
                                <div class="container text-center">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-2_like"></i>
                                    </div>
                                    <strong>SUCESSO!</strong> Mails enviados com sucesso
                                </div>
                            </div>';
                } else if ($check == 0) {
                    echo '<div class="alert alert-warning w-50 mx-auto" role="alert">
                            <div class="container text-center">
                                <div class="alert-icon">
                                    <i class="now-ui-icons ui-2_like"></i>
                                </div>
                                <strong>AVISO!</strong> Erro ao enviar a mails
                            </div>
                        </div>';
                }
            }
        }


        //Custom message
        if(Input::get('set_message')) {
            
            $check = Db::getInstance()->query("SELECT * FROM `custom_message`");
            if($check->count()) { //Update
                $update = Db::getInstance()->update('custom_message', 1, 'me_set', array("me_message" => Input::get('msg')));
            } else { //Insert
                if(Db::getInstance()->insert('custom_message', array("me_message" => Input::get('msg'), "me_set" => 1))) {
                    echo '<div class="alert alert-success w-50 mx-auto" role="alert">
                                <div class="container text-center">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-2_like"></i>
                                    </div>
                                    <strong>SUCESSO!</strong> Mensagem definida com sucesso
                                </div>
                            </div>';
                } else {
                    echo '<div class="alert alert-warning w-50 mx-auto" role="alert">
                                <div class="container text-center">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-2_like"></i>
                                    </div>
                                    <strong>SUCESSO!</strong> Erro
                                </div>
                            </div>';
                }
            }
        }
    }
?>

<div class="container">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo URL_PATH; ?>">Início</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo URL_PATH.'index.php'; ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Administração</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <h1 class="display-4 mx-auto text-center">Centro de Administração</h1><hr class="mb-5" style=" width: 75%; background-color: #838383; height: 0.5px;">

            <div class="row">
                <h4 class="mx-auto text-center mb-4">Produtos mais vistos</h4>
                <div id="chart-container" class="mx-auto" style="width: 95%; height: auto; position: relative;">
                    <canvas class="line-chart"></canvas>
                </div>
            </div>
            <hr class="my-5">
            <div class="row">
                <h4 class="mx-auto text-center mb-4">Enviar email aos utilizadores</h4>
            </div>
            <div class="row">
                <form method="post" id="msg_users" class="w-75 mx-auto">
                    <div class="form-group">
                    <input type="text" name="subject" id="subject" placeholder="Assunto" class="form-control">
                    </div>
                    <hr class="my-3">
                    <div class="form-group">
                    <textarea class="form-control" id="message" name="message" placeholder="Mensagem" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input type="submit" class="btn btn-primary w-50 btn-round" value="Enviar">
                    </div>
                </form>
                </div>
            </div>
            <hr class="my-5">
            <div class="row">
                <h4 class="mx-auto text-center mb-4">Aviso Geral</h4>
            </div>
            <div class="row">
                <form method="post" id="message_form" class="form-inline w-50 mx-auto mt-4 mb-5">
                    <div class="form-group">
                        <label for="msg">Mensagem &nbsp;</label>
                        <input type="text" class="form-control" name="msg" id="msg">
                    </div>
                    <button type="submit" name="set_message" class="btn btn-success ml-5">Definir</button>
                    <button class="btn btn-default ml-4">Apagar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    Assets::loadJS_Assets('validation/dist/jquery.validate.min');
    Assets::loadJS_Assets('validation/dist/additional-methods.min');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script type="text/javascript">
    sr.reveal('.breadcrumb', {
    duration: 1000,
    origin:'bottom',
    distance: '20px'
    });

    $(document).ready(function () {
        $('.alert-warning').delay(4500).slideUp('slow');
        $('.alert-success').delay(3500).slideUp('slow');

        $("#msg_users").validate({
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
                    data: formData,
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

        /*  Chart .js  */
        $.ajax({
            url: 'actions/chart.php',
            method: "GET",
            data: {news: 1},
            success: function(data) {
                var noticias = [];
                var views = [];
                
                for (var i in data) {
                    noticias.push(data[i].prod_name);
                    views.push(data[i].prod_views);
                }

                var chartdata = {
                    labels: noticias,
                    datasets: [
                        {
                            label: 'Visualizações',
                            backgroundColor: 'rgba(200, 200, 200, 0.75)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundCOlor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: views
                        }
                    ]
                };

                var ctx = $('.line-chart');
                
                Chart.defaults.global.defaultFontFamily = 'Arial';
                Chart.defaults.global.defaultFontSize = 16;
                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        responsive: true
                    }
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>


<?php
    require_once 'includes/footer.php';
?>
