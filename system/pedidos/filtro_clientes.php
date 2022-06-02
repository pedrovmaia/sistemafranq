<?php
if (empty($Read)):
    $Read = new Read;
endif;
$Delete = new Delete;
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
        margin-right:120px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 120px;
    }
    .nome{
        min-width: 280px;
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
                         <a href="<?= BASE ?>/painel.php?exe=pedidos/home" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></a>
                      </div>
                      <div class="col-md-10 text-center">
                          <h4 class="card-title"><?= $texto['AllCLNTTSS'] ?></h4>
                          <p class="card-category"><?= $texto['RelCLNTTSS'] ?></p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDIDOS_CLIENTES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                           class="btn btn-primary pull-right"><?= $texto['PSQRD'] ?></button>
                        <a href="<?= BASE ?>/painel.php?exe=pedidos/cadastro_clientes"
                           class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>

                <div class="border_shadow" style="padding: 20px">
                <table  class="table table-hover display"
                        id="table-clientes"
                        data-toolbar="#toolbar"
                        data-locale="pt-BR"
                        data-show-export="true"
                        data-filter-control="true"
                        data-filter-show-clear="true"
                        data-show-toggle="true"
                        data-show-fullscreen="true"
                        data-show-columns="true"
                        data-minimum-count-columns="2"
                        data-url="_ajax/pedido/ListClientes.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead>
                    <tr>
                        <th data-field="id" data-filter-control="input">ID</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="e-mail" data-filter-control="input">E-mail</th>
                         <th class="acoes headcol" data-field="acoes"><span style="margin-left: 30px";> <?= $texto['Act'] ?></span></th>
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
        ID FUNCIONALIDADE: <?= PEDIDOS_CLIENTES ?>
    </div>

<div id="getCodeModal" class="modal fade in" >
  <div class="modal-dialog modal-confirm">
      <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
          <div class="modal-header" style=" border-bottom: none">
              <h4 class="card-title  text-center"><?= $texto['LOCALCLNTS'] ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body text-center">
              <div class="border_shadow" style="background-color: #fff; padding: 20px">
                  <table  class="table table-hover display"
                          id="table_modal_alunos_rede"
                          data-toolbar="#table"
                          data-locale="pt-BR"
                          data-filter-control="true"
                          data-minimum-count-columns="2"
                          data-url="_ajax/lookups/ListClientes.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="nome"
                          data-toggle="table"
                          data-select-item-name="nome"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-radio="true"></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                      </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>