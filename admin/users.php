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
                            <li class="breadcrumb-item active" aria-current="page">Painel utilizadores</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Painel Utilizadores</h2>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <button type="button" id="users_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_users" class="table table-striped table-bordered" cellspacing="0" width="100%" style="min-height: 300px;">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Nif</th>
                        <th>Tel.</th>
                        <th>Morada</th>
                        <th>C.P.</th>
                        <th>Conta</th>
                        <th>Grupo</th>
                        <th>Carrinho</th>
                        <th>Opçoes</th>
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
                    <h5 class="modal-title" id="edit">Editar utilizador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="actions/users/editUsersData" method="post" id="editUsersForm" autocomplete="off">
                    <div class="form-group">
                        <label for="user_confirmed">Estado da Conta</label><br>
                        <select class="custom-select" name="user_confirmed" id="user_confirmed" style="width:100%;">
                            <option selected disabled>Escolha um grupo de permissões</option>
                            <option value="0">Desactivada</option>
                            <option value="1">Ativada</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group_id">Permissões</label><br>
                        <select class="custom-select" name="group_id" id="group_id" style="width:100%;">
                            <option selected disabled>Escolha um grupo de permissões</option>
                            <?php 
                            $groups = Db::getInstance()->query("SELECT * FROM groups")->results();
                            foreach ($groups as $group) {
                                echo '<option value="'.$group->group_id.'">'.$group->group_name.'</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer editBrandsFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editBrandBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar o utilizador?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteUser">Confirmar</button>
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
      var validation = $("#editUsersForm").validate({
        rules: {
          'user_confirmed': {
              required: true
          },
          'group_id': {
              required: true
          }
        },
        messages: {
            'user_confirmed': {
                required: 'É necessário escolher o estado da conta'
            },
            'group_id': {
                required: 'É necessário escolher um grupo de permissões'
            }
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);

            var update = $.ajax({
            url: 'actions/users/editUsersData',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(response) {
                if (response.success == true) {
                $('#edit_modal').modal('hide');

                //Atualizar a tabela
                $('#table_users').DataTable().ajax.reload();

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
            var table_users = $('#table_users').DataTable({
                language: {
                    processing:     "A processar...",
                    search:         "Pesquise&nbsp;:",
                    lengthMenu:     "Filtrar _MENU_ Linhas",
                    info:           "A exibir _END_ marcas, num total de _TOTAL_",
                    infoEmpty:      "A exibir 0 marcas, num total de 0",
                    loadingRecords: "Carregamento em curso...",
                    emptyTable:     "Não existe marcas",
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
                ajax: "actions/users/fetchUsersData",
                order: [[ 11, "desc" ]],
                responsive: true,
                scroller: true,
                scrollCollapse: true,
                sScrollX: "100%",
                scrollY: 700
            });

            $('#users_table_update').click(function() {
                $('#table_users').DataTable().ajax.reload();

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

        function deleteUser(user_id = null) {
          if (user_id) {

           $('#deleteUser').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/users/deleteUsersData',
               type: 'post',
               data: {user_id: user_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_users').DataTable().ajax.reload();

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


        function editUser(user_id = null) {
          if (user_id) {
            $('#user_id').remove();
            $('#editUsersForm')[0].reset();
            $('<input>').attr({
                type: 'hidden',
                id: 'user_id',
                name: 'user_id',
                value: user_id
            }).appendTo('#editUsersForm');
            $.ajax({
              url: 'actions/users/fetchSelectedUsersData',
              type: 'post',
              data: {user_id: user_id},
              dataType: 'json',
              success:function(response) {
                $('#group_id').val(response.group_id);
                $('#user_confirmed').val(response.user_confirmed);

              }// success first ajax
          }); //Ajax
          } // if (ageId)
        } // /edit ages function
    </script>
<?php
    require_once 'includes/footer.php';
?>
