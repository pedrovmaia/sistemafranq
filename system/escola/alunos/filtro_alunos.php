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
        margin-right:101px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 100px;
    }
    .nome{
        min-width: 380px;
    }
    .pedagogico{
        min-width: 380px;
    }
    .email{
        min-width: 280px;
    }
    .financeiro{
        min-width: 380px;
    }
    .phone{
        min-width: 150px;
    }
    .turma{
        min-width: 200px;
    }
    .cpf, .rg{
        min-width: 150px;
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
                          <h4 class="card-title"><?= $texto['AllALNi'] ?></h4>
                          <p class="card-category"><?= $texto['AllALNCAD'] ?></p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ALUNOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                  if($Read->getResult()){
                      $permissao = $Read->getResult()[0];
                      $_SESSION['permissao'] = $permissao;
                  } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                  }


                $_SESSION['permissao'] = $permissao;
                if($permissao["ler"] == 1){
                ?>

                <div id="toolbar">
                    <br/>
                    <?php
                    if($permissao["inserir"] == 1) {
                        ?>
                        <button data-toggle="modal" data-target="#getCodeModal"
                           class="btn btn-primary pull-right"><?= $texto['PESQRED'] ?></button>
                        <a href="<?= BASE ?>/painel.php?exe=escola/alunos/cadastro_alunos"
                           class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>

                <div class="border_shadow" style="padding: 20px">
                <table  class="table table-hover display table-sm"
                        id="table-aluno"
                        data-toolbar="#toolbar"
                        data-locale="pt-BR"
                        data-show-export="true"
                        data-filter-control="true"
                        data-filter-show-clear="true"
                        data-show-toggle="true"
                        data-show-fullscreen="true"
                        data-show-columns="true"
                        data-minimum-count-columns="2"
                        data-url="_ajax/escola/ListAlunos.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead >
                    <tr>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="idade" data-filter-control="input">Idade</th>
                        <th class="phone" data-filter-control-placeholder="⌕" data-sortable="true" class="telefone" data-field="phone" data-filter-control="input"><?= $texto['TELF'] ?></th>
                      <th class="turma" data-filter-control-placeholder="⌕" data-sortable="true" class="turma" data-field="turma" data-filter-control="input">Turma</th>
                      <th class="cpf" data-filter-control-placeholder="⌕" data-sortable="true" data-field="cpf" data-filter-control="input">CPF</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="pedagogico" data-field="pedagogico" data-filter-control="input"><?= $texto['RESPPD'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="financeiro" data-field="financeiro" data-filter-control="input"><?= $texto['RESPFN'] ?></th>
                         <th class="acoes headcol" data-field="acoes"><span style="margin-left: 10px"> <?= $texto['Act'] ?></span></th>
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
      </div>
        ID FUNCIONALIDADE: <?= ESCOLA_ALUNOS ?>
    </div>


<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_alunos_rede"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
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
                            <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
