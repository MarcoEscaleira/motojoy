<?php
   require 'core/config.php';
   require_once (INCLUDES_PATH . 'header.php');

   //echo Session::get(Config::get('session/session_name'));
   //$user = new User();
   # echo $user->data()->user_email;
?>
    <div class="container">
        <?php
            if (Session::exists('homew')) {
                echo '  
                <div class="alert alert-warning w-75 mx-auto flash_warning" role="alert">
                    <div class="container text-center">
                        <div class="alert-icon">
                            <i class="now-ui-icons ui-2_like"></i>
                        </div>
                        <strong>AVISO!</strong> '.Session::flash('homew').'
                    </div>
                </div>';
            }
            if (Session::exists('homes')) {
                echo '
                <div class="alert alert-success w-75 mx-auto flash_success" role="alert">
                    <div class="container text-center">
                        <div class="alert-icon">
                            <i class="now-ui-icons ui-2_like"></i>
                        </div>
                        <strong>SUCESSO!</strong> '.Session::flash('homes').'
                    </div>
                </div>';
            }

        ?>
        <h1 class="text-center display-4 mb-5">MotoJoy</h1>
        <div class="row">
            <div id="index_carousel" class="carousel slide mx-auto" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#index_carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#index_carousel" data-slide-to="1"></li>
                    <li data-target="#index_carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <?php
                        //Inside $imgs array, the first element will be the active image
                        $imgs = ['r1m.png', 'dirt2.png', 'gp-cel.jpg'];
                        $check_active = 0;
                        foreach($imgs as $img) {
                            $check_active++;
                            
                            echo '<div class="carousel-item '. (($check_active == 1) ? 'active' : '') .'">
                                        <div class="uk-cover-container">
                                            <canvas width="840" height="460"></canvas>
                                            <img class="d-block w-100 img-fluid" src="'.IMGS_PATH . $img.'" style="width: 100%; height: 500px;" uk-cover>
                                        </div>  
                                    </div>';
                        }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#index_carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#index_carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Seguinte</span>
                </a>
            </div>
        </div>
        
        <div class="row mt-5">
            <h1 class="display-4 text-center titles">Promoções <i class="fa fa-percent"></i> </h1><hr style="width: 100%; color: #000; height: 1px; margin-top: -15px;">
        </div>
        <div class="row">
        <?php 
            $today = date('y-m-d');
            $promotions = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_start` <= '$today' AND `prom_end` >= '$today'");
            foreach ($promotions->results() as $prom) {
                $prod_id = $prom->prod_id;
                $prod = Db::getInstance()->get('products', array('prod_id', '=', $prod_id))->first();
                
                $priceDisc = round($prod->prod_price - $prod->prod_price * ($prom->prom_discount / 100), 2);
                echo '
                <figure class="snip1418 text-center mx-auto"><img src="'. PRODUCTS_PATH . $prod->prod_image .'" class="img-responsive">
                  <div class="add-to-cart" id="product" pid="'.$prod_id.'"> <i class="fa fa-cart-plus"></i><span>Ver mais</span></div>
                  <figcaption>
                    <h3>'.$prod->prod_name.' <span class="text-danger">-'.$prom->prom_discount.'%</span></h3>
                    <p>'.$prod->prod_desc.'</p>
                    <div class="price">
                      <s class="text-danger">'.$prod->prod_price.'€</s>'.$priceDisc.'€
                    </div>
                  </figcaption><a href="'.STORE_PATH.'product?p='.$prod_id.'" class="mx-auto"></a>
                </figure>
                ';
            }
        ?>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.flash_warning').delay(2500).slideUp('slow');
            $('.flash_success').delay(2500).slideUp('slow');
        });
    </script>
<?php
   require_once INCLUDES_PATH . 'footer.php';
?>
