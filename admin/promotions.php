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
                            <li class="breadcrumb-item active" aria-current="page">Painel Promoções</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Painel Promoções</h2>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="addPromotions" class="btn btn-outline-success btn-block mt-2 mb-4"><i class="fa fa-plus-circle"></i> Criar promoção</a>
                </div>
                <div class="col-6">
                    <button type="button" id="promotions_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_promotions" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Desconto</th>
                        <th>Início</th>
                        <th>Fim</th>
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
                    <form action="" method="post" id="editPromotionsForm" autocomplete="off">
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
                        <select class="custom-select" name="prod_id" id="prod_id" style="width:100%;" disabled>
                            <option selected disabled>Escolha um produto</option>
                            <?php 
                            $products = Db::getInstance()->query("SELECT * FROM products")->results();
                            
                            foreach ($products as $prod) {
                                $type = Db::getInstance()->get('typep', array('type_id', '=', $prod->type_id))->first();
                                echo '<option value="'.$prod->prod_id.'">'.$prod->prod_name.' ('.$type->type_name.')</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer editPromotionsFooter">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-outline-success w-25" id="editPromotionBtn">Guardar</button>
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
                    <p>Confirma que pretende eliminar a promoção?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deletePromotion">Confirmar</button>
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
        $.validator.addMethod('daterange', function(value, element, arg) {
            if (this.optional(element) && !value) {
                return true;
            }

            var startDate = Date.parse(arg[0]),
                endDate = Date.parse(arg[1]),
                enteredDate = Date.parse(value);

            if (isNaN(enteredDate)) {
                return false;
            }

            return ( (isNaN(startDate) || (startDate <= enteredDate)) &&
                    (isNaN(endDate) || (enteredDate <= endDate)));
        }, $.validator.format("Introduza uma data entre {0} e {1}."));

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 
        if(mm<10) {
            mm = '0'+mm
        } 

        today = yyyy + '-' + mm + '-' + dd;

        var validation = $("#editPromotionsForm").validate({
            rules: {
            'prom_discount': {
                required: true
            },
            'prom_start': {
                required: true,
                daterange:[today,'2020-01-31']
            },
            'prom_end': {
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
                }
            },
            submitHandler: function (form) {
                var formData = new FormData($(form)[0]);

                var update = $.ajax({
                url: 'actions/proms/editPromotionsData',
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success:function(response) {
                    if (response.success == true) {
                    $('#edit_modal').modal('hide');

                    //Atualizar a tabela
                    $('#table_promotions').DataTable().ajax.reload();

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
            var table_promotions = $('#table_promotions').DataTable({
              language: {
                processing:     "A processar...",
                search:         "Pesquise&nbsp;:",
                lengthMenu:     "Filtrar _MENU_ Linhas",
                info:           "A exibir _END_ promoções, num total de _TOTAL_",
                infoEmpty:      "A exibir 0 promoções, num total de 0",
                loadingRecords: "Carregamento em curso...",
                emptyTable:     "Não existe promoções",
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
             ajax: "actions/proms/fetchPromotionsData",
             order: [[ 5, "desc" ]],
             responsive: true,
             sScrollX: "100%",
             scrollY: 500
            });

            $('#promotions_table_update').click(function() {
                $('#table_promotions').DataTable().ajax.reload();

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

        function deletePromotion(prom_id = null) {
          if (prom_id) {

           $('#deletePromotion').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/proms/deletePromotionsData',
               type: 'post',
               data: {prom_id: prom_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_promotions').DataTable().ajax.reload();

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


        function editPromotion(prom_id = null) {
          if (prom_id) {
            //O que é feito aqui, é aquando da iniciação da modal

            //Resetar o input do Age Id
            $('#prom_id').remove();
            //Refresh no formulário
            $('#editPromotionsForm')[0].reset();
            // Inserir input com o Age Id no form para edição
            $('<input>').attr({
                type: 'hidden',
                id: 'prom_id',
                name: 'prom_id',
                value: prom_id
            }).appendTo('#editPromotionsForm');
            $.ajax({
              url: 'actions/proms/fetchSelectedPromotionsData',
              type: 'post',
              data: {prom_id: prom_id},
              dataType: 'json',
              success:function(response) {
                $('#prom_discount').val(response.prom_discount);
                $('#prom_start').val(response.prom_start);
                $('#prom_end').val(response.prom_end);
                $('#prod_id').val(response.prod_id);

              }// success first ajax
          }); //Ajax
          } // if (ageId)
        } // /edit ages function
    </script>
<?php
    require_once 'includes/footer.php';
?>
