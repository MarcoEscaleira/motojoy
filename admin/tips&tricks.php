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
                            <li class="breadcrumb-item active" aria-current="page">Painel Dicas e Truques</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Painel Dicas e Truques</h1>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addTips" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar dica</a>
                </div>
                <div class="col-6">
                    <button type="button" id="tt_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_tt" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Sub-título</th>
                        <th>Descrição</th>
                        <th>Autor</th>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>Sub-categoria</th>
                        <th>Imagem</th>
                        <th>Views</th>
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
                            <img alt="tt_image" id="tt_image" class="img-fluid mx-auto">
                        </div>
                    </div>
                    <form action="actions/editTtData" method="post" id="editTtForm" autocomplete="off">
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
                        <textarea id="tt_description" name="tt_description" class="form-control" placeholder="Descrição" rows="7"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tt_author">Autor</label>
                        <input type="text" id="tt_author" name="tt_author" class="form-control" placeholder="Autor">
                    </div>
                    <div class="form-group">
                        <label for="tt_cat">Categoria</label><br>
                        <select class="custom-select" name="tt_cat" id="tt_cat">
                        <option value="limp">Limpeza</option>
                        <option value="manu">Manutenção</option>
                        <option value="cond">Condução</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tt_subcat">Sub-categoria</label><br>
                        <select class="custom-select" name="tt_subcat" id="tt_subcat">
                        <option value="motor">Motor</option>
                        <option value="transmissao">Transmissão</option>
                        <option value="pneus">Pneus</option>
                        <option value="null">Nenhuma</option>
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
                </div>
                <div class="modal-footer editTtFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editTtBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar a dica?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteTt">Confirmar</button>
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
  var validation = $("#editTtForm").validate({
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
        }
    },
    submitHandler: function (form) {
        var formData = new FormData($(form)[0]);

        var update = $.ajax({
        url: 'actions/tt/editTtData',
        type: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success:function(response) {
            if (response.success == true) {
            $('#edit_modal').modal('hide');

            //Atualizar a tabela
            $('#table_tt').DataTable().ajax.reload();

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
    },
    highlight: function(element) {
        $(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function(element) {
        $(element).closest('.form-control').removeClass('is-invalid');
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
        var table_tt = $('#table_tt').DataTable({
          language: {
            processing:     "A processar...",
            search:         "Pesquise&nbsp;:",
            lengthMenu:     "Filtrar _MENU_ Linhas",
            info:           "A exibir _END_ dicas, num total de _TOTAL_",
            infoEmpty:      "A exibir 0 dicas, num total de 0",
            loadingRecords: "Carregamento em curso...",
            emptyTable:     "Não existe dicas",
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
         ajax: "actions/tt/fetchTtData",
         order: [[ 9, "desc" ]],
         responsive: true,
         scroller: true,
         scrollCollapse: true,
         sScrollX: "100%",
         scrollY: 500
        });

        $('#tt_table_update').click(function() {
            $('#table_tt').DataTable().ajax.reload();

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

    function deleteTt(tt_id = null) {
      if (tt_id) {

       $('#deleteTt').unbind('click').bind('click', function() {
         $.ajax({
           url: 'actions/tt/deleteTtData',
           type: 'post',
           data: {tt_id: tt_id},
           dataType: 'json',
           success:function(response) {
             if (response.success == true) {
               $('#delete_modal').modal('hide');

               //Atualizar a tabela
               $('#table_tt').DataTable().ajax.reload();

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


    function editTt(tt_id = null) {
      if (tt_id) {
        //O que é feito aqui, é aquando da iniciação da modal

        //Resetar o input do Age Id
        $('#tt_id').remove();
        //Refresh no formulário
        $('#editTtForm')[0].reset();
        // Inserir input com o Age Id no form para edição
        $('<input>').attr({
            type: 'hidden',
            id: 'tt_id',
            name: 'tt_id',
            value: tt_id
        }).appendTo('#editTtForm');
        $.ajax({
          url: 'actions/tt/fetchSelectedTtData',
          type: 'post',
          data: {tt_id: tt_id},
          dataType: 'json',
          success:function(response) {
            $("#tt_image").attr("src",'<?php echo IMGS_PATH . 'tips/' ?>'+response.tt_image);
            $('#tt_title').val(response.tt_title);
            $('#tt_subtitle').val(response.tt_subtitle);
            $('#tt_description').val(response.tt_description);
            $('#tt_author').val(response.tt_author);
            $('#tt_cat').val(response.tt_cat);
            $('#tt_subcat').val(response.tt_subcat);
            $('#tt_video').val(response.tt_video);

          }// success first ajax
      }); //Ajax
      } // if (ageId)
    } // /edit ages function
</script>

<?php
    require_once 'includes/footer.php';
?>
