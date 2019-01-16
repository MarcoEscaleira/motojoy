<?php
   require 'core/config.php';

   $user = new User();

   $user->logout();

   Session::flash('homes', 'A sua sessão foi terminada');
   Redirect::to('index');
?>
