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
                            <li class="breadcrumb-item active" aria-current="page">Encomendas</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <a href="<?php echo URL_PATH . 'index'; ?>" class="btn btn-outline-info mt-1" id="back_to" style="float:right;">Voltar ao site</a>
                </div>
            </div>
            <div class="row">
                <h2 class="display-4 mx-auto mb-4 text-center">Encomendas</h2>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <button type="button" id="orders_table_update" class="btn btn-outline-secondary btn-block mt-2 mb-4" data-toggle="popover" data-trigger="focus" data-placement="left" title="Informação" data-content="Atualiza os dados da base de dados sem atualizar a página."><i class="fa fa-refresh"></i> Atualizar a tabela</button>
                </div>
            </div>
            <table id="table_orders" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Transação</th>
                        <th>Utilizador</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Qt</th>
                        <th>Sub-total</th>
                        <th>Opções</th>
                    </tr>
                </thead>
            </table>
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
                    <p>Confirma que pretende eliminar a encomenda?</p>
                    <p id="print_new"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-outline-success w-25" id="deleteOrder">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

</div><!--container-->
    <?php
        Assets::loadJS_Assets('validation/dist/jquery.validate.min');
        Assets::loadJS_Assets('validation/dist/additional-methods.min');
    ?>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
        $('.popover-dismiss').popover({
            trigger: 'focus'
        });
        
        sr.reveal('.breadcrumb', {
            duration: 1000,
            origin:'bottom',
            distance: '20px'
        });
        var table_orders = $('#table_orders').DataTable({
            language: {
                processing:     "A processar...",
                search:         "Pesquise&nbsp;:",
                lengthMenu:     "Filtrar _MENU_ Linhas",
                info:           "A exibir _END_ encomendas, num total de _TOTAL_",
                infoEmpty:      "A exibir 0 encomendas, num total de 0",
                loadingRecords: "Carregamento em curso...",
                emptyTable:     "Não existe encomendas",
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
            ajax: "actions/orders/fetchOrdersData",
            responsive: true,
            order: [[ 6, "desc" ]],
            sScrollX: "100%",
            scrollY: 500
        });

        $('#orders_table_update').click(function() {
                $('#table_orders').DataTable().ajax.reload();

                $('.flash_messages').html('<div class="alert alert-success text-center" role="alert">'+
                '<i class="fa fa-check"></i>&nbsp;&nbsp;Tabela atualizada de acordo com a Base de Dados'+
                '</div>');

                  $(".alert-success").delay(400).slideDown(10, function() {
                    $(this).delay(2000).slideUp('slow', function() {
                        $(this).remove();
                    });
                  }); // /.alert
            });
    });
    function deleteOrder(pay_id = null) {
          if (pay_id) {

           $('#deleteOrder').unbind('click').bind('click', function() {
             $.ajax({
               url: 'actions/orders/deleteOrdersData',
               type: 'post',
               data: {pay_id: pay_id},
               dataType: 'json',
               success:function(response) {
                 if (response.success == true) {
                   $('#delete_modal').modal('hide');

                   //Atualizar a tabela
                   $('#table_orders').DataTable().ajax.reload();

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
</script>

<?php
    require_once 'includes/footer.php';
?>
