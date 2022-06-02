<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
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
                                <h4 class="card-title">VER GRADE DE HORÁRIOS</h4>
                                <p class="card-category">Exibição de horários</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TURMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
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
                                    data-url="_ajax/escola/ListPlanejamento.ajax.php?action=list&projeto_id=<?= $Id; ?>"
                                    data-pagination="true"
                                    data-id-field="id"
                                    data-page-size="30"
                                    data-buttons-class="primary">
                                <thead>
                                <tr>
                                    <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                                    <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="descricao" data-filter-control="input">Descrição</th>
                                    <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="inicio">Início</th>
                                    <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="fim">Término</th>
                                    <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="status">Status</th>
                                    <th data-field="acoes"></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    <?php
            else:
                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                header('Location: painel.php?exe=escola/turma/cadastro_turma');
                exit;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
  </div>
</div>
