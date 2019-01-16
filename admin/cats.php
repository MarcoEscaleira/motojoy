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
                            <li class="breadcrumb-item active" aria-current="page">Painel Categorias</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Painel Categorias</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addCats" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar Categoria</a>
                </div>
                <div class="col-6">
                    <button type="button" id="cats_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_cats" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nome</th>
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
                    <h5 class="modal-title" id="edit">Editar categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="actions/cats/editCatsData" method="post" id="editCatsForm" autocomplete="off">
                    <div class="form-group">
                        <label for="cat_name">Nome</label>
                        <input type="text" id="cat_name" name="cat_name" class="form-control" placeholder="Nome">
                    </div>
                </div>
                <div class="modal-footer editCatsFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editCatBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar a categoria?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteCat">Confirmar</button>
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
      var validation = $("#editCatsForm").validate({
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
            var formData = new FormData($(form)[0]);

            var update = $.ajax({
            url: 'actions/cats/editCatsData',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(response) {
                if (response.success == true) {
                $('#edit_modal').modal('hide');

                //Atualizar a tabela
                $('#table_cats').DataTable().ajax.reload();

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
            var table_cats = $('#table_cats').DataTable({
                language: {
                    processing:     "A processar...",
                    search:         "Pesquise&nbsp;:",
                    lengthMenu:     "Filtrar _MENU_ Linhas",
                    info:           "A exibir _END_ categorias, num total de _TOTAL_",
                    infoEmpty:      "A exibir 0 categorias, num total de 0",
                    loadingRecords: "Carregamento em curso...",
                    emptyTable:     "Não existe categorias",
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
                ajax: "actions/cats/fetchCatsData",
                responsive: true,
                order: [[ 1, "desc" ]],
                sScrollX: "100%",
                scrollY: 500
            });

            $('#cats_table_update').click(function() {
                $('#table_cats').DataTable().ajax.reload();

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

        function deleteCat(cat_id = null) {
          if (cat_id) {

           $('#deleteCat').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/cats/deleteCatsData',
               type: 'post',
               data: {cat_id: cat_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_cats').DataTable().ajax.reload();

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


        function editCat(cat_id = null) {
          if (cat_id) {
            $('#cat_id').remove();
            $('#editCatsForm')[0].reset();
            $('<input>').attr({
                type: 'hidden',
                id: 'cat_id',
                name: 'cat_id',
                value: cat_id
            }).appendTo('#editCatsForm');
            $.ajax({
              url: 'actions/cats/fetchSelectedCatsData',
              type: 'post',
              data: {cat_id: cat_id},
              dataType: 'json',
              success:function(response) {
                $('#cat_name').val(response.cat_name);
              }// success first ajax
          }); //Ajax
          } // if (ageId)
        } // /edit ages function
    </script>
<?php
    require_once 'includes/footer.php';
?>
