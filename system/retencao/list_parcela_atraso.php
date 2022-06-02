<?php
if (empty($Read)):
  $Read = new Read;
endif;
$Delete = new Delete;
date_default_timezone_set('America/Sao_Paulo');

$data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
$data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
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
    .qtd{ 
      min-width: 100px;
    }
    .nome{
              min-width: 300px;
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
     
</style>
<div class="content">

  <div class="col-lg-12 col-md-12">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                      <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title">Todos os alunos com parcelas em atraso</h4>
                      <p class="card-category">Relação de alunos</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RETENCAO_PARCELA_ATRASO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                        <div class="col-md-12">
                            <p class="texto_trocar_parcela"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3">
                            Quantidade de Parcelas Inicial : <input type="number"  name="inicio_parcela" value="" class="form-control inicio_parcela">
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-3">
                            Quantidade de Parcelas Final :  <input type="number"  name="fim_parcela"  value="" class="form-control fim_parcela">
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-3">
                            <span rel="retencao/ListParcelaAtraso" class="btn btn-primary pull-right mt-4 j_sys_busca_parcelas_atraso">PESQUISAR</span>
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
                          data-url="_ajax/retencao/ListParcelaAtraso.ajax.php?action=list&inicio=<?= date('Y-m-d',$data_incio) ?>&fim=<?= date('Y-m-d',$data_fim) ?>"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th  data-filter-control-placeholder="⌕" class="qtd" data-sortable="true" data-field="qtd" data-filter-control="input">Qtd de Parcelas</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor_total" data-filter-control="input">Valor Total</th>                   
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="telefone" data-filter-control="input"><?= $texto['TELF'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome_res" data-filter-control="input">Nome responsável</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="telefone_res" data-filter-control="input">Telefone responsável</th>
                           <th class="acoes headcol" data-field="acoes"><span style="";> <?= $texto['Act'] ?></span>
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
      ID FUNCIONALIDADE: <?= RETENCAO_PARCELA_ATRASO ?>
  </div>