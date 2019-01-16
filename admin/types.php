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
                            <li class="breadcrumb-item active" aria-current="page">Painel Tipos</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Painel Tipos</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addTypes" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar Tipo</a>
                </div>
                <div class="col-6">
                    <button type="button" id="types_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_types" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
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
                    <h5 class="modal-title" id="edit">Editar tipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="actions/types/editTypesData" method="post" id="editTypesForm" autocomplete="off">
                    <div class="form-group">
                        <label for="type_name">Nome</label>
                        <input type="text" id="type_name" name="type_name" class="form-control" placeholder="Nome">
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
                </div>
                <div class="modal-footer editTypesFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editTypesBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar o tipo?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteType">Confirmar</button>
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
      var validation = $("#editTypesForm").validate({
        rules: {
          'type_name': {
              required: true
          },
          'cat_id': {
              required: true
          }
        },
        messages: {
            'type_name': {
                required: 'É necessário definir um nome'
            },
            'cat_id': {
                required: 'É necessário definir uma categoria'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);

            var update = $.ajax({
            url: 'actions/types/editTypesData',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(response) {
                if (response.success == true) {
                $('#edit_modal').modal('hide');

                //Atualizar a tabela
                $('#table_types').DataTable().ajax.reload();

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
            var table_types = $('#table_types').DataTable({
                language: {
                    processing:     "A processar...",
                    search:         "Pesquise&nbsp;:",
                    lengthMenu:     "Filtrar _MENU_ Linhas",
                    info:           "A exibir _END_ tipos, num total de _TOTAL_",
                    infoEmpty:      "A exibir 0 tipos, num total de 0",
                    loadingRecords: "Carregamento em curso...",
                    emptyTable:     "Não existe tipos",
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
                ajax: "actions/types/fetchTypesData",
                responsive: true,
                order: [[ 2, "desc" ]],
                sScrollX: "100%",
                scrollY: 500
            });

            $('#types_table_update').click(function() {
                $('#table_types').DataTable().ajax.reload();

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

        function deleteType(type_id = null) {
          if (type_id) {

           $('#deleteType').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/types/deleteTypesData',
               type: 'post',
               data: {type_id: type_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_types').DataTable().ajax.reload();

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


        function editType(type_id = null) {
          if (type_id) {
            $('#type_id').remove();
            $('#editTypesForm')[0].reset();
            $('<input>').attr({
                type: 'hidden',
                id: 'type_id',
                name: 'type_id',
                value: type_id
            }).appendTo('#editTypesForm');
            $.ajax({
              url: 'actions/types/fetchSelectedTypesData',
              type: 'post',
              data: {type_id: type_id},
              dataType: 'json',
              success:function(response) {
                $('#type_name').val(response.type_name);
                $('#cat_id').val(response.cat_id);
              }// success first ajax
          }); //Ajax
          } // if (ageId)
        } // /edit ages function
    </script>
<?php
    require_once 'includes/footer.php';
?>
