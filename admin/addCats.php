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
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH . 'brands'; ?>">Painel categorias</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Criar categoria</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Criar uma categoria</h1>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    
                    <form action="actions/cats/addCatsData" method="post" id="addCatsForm" action="javascript:;" autocomplete="off">
                        <div class="form-group">
                            <label for="cat_name">Nome</label>
                            <input type="text" id="cat_name" name="cat_name" class="form-control" placeholder="Nome">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-outline-success btn-block mt-5" id="addCatBtn" name="addCatBtn" value="Criar">
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
        $("#addCatsForm").validate({
        rules: {
          'cat_name': {
              required: true
          }
        },
        messages: {
            'cat_name': {
                required: 'É necessário definir um nome'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#addCatsForm')[0]);

            $.ajax({
                url: 'actions/cats/addCatsData',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response) {
                    
                    if (response.success == true) {
                        $('.flash_messages').html('<div class="alert alert-' + response.type + ' text-center" role="alert">'+
                        '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages + '&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="history.go(-1)" class="btn btn-outline-warning">Regressar</a>' +
                        '</div>');

                        $(".alert-success").delay(10000).slideDown(2000, function() {
                            $(this).delay(10000).slideUp('slow', function() {
                                $(this).remove();
                            });
                        }); // /.alert

                        $("#addCatsForm input").prop("disabled", true);
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
