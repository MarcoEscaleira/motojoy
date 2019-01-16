<?php
    require 'core/config.php';
    require_once '../includes/header.php';

    if (Input::exists('get')) {
        if (Input::get('p')) {
            $prod_id = Input::get('p');
            
            $prod_get = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));

            if ($prod_get->count()) {
                $data = $prod_get->first();
                $cat = Db::getInstance()->query("
                    SELECT cat_name
                    FROM categories c JOIN products p
                    ON c.cat_id = p.cat_id
                    WHERE p.prod_id = $prod_id
                ")->first()->cat_name;

                $brand = Db::getInstance()->query("
                    SELECT brand_name
                    FROM brands b JOIN products p
                    ON b.brand_id = p.brand_id
                    WHERE p.prod_id = $prod_id
                ")->first()->brand_name;
                
                $prod_type = ucfirst(Db::getInstance()->query("SELECT type_name FROM typep WHERE `type_id` = $data->type_id")->first()->type_name);

                switch ($cat) {
                    case 'Acessorios':
                        $location = 'accessories';
                        break;
                    
                    case 'Protecoes':
                        $location = 'protections';
                        break;
                    
                    default:
                        $location = 'index';
                        break;
                }
                
                if ($data->prod_stock == 0) {
                    $stock = '<span class="badge badge-danger">Esgotado</span>';
                } else if ($data->prod_stock == 1) {
                    $stock = '<span class="badge badge-warning">Limitado</span>';
                } else if ($data->prod_stock >= 5) {
                    $stock = '<span class="badge badge-success">Em Stock</span>';
                } else if ($data->prod_stock < 5) {
                    $stock = '<span class="badge badge-info">Pouco Stock</span>';
                }

                //Prod page - header
                echo '
                    <div class="container">
                        <div class="row">
                            <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                                <ol class="breadcrumb backbread">
                                    <li class="breadcrumb-item"><a href="'. URL_PATH . 'index">Início</a></li>
                                    <li class="breadcrumb-item"><a href="'. STORE_PATH . 'index">Loja</a></li>
                                    <li class="breadcrumb-item"><a href="'. STORE_PATH . $location.'">'.$cat.'</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">'.strtoupper($data->prod_name).' ( '.$prod_type.' )</li>
                                </ol>
                            </nav>
                        </div>
                        
                        <div id="cartResponse"></div>

                        <div class="row">';

                        if(!empty($data->prom_id)) {
                            $prom_id = $data->prom_id;
                            $today = date('y-m-d');
                            $promotion = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_id` = $prom_id AND `prom_start` <= '$today' AND `prom_end` >= '$today'");
                            if($promotion->count()) {
                                $prom = $promotion->first();

                                $priceDisc = round($data->prod_price - $data->prod_price * ($prom->prom_discount / 100), 2);
                                echo '<div class="wrapperp">
                                    <div class="col-1-2">
                                        <div class="product-wrap">
                                            <div class="product-shot">
                                                <img src="'.PRODUCTS_PATH . $data->prod_image.'">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-1-2">
                                        <div class="product-info">
                                            <h2>'.$data->prod_name.' <small class="text-muted">'.$brand.'</small></h2>
                                            <div class="desc">
                                                '.$data->prod_desc.'
                                            </div>
                                            <div class="row">
                                                <h5 class="mx-auto mt-5">'.$data->prod_price.' € | <span class="text-danger">-'.$prom->prom_discount.'%</span> | <span class="text-success">'.$priceDisc.'</span> € <small class="text-muted" id="stock">'.$stock.'</small></h5>
                                            </div>
                                            
                                            <div class="row">
                                                <a href="" class="button mx-auto" id="product" pid="'.$prod_id.'"><i class="fa fa-cart-plus fa-lg"></i> Comprar</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>';
                            } else {
                               echo '<div class="wrapperp">
                                    <div class="col-1-2">
                                        <div class="product-wrap">
                                            <div class="product-shot">
                                                <img src="'.PRODUCTS_PATH . $data->prod_image.'">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-1-2">
                                        <div class="product-info">
                                            <h2>'.$data->prod_name.' <small class="text-muted">'.$brand.'</small></h2>
                                            <div class="desc">
                                                '.$data->prod_desc.'
                                            </div>
                                            <div class="row">
                                                <h5 class="mx-auto mt-5">'.$data->prod_price.' € <small class="text-muted" id="stock">'.$stock.'</small></h5>
                                            </div>
                                            
                                            <div class="row">
                                                <a href="" class="button mx-auto" id="product" pid="'.$prod_id.'"><i class="fa fa-cart-plus fa-lg"></i> Comprar</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>'; 
                            }
                        } else {
                            echo '<div class="wrapperp">
                                <div class="col-1-2">
                                    <div class="product-wrap">
                                        <div class="product-shot">
                                            <img src="'.PRODUCTS_PATH . $data->prod_image.'">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-1-2">
                                    <div class="product-info">
                                        <h2>'.$data->prod_name.' <small class="text-muted">'.$brand.'</small></h2>
                                        <div class="desc">
                                            '.$data->prod_desc.'
                                        </div>
                                        <div class="row">
                                            <h5 class="mx-auto mt-5">'.$data->prod_price.' € <small class="text-muted" id="stock">'.$stock.'</small></h5>
                                        </div>
                                        
                                        <div class="row">
                                            <a href="" class="button mx-auto" id="product" pid="'.$prod_id.'"><i class="fa fa-cart-plus fa-lg"></i> Comprar</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>';
                        }
                        
                    echo'</div>
                    </div>';

                $view_inc = $data->prod_views += 1;
                $view_insert = Db::getInstance()->update('products', $prod_id, 'prod_id', array(
                    'prod_views' => $view_inc
                ));
            } else {
                Redirect::to(404);
            }
        } else {
            Redirect::to(404);
        }
    }
?>
    <div id="disqus_thread" class="mt-5"></div>
    <script>
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://motojoy.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Por favor ative o JavaScript para visualizar <a href="https://disqus.com/?ref_noscript">comentários do Disqus.</a></noscript>

    <script type="text/javascript">
        //Adicionar produto ao carrinho
        $('body').delegate('#product', 'click', function(event) {
            event.preventDefault();

            var prod_id = $(this).attr('pid');

            $.ajax({
                url: 'actions/cart.php',
                method: 'POST',
                data: {addProduct: 1, prod_id: prod_id},
                success: function(data) {
                    $('#cartResponse').html(data).fadeIn('fast');
                    $('#cartResponse').delay(1300).fadeOut('slow');

                    setTimeout(function(){
                        location.reload();
                    },1500);
                }
            });
        });

        var stock = $('#stock').text();
        
        if (stock == 'Esgotado') {
            $('#product').hide();
        } else {
            $('#product').show();
        }
    </script>
<?php
    require_once '../includes/footer.php';
?>
