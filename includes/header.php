<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="description" content="MotoJoy">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="<?php echo IMGS_PATH . 'Motojoy.png' ?>">
      <title>MotoJoy</title>
      <?php
        //Semantic UI
        //Assets::loadCSS_Assets('semantic/semantic.min');
        //Assets::loadJS_Assets('semantic/semantic.min');
        //Bootstrap CSS
        Assets::loadCSS_Assets('now-ui/assets/css/bootstrap.min');
        Assets::loadCSS_Assets('now-ui/assets/css/now-ui-kit');
        //uikit
        Assets::loadCSS_Assets('uikit/css/uikit.min');
        //Font-awesome
        Assets::loadCSS_Assets('font-awesome/font-awesome.min');
        //Data tables
        Assets::loadCSS_Assets('datatables/css/dataTables.bootstrap4.min');
         
        Assets::loadCSS_Custom('navbar');
        Assets::loadCSS_Custom('main');
        Assets::loadCSS_Custom('404');

        if ($current_file == 'settings.php')
          Assets::loadCSS_Custom('settings');

        //Jquery
        Assets::loadJS_Assets('jquery/jquery-3.2.1.min');
        //Popper
        Assets::loadJS_Assets('now-ui/assets/js/core/popper.min');
        //Bootstrap JS
        Assets::loadJS_Assets('now-ui/assets/js/core/bootstrap.min');
        Assets::loadJS_Assets('now-ui/assets/js/now-ui-kit');
        //uikit
        Assets::loadJS_Assets('uikit/js/uikit.min');

        //Scroll Revealer
        Assets::loadJS_Assets('scrollreveal/scrollreveal.min');
         
        //Autosize
        Assets::loadJS_Assets('autosize/autosize.min');

        //Data tables
        Assets::loadJS_Assets('datatables/js/jquery.dataTables.min');
        Assets::loadJS_Assets('datatables/js/dataTables.bootstrap4.min');

        Assets::loadJS_Custom('navbar');
        Assets::loadJS_Custom('main');
         

        if ($current_file == 'settings.php')
             Assets::loadJS_Custom('settings');
      ?>

      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.2.2/css/autoFill.dataTables.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.4.1/css/colReorder.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/keytable/2.3.2/css/keyTable.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.4.3/css/scroller.dataTables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.4/css/select.dataTables.min.css"/>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/autofill/2.2.2/js/dataTables.autoFill.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.colVis.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/keytable/2.3.2/js/dataTables.keyTable.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/scroller/1.4.3/js/dataTables.scroller.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
      <script type="text/javascript">
         window.sr = ScrollReveal({ reset: true });
      </script>
   </head>
   <body style="position: absolute; width:100%;">
     <?php
        $user = new User();
      ?>
      <header>

     <!-- TOP NAV -->
     <nav class="top-nav">

       <!-- Primary Nav Container Start -->
       <div class="primary-nav-container" id="gradient">

         <!-- offCanvas Menu Toggle -->
         <div class="toggle--offcanvas">
           <a class="navicon-button">
             <div class="navicon"></div>
           </a>
         </div>
        
         <div class="logo">
           <img src="<?php echo IMGS_PATH . 'Motojoy.png' ?>" alt="motojoy logo"><a href="<?php echo URL_PATH . 'index'; ?>"></a>
         </div>

         <ul class="menu nav--primary">
           <li><a class="has-submenu" href="/home/">Início</a></li>
           <li><a class="has-submenu" href="/shop/">Loja</a></li>
           <li><a class="has-submenu" href="/noticias/">Noticias</a></li>
           <li><a class="has-submenu" href="/dicas/">Dicas</a></li>
           <!--<li><a class="has-submenu" href="/tool-tethering/">Tool Safety</a></li>-->
           <li><a class="has-submenu" href="/extras/">Mais</a></li>
         </ul>

         <ul class="menu tools">
           <?php if ($user->isLoggedIn()) { 
             if($user->hasPermission('admin')) {
               echo '<li><a href="'.URL_PATH.'admin/"><i class="fa fa-wrench"></i> Admin<a/a></li>';
             }
           ?>
           <li><a href="<?php echo URL_PATH . 'panel'; ?>"><i class="fa fa-user-circle"></i> Painel</a></li>
           <?php } else { ?>
           <li><a href="<?php echo (!$user->isLoggedIn()) ? URL_PATH . 'login' : URL_PATH . 'panel'; ?>"><i class="fa fa-sign-in"></i> Entrar</a></li>
           <li><a href="<?php echo (!$user->isLoggedIn()) ? URL_PATH . 'register' : URL_PATH . 'panel'; ?>"><i class="fa fa-user-circle"></i> Registar</a></li>
           <?php } ?>
           <li><a href="<?php echo URL_PATH . 'store/cart'; ?>"><i class="fa fa-shopping-cart"></i> Carrinho <label class="badge badge-secondary cart_quantity">0</label></a></li>
         </ul>

         <!--   Quick Menu Triggers -->
         <div class="menu quick-menu-triggers">
           <a id="trigger--shop-menu" class="trigger">Loja</a>
           <a id="trigger--courses-menu" class="trigger">Utilizador</a>
         </div>

       </div> <!-- Primary Nav Container END -->


       <!-- Nav Secondary Start -->
       <div class="nav--secondary">
          <!-- Secondary Menu 0 -->
          <ul data-menu="home" class="menu menu-0">
            <li><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
            <li><a href="<?php echo URL_PATH . 'intro'; ?>">Introdução</a></li>
          </ul>

         <!-- Secondary Menu 1 -->
         <ul data-menu="noticias" class="menu menu-1">
           <li><a href="<?php echo URL_PATH . 'news'; ?>">Ao minuto</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=lan'; ?>">Lançamentos</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=up'; ?>">Atualizações</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=gp'; ?>">Moto GP</a></li>
         </ul>

         <!-- Secondary Menu 3 -->
         <!--<ul data-menu="tool-tethering" class="menu menu-3">
           <li><a href="#">Overview</a></li>
           <li><a href="#">Products</a></li>
           <li><a href="#">Testing</a></li>
           <li><a href="#">Manufacturing</a></li>
           <li class="has-dropdown">
             <a href="#">Support</a>
             <ul style="">
               <li><a href="#">Tether Guide</a></li>
               <li><a href="#">Tool Safety Roadmap</a></li>
               <li><a href="#">Free Consultation</a></li>
             </ul>
           </li>
        </ul>-->

         <!-- Secondary Menu 4 -->
         <ul data-menu="extras" class="menu menu-4">
           <li><a href="<?php echo URL_PATH; ?>contact">Fale connosco</a></li>
         </ul>

         <!-- Secondary Menu 2 -->
         <ul data-menu="dicas" class="menu menu-2">
           <li><a href="<?php echo URL_PATH . 'tipstricks'; ?>">Todas</a></li>
           <li><a href="<?php echo URL_PATH . 'tipstricks?go=limp'; ?>">Limpeza</a></li>
           <li class="has-dropdown">
             <a href="#">Manutenção&nbsp;</a>
             <ul style="">
               <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=motor'; ?>">Motor</a></li>
               <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=transmissao'; ?>">Transmissão</a></li>
               <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=pneus'; ?>">Pneus</a></li>
               <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu'; ?>">Todas</a></li>
             </ul>
           </li>
           <li><a href="<?php echo URL_PATH . 'tipstricks?go=cond'; ?>">Condução</a></li>
         </ul>

         <!-- Secondary Menu 5 -->
         <ul data-menu="shop" class="menu menu-5">
          <li><a href="<?php echo URL_PATH; ?>store/protections">Proteção</a></li>
          <li><a href="<?php echo URL_PATH; ?>store/performance/">Desempenho</a></li>
          <li><a href="<?php echo URL_PATH; ?>store/accessories/">Acessórios</a></li>
         </ul>

       </div> <!-- Nav Secondary END -->
     </nav> <!-- Main-Nav END -->

   </header>

   <!-- Offcanvas Menu -->
   <div id="menu--offcanvas" class="mobile-menu-container">

     <ul class="menu">
         <li class="title text-center">Menu</li>
         <li>
           <a class="has-dropdown">Home</a>
           <ul class="menu dropdown--primary">
             <li><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
             <li><a href="<?php echo URL_PATH . 'intro'; ?>">Introdução</a></li>
           </ul>
         </li>

       <li>
         <a class="has-dropdown">Notícias</a>
         <ul class="menu dropdown--primary">
           <li><a href="<?php echo URL_PATH . 'news'; ?>">Ao minuto</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=lan'; ?>">Lançamentos</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=up'; ?>">Atualizações</a></li>
           <li><a href="<?php echo URL_PATH . 'news?go=gp'; ?>">Moto GP</a></li>
         </ul>
       </li>

       <!-- Height Rescue Menu -->
       <li>
         <a class="has-dropdown">Dicas e Truques</a>
         <ul class="menu dropdown--primary">
             <li><a href="<?php echo URL_PATH . 'tipstricks'; ?>">Todas</a></li>
             <li><a href="<?php echo URL_PATH . 'tipstricks?go=limp'; ?>">Limpeza</a></li>
             <li>
               <a class="has-dropdown">Manutenção</a>
                <ul class="menu dropdown--secondary">
                    <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=motor'; ?>">Motor</a></li>
                    <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=transmissao'; ?>">Transmissão</a></li>
                    <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu&on=pneus'; ?>">Pneus</a></li>
                    <li><a href="<?php echo URL_PATH . 'tipstricks?go=manu'; ?>">Todas</a></li>
               </ul>
             </li>
             <li><a href="<?php echo URL_PATH . 'tipstricks?go=cond'; ?>">Condução</a></li>
         </ul>
       </li>

       <!-- Tool Tethering Menu -->
       <!--<li>
         <a class="has-dropdown">Mais</a>
         <ul class="menu dropdown--primary">
           <li><a href="<?php //echo URL_PATH . 'downloads'; ?>">Downloads</a></li>
         </ul>
     </li>-->
     </ul>
   </div> <!-- Offcanvas Menu END -->

   <!-- Courses Quick Menu -->
   <div id="menu--courses" class="mobile-menu-container">
     <ul class="menu">
       <li class="title text-center">Navegação rápida</li>
       <?php
        if ($user->isLoggedIn()) {
            if($user->hasPermission('admin')) {
              echo '<li><a href="'.URL_PATH.'admin/" class="text-center"> <i class="fa fa-bar-chart"></i> Administração</a></li>';
            }
            echo '<li><a href="'. URL_PATH . 'panel" class="text-center"><i class="fa fa-address-card"></i> Painel do utilizador</a></li>';
            echo '<li><a href="'. URL_PATH . 'settings" class="text-center"><i class="fa fa-wrench"></i> Definições</a></li>';
            echo '<li><a href="'. URL_PATH . 'logout" class="text-center"><i class="fa fa-sign-out"></i> Sair</a></li>';
        } else {
            echo '<li><a href="'. URL_PATH . 'login" class="text-center"><i class="fa fa-sign-in"></i> Login</a></li>';
            echo '<li><a href="'. URL_PATH . 'register" class="text-center"><i class="fa fa-user-circle"></i> Registar</a></li>';
        }
       ?>
     </ul>
   </div> <!-- Courses Quick Menu END -->

   <!-- Shop Quick Menu -->
   <div id="menu--shop" class="mobile-menu-container">
     <ul class="menu">
          <li class="title text-center">Navegação rápida</li>
          <li><a href="<?php echo URL_PATH; ?>store/cart" class="text-center"><i class="fa fa-shopping-cart"></i> Carrinho <label class="badge badge-secondary cart_quantity">0</label></a></li>
          <li><a href="#"><hr></a></li>
          <li><a href="<?php echo URL_PATH; ?>store/protections" class="text-center">Proteção</a></li>
          <li><a href="<?php echo URL_PATH; ?>store/" class="text-center">Peças</a></li>
          <li><a href="<?php echo URL_PATH; ?>store/accessories/" class="text-center">Acessórios</a></li>
     </ul>
   </div> <!-- Shop Quick Menu END -->

   <div class="overlay"></div>

   <main style="margin-top: 70px;">
      <div class="container-fluid">
          <div class="card" style="width: 100%;">
              <div class="card-body">
                  <div id="custom_message"></div>
