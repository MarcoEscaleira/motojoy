<?php
    include 'core/config.php';
    require_once (INCLUDES_PATH . 'header.php');

    if (!$user->isLoggedIn()) {
        Session::flash('home', 'Precisa de estar logado para aceder ao <b>Painel</b>');
        Redirect::to('index');
    } else {
        $ud = $user->data();
    }
 ?>

 <div class="container" style="min-height: 800px;">
        <div class="row">
            <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                <ol class="breadcrumb backbread">
                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Painel do Utilizador</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <h2 class="titles mx-auto text-center">Painel do Utilizador</h2>
        </div>
        
        <div class="row">
            <div class="col-3">
                <a href="history" class="btn btn-lg btn-info mx-auto w-100 mt-3 radio10"><i class="fa fa-shopping-cart"></i> Histórico de Compras</a>
                <hr>
                <a href="settings" class="uk-button uk-button-default w-100 radio10"><i class="fa fa-wrench"></i> Definições</a>
                <hr>
                <a href="changepassword" class="uk-button uk-button-default w-100 radio10"><i class="fa fa-key"></i> Mudar password</a>
                <hr>
                <a href="logout" class="uk-button uk-button-default w-100 radio10"><i class="fa fa-sign-out"></i> Sair</a>
            </div>
            <div class="col-9">
                <figure class="snip1344 mx-auto">
                    <img src="<?php echo AIMGS_PATH . $ud->user_image; ?>" alt="<?php echo $ud->user_image; ?>" class="background">
                    <img src="<?php echo AIMGS_PATH . $ud->user_image; ?>" alt="<?php echo $ud->user_image; ?>" class="profile">
                    <figcaption>
                        <h3><?php echo $ud->user_name; ?><span><?php echo $ud->user_username; ?></span></h3>
                        <div class="row mt-3">
                            <div class="col-6 text-right">
                                <span class="type">Email</span><br>
                                <span class="type">Data de criação</span><br>
                                <span class="type">Nif</span><br>
                                <span class="type">Telemóvel</span><br>
                                <span class="type">Endereço</span><br>
                                <span class="type">Código de Postal</span><br>
                                <span class="type">Permissões</span>
                            </div>
                            <div class="col-6 text-left">
                                <?php echo $ud->user_email; ?><br>
                                <?php echo date('d / M / Y',strtotime($ud->user_joined)); ?><br>
                                <?php echo $ud->user_nif; ?><br>
                                <?php echo $ud->user_phone; ?><br>
                                <?php echo $ud->user_address; ?><br>
                                <?php echo $ud->user_postcode; ?><br>
                                <?php echo ($ud->group_id == '1')?'Utilizador' : 'Administrador';  ?>
                            </div>
                        </div>
                    </figcaption>
                </figure>
            </div>
        </div>

 </div><!--Container-->

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
