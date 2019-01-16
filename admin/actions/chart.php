<?php
  require ('../core/configMain.php');

  header('Content-Type: application/json');

  //if (Input::get('news')) {
    $news = Db::getInstance()->query("SELECT prod_name, prod_views FROM products ORDER BY prod_views DESC LIMIT 0,5");

    $data = array();
    if($news->count()) {
      
      foreach ($news->results() as $row) {
        $data[] = $row;
      }
      
      print json_encode($data);
    }
  //}
?>