<?php
if (empty($Read)):
    $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">

<style>
    .filter-control input {
        border: 0.55px !important;
         height: 20px !important;

    }
    .filter-control select {
        border: 0.55px solid gray !important;
    }
    select.form-control:not([size]):not([multiple]){
        height: 36px;
    }
</style>
 
   <div id="loader" class="loader"></div>
   
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header card-header-primary">
                  <div class="row">
                      <div class="col-md-1">
                         <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                      </div>
                      <div class="col-md-10 text-center">
                          <h4 class="card-title">Todos os títulos em atraso</h4>
                          <p class="card-category">Relação de títulos em atraso</p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RELATORIOS_TITULOS_ATRASO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                  if($Read->getResult()){
                      $permissao = $Read->getResult()[0];
                      $_SESSION['permissao'] = $permissao;
                  } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                  }


                $_SESSION['permissao'] = $permissao;
                if($permissao["ler"] == 1){
                ?>

                <div class="border_shadow" style="padding: 20px">
                  <div class="table-scroll">
                        <div class="table-wrap">
                <table  class="table table-hover display"
                        id="table"
                        data-toolbar="#toolbar"
                        data-locale="pt-BR"
                        data-show-export="true"
                        data-filter-control="true"
                        data-filter-show-clear="true"
                        data-show-toggle="true"
                        data-show-fullscreen="true"
                        data-show-columns="true"
                        data-minimum-count-columns="2"
                        data-url="_ajax/relatorios/ListTitulosAtrasados.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead>
                    <tr>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="moviid" data-filter-control="input">Movimentação ID</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="datav" data-filter-control="input">Data de Vencimento</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="numero" data-filter-control="input"><?= $texto['NUMB'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="parcela" data-filter-control="input">Parcela</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="status" data-filter-control="input"><?= $texto['STASS'] ?></th> 
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor" data-filter-control="input">Valor de Recebimento</th> 
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="pessoa" data-field="pessoa" data-filter-control="input"><?= $texto['PEOPLE'] ?></th> 
                        
                    </tr>
                    </thead>
                </table>
              </div>
            </div>
                </div>
                    <?php
                }
                ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= RELATORIOS_TITULOS_ATRASO ?>
    </div>
  <style>
          .table-scroll {
              max-width: 2000px;
              overflow: hidden;
          }
          .table-wrap {
              width:100%;
              overflow:auto;
          }
          .table-scroll table {
              width:100%;
              margin:auto;
              border-collapse:separate;
              border-spacing:0;
          }
          .table-scroll .acoes{
              min-width: 150px;
          }
          .table-scroll .pessoa{
              min-width: 280px;
          }

          .table-scroll .turma{
              min-width: 400px;
          }
           .table-scroll .funcionario{
              min-width: 200px;
          }
      </style>
