<?php
    require ('../core/configActions.php');
    $user = new User();

    if (Input::get('addProduct')) {
        //Verificar se o utilizador tem a sessão iniciada
        if (!$user->isLoggedIn()) {
            echo '  <div class="alert alert-warning" role="alert">
                        <div class="container">
                            <div class="alert-icon">
                                <i class="now-ui-icons ui-2_like"></i>
                            </div>
                            <strong>AVISO!</strong> Inicie sessão para puder adicionar produtos ao carrinho!
                        </div>
                    </div>';
        } else {
            if ($prod_id = Input::get('prod_id')) {
                $user_id = $user->data()->user_id;

                $check_cart = Db::getInstance()->query("SELECT * FROM cart WHERE prod_id = $prod_id AND user_id = $user_id");

                if ($check_cart->count()) {
                    echo '<div class="alert alert-warning" role="alert">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons ui-2_like"></i>
                                </div>
                                <strong>AVISO!</strong> O produto já está no carrinho!
                            </div>
                        </div>';
                } else {
                    //Inserir produto no cart da Db
                    //Verificar se o produto está em promoção
                    $prod = Db::getInstance()->get('products', array('prod_id', '=', $prod_id))->first();
                    
                    if(!empty($prod->prom_id)) {
                        $prom_id = $prod->prom_id;

                        $today = date('y-m-d');
                        $promotion = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_id` = $prom_id AND `prom_start` <= '$today' AND `prom_end` >= '$today'");
                        
                        if ($promotion->count()) {
                            $prom = $promotion->first();
                            $prod_price = $prod->prod_price;
                            $prod_price = round($prod_price - $prod_price * ($prom->prom_discount / 100), 2);
                            
                            $insertToCart = Db::getInstance()->insert('cart', array(
                                "prod_id" => $prod_id,
                                "user_id" => $user_id,
                                "cart_prod_qty" => 1,
                                "cart_prod_total" => $prod_price
                            ));

                            $cart_prods = $user->data()->cart_prods;
                            $inc_cart_prods = $user->update(array(
                                'cart_prods' => $cart_prods+1
                            ) , $user_id);
                            if ($insertToCart) {
                                echo '  <div class="alert alert-success" role="alert">
                                            <div class="container">
                                                <div class="alert-icon">
                                                    <i class="now-ui-icons ui-2_like"></i>
                                                </div>
                                                <strong>SUCESSO!</strong> Produto adicionado ao carrinho!
                                            </div>
                                        </div>';
                            }
                        } else {
                            $prod_price = $prod->prod_price;
                            $insertToCart = Db::getInstance()->insert('cart', array(
                                "prod_id" => $prod_id,
                                "user_id" => $user_id,
                                "cart_prod_qty" => 1,
                                "cart_prod_total" => $prod_price
                            ));

                            $cart_prods = $user->data()->cart_prods;
                            $inc_cart_prods = $user->update(array(
                                'cart_prods' => $cart_prods+1
                            ) , $user_id);
                            if ($insertToCart) {
                                echo '  <div class="alert alert-success" role="alert">
                                            <div class="container">
                                                <div class="alert-icon">
                                                    <i class="now-ui-icons ui-2_like"></i>
                                                </div>
                                                <strong>SUCESSO!</strong> Produto adicionado ao carrinho!
                                            </div>
                                        </div>';
                            }
                        }
                    } else {
                        $prod_price = $prod->prod_price;
                        $insertToCart = Db::getInstance()->insert('cart', array(
                            "prod_id" => $prod_id,
                            "user_id" => $user_id,
                            "cart_prod_qty" => 1,
                            "cart_prod_total" => $prod_price
                        ));

                        $cart_prods = $user->data()->cart_prods;
                        $inc_cart_prods = $user->update(array(
                            'cart_prods' => $cart_prods+1
                        ) , $user_id);
                        if ($insertToCart) {
                            echo '  <div class="alert alert-success" role="alert">
                                        <div class="container">
                                            <div class="alert-icon">
                                                <i class="now-ui-icons ui-2_like"></i>
                                            </div>
                                            <strong>SUCESSO!</strong> Produto adicionado ao carrinho!
                                        </div>
                                    </div>';
                        }
                    }
                }
            } else {
                echo '  <div class="alert alert-danger" role="alert">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons ui-2_like"></i>
                                </div>
                                <strong>AVISO!</strong> Problema ao adicionar o produto!
                            </div>
                        </div>';
            }
        }
    }









    if (Input::get('cart_checkout')) {
        if (!$user->isLoggedIn()) {
            echo '<div class="alert alert-warning" role="alert">
                        <div class="container">
                            <div class="alert-icon">
                                <i class="now-ui-icons ui-2_like"></i>
                            </div>
                            <strong>AVISO!</strong> Inicie sessão para puder ver os produtos no carrinho!
                        </div>
                    </div>
                    <div class="row">
                        <a href="'.URL_PATH.'login" class="uk-button uk-button-default w-50 mx-auto">Login</a>
                    </div>
                    ';
        } else {
            $user_id = $user->data()->user_id;

            //Pegar produtos do Carrinho
            $db_cart_products = Db::getInstance()->get('cart', array('user_id', '=', $user_id));

            if ($db_cart_products->count()) {
                $cart_products = $db_cart_products->results();

                $total_amount = 0;

                echo '
                <table class="table table-responsive w-100 d-block table-sm">
                    <thead class="text-center">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="text-center">Imagem</th>
                            <th scope="col" class="text-center w-50">Nome</th>
                            <th scope="col" class="text-center">Preço</th>
                            <th scope="col" class="text-center">Qt</th>
                            <th scope="col" class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $all_total = 0;
                foreach ($cart_products as $cart_prod) {
                    //Pegar info da row do produto adicionado ao cart
                    $prod_id = $cart_prod->prod_id;
                    $db_cart_product = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));

                    if ($db_cart_product->count()) {
                        $cart_prod_info = $db_cart_product->first();
                        unset($priceDisc);
                        if(!empty($cart_prod_info->prom_id)) {
                            $prom_id = $cart_prod_info->prom_id;
                            $today = date('y-m-d');
                            $promotion = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_id` = $prom_id AND `prom_start` <= '$today' AND `prom_end` >= '$today'");
                            if($promotion->count()) {
                                $prom = $promotion->first();
                                
                                $priceDisc = round($cart_prod_info->prod_price - $cart_prod_info->prod_price * ($prom->prom_discount / 100), 2);
                            }
                        }
                        
                        $prod_price = number_format($cart_prod_info->prod_price, 2);

                        $prod_total = $cart_prod->cart_prod_total;
                        $prod_total = number_format($prod_total, 2);

                        $all_total = $all_total + $prod_total;
                        $all_total = round($all_total, 2);
                        

                        //Definir cookie para guardar o total
                        setcookie("tc", $all_total, strtotime("+1 day"), "/", "", "", TRUE);
                        
                        if(!empty($priceDisc)) {
                            echo '
                            <tr>
                                <th scope="row"><div id="trash_icon"><i remove_id="'.$prod_id.'" class="fa fa-trash fa-lg remove"></i></div></td>
                                <td><a href="'.STORE_PATH.'product?p='.$prod_id.'"><img src="'.PRODUCTS_PATH.$cart_prod_info->prod_image.'" style="max-width: 70px;"></a></td>
                                <td>
                                    <p> <strong>'.$cart_prod_info->prod_name.'</strong></p>
                                    <p>'.$cart_prod_info->prod_desc.'</p>
                                </td>
                                <td><p class="text-center price" pid="'.$prod_id.'" id="price-'.$prod_id.'" prom="'.$priceDisc.'"> '.$prod_price.' </p></td>
                                <td>
                                    <div class="input-group mx-auto" style="width:8em;">
                                        <span class="input-group-btn"><button type="button" class="quantity-left-minus btn btn-danger btn-number" pid="'.$prod_id.'"><i class="fa fa-minus"></i></button></span>

                                        <input type="text" class="form-control w-25 qty text-center" value="'.$cart_prod->cart_prod_qty.'" pid="'.$prod_id.'" id="qty-'.$prod_id.'">

                                        <span class="input-group-btn"><button type="button" class="quantity-right-plus btn btn-success btn-number" pid="'.$prod_id.'"><i class="fa fa-plus"></i></button></span>
                                    </div>
                                </td>
                                <td><p class="text-center total" pid="'.$prod_id.'" id="total-'.$prod_id.'"> '.$prod_total.' </p></td>
                            </tr>
                            ';
                        } else {
                            echo '
                            <tr>
                                <th scope="row"><div id="trash_icon"><i remove_id="'.$prod_id.'" class="fa fa-trash fa-lg remove"></i></div></td>
                                <td><a href="'.STORE_PATH.'product?p='.$prod_id.'"><img src="'.PRODUCTS_PATH.$cart_prod_info->prod_image.'" style="max-width: 70px;"></a></td>
                                <td>
                                    <p> <strong>'.$cart_prod_info->prod_name.'</strong></p>
                                    <p>'.$cart_prod_info->prod_desc.'</p>
                                </td>
                                <td><p class="text-center price" pid="'.$prod_id.'" id="price-'.$prod_id.'"> '.$prod_price.' </p></td>
                                <td>
                                    <div class="input-group mx-auto" style="width:8em;">
                                        <span class="input-group-btn"><button type="button" class="quantity-left-minus btn btn-danger btn-number" pid="'.$prod_id.'"><i class="fa fa-minus"></i></button></span>

                                        <input type="text" class="form-control w-25 qty text-center" value="'.$cart_prod->cart_prod_qty.'" pid="'.$prod_id.'" id="qty-'.$prod_id.'">

                                        <span class="input-group-btn"><button type="button" class="quantity-right-plus btn btn-success btn-number" pid="'.$prod_id.'"><i class="fa fa-plus"></i></button></span>
                                    </div>
                                </td>
                                <td><p class="text-center total" pid="'.$prod_id.'" id="total-'.$prod_id.'"> '.$prod_total.' </p></td>
                            </tr>
                            ';
                        }
                        
                    }
                }
                echo '
                    </tbody>
                </table>
                <hr>
                <div style="float:right;">
                    <h4 id="cart_total" class="text-right"><b>Total</b>: '.$all_total.' €</h4>
                    <a href="'.STORE_PATH.'customer_order.php" class="btn btn-primary w-100">Continuar <i class="fa fa-arrow-right"></i></a>
                </div>';
            } else {
                echo '
                <div class="row">
                    <div class="col-9">
                        <h4 class="mx-auto text-center">Não tem produtos no carrinho ...</h4>
                    </div>
                    <div class="col-3">
                        <img src="'.IMGS_PATH.'cart.png">
                    </div>
                </div>
                ';
            }
        }
    }


    if (Input::get('prod_remove')) {
        $user_id = $user->data()->user_id;
        $prod_id = Input::get('remove_id');

        $delete_prod = Db::getInstance()->query("DELETE FROM `cart` WHERE `user_id` = $user_id AND `prod_id` = $prod_id");
        $cart_prods = $user->data()->cart_prods;
        $inc_cart_prods = $user->update(array(
            'cart_prods' => $cart_prods-1
        ) , $user_id);

        if ($delete_prod) {
            echo '
                <div class="alert alert-success" role="alert">
                    <div class="container">
                        <div class="alert-icon">
                            <i class="now-ui-icons ui-2_like"></i>
                        </div>
                        <strong>SUCESSO!</strong> Produto eliminado!
                    </div>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-success" role="alert">
                    <div class="container">
                        <div class="alert-icon">
                            <i class="now-ui-icons ui-2_like"></i>
                        </div>
                        <strong>AVISO!</strong> Erro ao eliminar o produto!
                    </div>
                </div>
            ';
        }

    }

    if (Input::get('cart_qty')) {
        $prod_id = Input::get('prod_id');
        $user_id = $user->data()->user_id;
        $qty = Input::get('qty');
        $total = Input::get('total');

        $update = Db::getInstance()->query("UPDATE `cart` SET `cart_prod_qty` = $qty, `cart_prod_total` = $total  WHERE `prod_id` = $prod_id AND `user_id` = $user_id");

        if ($update) {
            echo '<span class="badge badge-success">Atualizado!</span>';
        }
    }

?>
