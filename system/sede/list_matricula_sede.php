<?php
if (empty($Read)):
  $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">

<style>
    .headcol {
        position:absolute;
        right:0;
        top:auto;
        border-right: 1px black;
        border-top-width:3px; /*only relevant for first row*/
        margin-top:-3px; /*compensate for top border*/
        background: linear-gradient(#EEEEEE, #EEEEEE, #EEEEEE);
        border-radius: 3px;
    }
    table {
        width:100%;
        margin:auto;
        border-collapse:separate;
        border-spacing:0;
    }
    .fixed-table-body {
        width: auto;
        overflow-x:scroll;
        margin-right:100px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 100px;
        text-align: center;
    }
      .cliente{
              min-width: 280px;
          }
          .data{
              min-width: 150px;
          }
          .funcionario{
              min-width: 280px;
          }
          .convenio{
              min-width: 280px;
          }
          .observacao{
              min-width: 400px;
          }
          .unidade{
              min-width: 280px;
          }

           .filter-control input {
        border: 0.55px !important;


    }
    .filter-control select {
        border: 0.55px solid  !important;
    }
    select.form-control:not([size]):not([multiple]){
      height: 36px;
    }
     
</style>>

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
                      <h4 class="card-title">Todas as matriculas</h4>
                      <p class="card-category">Relação de matriculas</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".SEDE_MATRICULAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>

                  <div class="border_shadow" style="padding: 20px">
                  
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
                        data-url="_ajax/sede/ListMatriculaSede.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                                
                      <thead>
                      <tr>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" style="width: 20px" data-field="id" data-filter-control="input">ID</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="data" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="unidade" data-field="unidade" data-filter-control="input">Unidade</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="totalparcela" data-filter-control="input">Total Parcela</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="status" data-field="status" data-filter-control="input">Status</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="cliente" data-field="cliente" data-filter-control="input"><?= $texto['CLNT'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="funcionario" data-field="funcionario" data-filter-control="input">Funcionario</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor" data-filter-control="input">Valor Total</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="recorrencia" data-field="recorrencia" data-filter-control="input">Recorrência</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="observacao" data-field="observacao" data-filter-control="input"><?= $texto['OBSi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="valore" data-filter-control="input">Valor Entrada</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="forma" data-field="forma" data-filter-control="input">Forma de Parcelamento</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="convenio" data-field="convenio" data-filter-control="input">Convênio</th>
                          <th class="acoes headcol" data-field="acoes"><span style="";> <?= $texto['Act'] ?></span> 

                      </tr>
                      </thead>
                  </table>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= SEDE_MATRICULAS ?>
  </div>
  