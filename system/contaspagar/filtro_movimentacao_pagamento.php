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
<div class="content">

  <div id="loader" class="loader"></div>

  <div class="col-lg-12 col-md-12" style="display:none" id="tudo_page">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                       <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title"><?= $texto['AllMOVPGMT'] ?></h4>
                      <p class="card-category"><?= $texto['RelMOVPGMTi'] ?></p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASPAGAR_MOVIMENTACAO_PAGAMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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

                             <?php if(isset($_SESSION['caixaSYS']))
                                    {?> 
                              <a href="<?= BASE ?>/painel.php?exe=contaspagar/cadastro_movimentacao_pagamento" class="btn btn-primary pull-right"><?= $texto['ADDNEWPAG'] ?></a>

                              <?php
                              }
                              ?>


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
                          data-url="_ajax/financeiro/ListMovimentacaoPagamento.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input"><?= $texto['dsc'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="fornecedor" data-filter-control="input"><?= $texto['FORN'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>
                          <th data-field="acoes"><?= $texto['Act'] ?></th>
                      </tr>
                      </thead>
                  </table>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= CONTASPAGAR_MOVIMENTACAO_PAGAMENTO ?>
  </div>
