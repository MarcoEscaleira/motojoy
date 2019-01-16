<?php
    require ('core/config.php');
    require_once 'includes/header.php';
?>

<div class="container">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb backbread">
                            <li class="breadcrumb-item"><a href="<?php echo ADMIN_PATH; ?>">Administração</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6">
                    <a href="<?php echo URL_PATH . 'store/'; ?>" class="btn btn-outline-info mt-1 w-25" id="back_to" style="float:right;">Loja</a>
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1 mr-4 w-25" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h1 class="display-4 mx-auto mb-5 text-center">Painel Produtos</h1>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addProduct" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar produto</a>
                </div>
                <div class="col-6">
                    <button type="button" id="tt_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_prods" class="table table-striped table-bordered" cellspacing="0" width="100%" style="min-height: 300px;">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Stock</th>
                        <th>Preço</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Views</th>
                        <th>Indíce</th>
                        <th>Keywords</th>
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
                    <h5 class="modal-title" id="edit">Editar produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col-9 mx-auto" style="height: 250px;">
                            <img alt="prod_image" id="prod_image" class="img-fluid mx-auto d-block" style="width: 70%; max-height: 250px;">
                        </div>
                    </div>
                    <form action="actions/editProdData" method="post" id="editProdForm" autocomplete="off">
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
                        <label for="type_id">Marca</label><br>
                        <select class="custom-select" name="brand_id" id="brand_id" style="width:100%;">
                            <option selected disabled>Escolha uma marca</option>
                            <?php 
                                $brands = Db::getInstance()->query("SELECT * FROM brands")->results();
                                foreach ($brands as $brand) {
                                    echo '<option value="'.$brand->brand_id.'" data-tokens="'.$brand->brand_name.'">'.$brand->brand_name.'</option>';
                                } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_id">Tipo</label><br>
                        <select class="custom-select" name="type_id" id="type_id" style="width:100%;">
                            <option selected disabled>Escolha uma categoria</option>
                            <?php 
                                $types = Db::getInstance()->query("SELECT * FROM typep")->results();
                                foreach ($types as $type) {
                                    echo '<option value="'.$type->type_id.'">'.ucfirst($type->type_name).'</option>';
                                } ?>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer editProdFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editProdBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar o produto?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteProd">Confirmar</button>
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
    $('[data-toggle="popover"]').popover();
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });
</script>
<?php
    Assets::loadJS_Assets('validation/dist/jquery.validate.min');
    Assets::loadJS_Assets('validation/dist/additional-methods.min');
?>
<script type="text/javascript">
$(function() {
  var validation = $("#editProdForm").validate({
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
        'prod_type': {
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
            required: 'É necessário definir um stock'
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
        'prod_type': {
            required: 'É necessário escolher um tipo'
        }
    },
    submitHandler: function (form) {
        var formData = new FormData($(form)[0]);

        var update = $.ajax({
        url: 'actions/prod/editProdData',
        type: 'post',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success:function(response) {
            if (response.success == true) {
            $('#edit_modal').modal('hide');

            //Atualizar a tabela
            $('#table_prods').DataTable().ajax.reload();

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
        var table_prods = $('#table_prods').DataTable({
          language: {
            processing:     "A processar...",
            search:         "Pesquise&nbsp;:",
            lengthMenu:     "Filtrar _MENU_ Linhas",
            info:           "A exibir _END_ produtos, num total de _TOTAL_",
            infoEmpty:      "A exibir 0 produtos, num total de 0",
            loadingRecords: "Carregamento em curso...",
            emptyTable:     "Não existe produtos",
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
         ajax: "actions/prod/fetchProdData",
         order: [[ 10, "desc" ]],
         responsive: true,
         scroller: true,
         scrollCollapse: true,
         sScrollX: "100%",
         scrollY: 500
        });

        $('#tt_table_update').click(function() {
            $('#table_prods').DataTable().ajax.reload();

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

    function deleteProd(prod_id = null) {
      if (prod_id) {

       $('#deleteProd').unbind('click').bind('click', function() {
         $.ajax({
           url: 'actions/prod/deleteProdData',
           type: 'post',
           data: {prod_id: prod_id},
           dataType: 'json',
           success:function(response) {
             if (response.success == true) {
               $('#delete_modal').modal('hide');

               //Atualizar a tabela
               $('#table_prods').DataTable().ajax.reload();

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


    function editProd(prod_id = null) {
      if (prod_id) {
        //O que é feito aqui, é aquando da iniciação da modal

        //Resetar o input do Age Id
        $('#prod_id').remove();
        //Refresh no formulário
        $('#editProdForm')[0].reset();
        // Inserir input com o Age Id no form para edição
        $('<input>').attr({
            type: 'hidden',
            id: 'prod_id',
            name: 'prod_id',
            value: prod_id
        }).appendTo('#editProdForm');
        $.ajax({
          url: 'actions/prod/fetchSelectedProdData',
          type: 'post',
          data: {prod_id: prod_id},
          dataType: 'json',
          success:function(response) {
            $("#prod_image").attr("src",'<?php echo IMGS_PATH . 'products/' ?>'+response.prod_image);
            $('#prod_name').val(response.prod_name);
            $('#prod_desc').val(response.prod_desc);
            $('#prod_price').val(response.prod_price);
            $('#prod_stock').val(response.prod_stock);
            $('#prod_keywords').val(response.prod_keywords);
            $('#cat_id').val(response.cat_id);
            $('#brand_id').val(response.brand_id);
            $('#type_id').val(response.type_id);
          }// success first ajax
      }); //Ajax
      } // if (ageId)
    } // /edit ages function
</script>

<?php
    require_once 'includes/footer.php';
?>
