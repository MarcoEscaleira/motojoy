<?php
    require ('core/config.php');
    require_once 'includes/header.php';
?>

<div class="container">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH; ?>">Administração</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Painel Notícias</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Painel Notícias</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addNews" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar notícia</a>
                </div>
                <div class="col-6">
                    <button type="button" id="news_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_news" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Sub-título</th>
                        <th>Descrição</th>
                        <th>Autor</th>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>Capa</th>
                        <th>Indíce</th>
                        <th>Opções</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2 mb-4">
                        <div class="col-9 mx-auto">
                            <img alt="news_image" id="news_image" class="img-fluid mx-auto">
                        </div>
                    </div>
                    <form action="actions/editNewsData" method="post" id="editNewsForm" autocomplete="off">
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
                        <select class="custom-select" name="news_cat" id="news_cat">
                        <option value="lan">Lançamentos</option>
                        <option value="up">Atualizações</option>
                        <option value="gp">Moto GP</option>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer editNewsFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editNewBtn">Guardar</button>
                </div>
            </div>
                    </form>
        </div>
    </div>

<!-- Delete Modal -->
    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="eliminar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminar">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirma que pretende eliminar a noticia?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteNew">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

</div><!--Container-->

    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
        duration: 1000,
        origin:'bottom',
        distance: '20px'
        });
    </script>
    <?php
        Assets::loadJS_Assets('validation/dist/jquery.validate.min');
        Assets::loadJS_Assets('validation/dist/additional-methods.min');
    ?>
    <script type="text/javascript">
    $(function() {
      var validation = $("#editNewsForm").validate({
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
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);

            var update = $.ajax({
            url: 'actions/news/editNewsData',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(response) {
                if (response.success == true) {
                $('#edit_modal').modal('hide');

                //Atualizar a tabela
                $('#table_news').DataTable().ajax.reload();

                $('.flash_messages').html('<div class="alert alert-success text-center" role="alert">'+
                '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages +
                '</div>');

                $(".alert-success").delay(400).slideDown(10, function() {
                    $(this).delay(2000).slideUp('slow', function() {
                        $(this).remove();
                    });
                }); // /.alert
                }
            }
            }); // Edit ajax
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

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
            $('.popover-dismiss').popover({
                trigger: 'focus'
            });
            var table_news = $('#table_news').DataTable({
              language: {
                processing:     "A processar...",
                search:         "Pesquise&nbsp;:",
                lengthMenu:     "Filtrar _MENU_ Linhas",
                info:           "A exibir _END_ notícias, num total de _TOTAL_",
                infoEmpty:      "A exibir 0 notícias, num total de 0",
                loadingRecords: "Carregamento em curso...",
                emptyTable:     "Não existe notícias",
                paginate: {
                  first:      "Primeira",
                  previous:   "Anterior",
                  next:       "Proxima",
                  last:       "Última"
                },
                aria: {
                  sortAscending:  ": Ordem Crescente",
                  sortDescending: ": Ordem Decrescente"
               }
             },
             fixedHeader: true,
             ajax: "actions/news/fetchNewsData",
             order: [[ 7, "desc" ]],
             responsive: true,
             rowGroup: {
                dataSrc: 'group'
            },
            scroller: true,
            sScrollX: "100%",
            scrollY: 500
            });

            $('#news_table_update').click(function() {
                $('#table_news').DataTable().ajax.reload();

                $('.flash_messages').html('<div class="alert alert-success text-center" role="alert">'+
                '<i class="fa fa-check"></i>&nbsp;&nbsp;Tabela atualizada de acordo com a Base de Dados'+
                '</div>');

                  $(".alert-success").delay(400).slideDown(10, function() {
                    $(this).delay(2000).slideUp('slow', function() {
                        $(this).remove();
                    });
                  }); // /.alert
            });
        } );

        function deleteNew(news_id = null) {
          if (news_id) {

           $('#deleteNew').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/news/deleteNewsData',
               type: 'post',
               data: {news_id: news_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_news').DataTable().ajax.reload();

                   $('.flash_messages').html('<div class="alert alert-success text-center" role="alert">'+
                   '<i class="fa fa-trash-o"></i>&nbsp;&nbsp;' + response.messages +
                   '</div>');

                   $(".alert-success").delay(400).slideDown(10, function() {
                     $(this).delay(2000).slideUp('slow', function() {
                         $(this).remove();
                     });
                   }); // /.alert
                 }
               }
             });
           });
          } // if age_id
        }


        function editNew(news_id = null) {
          if (news_id) {
            //O que é feito aqui, é aquando da iniciação da modal

            //Resetar o input do Age Id
            $('#news_id').remove();
            //Refresh no formulário
            $('#editNewsForm')[0].reset();
            // Inserir input com o Age Id no form para edição
            $('<input>').attr({
                type: 'hidden',
                id: 'news_id',
                name: 'news_id',
                value: news_id
            }).appendTo('#editNewsForm');
            $.ajax({
              url: 'actions/news/fetchSelectedNewsData',
              type: 'post',
              data: {news_id: news_id},
              dataType: 'json',
              success:function(response) {
                $("#news_image").attr("src",'<?php echo IMGS_PATH . 'news/' ?>'+response.news_image);
                $('#news_title').val(response.news_title);
                $('#news_subtitle').val(response.news_subtitle);
                $('#news_description').val(response.news_description);
                $('#news_author').val(response.news_author);
                $('#news_cat').val(response.news_cat);

              }// success first ajax
          }); //Ajax
          } // if (ageId)
        } // /edit ages function
    </script>
<?php
    require_once 'includes/footer.php';
?>
