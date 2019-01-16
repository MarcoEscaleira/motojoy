<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';

    if (Input::exists('get')) {
        if ((($cat = Input::get('go')) == 'manu') && ($subcat = Input::get('on'))) {
            //Dicas apenas de //Determinada Categoria //Determinada sub-categoria
            $cat_tips = Db::getInstance()->get('tips_tricks', array('tt_cat', '=', $cat));
            ?>
            <div class="container">
               <div class="row">
                  <div class="col-11 mx-auto">
                      <div class="row">
                        <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                            <ol class="breadcrumb backbread">
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'tipstricks'; ?>">Dicas e Truques</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'tipstricks?go=manu'; ?>">Manutenção</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($subcat); ?></li>
                            </ol>
                        </nav>
                      </div>
                    <?php
                        if ($cat_tips->count()) {
                            $subcat_tips = Db::getInstance()->query("SELECT * FROM tips_tricks WHERE tt_subcat = '$subcat' ORDER BY tt_date DESC");

                            if ($subcat_tips->count()) {
                                echo "<div class='row'>";
                                foreach ($subcat_tips->results() as $subcat_tips) {
                                    echo '
                                    <figure class="snip1493 mx-auto">
                                        <div class="image"><img src="'.TIPS_PATH.$subcat_tips->tt_image.'" /></div>
                                            <figcaption>
                                                <div class="date"><span class="day">'.date('d',strtotime($subcat_tips->tt_date)).'</span><span class="month">'.date('M',strtotime($subcat_tips->tt_date)).'</span></div>
                                                <h3>'.$subcat_tips->tt_title.'</h3>
                                                <p>'.$subcat_tips->tt_subtitle.'</p>
                                                <footer>
                                                    <div class="views"><i class="fa fa-eye"></i>'.$subcat_tips->tt_views.'</div>
                                                    <!--<div class="love"><i class="ion-heart"></i>623</div>
                                                    <div class="comments"><i class="ion-chatboxes"></i>23</div>-->
                                                </footer>
                                            </figcaption>
                                        <a href="tiptrick?n='.$subcat_tips->tt_id.'"></a>
                                    </figure>
                                    ';
                                }
                                echo "</div>";
                            } else {
                                echo "
                                <div class='row'>
                                    <h2 class='mx-auto text-center'>Não há produtos</h2>
                                </div>
                                ";
                            }
                        }
                    ?>
                  </div>
               </div>
            </div>
            <?php

        } else if ($cat = Input::get('go')) {
            //Todas as dicas //Determinada Categoria
            $cat_tips = Db::getInstance()->query("SELECT * FROM tips_tricks WHERE tt_cat = '$cat' ORDER BY tt_date DESC");
            ?>
            <div class="container">
                <div class="row">
                  <div class="col-11 mx-auto">
                      <div class="row">
                        <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                            <ol class="breadcrumb backbread">
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'tipstricks'; ?>">Dicas e Truques</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo ($cat == 'limp') ? 'Limpeza' : ''; echo ($cat == 'manu') ? 'Manutenção' : ''; echo ($cat == 'cond') ? 'Condução' : ''; ?></li>
                            </ol>
                        </nav>
                      </div>
                    <?php
                        if ($cat_tips->count()) {
                            echo "<div class='row'>";
                            foreach ($cat_tips->results() as $cat_tips) {
                                echo '
                                <figure class="snip1493 mx-auto">
                                    <div class="image"><img src="'.TIPS_PATH.$cat_tips->tt_image.'"></div>
                                        <figcaption>
                                            <div class="date"><span class="day">'.date('d',strtotime($cat_tips->tt_date)).'</span><span class="month">'.date('M',strtotime($cat_tips->tt_date)).'</span></div>
                                            <h3>'.$cat_tips->tt_title.'</h3>
                                            <p>'.$cat_tips->tt_subtitle.'</p>
                                            <footer>
                                                <div class="views"><i class="fa fa-eye"></i>'.$cat_tips->tt_views.'</div>
                                                <!--<div class="love"><i class="ion-heart"></i>623</div>
                                                <div class="comments"><i class="ion-chatboxes"></i>23</div>-->
                                            </footer>
                                        </figcaption>
                                    <a href="tiptrick?n='.$cat_tips->tt_id.'"></a>
                                </figure>
                                ';
                            }
                            echo "</div>";
                        } else {
                            switch ($cat) {
                                case 'limp':
                                    $cat = 'Limpeza';
                                    break;

                                case 'manu':
                                    $cat = 'Manutenção';
                                    break;

                                case 'cond':
                                    $cat = 'Condução';
                                    break;
                            }
                            Session::flash('homew', 'Não foi possível mostrar as Dicas e Truques na categoria de '.$cat);
                            Redirect::to('index.php');
                        }
                    ?>
                  </div>
               </div>
            </div>
            <?php
        }
    } else {
        $all_tips = Db::getInstance()->query("SELECT * FROM tips_tricks ORDER BY tt_date DESC");
        ?>
        <div class="container">
            <div class="row">
                  <div class="col-11 mx-auto">
                        <div class="row">
                            <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                                <ol class="breadcrumb backbread">
                                    <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dicas e Truques</li>
                                </ol>
                            </nav>
                        </div>
                <?php
                    if ($all_tips->count()) {
                        echo "<div class='row'>";
                        foreach ($all_tips->results() as $all_tips) {
                            echo '
                            <figure class="snip1493 mx-auto">
                                <div class="image"><img src="'.TIPS_PATH.$all_tips->tt_image.'" /></div>
                                    <figcaption>
                                        <div class="date"><span class="day">'.date('d',strtotime($all_tips->tt_date)).'</span><span class="month">'.date('M',strtotime($all_tips->tt_date)).'</span></div>
                                        <h3>'.$all_tips->tt_title.'</h3>
                                        <p>'.$all_tips->tt_subtitle.'</p>
                                        <footer>
                                            <div class="views"><i class="fa fa-eye"></i>'.$all_tips->tt_views.'</div>
                                            <!--<div class="love"><i class="ion-heart"></i>623</div>
                                            <div class="comments"><i class="ion-chatboxes"></i>23</div>-->
                                        </footer>
                                    </figcaption>
                                <a href="tiptrick?n='.$all_tips->tt_id.'"></a>
                            </figure>
                            ';
                        }
                        echo "</div>";
                    } else {
                        Session::flash('homew', 'Não foi possível mostrar as Dicas e Truques');
                        Redirect::to('index.php');
                    }
                ?>
              </div>
           </div>
        </div>
        <?php
    }
?>
    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
        duration: 1000,
        origin:'bottom',
        distance: '20px'
        });
    </script>
<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
