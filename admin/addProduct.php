<?php
    require ('core/config.php');

    require ('includes/header.php');
?>

<div class="container">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH; ?>">Administração</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH . 'products'; ?>">Painel de Produtos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Criar produto</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Criar um produto</h1>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    
                    <form enctype="multipart/form-data" action="actions/addProdData" method="post" id="addProdForm" action="javascript:;" autocomplete="off">
                        <div class="form-group">
                            <label for="prod_name">Nome</label>
                            <input type="text" id="prod_name" name="prod_name" class="form-control" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label for="prod_desc">Descrição</label>
                            <textarea id="prod_desc" name="prod_desc" class="form-control" placeholder="Descrição" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prod_price">Preço</label>
                            <input type="text" id="prod_price" name="prod_price" class="form-control" placeholder="Preço">
                        </div>
                        <div class="form-group">
                            <label for="prod_stock">Stock</label>
                            <input type="text" id="prod_stock" name="prod_stock" class="form-control" placeholder="Stock">
                        </div>
                        <div class="form-group">
                            <label for="prod_keywords">Palavras-chave</label>
                            <textarea id="prod_keywords" name="prod_keywords" class="form-control" placeholder="Palavras-chave" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cat_id">Categoria</label><br>
                            <select class="custom-select" name="cat_id" id="cat_id" style="width:100%;">
                                <option selected disabled>Escolha uma categoria</option>
                                <?php 
                                    $cats = Db::getInstance()->query("SELECT * FROM categories")->results();
                                    foreach ($cats as $cat) {
                                        echo '<option value="'.$cat->cat_id.'">'.$cat->cat_name.'</option>';
                                    } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Marca</label><br>
                            <select class="custom-select" name="brand_id" id="brand_id" style="width:100%;">
                                <option selected disabled>Escolha uma marca</option>
                                <?php 
                                    $brands = Db::getInstance()->query("SELECT * FROM brands")->results();
                                    foreach ($brands as $brand) {
                                        echo '<option value="'.$brand->brand_id.'" data-tokens="'.$brand->brand_name.'">'.$brand->brand_name.'</option>';
                                    } ?>
                            </select>
                        </div>
                        
                        <div id="options_type"></div>
                        
                        <div class="form-group mt-4">
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-outline-success btn-block mt-5" id="addProdBtn" name="addProdBtn" value="Criar">
                    </form>

                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
</div>

<?php
    Assets::loadJS_Assets('validation/dist/jquery.validate.min');
    Assets::loadJS_Assets('validation/dist/additional-methods.min');
?>

<script type="text/javascript">
    sr.reveal('.breadcrumb', {
    duration: 1000,
    origin:'bottom',
    distance: '20px'
    });
</script>

<script type="text/javascript">

    $('body').delegate('#cat_id', 'change', function(event) {

        var cat_id = $(this).val();
        
        $.ajax({
            url: 'actions/prod/type.php',
            method: 'POST',
            data: {cat_id: cat_id},
            success: function(data) {
                $('#options_type').html(data);
            }
        });
    });

    $(document).ready(function () {
        $("#addProdForm").validate({
        rules: {
          'prod_name': {
              required: true
          },
          'prod_desc': {
              required: true
          },
          'prod_price': {
              required: true
          },
          'prod_stock': {
              required: true
          },
          'prod_keywords': {
              required: true
          },
          'prod_cat': {
              required: true
          },
          'prod_brand': {
              required: true
          },
          'image': {
              required: true
          }
        },
        messages: {
            'prod_name': {
              required: 'É necessário definir um nome'
            },
            'prod_desc': {
                required: 'É necessário definir uma descrição'
            },
            'prod_price': {
                required: 'É necessário definir um preço'
            },
            'prod_stock': {
                required: 'É necessário definir o stock'
            },
            'prod_keywords': {
                required: 'É necessário definir as palavras-chave'
            },
            'prod_cat': {
                required: 'É necessário escolher uma categoria'
            },
            'prod_brand': {
                required: 'É necessário escolher uma marca'
            },
            'image': {
                required: 'É necessário escolher uma imagem'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#addProdForm')[0]);

            $.ajax({
                url: 'actions/prod/addProdData',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response) { 
                    console.log(response);
                    
                    if (response.success == true) {
                        $('.flash_messages').html('<div class="alert alert-' + response.type + ' text-center" role="alert">'+
                        '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages + '&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="history.go(-1)" class="btn btn-outline-warning">Regressar</a>' +
                        '</div>');

                        $(".alert-success").delay(10000).slideDown(2000, function() {
                            $(this).delay(10000).slideUp('slow', function() {
                                $(this).remove();
                            });
                        }); // /.alert

                        $("#addProdForm input").prop("disabled", true);
                        $("#addProdForm textarea").prop("disabled", true);
                        $("#addProdForm select").prop("disabled", true);
                    } else if (response.success = false) {

                        $('.flash_messages').html('<div class="alert alert-' + response.type + ' text-center" role="alert">'+
                        '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages +
                        '</div>');

                        $(".alert-success").delay(400).show(10, function() {
                            $(this).delay(2000).slideUp('slow', function() {
                                $(this).remove();
                            });
                        }); // /.alert

                    }
                },
                error: function(data, textStatus, jqXHR) {
                    alert(data + ' - ' + textStatus + ' - ' + jqXHR);
                }
            });

            return false;
        },
        highlight: function(element) {
            $(element).closest('.form-control').addClass('is-invalid');
            $(element).closest('.custom-select').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-control').removeClass('is-invalid');
            $(element).closest('.custom-select').removeClass('is-invalid');
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback mb-3',
        errorPlacement: function(error, element) {
            if(element.parent('.form-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
      });
    });
      
</script>
    
<?php
    require ('includes/footer.php');
?>
