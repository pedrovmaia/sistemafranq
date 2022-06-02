<?php
if (empty($Read)):
  $Read = new Read;
endif;
$data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
$data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
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

  <div class="col-lg-12 col-md-12">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                     <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title">Todas as vendas realizadas</h4>
                      <p class="card-category">Relação de vendas realizadas</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RELATORIOS_VENDAS_REALIZADAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;


              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>
                            <div id="botao" class="border_shadow" style="padding: 15px; margin-bottom: 5px">
                    <div class="row">
                    <div class="ml-3">
                        Data Inicial : <input type="date"  name="pessoa_nome" value="<?= date('Y-m-d',$data_incio) ?>" class="form-control data_inicio_busca">
                        <div class="clearfix"></div>
                    </div>
                      <div class="ml-3">
                         Data Final :  <input type="date"  name="pessoa_nome"  value="<?= date('Y-m-d',$data_fim) ?>" class="form-control data_fim_busca">
                        <div class="clearfix"></div>
                    </div>
                        <div class="ml-3">
                            <span rel="relatorios/ListVendasRealizadas" class="btn btn-primary pull-right mt-4 j_sys_busca_data">PESQUISAR</span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                  </div>

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
                        data-url="_ajax/relatorios/ListVendasRealizadas.ajax.php?action=list&inicio=<?= date('Y-m-d',$data_incio) ?>&fim=<?= date('Y-m-d',$data_fim) ?>"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                                
                      <thead>
                      <tr>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="movimentacao" data-filter-control="input">Movimentação</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="aluno" data-field="aluno" data-filter-control="input"><?= $texto['ALNSE'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="atendente" data-field="atendente" data-filter-control="input">Atendente</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor" data-filter-control="input">Valor Total</th>
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
      ID FUNCIONALIDADE: <?= RELATORIOS_VENDAS_REALIZADAS ?>
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
          .table-scroll .aluno{
              min-width: 280px;
          }
           .table-scroll .atendente{
              min-width: 200px;
          }


      </style>