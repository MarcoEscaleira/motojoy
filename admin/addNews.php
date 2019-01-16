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
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH . 'news'; ?>">Painel notícias</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Criar notícia</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Criar uma notícia</h1>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    
                    <form enctype="multipart/form-data" action="actions/addNewsData" method="post" id="addNewsForm" action="javascript:;" autocomplete="off">
                        <div class="form-group">
                            <label for="news_title">Título</label>
                            <input type="text" id="news_title" name="news_title" class="form-control" placeholder="Título">
                        </div>
                        <div class="form-group">
                            <label for="news_subtitle">Sub-título</label>
                            <input type="text" id="news_subtitle" name="news_subtitle" class="form-control" placeholder="Sub-título">
                        </div>
                        <div class="form-group">
                            <label for="news_description">Descrição</label>
                            <textarea id="news_description" name="news_description" class="form-control" placeholder="Descrição" rows="7"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="news_author">Autor</label>
                            <input type="text" id="news_author" name="news_author" class="form-control" placeholder="Autor">
                        </div>
                        <div class="form-group">
                            <label for="news_cat">Categoria</label><br>
                            <select class="custom-select" name="news_cat" id="news_cat" style="width:100%;">
                                <option selected disabled>Escolha uma categoria</option>
                                <option value="lan">Lançamentos</option>
                                <option value="up">Atualizações</option>
                                <option value="gp">Moto GP</option>
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <input type="file" name="image" id="image" class="form-control-file">
                        </div>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                        <input type="submit" class="btn btn-outline-success btn-block mt-5" id="addNewBtn" name="addNewBtn" value="Criar">
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
        $("#addNewsForm").validate({
        rules: {
          'news_title': {
              required: true
          },
          'news_subtitle': {
              required: true,
          },
          'news_description': {
              required: true
          },
          'news_author': {
              required: true
          },
          'news_cat': {
              required: true
          },
          'image': {
              required: true
          }
        },
        messages: {
            'news_title': {
                required: 'É necessário definir um título'
            },
            'news_subtitle': {
                required: 'É necessário definir um subtítulo',
            },
            'news_description': {
                required: 'É necessário definir uma descrição'
            },
            'news_author': {
                required: 'É necessário definir um autor'
            },
            'news_cat': {
                required: 'É necessário escolher uma categoria'
            },
            'image': {
                required: 'É necessário fazer upload de uma imagem'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($('#addNewsForm')[0]);

            $.ajax({
                url: 'actions/news/addNewsData',
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

                        $("#addNewsForm input").prop("disabled", true);
                        $("#addNewsForm textarea").prop("disabled", true);
                        $("#addNewsForm select").prop("disabled", true);
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
