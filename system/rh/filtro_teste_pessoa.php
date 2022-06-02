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
      .responsavel{
              min-width: 300px;
          }
          .tipo{
              min-width: 300px;
          }
          .obs{
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
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if($Id){
?>
<div class="content">

  <div class="col-lg-12 col-md-12">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                     <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title">Todos os teste de nível</h4>
                      <p class="card-category">Relação de testes</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RH_TESTE_PESSOAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                          <a href="<?= BASE ?>/painel.php?exe=rh/cadastro_teste_pessoa&id=<?= $Id ?>" class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                          <?php
                      }
                      ?>
                      <div class="clearfix"></div>
                  </div>

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
                          data-url="_ajax/rh/ListTestePessoa.ajax.php?action=list&id=<?= $Id ?>"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="responsavel" data-field="responsavel" data-filter-control="input">Responsável</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="tipo" data-field="tipo" data-filter-control="input">Tipo de Teste</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="data" data-filter-control="input">Data Prevista</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="datar" data-filter-control="input">Data Realizado</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="horario" data-filter-control="input">Horário</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="duracao" data-filter-control="input">Duração</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="situacao" data-filter-control="input">Situação</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="curso" data-filter-control="input">Curso-Estágio</th>
                          <th  data-filter-control-placeholder="⌕" data-sortable="true" class="obs" data-field="observacao" data-filter-control="input"><?= $texto['OBSi'] ?></th>
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
      ID FUNCIONALIDADE: <?= RH_TESTE_PESSOAS ?>
  </div>
<?php
} else {
  die("Erro");
}
?>