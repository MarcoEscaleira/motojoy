<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';

    if (Input::exists('get')) {
        if ($tt_id = Input::get('n')) {
            $tip = Db::getInstance()->get('tips_tricks', array('tt_id', '=', $tt_id));

            if ($tip->count()) {
                $n = $tip->first();
            }

            $view_inc = $n->tt_views += 1;
            $view_insert = Db::getInstance()->update('tips_tricks', $n->tt_id, 'tt_id', array(
                'tt_views' => $view_inc
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
              <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'tipstricks'; ?>">Dicas e Truques</a></li>
              <li class="breadcrumb-item active"><?php echo $n->tt_title; ?></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="mx-auto mt-3">
                    <img src="<?php echo TIPS_PATH.$n->tt_image ?>" class="img-fluid img_fix" alt="tip_image">
                </div>
            </div>
            <div class="col-6">
                <div class="limit_video">
                    <div class="mx-auto mt-3">
                        <?php echo $n->tt_video; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-4">
                <blockquote class="blockquote text-left mx-auto">
                    <h1 class="mb-0 display-4" style="Font-family: 'Lato';"><?php echo $n->tt_title ?></h1>
                    <footer class="blockquote-footer"><?php echo $n->tt_author ?></footer>
                </blockquote>
            </div>
            <div class="col-12">
                <p style="text-align: justify;"><?php echo $n->tt_description ?></p>
            </div>
        </div>
        <h2 class="text-center mt-5" style="Font-family: 'Lato';"><b>TOP</b> Dicas</h2>
        <div class="row mb-5">
                <?php
                    $dicas = Db::getInstance()->query("SELECT * FROM tips_tricks ORDER BY tt_views DESC LIMIT 3");
                    if ($dicas->count()) {
                        $top_dicas = $dicas->results();
                    } else {
                        echo "Nenhuma dica encontrada";
                    }


                    foreach ($top_dicas as $topd) {
                        echo '
                        <figure class="snip1493 mx-auto">
                            <div class="image"><img src="'.TIPS_PATH.$topd->tt_image.'"></div>
                                <figcaption>
                                    <div class="date"><span class="day">'.date('d',strtotime($topd->tt_date)).'</span><span class="month">'.date('M',strtotime($topd->tt_date)).'</span></div>
                                    <h3>'.$topd->tt_title.'</h3>
                                    <p>'.$topd->tt_subtitle.'</p>
                                    <footer>
                                        <div class="views"><i class="fa fa-eye"></i>'.$topd->tt_views.'</div>
                                        <!--<div class="love"><i class="ion-heart"></i>623</div>
                                        <div class="comments"><i class="ion-chatboxes"></i>23</div>-->
                                    </footer>
                                </figcaption>
                            <a href="tiptrick?n='.$topd->tt_id.'"></a>
                        </figure>
                        ';
                    }
                ?>
        </div>
    </div>


    <div id="disqus_thread" class="mt-5"></div>
    <script>
        (function() {
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
        sr.reveal('.snip1493', {
            duration: 600,
            origin: 'right',
            distance: '40px',
            reset: false
        }, 500)
    </script>

<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
