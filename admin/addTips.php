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
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH . 'tips&tricks.php'; ?>">Painel Dicas e Truques</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Criar Dica</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Criar uma dica</h1>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <form enctype="multipart/form-data" action="actions/addTtData" method="post" id="addTtForm" autocomplete="off">
                        <div class="form-group">
                            <label for="tt_title">Título</label>
                            <input type="text" id="tt_title" name="tt_title" class="form-control" placeholder="Título">
                        </div>
                        <div class="form-group">
                            <label for="tt_subtitle">Sub-título</label>
                            <input type="text" id="tt_subtitle" name="tt_subtitle" class="form-control" placeholder="Sub-título">
                        </div>
                        <div class="form-group">
                            <label for="tt_description">Descrição</label>
                            <textarea id="tt_description" name="tt_description" class="form-control" placeholder="Descrição" rows="9"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tt_author">Autor</label>
                            <input type="text" id="tt_author" name="tt_author" class="form-control" placeholder="Autor">
                        </div>
                        <div class="form-group">
                            <label for="tt_cat">Categoria</label><br>
                            <select class="custom-select" name="tt_cat" id="tt_cat">
                                <option value="" selected disabled hidden>Escolha uma categoria</option>
                                <option value="limp">Limpeza</option>
                                <option value="manu">Manutenção</option>
                                <option value="cond">Condução</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tt_subcat">Sub-categoria</label><br>
                            <select class="custom-select" name="tt_subcat" id="tt_subcat">
                                <option value="null" selected>Nenhuma</option>
                                <option value="motor">Motor</option>
                                <option value="transmissao">Transmissão</option>
                                <option value="pneus">Pneus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tt_video">Video</label>
                            <textarea id="tt_video" name="tt_video" class="form-control" placeholder="Referência video pelo youtube" rows="2"></textarea>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                            Por favor mantenha a <b>width: 560px</b> e a <b>height: 315px</b>.
                            </small>
                        </div>
                        <div class="form-group mt-4">
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-outline-success btn-block mt-5" id="addTtBtn" name="addTtBtn" value="Criar Dica">
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

    $(function() {
      var validation = $("#addTtForm").validate({
        rules: {
          'tt_title': {
              required: true
          },
          'tt_subtitle': {
              required: true,
          },
          'tt_description': {
              required: true
          },
          'tt_author': {
              required: true
          },
          'tt_cat': {
              required: true
          },
          'tt_subcat': {
              required: true
          },
          'image': {
              required: true
          }
        },
        messages: {
            'tt_title': {
                required: 'É necessário definir um título'
            },
            'tt_subtitle': {
                required: 'É necessário definir um subtítulo',
            },
            'tt_description': {
                required: 'É necessário definir uma descrição'
            },
            'tt_author': {
                required: 'É necessário definir um autor'
            },
            'tt_cat': {
                required: 'É necessário escolher uma categoria'
            },
            'tt_subcat': {
                required: 'É necessário escolher uma sub-categoria'
            },
            'image': {
                required: 'É necessário enviar uma imagem'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#addTtForm')[0]);

            $.ajax({
                url: 'actions/tt/addTtData',
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

                        $(".alert-success").delay(1000).slideDown(2000, function() {
                            $(this).delay(10000).slideUp('slow', function() {
                                $(this).remove();
                            });
                        }); // /.alert

                        $("#addTtForm input").prop("disabled", true);
                        $("#addTtForm textarea").prop("disabled", true);
                        $("#addTtForm select").prop("disabled", true);
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
                }
            });
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
