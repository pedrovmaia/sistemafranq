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
    .nome{
        min-width: 350px;
    }
    .codigo
    {
      min-width: 160px;
    }
    .professor{
        min-width: 280px;
    }
    .situacao{
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

<div id="loader" class="loader"></div>

<div class="content">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-md-1">
                        <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                    </div>
                    <div class="col-md-10 text-center">
                        <h4 class="card-title"><?= $texto['AllTRMS'] ?></h4>
                        <p class="card-category"><?= $texto['RelTRMS'] ?></p>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TURMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                if($Read->getResult()){
                    $permissao = $Read->getResult()[0];
                    $_SESSION['permissao'] = $permissao;
                } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                if($permissao["ler"] == 1){
                    ?>

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
                                data-url="_ajax/escola/ListTurmasDiario.ajax.php?action=list"
                                data-pagination="true"
                                data-id-field="id"
                                data-buttons-class="primary">

                            <thead>
                            <tr>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" style="width: 20px" data-field="id" data-filter-control="input">ID</th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" class="codigo" data-field="codigo" data-filter-control="input"><?= $texto['Code'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="curso" data-filter-control="input"><?= $texto['CRSO'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="modalidade" data-filter-control="input"><?= $texto['Modami'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" class="professor" data-field="professor" data-filter-control="input"><?= $texto['Prof'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="vagas" data-filter-control="input"><?= $texto['NVAGAS'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                                <th data-filter-control-placeholder="⌕" data-sortable="true" class="situacao" data-field="situacao" data-filter-control="input"><?= $texto['SITACi'] ?></th>
                                <th class="acoes headcol" data-field="acoes"><span><?= $texto['TSEE'] ?></span></th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
    </div>