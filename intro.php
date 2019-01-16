<?php
   include 'core/config.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>MotoJoy - Intro</title>
      <meta name="description" content="MotoJoy">
      <link rel="icon" href="<?php echo IMGS_PATH . 'icon.png' ?>">
      <?php
         //Bootstrap CSS
         Assets::loadCSS_Assets('bootstrap4/bootstrap.min');
         //Font-awesome
         Assets::loadCSS_Assets('font-awesome/font-awesome.min');

         Assets::loadCSS_Custom('intro');

         //Jquery
         Assets::loadJS_Assets('jquery/jquery-3.2.1.min');

         //Scroll Revealer
         Assets::loadJS_Assets('scrollreveal/scrollreveal.min');

         Assets::loadJS_Custom('intro');
      ?>
      <script type="text/javascript">
         window.sr = ScrollReveal({ reset: true });
      </script>
   </head>
   <body>
   <div class="jumbotron">
        <video id="video-background" autoplay loop muted>
            <source type="video/mp4" src="<?php echo ASSETS_PATH . 'video/intro2.mp4'; ?>">
        </video>

       <div class="container">
           <h1 id="vid_title">We live, We ride!</h1>
           <h3 class="red_text">Moto <b>Joy</b></h3>
           <div class="arrow">
               <a href="#intro"><i class="fa fa-chevron-down" style="color: #000;"></i></a>
           </div>
       </div>
   </div>
   <div class="redline"></div>
       <div id="intro">
       <div class="container">
           <h2>Bem vindo ao Hub <b>Motojoy</b></h2>
           <p>Podes fazer as tuas compras, acompanhar todas as novidades do nosso mundo e ainda aprender mais sobre a tua máquina.</p>

           <div class="line mb-4"></div>
           <a href="index" class="btn btn-danger btn-lg btn-block mb-4" id="btn-home" role="button" aria-pressed="true">Continuar</a>
           <div class="line mb-4"></div>

           <div class="row category h-90">
               <div class="col-md-4 cat">
                   <div class="card" id="card_loja">
                       <div class="card-img">
                            <div class="uk-cover-container">
                                <img class="card-img-top d-block w-100 img-fluid w-100 h-100" src="<?php echo IMGS_PATH . 'panigale.png'; ?>" alt="panigale" uk-cover>
                            </div>
                       </div>
                       <div class="card-block">
                           <h4 class="card-title">Compra connosco</h4>
                           <p class="card-text">Precisas de alguma peça ou acessório para a tua mota? Estamos ao ao teu dispor !</p>
                           <a href="<?php echo STORE_PATH; ?>" class="btn btn-outline-danger mb-4 w-50">Loja</a>
                       </div>
                   </div>
               </div>

               <div class="col-md-4 cat">
                   <div class="card" id="card_noticias">
                       <div class="card-img">
                            <div class="uk-cover-container">
                                <img class="card-img-top d-block w-100 img-fluid w-100 h-100" src="<?php echo IMGS_PATH . 'default.png'; ?>" alt="r1m" uk-cover>
                            </div>
                       </div>
                       <div class="card-block">
                           <h4 class="card-title">Notícias do nosso mundo</h4>
                           <p class="card-text">Tens aqui as notícias mais recentes do mundo motard. Acompanha todas já !</p>
                           <a href="<?php echo URL_PATH . 'news'; ?>" class="btn btn-outline-primary mb-4 w-50">Notícias</a>
                       </div>
                   </div>
               </div>

               <div class="col-md-4 cat">
                   <div class="card" id="card_aprende">
                       <div class="card-img">
                            <div class="uk-cover-container">
                                <img class="card-img-top d-block w-100 img-fluid w-100 h-100" src="<?php echo IMGS_PATH . 'r6.png'; ?>" alt="r6" uk-cover> 
                            </div>
                       </div>
                       <div class="card-block">
                           <h4 class="card-title">Aprende connosco!</h4>
                           <p class="card-text">Queres aprender a mexer na tua própria mota? Vê e aprende connosco !</p>
                           <a href="<?php echo URL_PATH . 'tipstricks'; ?>" class="btn btn-outline-success mb-4 w-50">Aprende connosco</a>
                       </div>
                   </div>
               </div>

           </div>
       </div>
   </div>
   <div class="contact" style="background: url('<?php echo IMGS_PATH . 'dirt.png'; ?>') fixed no-repeat; background-size: cover; min-height: 350px;">
   </div>

<footer>
  <div class="flash_messages"></div>
  <div class="container">
  <div class="top-footer">

    <div class="row">

    <div class="col-md-5">
    <address>
      <strong>Marco Escaleira</strong><br>
      Travessa da Seara 61 3ºDT<br>
      Matosinhos, Porto<br>
      <abbr title="Phone">+351 912766624</abbr>
    </address>
      </div>

      <div class="col-md-7">
        <h3>Marco Escaleira.</h3>
        <p>Sou um jovem que adora o desenvolvimento de plataformas online. Sou determinado e gosto de novos desafios. Prazer, sou eu... Marco Escaleira</p>
      </div>

    </div>
  </div>
  <div class="main-footer">
<div class="row">
    <div class="col-md-4 col-sm-12 social">
      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
      <a href="#"><i class="fa fa-google-plus"></i></a>
      <a href="#"><i class="fa fa-instagram"></i></a>
  </div>
      <div class="col-md-4 col-sm-12 year">
        <p>Marco Escaleira. 2017</p>
        <p>Todos os direitos reservados.</p>
  </div>
      <div class="col-md-4 col-sm-12 copyright">
        <p>Copyrights &copy; Marco Escaleira</p>
  </div>

    </div>
  </div>
    </div>
</footer>


      <!--<div id="overlay">
         <div class="spinner"></div>
     </div>-->
     <div id="loader-wrapper">
         <div class="loader">
             <div class="line"></div>
             <div class="line"></div>
             <div class="line"></div>
             <div class="line"></div>
             <div class="line"></div>
             <div class="line"></div>
             <div class="subline"></div>
             <div class="subline"></div>
             <div class="subline"></div>
             <div class="subline"></div>
             <div class="subline"></div>
             <div class="loader-circle-1"><div class="loader-circle-2"></div></div>
             <div class="needle"></div>
             <div class="loading">Carregando</div>
         </div>
     </div>

      <script type="text/javascript">
         sr.reveal('#vid_title', {
            duration: 2500,
            origin:'top',
            distance: '100px'
         });
         sr.reveal('.red_text', {
            duration: 1500,
            origin: 'left',
            distance: '200px'
         });
         sr.reveal('#btn-home', {
            duration: 1000,
            origin: 'bottom',
            distance: '100px'
         });
         sr.reveal('#card_loja', {
            duration: 1700,
            origin: 'right',
            rotate: {x: 50}
         });
         sr.reveal('#card_noticias', {
            duration: 1700,
            origin: 'bottom',
            rotate: {x: 50},
            delay: 250
         });
         sr.reveal('#card_aprende', {
            duration: 1700,
            origin: 'right',
            rotate: {x: 50},
            delay: 500
         });
      </script>

      <?php
          Assets::loadJS_Assets('validation/dist/jquery.validate.min');
          Assets::loadJS_Assets('validation/dist/additional-methods.min');
      ?>
      <script type="text/javascript">
      $(function() {
        var validation = $("#con_form").validate({
          rules: {
            'con_email': {
                required: true,
                email: true
            },
            'con_msg': {
                required: true
            }
          },
          messages: {
              'con_email': {
                  required: 'É necessário definir um email',
                  email: 'Insira um email válido'
              },
              'con_msg': {
                  required: 'É necessário escrever uma mensagem',
              }
          },
          submitHandler: function (form, event) {
              event.preventDefault();
              //Pegar campos dos inputs
              var con_email  = $('#con_email').val();
              var con_msg    = $('#con_msg').val();

                var form = $('#con_form');
                var update = $.ajax({
                  url: 'intro.php',
                  type: 'post',
                  data: form.serialize(),
                  dataType: 'json',
                  success:function(response) {
                    alert('aqui');
                      $('.flash_messages').html('<div class="alert alert-success text-center" role="alert">'+
                      '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages +
                      '</div>');

                      $(".alert-success").delay(400).slideDown(10, function() {
                        $(this).delay(2000).slideUp('slow', function() {
                            $(this).remove();
                        });
                      }); // /.alert

                      $('#con_email').html('');
                      $('#con_msg').html('');
                  }


                }); // Edit ajax
          },
          highlight: function(element) {
              $(element).closest('.form-control').addClass('is-invalid');
          },
          unhighlight: function(element) {
              $(element).closest('.form-control').removeClass('is-invalid');
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
   </body>
</html>
