<?php
    require ('../core/configActions.php');

    if (Input::get('search')) {
        $keyword = Input::get('keyword');

        if (Input::get('cat') == 0) {
            $prods_keyword = Db::getInstance()->query("SELECT * FROM products WHERE prod_keywords LIKE '%$keyword%'");
        } else {
            $cat_id = Input::get('cat');
            $prods_keyword = Db::getInstance()->query("SELECT * FROM products WHERE cat_id = $cat_id AND prod_keywords LIKE '%$keyword%'");
        }

        if ($prods_keyword->count()) {
            $keyword_products = $prods_keyword->results();
            echo '<div class="row">';
            foreach ($keyword_products as $prod) {
                $prod_id = $prod->prod_id;

                if(!empty($prod->prom_id)) {
                    $prom_id = $prod->prom_id;
                    $today = date('y-m-d');
                    $promotion = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_id` = $prom_id AND `prom_start` <= '$today' AND `prom_end` >= '$today'");
                    if($promotion->count()) {
                        $prom = $promotion->first();

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
                    } else {
                        echo '
                        <figure class="snip1418 text-center mx-auto"><img src="'. PRODUCTS_PATH . $prod->prod_image .'" class="img-responsive">
                        <div class="add-to-cart" id="product" pid="'.$prod_id.'"> <i class="fa fa-cart-plus"></i><span>Ver mais</span></div>
                        <figcaption>
                            <h3>'.$prod->prod_name.'</h3>
                            <p>'.$prod->prod_desc.'</p>
                            <div class="price">
                            '.$prod->prod_price.'€
                            </div>
                        </figcaption><a href="'.STORE_PATH.'product?p='.$prod_id.'" class="mx-auto"></a>
                        </figure>
                        ';
                    }
                } else {
                    echo '
                    <figure class="snip1418 text-center mx-auto"><img src="'. PRODUCTS_PATH . $prod->prod_image .'" class="img-responsive">
                    <div class="add-to-cart" id="product" pid="'.$prod_id.'"> <i class="fa fa-cart-plus"></i><span>Ver mais</span></div>
                    <figcaption>
                        <h3>'.$prod->prod_name.'</h3>
                        <p>'.$prod->prod_desc.'</p>
                        <div class="price">
                        '.$prod->prod_price.'€
                        </div>
                    </figcaption><a href="'.STORE_PATH.'product?p='.$prod_id.'" class="mx-auto"></a>
                    </figure>
                    ';
                }
            }
            echo '</div>';
        } else {
            echo "
            <div class='row'>
                <h2 class='titles mx-auto text-center'>Não há produtos com o nome: <b>".$keyword."</b></h2>
            </div>
            ";
        }
    }
?>
