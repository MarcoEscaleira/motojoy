<?php
    require 'core/config.php';
    require_once '../includes/header.php';
?>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include_once SYSTEM_PATH . 'includes/filters.php'; ?>
            </div><!-- filtros -->

            <div class="col-md-9">
                <div class="row">
                    <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Loja</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div id="products" class="w-100"></div>
                </div>
                <div class="row">
                    <div id="pageno" class="w-100"></div>
                </div>
            </div><!-- main -->

        </div><!-- row filtros / main -->

    </div><!-- container -->
    

    <script src="<?php echo STORE_PATH . 'includes/filtersMain.js' ?>"></script>
    <script>
        sr.reveal('.breadcrumb', {
           duration: 1000,
           origin:'right',
           distance: '20px'
        });


        $(document).ready(function () {
            category = 0;//protections

            show_cats(category);

            show_brands(category);
            
            show_all(category);
            $('#all').click(function(e) { e.preventDefault();
                products(category);
                $('#search').val('');
            });

            products(category);


            //Search bar
            $('#search_btn').click(function(event) {
                event.preventDefault();
                var keyword = $('#search').val();
                if (keyword != '') {
                    $.ajax({
                        url: 'actions/search.php',
                        method: 'POST',
                        data: {search: 1, keyword: keyword, cat: category},
                        success: function(data) {
                            $('#products').html(data);
                        }
                    });
                } else {
                    products(category);
                    $('#search').val('');
                }
            });
            
            page(category);
            
            $('body').delegate('#page', 'click', function(event) {
                event.preventDefault();

                var pageno = $(this).attr('page');

                $.ajax({
                    url: 'actions/products.php',
                    method: 'POST',
                    data: {get_products: 1, changePage: 1, pageno: pageno, cat: category},
                    success: function(data) {
                        $('#products').html(data);
                    }
                });
            });
        });
    </script>
<?php
    require_once '../includes/footer.php';
?>