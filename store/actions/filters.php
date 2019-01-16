<?php
    require ('../core/configActions.php');

    if (Input::get('categories')) {
        
        if (Input::get('cat') == 0) {
            $cat_query = Db::getInstance()->query("SELECT * FROM typep");
        } else {
            $cat_id = Input::get('cat');   
            $cat_query = Db::getInstance()->query("SELECT * FROM typep WHERE cat_id = $cat_id"); 
        }
        
        if ($cat_query->count()) {
            $types = $cat_query->results();
            
            foreach ($types as $type) {
                echo '<div class="row"><a class="pl-4 py-1 cat category" href="#" cat_id="'.$type->cat_id.'" type_id="'.$type->type_id.'">'.$type->type_name.'</a></div>';
            }
        }
    }


    if (Input::get('getSelectedCategory')) {
        $cat_id = Input::get('cat_id');
        $type_id = Input::get('type_id');

        $prod_filter = Db::getInstance()->query("SELECT * FROM products WHERE cat_id = $cat_id AND type_id = $type_id");



        if ($prod_filter->count()) {
            $filtered_products = $prod_filter->results();
            echo "<div class='row'>";
            foreach ($filtered_products as $prod) {
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
            echo "</div>";
        } else {
            $cat = Db::getInstance()->get('categories', array('cat_id', '=', $cat_id))->first();
            echo "
            <div class='row'>
                <h2 class='titles mx-auto text-center'>Não há produtos na categoria: <b>".ucfirst($cat->cat_name)."</b></h2>
            </div>
            ";
        }
    }






    if (Input::get('brands')) {
        $cat_id = 0;

        if (Input::get('cat') == 0) {
            $brands_query = Db::getInstance()->query("SELECT * FROM brands");
        } else {
            $cat_id = Input::get('cat');   
            $brands_query = Db::getInstance()->query("SELECT * FROM brands WHERE cat_id = $cat_id");
        }

        
        if ($brands_query->count()) {
            $brands = $brands_query->results();
            
            foreach ($brands as $brand) {
                echo '<div class="row"><a class="pl-4 py-1 brand category" href="#" brand_id="'.$brand->brand_id.'" cat_id="'.$brand->cat_id.'">'.$brand->brand_name.'</a></div>';
            }
        }
    }

    
    if (Input::get('getSelectedBrand')) {
        $brand_id = Input::get('brand_id');
        $cat_id = Input::get('cat_id');

        if ($cat_id) {
            $prod_filter = Db::getInstance()->query("SELECT * FROM products WHERE cat_id = $cat_id AND brand_id = $brand_id");
        } else {
            $prod_filter = Db::getInstance()->query("SELECT * FROM products WHERE brand_id = $brand_id");
        }
        



        if ($prod_filter->count()) {
            $filtered_products = $prod_filter->results();
            echo "<div class='row'>";
            foreach ($filtered_products as $prod) {
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
            $brand = Db::getInstance()->get('brands', array('brand_id', '=', $brand_id))->first();
            echo "
            <div class='row'>
                <h2 class='titles mx-auto text-center'>Não há produtos da marca: <b>".ucfirst($brand->brand_name)."</b></h2>
            </div>
            ";
        }
    }
?>
