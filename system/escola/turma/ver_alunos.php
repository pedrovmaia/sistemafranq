<?php
if (empty($Read)):
    $Read = new Read;
endif;

$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_projetos", "WHERE projeto_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $Projeto = $Read->getResult()[0];
    else:
        die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
    endif;
else:
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
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
    <input type="hidden" class="turma_id" value="<?= $Id ?>">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-md-1">
                     <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                    </div>
                    <div class="col-md-10 text-center">
                        <h4 class="card-title">Alunos da <?= $Projeto['projeto_descricao'] ?></h4>
                        <p class="card-category">Relação de alunos da turma de sua escola</p>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="btn-group">

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Alteração <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="j_click_cancelar_curso" href="#">Cancelar Curso</a></li>
                            <li><a class="j_click_trancar_curso" href="#">Trancar Curso</a></li>
                            <li><a class="j_click_transferir_curso" href="#">Transferência de Curso</a></li>
                        </ul>
                    </div>

                </div>

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
                    <div id="toolbar">
                        <div class="clearfix"></div>
                    </div>

                    <div class="border_shadow" style="padding: 20px">
                        <table  class="table table-hover display table-striped table-sm"
                                id="table"
                                data-height="500"
                                data-toolbar="#toolbar"
                                data-locale="pt-BR"
                                data-show-export="true"
                                data-filter-control="true"
                                data-filter-show-clear="true"
                                data-show-toggle="true"
                                data-show-fullscreen="true"
                                data-show-columns="true"
                                data-click-to-select="true"
                                data-minimum-count-columns="2"
                                data-url="_ajax/escola/ListAlunosTurma.ajax.php?action=list&id=<?= $Id ?>"
                                data-pagination="true"
                                data-id-field="id"
                                data-buttons-class="primary">
                            <thead>
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th style="width: 20px" data-field="id" data-filter-control="input">ID</th>
                                <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                                <th data-field="email" data-filter-control="input">E-mail</th>
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
        ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
    </div>