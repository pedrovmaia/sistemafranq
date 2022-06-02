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

  <div class="col-lg-12 col-md-12">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                    <a href="<?= BASE ?>/painel.php?exe=escola/home" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></a>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title"><?= $texto['AllTrnsff'] ?></h4>
                      <p class="card-category"><?= $texto['RelTrnsff'] ?></p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TRANSFERENCIA_ENVOLVIDOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>

                  <div class="btn-group">

                      <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['INFOS'] ?><span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu">
                              <li><a class="j_click_reposicao_aluno" href="#"><?= $texto['REPAUL'] ?></a></li>
                              <li><a class="j_click_transferir_aluno" href="#"><?= $texto['TRANSALN'] ?></a></li>
                          </ul>
                      </div>

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
                          data-url="_ajax/escola/ListTransferenciaEnvolvidos.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="id"
                          data-click-to-select="true"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-field="state" data-checkbox="true"></th>
                          <th data-field="id" data-filter-control="input">ID</th>
                          <th data-field="datao" data-filter-control="input"><?= $texto['DTORGM'] ?></th>
                          <th data-field="datad" data-filter-control="input"><?= $texto['DTDEST'] ?></th>
                          <th data-field="aluno" data-filter-control="input"><?= $texto['ALNSE'] ?></th>
                          <th data-field="funcionaro_origem" data-filter-control="input"><?= $texto['FNCORGM'] ?></th>
                          <th data-field="funcionario_destino" data-filter-control="input"><?= $texto['FNCDEST'] ?></th>
                          <th data-field="turma_origem" data-filter-control="input"><?= $texto['TRMORGM'] ?></th>
                          <th data-field="turma_destino" data-filter-control="input"><?= $texto['TRMDEST'] ?></th>
                          <th data-field="status" data-filter-control="input">Status</th>
                      </tr>
                      </thead>
                  </table>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TRANSFERENCIA_ENVOLVIDOS ?>
  </div>
</div>

<div class="showcase hide-print" id="getCodeModalTurmaTransferencia">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_turma_transferencia"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListTurmas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-click-to-select="true"
                            data-buttons-class="primary">
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

<div class="modal fade" id="modal_transferencia_aluno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="heading lead">TRANFERIR ALUNO</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form_transferir_aluno_turma">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">ALUNO</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input readonly id="txt_aluno" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">TURMA</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input readonly autocomplete="off" data-toggle="modal" data-target="#getCodeModalTurmaTransferencia" placeholder="Clique e selecione a turma" id="txt_turma" type="text"   class="form-control">
                                    <div class="input-group-prepend">
                                        <div data-remove1="txt_turma" data-remove2="txt_id_turma" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                    </div>
                                </div>
                                <input name="txt_id_turma" id="txt_id_turma" type="hidden">
                                <input name="solicitacao_id" id="solicitacao_id" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="action" value="transferirAluno"/>
                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>