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
        overflow-x:scroll;-  
        overflow-y:visible;
        padding-bottom:1px;
    }

   .nome{
              min-width: 280px;
          }
          .turma{
              min-width: 300px;
          }
           .descricao{
              min-width: 400px;
          }
          .data{
              min-width: 120px;
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
                      <h4 class="card-title">Todas as reposições</h4>
                      <p class="card-category">Relação de reposições</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_REPOSICAO_AULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>
                  <div id="toolbar">
                      <br/>
                      <?php
                      if($permissao["inserir"] == 1) {
                          ?>
                          <?php
                      }
                      ?>
                      <div class="clearfix"></div>
                  </div>

                  <div class="border_shadow" style="padding: 20px">
                    <div >
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
                          data-url="_ajax/relatorios/ListReposicao.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="turma" data-field="turma" data-filter-control="input">Turma</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="data" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="descricao" data-field="descricao" data-filter-control="input"><?= $texto['dsc'] ?></th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="horai" data-filter-control="input">Hora Inicial</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="horaf" data-filter-control="input">Hora Final</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="modalidade" data-filter-control="input">Modalidade</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="atividade" data-filter-control="input">Atividades</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="pago" data-filter-control="input">Pago</th>
                         
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
      ID FUNCIONALIDADE: <?= ESCOLA_REPOSICAO_AULA ?>
  </div>
