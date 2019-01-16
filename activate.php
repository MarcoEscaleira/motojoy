<?php
   require 'core/config.php';
   require_once (INCLUDES_PATH . 'header.php');

   if (Input::exists('get')) {
      $get_user_id = Input::get('u');
      $get_confirm = Input::get('c');

      $user = new User($get_user_id);

      if ($user->data()->user_confirmed == 0) {
          try {
             if ($user->data()->user_confirm == $get_confirm) {
                $user->update(array(
                    'user_confirmed' => 1
                ), $get_user_id);
             }

             Session::flash('homes', 'Conta ativada');
             Redirect::to('index');
          } catch (Exception $e) {
             die($e->getMessage());
          }
      } else {
          Session::flash('homew', 'A sua conta já não precisa de ser ativada');
          Redirect::to('index');
      }

   }
?>
