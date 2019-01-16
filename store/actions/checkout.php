<?php
    require ('../core/configActions.php');

    $user = new User();
    /*
    <div class="row">
        <div class="col-6">
        <img  src="<?php echo PRODUCTS_PATH.'knfilter.jpg' ?>" class="img-thumbnail img-fluid float-right">
        </div>
        <div class="col-6">
        <table class="table table-sm">
            <tr><td>Product Name</td><td><b>Filtro K&N</b></td></tr>
            <tr><td>Product Price</td><td><b>45 €</b></td></tr>
            <tr><td>Quantity</td><td><b>2</b></td></tr>
            <tr><td>Payment</td><td><b>Completed</b></td></tr>
            <tr><td>Transaction ID</td><td><b>SDOJDFNASIODFN23421JIOSDF</b></td></tr>
        </table>
        </div>
    </div>
    */
    if (Input::get('order_checkout')) {
        $user_id = $user->data()->user_id;

        $user_cart_prods = Db::getInstance()->get('cart', array('user_id', '=', $user_id));

        if ($user_cart_prods->count()) {
            $cart_prods = $user_cart_prods->results();

            $total_amount = 0;
            $all_total = 0;

            foreach ($cart_prods as $cart_prod) {
                $prod_id = $cart_prod->prod_id;
                $product = Db::getInstance()->get('products', array('prod_id', '=', $prod_id));

                if ($product->count()) {
                    $p = $product->first();

                    if(!empty($p->prom_id)) {
                        $prom_id = $p->prom_id;
                        
                        $today = date('y-m-d');
                        $promotion = Db::getInstance()->query("SELECT * FROM `promotions` WHERE `prom_id` = $prom_id AND `prom_start` <= '$today' AND `prom_end` >= '$today'");

                        if($promotion->count()) {
                            $prod_price = round($p->prod_price - $p->prod_price * ($promotion->first()->prom_discount / 100), 2);
                        } else {
                            $prod_price = number_format($p->prod_price, 2);
                        }
                    } else {
                        $prod_price = number_format($p->prod_price, 2);
                    }

                    $prod_total = $cart_prod->cart_prod_total;
                    $prod_total = number_format($prod_total, 2);

                    $all_total = $all_total + $prod_total;
                    $all_total = number_format($all_total, 2);

                    echo '
                    <div class="row">
                        <div class="col-6">
                        <img  src="'.PRODUCTS_PATH. $p->prod_image . '" class="img-thumbnail img-fluid w-75 float-right">
                        </div>
                        <div class="col-6">
                        <table class="table table-sm">
                            <tr><td>Produto</td><td><b>'.$p->prod_name.'</b></td></tr>
                            <tr><td>Preço</td><td><b>'.$prod_price.' €</b></td></tr>
                            <tr><td>Quantidade</td><td><b>'.$cart_prod->cart_prod_qty.'</b></td></tr>
                            <tr><td>Sub-total</td><td><b>'.round($cart_prod->cart_prod_qty * $prod_price, 2).' €</b></td></tr>
                            <tr><td>Estado</td><td><b>Pendente</b></td></tr>
                        </table>
                        </div>
                    </div>
                    ';
                }
            }
        }
    }



    if (Input::get('paypal_checkout')) {
        $valid['success'] = array('success' => false, 'messages' => array());

        $user_id = $user->data()->user_id;
        $user_cart_prods = Db::getInstance()->get('cart', array('user_id', '=', $user_id));

        if ($user_cart_prods->count()) {
            $cart_prods = $user_cart_prods->results();

            foreach ($cart_prods as $cart_prod) {
                //Send cart to customer order table
                $insert = Db::getInstance()->insert('customer_order', array(
                    "user_id" => $user_id,
                    "prod_id" => $cart_prod->prod_id,
                    "order_qty" => $cart_prod->cart_prod_qty,
                    "order_amount" => $cart_prod->cart_prod_total,
                    "order_status" => 'Pendente'
                ));
            } //foreach
        } //count
    }
    