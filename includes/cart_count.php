<?php
    require '../core/configIn.php';

    $user = new User();

    if (Input::get('cart_count')) {
        if ($user->isLoggedIn()) {
            $user_id = $user->data()->user_id;

            $cart_products = Db::getInstance()->get('cart', array('user_id', '=', $user_id));
            $rowCount = $cart_products->count();

            echo $rowCount;
        } else {
            echo 0;
        }
    }
?>