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
                      <h4 class="card-title">Todas as avaliações</h4>
                      <p class="card-category">Relação de avaliações</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_AVALIACOES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                          <a href="<?= BASE ?>/painel.php?exe=escola/admin/cadastro_avaliacao&idestagio=<?= $Id ?>" class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                          <?php
                      }
                      ?>
                      <div class="clearfix"></div>
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
                          data-url="_ajax/escola/ListAvaliacao.ajax.php?action=list&id=<?= $Id ?>"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="codigo" data-filter-control="input">Codigo</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="etapa" data-filter-control="input">Etapa</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="tipo" data-filter-control="input">Tipo de avaliação</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true"data-filter-control-placeholder="⌕" data-sortable="true" data-field="tiponota" data-filter-control="input">Tipo de nota</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true"data-filter-control-placeholder="⌕" data-sortable="true" data-field="formula" data-filter-control="input">Fórmula</th>
                          <th class="acoes" data-field="acoes"><?= $texto['Act'] ?></th>
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
      ID FUNCIONALIDADE: <?= ESCOLA_AVALIACOES ?>
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
</style>
<?php
} else {
  die("Erro");
}
?>