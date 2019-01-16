<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="description" content="MotoJoy">
      <link rel="icon" href="<?php echo IMGS_PATH . 'icon.png' ?>">
      <title>MotoJoy</title>
      <?php
         //Semantic UI
         //Assets::loadCSS_Assets('semantic/semantic.min');

         //Bootstrap CSS
         Assets::loadCSS_Assets('bootstrap4/bootstrap.min');

         //Font-awesome
         Assets::loadCSS_Assets('font-awesome/font-awesome.min');
         //Data tables
         Assets::loadCSS_Assets('datatables/css/dataTables.bootstrap4.min');

         //Bootstrap Select
         Assets::loadCSS_Assets('select/bootstrap-select.min');

         //Datepicker
         Assets::loadCSS_Assets('datepicker3/bootstrap-datetimepicker.min');

         Assets::loadCSS_Custom('admin');

         //Jquery
         Assets::loadJS_Assets('jquery/jquery-3.2.1.min');
         //Popper
         Assets::loadJS_Assets('now-ui/assets/js/core/popper.min');
         //Moment
         Assets::loadJS_Assets('moment/moment');
         //Bootstrap JS
         Assets::loadJS_Assets('bootstrap4/bootstrap.min');
         //Semantic Ui
         //Assets::loadJS_Assets('semantic/semantic.min');
         
         //Autosize
         Assets::loadJS_Assets('autosize/autosize.min');

         //Scroll Revealer
         Assets::loadJS_Assets('scrollreveal/scrollreveal.min');

         //Data tables
         Assets::loadJS_Assets('datatables/js/jquery.dataTables.min');
         Assets::loadJS_Assets('datatables/js/dataTables.bootstrap4.min');

         //Datepicker
         Assets::loadJS_Assets('datepicker3/bootstrap-datetimepicker.min');

         Assets::loadJS_Custom('admin');
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
   <body>

    <?php
        $user = new User();

        if (!$user->hasPermission('admin')) {
            Session::flash('homew', 'Não tem permissões!');
            Redirect::to('../index');
        }
    ?>

    <div class="header">
        <a href="#" id="menu-action">
            <i class="fa fa-bars"></i>
            <span>Close</span>
        </a>
        <div class="logo">
            <a href="<?php echo URL_PATH . 'admin/'; ?>" id="admin_title">Moto<b>Joy</b> - Administração</a>
            <div class="flash_messages"></div>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="<?php echo URL_PATH . 'admin/users'; ?>"><i class="fa fa-user"></i><span>Utilizadores</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/news'; ?>"><i class="fa fa-newspaper-o"></i><span>Noticias</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/tips&tricks.php'; ?>"><i class="fa fa-check-square-o"></i><span>Dicas e Truques</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/orders'; ?>"><i class="fa fa-gift"></i><span>Encomendas</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/promotions'; ?>"><i class="fa fa-percent"></i><span>Promoções</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/products'; ?>"><i class="fa fa-th-large"></i><span>Produtos</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/brands'; ?>"><i class="fa fa-building-o"></i><span>Marcas</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/cats'; ?>"><i class="fa fa-clone"></i><span>Categorias</span></a></li>
            <li><a href="<?php echo URL_PATH . 'admin/types'; ?>"><i class="fa fa-file-text"></i><span>Tipos</span></a></li>
        </ul>
    </div>

<!-- Content -->
<div class="main">
