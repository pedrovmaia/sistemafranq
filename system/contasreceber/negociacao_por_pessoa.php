<?php
if (empty($Read)):
  $Read = new Read;
endif;
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                      <h4 class="card-title">Todos os titulos a receber</h4>
                      <p class="card-category">Relação de titulos a receber</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_TITULOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>

                  <div class="row">
                      <div class="col-lg-6 col-md-12">
                          <div class="card">
                              <div class="card-header card-header-primary">
                                  <h4 class="card-title">Parcelas a receber</h4>
                                  <p class="card-category">Relação de parcelas a receber</p>
                              </div>
                              <div class="card-body table-responsive">

                                  <table class="table table-hover display"
                                         id="table"
                                         data-toolbar="#toolbar"
                                         data-locale="pt-BR"
                                         data-show-export="false"
                                         data-filter-control="true"
                                         data-filter-show-clear="false"
                                         data-show-toggle="false"
                                         data-show-fullscreen="false"
                                         data-show-columns="false"
                                         data-click-to-select="true"
                                         data-minimum-count-columns="2"
                                         data-url="_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list_negociacao&pessoa_id=<?= $Id ?>"
                                         data-pagination="true"
                                         data-id-field="id"
                                         data-buttons-class="primary">
                                      <thead>
                                      <tr>
                                          <th data-field="state" data-checkbox="true"></th>
                                          <th data-field="id" data-filter-control="input">ID</th>
                                          <th data-field="vencimento" data-filter-control="input">Vencimento</th>
                                          <th data-field="parcela" data-filter-control="input">Parcela</th>
                                          <th data-field="valor" data-filter-control="input">Valor</th>
                                      </tr>
                                      </thead>
                                  </table>
                              </div>
                              <div class="row">
                                  <div class="col-md-12 mb-1">
                                      <input type="text" placeholder="Observação da negociação" name="observacao_negociacao" class="form-control observacao_negociacao"/>
                                  </div>
                                  <div class="col-md-6">
                                      <input type="number" min="0" placeholder="Quantidade de parcelas da negociação" name="parcelas_negociacao" class="form-control qtd_parcelas_negociacao"/>
                                  </div>
                                  <div class="col-md-6">
                                      <select name="motivo_negociacao" class="form-control motivo_negociacao">
                                          <option value="" selected disabled>Selecione um motivo de negociação</option>
                                          <?php
                                          $Read->ExeRead("sys_motivo_negociacao", "WHERE motivo_negociacao_status = 0");
                                          if($Read->getResult()) {
                                              foreach ($Read->getResult() as $Motivo) {
                                                  echo "<option value='{$Motivo['motivo_negociacao_id']}'>{$Motivo['motivo_negociacao_nome']}</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <button type="button" class="btn btn-primary j_click_renegociacao_parcela">Renegociar parcelas selecionadas <span class="caret"></span><div class="ripple-container"></div></button>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-12">
                          <div class="card">
                              <div class="card-header card-header-primary">
                                  <h4 class="card-title">Parcelas a negociar</h4>
                                  <p class="card-category">Relação de parcelas a negociar</p>
                              </div>
                              <div class="card-body table-responsive">
                                  <div id="total"></div>
                                  <div class="append_itens_renegociacao"></div>
                              </div>
                              <button type="button" class="btn btn-primary j_click_confirmar_renegociacao_parcela">Confirmar <span class="caret"></span><div class="ripple-container"></div></button>
                          </div>
                      </div>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= CONTASRECEBER_TITULOS ?>
  </div>
