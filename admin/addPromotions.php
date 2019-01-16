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
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH . 'promotions'; ?>">Painel promoções</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Criar uma promoção</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Criar uma promoção</h1>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    
                    <form action="" method="post" id="addPromotionsForm" action="javascript:;" autocomplete="off">
                        <div class="form-group">
                            <label for="prom_discount">Desconto em %</label>
                            <input type="text" id="prom_discount" name="prom_discount" class="form-control" placeholder="Ex: 20">
                        </div>
                        <div class="form-group">
                            <label for="prom_start">Data de Início</label>
                            <input type="text" id="prom_start" name="prom_start" class="form-control" placeholder="Ex: 2018-10-15">
                        </div>
                        <div class="form-group">
                            <label for="prom_end">Data de Conclusão</label>
                            <input type="text" id="prom_end" name="prom_end" class="form-control" placeholder="Ex: 2018-11-02">
                        </div>
                        <div class="form-group">
                            <label for="prod_id">Produto</label><br>
                            <select class="custom-select" name="prod_id" id="prod_id" style="width:100%;">
                                <option selected disabled>Escolha um produto</option>
                                <?php 
                                $products = Db::getInstance()->query("SELECT * FROM products")->results();
                                
                                foreach ($products as $prod) {
                                    $type = Db::getInstance()->get('typep', array('type_id', '=', $prod->type_id))->first();
                                    echo '<option value="'.$prod->prod_id.'">'.$prod->prod_name.' ('.$type->type_name.')</option>';
                                } ?>
                            </select>
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-outline-success btn-block mt-5" id="addPromotionBtn" name="addPromotionBtn" value="Criar">
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
    $(document).ready(function () {
        $("#addPromotionsForm").validate({
        rules: {
          'prom_discount': {
              required: true
          },
          'prom_start': {
              required: true
          },
          'prom_end': {
              required: true
          },
          'prod_id': {
              required: true
          }
        },
        messages: {
            'prom_discount': {
              required: 'É necessário definir o desconto'
            },
            'prom_start': {
                required: 'É necessário definir uma data de início'
            },
            'prom_end': {
                required: 'É necessário definir uma data de conclusão'
            },
            'prod_id': {
                required: 'É necessário escolher um produto'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#addPromotionsForm')[0]);

            $.ajax({
                url: 'actions/proms/addPromotionsData',
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

                        $("#addPromotionsForm input").prop("disabled", true);
                        $("#addPromotionsForm select").prop("disabled", true);
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
