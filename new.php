<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';

    if (Input::exists('get')) {
        if ($topn_id = Input::get('n')) {
            $new = Db::getInstance()->get('newspapper', array('news_id', '=', $topn_id));

            if ($new->count()) {
                $n = $new->first();
            }

            $view_inc = $n->news_views += 1;
            $view_insert = Db::getInstance()->update('newspapper', $n->news_id, 'news_id', array(
                'news_views' => $view_inc
            ));
        } else {
            Redirect::to(404);
        }
    } else {
        Redirect::to(404);
    }
?>

<div class="container">
    <div class="row pt-2">
        <ol class="breadcrumb mx-auto">
          <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
          <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'news'; ?>">Notícias</a></li>
          <li class="breadcrumb-item active"><?php echo ucfirst($n->news_title); ?></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="mx-auto mt-3" style="margin-bottom: 8em;">
                <img src="<?php echo NEWS_PATH.$n->news_image ?>" class="img-fluid img_fix" alt="new_image">
            </div>
            <h2 class="text-center mt-5" style="Font-family: 'Lato';"><b>TOP</b> Notícias</h2>
            <?php
                $topn = Db::getInstance()->query("SELECT * FROM newspapper ORDER BY news_views DESC LIMIT 4");
                if ($topn->count()) {
                    $top_news = $topn->results();
                } else {
                    echo "Nenhuma notícia encontrada";
                }


                foreach ($top_news as $topn) {
                    echo '
                    <div class="example-2 card-news">
                       <div class="wrapper" style="background: url('.NEWS_PATH.$topn->news_image.') center/cover no-repeat;">
                           <div class="header">
                               <div class="date">
                                   <span class="day">'.date('d',strtotime($topn->news_date)).'</span>
                                   <span class="month">'.date('M',strtotime($topn->news_date)).'</span>
                                   <span class="year">'.date('Y',strtotime($topn->news_date)).'</span>
                               </div>
                               <ul class="menu-content">
                                   <!--<li><a href="#" class="fa fa-bookmark-o"></a></li>
                                   <li><a href="#" class="fa fa-heart-o"><span>18</span></a></li>-->
                                   <li><a href="#" class="fa fa-eye"><span>'.$topn->news_views.'</span></a></li>
                               </ul>
                           </div>
                           <div class="data">
                               <div class="content">
                                   <span class="author">'.$topn->news_author.'</span>
                                   <h1 class="title"><a href="#">'.$topn->news_title.'</a></h1>
                                   <p class="text">'.$topn->news_subtitle.'</p>
                                   <a href="new?n='.$topn->news_id.'" class="button">Ler mais</a>
                               </div>
                           </div>
                       </div>
                   </div>
                    ';
                }
            ?>
        </div>
        <div class="col-6">
            <blockquote class="blockquote text-left mx-auto">
                <h1 class="mb-0 display-4"><?php echo $n->news_title ?></h1>
                <footer class="blockquote-footer pt-2"><?php echo $n->news_author ?></footer>
            </blockquote>
            <p style="text-align: justify;"><?php echo $n->news_description ?></p>
        </div>
    </div>
</div>


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
    sr.reveal('.breadcrumb', {
    duration: 1000,
    origin:'bottom',
    distance: '20px'
    });
    sr.reveal('.example-2', {
        duration: 300,
        origin: 'left',
        distance: '40px',
        reset: false
    }, 300)
</script>

<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
