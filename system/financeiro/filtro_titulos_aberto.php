<?php
if (empty($Read)):
    $Read = new Read;
endif;
$data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
$data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
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

    .pessoa{
        min-width: 385px;
    }
    .data{
        min-width: 180px;
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
                         <a href="<?= BASE ?>/painel.php?exe=financeiro/home" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></a>
                      </div>
                      <div class="col-md-10 text-center">
                          <h4 class="card-title">Todos os titulos em aberto</h4>
                          <p class="card-category">Relação de titulos em aberto</p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_TITULOS_ATRASO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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

                <div id="botao" class="border_shadow" style="padding: 15px; margin-bottom: 5px">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="texto_trocar"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3">
                            Data Inicial : <input type="date"  name="pessoa_nome" value="<?= date('Y-m-d',$data_incio) ?>" class="form-control data_inicio_busca">
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-3">
                            Data Final :  <input type="date"  name="pessoa_nome"  value="<?= date('Y-m-d',$data_fim) ?>" class="form-control data_fim_busca">
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-3">
                            <span rel="relatorios/ListTitulosAbertos" class="btn btn-primary pull-right mt-4 j_sys_busca_data">PESQUISAR</span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
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
                        data-url="_ajax/relatorios/ListTitulosAbertos.ajax.php?action=list&inicio=<?= date('Y-m-d',$data_incio) ?>&fim=<?= date('Y-m-d',$data_fim) ?>"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead>
                    <tr>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="pessoa" data-field="pessoa" data-filter-control="input"><?= $texto['CLNT'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="datav" data-filter-control="input"><?= $texto['DDVC'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="telefone" data-filter-control="input">Telefone Aluno</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="pessoa" data-field="responsavel" data-filter-control="input">Responsável</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="financeirotelefone" data-filter-control="input">Telefone Responsável</th>
                        <!--<th data-field="datar" data-filter-control="input">Data de Recebimento</th>-->
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="numero" data-filter-control="input"><?= $texto['NUMB'] ?></th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="parcela" data-filter-control="input"><?= $texto['PARC'] ?></th>
                        <!--<th data-field="status" data-filter-control="input">Status</th>-->
                        <th class="acoes headcol" data-field="acoes"><span><?= $texto['Act'] ?></span></th>
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
        ID FUNCIONALIDADE: <?= FINANCEIRO_TITULOS_ATRASO ?>
    </div>