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
        margin-right:120px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 120px;
    }
    .titulo{
        min-width: 350px;
    }
    .subtitulo
    {
      min-width: 250px;
    }
    .tipo{
        min-width: 280px;
    }
    .classificao{
        min-width: 200px;
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
                     <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title"><?= $texto['AllACRV'] ?></h4>
                      <p class="card-category"><?= $texto['RelACRV'] ?></p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>
          <div class="card-body">
              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ACERVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }

              if($permissao["ler"] == 1){
                  ?>             
                     <?php
                      if($permissao["inserir"] == 1) {
                          ?>
                          <a href="<?= BASE ?>/painel.php?exe=biblioteca/cadastro_acervo" class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
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
                          data-url="_ajax/franqueador/ListAcervo.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-field="id" data-filter-control="input">ID</th>
                          <th class="titulo" data-field="titulo" data-filter-control="input"><?= $texto['TITEi'] ?></th>
                          <th class="subtitulo" data-field="subtitulo" data-filter-control="input"><?= $texto['SUBTITi'] ?></th>
                          <th class="tipo" data-field="tipoobra" data-filter-control="input"><?= $texto['TYPOBRASi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="editora" data-filter-control="input"><?= $Texto['EDITRAi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="volume" data-filter-control="input"><?= $texto['VOLUMIi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="numeropagina" data-filter-control="input"><?= $texto['NUMPAGSi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="edicao" data-filter-control="input"><?= $texto['EDITSSi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="anoedicao" data-filter-control="input"><?= $texto['YEAREDTi'] ?></th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="isbn" data-filter-control="input">ISBN</th>
                          <th data-filter-control-placeholder="???" data-sortable="true" data-field="palavrachave" data-filter-control="input"><?= $texto['KEYWOR'] ?></th>
                          <th class="classificao" data-field="classificacao" data-filter-control="input"><?= $Texto['CLASLITi'] ?></th>
                          <th class="acoes headcol" data-field="acoes"><span style="margin-left: 30px";> <?= $texto['Act'] ?></span>
                      </tr>
                      </thead>
                  </table>
                </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= FRANQUEADOR_ACERVO ?>
  </div>
