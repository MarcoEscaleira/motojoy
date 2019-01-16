<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';



    if (Input::exists('get')) {
        if ($go = Input::get('go')) {
            $news = Db::getInstance()->get('newspapper', array('news_cat', '=', $go));

            if ($news->count()) {
                switch ($go) {
                    case 'lan':
                        $cat = 'Lançamentos';
                        break;

                    case 'up':
                        $cat = 'Atualizações';
                        break;

                    case 'gp':
                        $cat = 'Moto GP';
                        break;
                }
                ?>
                <div class="container">
                    <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                                <ol class="breadcrumb backbread">
                                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'news'; ?>">Notícias</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($cat); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row mb-4">
                            <h2 class="titles mx-auto text-center"><?php echo $cat; ?></h2>
                            <hr>
                        </div>
                        <div class="row">
                <?php
                foreach ($news->results() as $news) {
                    
                    echo '
                    <div class="example-2 card-news mx-auto">
                       <div class="wrapper" style="background: url('.NEWS_PATH.$news->news_image.') center/cover no-repeat;">
                           <div class="header">
                               <div class="date">
                                   <span class="day">'.date('d',strtotime($news->news_date)).'</span>
                                   <span class="month">'.date('M',strtotime($news->news_date)).'</span>
                                   <span class="year">'.date('Y',strtotime($news->news_date)).'</span>
                               </div>
                               <ul class="menu-content">
                                   <!--<li><a href="#" class="fa fa-bookmark-o"></a></li>
                                   <li><a href="#" class="fa fa-heart-o"><span>18</span></a></li>-->
                                   <li><a href="#" class="fa fa-eye"><span>'.$news->news_views.'</span></a></li>
                               </ul>
                           </div>
                           <div class="data">
                               <div class="content">
                                   <span class="author">'.$news->news_author.'</span>
                                   <h1 class="title"><a href="#">'.$news->news_title.'</a></h1>
                                   <p class="text">'.$news->news_subtitle.'</p>
                                   <a href="new?n='.$news->news_id.'" class="button">Ler mais</a>
                               </div>
                           </div>
                       </div>
                   </div>
                    ';
                }
                ?>
                        </div><!-- row -->
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <h5 class="titles pt-5 text-center mx-auto">Categorias</h5>
                            <a href="news?go=lan" class="btn btn-primary btn-block mx-auto">Lançamentos</a>
                            <a href="news?go=up" class="btn btn-primary btn-block mx-auto">Atualizações</a>
                            <a href="news?go=gp" class="btn btn-primary btn-block mx-auto">Moto GP</a>
                        </div>
                    </div>
                    </div>
                </div>
                <?php
            } else {
                //Caso nao haja notícias do tipo selecionado
                switch ($go) {
                    case 'lan':
                        $cat = 'Lançamentos';
                        break;

                    case 'up':
                        $cat = 'Atualizações';
                        break;

                    case 'gp':
                        $cat = 'Moto GP';
                        break;
                }
                Session::flash('homew', 'Não existe notícias na categoria <b>'.$cat.'</b>');
                Redirect::to('index');
            }
        }
    } else {
        $all_news = Db::getInstance()->query("SELECT * FROM newspapper");

        if ($all_news->count()) {
?>

       <div class="container">
          <div class="row">
             <div class="col-10 mx-auto">
                 <div class="row">
                    <nav aria-label="breadcrumb" role="navigation" class=mx-auto>
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notícias</li>
                        </ol>
                    </nav>
                 </div>
                <?php
                    foreach ($all_news->results() as $all_news) {
                        echo '
                        <div class="example-2 card-news">
                           <div class="wrapper" style="background: url('.NEWS_PATH.$all_news->news_image.') center/cover no-repeat;">
                               <div class="header">
                                   <div class="date">
                                       <span class="day">'.date('d',strtotime($all_news->news_date)).'</span>
                                       <span class="month">'.date('M',strtotime($all_news->news_date)).'</span>
                                       <span class="year">'.date('Y',strtotime($all_news->news_date)).'</span>
                                   </div>
                                   <ul class="menu-content">
                                       <!--<li><a href="#" class="fa fa-bookmark-o"></a></li>
                                       <li><a href="#" class="fa fa-heart-o"><span>18</span></a></li>-->
                                       <li><a href="#" class="fa fa-eye"><span>'.$all_news->news_views.'</span></a></li>
                                   </ul>
                               </div>
                               <div class="data">
                                   <div class="content">
                                       <span class="author">'.$all_news->news_author.'</span>
                                       <h1 class="title"><a href="new?n='.$all_news->news_id.'">'.$all_news->news_title.'</a></h1>
                                       <p class="text">'.$all_news->news_subtitle.'</p>
                                       <a href="new?n='.$all_news->news_id.'" class="button">Ler mais</a>
                                   </div>
                               </div>
                           </div>
                       </div>
                        ';
                    }
                ?>

             </div>
             <div class="col-2">
                <div class="row">
                    <h5 class="titles pt-5 text-center mx-auto">Categorias</h5>
                    <a href="news?go=lan" class="btn btn-primary btn-block mx-auto">Lançamentos</a>
                    <a href="news?go=up" class="btn btn-primary btn-block mx-auto">Atualizações</a>
                    <a href="news?go=gp" class="btn btn-primary btn-block mx-auto">Moto GP</a>
                </div>
             </div>
          </div>
       </div>
       <script type="text/javascript">
           sr.reveal('.breadcrumb', {
           duration: 1000,
           origin:'bottom',
           distance: '20px'
           });
       </script>
<?php
        }
    }
    require_once INCLUDES_PATH . 'footer.php';
?>
