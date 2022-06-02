<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id) {
    $Read->ExeRead("sys_projetos", "WHERE projeto_id = :id", "id={$Id}");
    if ($Read->getResult()) {
        $projeto = $Read->getResult()[0];

        $Read->ExeRead("sys_avaliacao_turma", "WHERE avaliacao_turma_turma_id = :id", "id={$Id}");
        if ($Read->getResult()) {
            $Avaliacoes = $Read->getResult();
            $QtdEtapas = $Read->getRowCount();
        } else {
            $Avaliacoes = null;
        }

    } else {
        die("<center><br><br>ERRO!!!</center>");
    }

} else {
    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
    header('Location: painel.php?exe=escola/turma/filtro_turma');
    exit;
}
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
                                <h4 class="card-title">AVALIAÇÃO POR TURMA</h4>
                                <p class="card-category"><?= $projeto['projeto_descricao'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TURMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                ?>
            <form class="form_avaliacao_turma">
                <div id="periodicidade" class="border_shadow" style="padding: 15px;">
                    <label class="bmd-label-floating"><strong>Turma</strong></label>
                    <div class="row">

                        <div class="table-responsive">
                            <div style="padding: 15px;">
                            <table class="table table-bordered table-responsive-md table-striped text-center">
                                <tr>
                                 <th class="text-center">Etapa</th>
                                 <th class="text-center">Matéria Inicial</th>
                                 <th class="text-center">Matéria Final</th>
                                 <th class="text-center">Data Inicial</th>
                                 <th class="text-center">Data Final</th>
                                </tr>
                                <?php
                                if($Avaliacoes){
                                    foreach ($Avaliacoes as $Avaliacao) {
                                    $i = 0;
                                        ?>
                                    <tr>
                                        <td class="pt-4-half">
                                            <input type="hidden" name="avaliacao_turma_id_<?= $i ?>" value="<?= $Avaliacao['avaliacao_turma_id']; ?>"/>
                                            <?php
                                            $Read->ExeRead("sys_etapa_produto", "WHERE etapa_produto_id = :id",
                                                "id={$Avaliacao['avaliacao_turma_etapa_id']}");
                                            if ($Read->getResult()) {
                                                ?>
                                                <input type="hidden" name="etapa_produto_id_<?= $i ?>"
                                                       value="<?= $Read->getResult()[0]['etapa_produto_id'] ?>">
                                                <span><?= $Read->getResult()[0]['etapa_produto_nome'] ?></span>
                                                <?php
                                            }
                                            ?>
                                        </td>

                                        <td class="pt-4-half">
                                            <select name='materia_inicio_<?= $i ?>' class="form-control">
                                                <option value="">Selecione uma matéria inicial</option>
                                                <?php
                                                $Read->ExeRead("sys_materias_aula",
                                                    "WHERE materias_aula_status = 0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $MateriaInicial):
                                                        echo "<option " . ($Avaliacao['avaliacao_turma_materia_inicial_id'] == $MateriaInicial['materias_aula_id'] ? "selected='selected'" : '') . " value='{$MateriaInicial['materias_aula_id']}'>{$MateriaInicial['materias_aula_nome'] }</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </td>

                                        <td class="pt-4-half">
                                            <select name='materia_fim_<?= $i ?>' class="form-control">
                                                <option value="">Selecione uma matéria final</option>
                                                <?php
                                                $Read->ExeRead("sys_materias_aula",
                                                    "WHERE materias_aula_status = 0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $MateriaInicial):
                                                        echo "<option " . ($Avaliacao['avaliacao_turma_materia_final_id'] == $MateriaInicial['materias_aula_id'] ? "selected='selected'" : '') . " value='{$MateriaInicial['materias_aula_id'] }'>{$MateriaInicial['materias_aula_nome'] }</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </td>

                                        <td class="pt-4-half">
                                            <input type="date" name="hora_inical_<?= $i ?>"
                                                   placeholder="dd/mm/aaaa"
                                                   class="form-control" value="<?= date('Y-m-d', strtotime($Avaliacao['avaliacao_turma_data_inicial'])) ?>">
                                        </td>

                                        <td class="pt-4-half">
                                            <input type="date" name="hora_final_<?= $i ?>"
                                                   placeholder="dd/mm/aaaa"
                                                   class="form-control" value="<?= date('Y-m-d', strtotime($Avaliacao['avaliacao_turma_data_final'])) ?>">
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    }

                                } else {

                                    $Read->ExeRead("sys_etapa_produto", "WHERE etapa_produto_turma_id = :id",
                                        "id={$Id}");
                                    if ($Read->getResult()) {
                                        $i = 0;
                                        $QtdEtapas = $Read->getRowCount();
                                        foreach ($Read->getResult() as $Etapa) {
                                            ?>
                                            <tr>
                                                <td class="pt-4-half">
                                                    <input type="hidden" name="etapa_produto_id_<?= $i ?>"
                                                           value="<?= $Etapa['etapa_produto_id'] ?>">
                                                    <span><?= $Etapa['etapa_produto_nome'] ?></span>
                                                </td>

                                                <td class="pt-4-half">
                                                    <select name='materia_inicio_<?= $i ?>' class="form-control">
                                                        <option value="">Selecione uma matéria inicial</option>
                                                        <?php
                                                        $Read->ExeRead("sys_materias_aula",
                                                            "WHERE materias_aula_status = 0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $MateriaInicial):
                                                                echo "<option value='{$MateriaInicial['materias_aula_id'] }'>{$MateriaInicial['materias_aula_nome'] }</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </td>

                                                <td class="pt-4-half">
                                                    <select name='materia_fim_<?= $i ?>' class="form-control">
                                                        <option value="">Selecione uma matéria final</option>
                                                        <?php
                                                        $Read->ExeRead("sys_materias_aula",
                                                            "WHERE materias_aula_status = 0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $MateriaInicial):
                                                                echo "<option value='{$MateriaInicial['materias_aula_id'] }'>{$MateriaInicial['materias_aula_nome'] }</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </td>

                                                <td class="pt-4-half">
                                                    <input type="date" name="hora_inical_<?= $i ?>"
                                                           placeholder="dd/mm/aaaa"
                                                           class="form-control">
                                                </td>

                                                <td class="pt-4-half">
                                                    <input type="date" name="hora_final_<?= $i ?>"
                                                           placeholder="dd/mm/aaaa"
                                                           class="form-control">
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        $QtdEtapas = 0;
                                        echo "<tr>Sem resultados</tr>";
                                    }
                                }
                                ?>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="qtdetapas" value="<?= $QtdEtapas ?>"/>
                <input type="hidden" name="action" value="manager"/>
                <input type="hidden" name="turma_id" value="<?= $Id; ?>"/>
                <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                     title="CARREGANDO..."/>
                <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
  </div>
</div>
