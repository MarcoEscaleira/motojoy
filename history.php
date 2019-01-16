<?php
    require 'core/config.php';
    require_once INCLUDES_PATH . 'header.php';
?>

    <div class="container">
      <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="row">
                <nav aria-label="breadcrumb" role="navigation" class="mx-auto">
                    <ol class="breadcrumb backbread">
                        <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'index'; ?>">Início</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo URL_PATH . 'panel'; ?>">Painel do Utilizador</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Histórico de Encomendas</li>
                    </ol>
                </nav>
            </div>
            <h2 class="titles mx-auto text-center">Histórico de Encomendas</h2>
            <hr>
            
            <table id="orders_table" class="table table-bordered" cellspacing="0" width="100%" style="min-height: 300px;">
              <thead>
                <tr>
                  <th>Transação</th>
                  <th>Imagem</th>
                  <th>Produto</th>
                  <th>Preço</th>
                  <th>Qt</th>
                  <th>Sub-total</th>
                  <th></th>
                </tr>
              </thead>
            </table>
        </div>
        <div class="col-1"></div>
      </div>
    </div>

    
    
    <script type="text/javascript">
        sr.reveal('.breadcrumb', {
          duration: 1000,
          origin:'bottom',
          distance: '20px'
        });

        $(document).ready(function () {
          var table_prods = $('#orders_table').DataTable({
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
            ajax: "includes/fetchOrders.php",
            order: [[ 6, "desc" ]],
            responsive: true,
            sScrollX: "100%",
            scrollY: 500
          });
        });
    </script>

<?php
    require_once INCLUDES_PATH . 'footer.php';
?>
