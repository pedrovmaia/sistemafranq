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
    .descricao{
        min-width: 400px;
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
        height: 20px !important;
    }
</style>


<div class="content">

<div class="col-lg-12 col-md-12">
  <div class="card">
      <div class="card-header card-header-primary">
          <div class="row">
              <div class="col-md-1">
                <a href="<?= BASE ?>/painel.php?exe=escola/home" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></a>
              </div>
              <div class="col-md-10 text-center">
                  <h4 class="card-title"><?= $texto['AllPSLE'] ?></h4>
                  <p class="card-category"><?= $texto['RelPSLE'] ?></p>
              </div>
              <div class="col-md-1">
              </div>
          </div>
      </div>
      <div class="card-body">
          <?php
          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_LISTA_ESPERA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                  <div class="clearfix"></div>
              </div>
              <input type="hidden" class="id_lista_espera_projeto">
              <div class="border_shadow" style="padding: 20px">
              <table  class="table table-hover display table-striped table-sm"
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
                      data-url="_ajax/escola/ListListaEspera.ajax.php?action=list"
                      data-pagination="true"
                      data-id-field="id"
                      data-buttons-class="primary">
                  <thead>
                  <tr>
                      <th data-filter-control-placeholder="⌕" data-sortable="true"  data-field="id" data-filter-control="input">ID</th>
                      <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                      <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="periodo" data-filter-control="input"><?= $texto['PERIOD'] ?></th>
                      <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="dia" data-filter-control="input"><?= $texto['DASEM'] ?></th>
                      <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="hora" data-filter-control="input"><?= $texto['HORAR'] ?></th>
                      <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="telefone" data-filter-control="input"><?= $texto['CONTACT'] ?></th>
                      <th class="acoes headcol" data-field="acoes"><span> <?= $texto['Act'] ?></span></th>
                  </tr>
                  </thead>
              </table>
              </div>
              <?php
          }
          ?>
      </div>
  </div>
</div>
  ID FUNCIONALIDADE: <?= ESCOLA_LISTA_ESPERA ?>
</div>


<div class="showcase hide-print" id="modal_escolherTurma_listaEspera">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_turma_espera"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListTurmas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="professor" data-filter-control="input"><?= $texto['Prof'] ?></th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>