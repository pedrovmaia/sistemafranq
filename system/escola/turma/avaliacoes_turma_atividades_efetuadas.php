<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
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
                                <h4 class="card-title">VER ATIVIDADES DA TURMA X ATIVIDADES EFETUADAS</h4>
                                <p class="card-category">Exibição de Atividades Da Turma X Atividades Efetuadas</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_CURSO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }

                $Read->FullRead("SELECT * FROM sys_acompanhamento_aula_materias AS a WHERE a.projeto_id = :id", "id={$Id}");
                $Materias_Realizadas = $Read->getResult();
                $Total_Materias_Realizadas = $Read->getRowCount();

                $Read->FullRead("SELECT p.materias FROM sys_planejamento AS p WHERE p.materias != '' AND p.planejamento_projeto_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $TotalARealizar = $Read->getRowCount();
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">
                                            <?php
                                            $total = $TotalARealizar;
                                            $parte = $Total_Materias_Realizadas;
                                            $x= $parte*100/$total;
                                            $x=substr($x,0,strpos($x,'.')+3);
                                            ?>
                                            <?= $Total_Materias_Realizadas ?> de <?= $TotalARealizar ?> matérias realizadas

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $x ?>%" aria-valuenow="<?= $Total_Materias_Realizadas ?>" aria-valuemin="0" aria-valuemax="<?= $TotalARealizar ?>"></div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="card">
                                                            <div class="card-header card-header-primary">
                                                                <h4 class="card-title">ATIVIDADES DA TURMA</h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <th><?= $texto['NomeMi'] ?></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    foreach ($Read->getResult() as $Materia){
                                                                        $Materias = explode(",", $Materia['materias']);
                                                                        for($i = 0; $i < count($Materias); $i++){
                                                                            $Read->FullRead("SELECT materias_aula_nome FROM sys_materias_aula WHERE materias_aula_status = 0 AND materias_aula_id = :id", "id={$Materias[$i]}");
                                                                            if($Read->getResult()) {
                                                                                foreach ($Read->getResult() as $Itens) {
                                                                                    ?>
                                                                                    <tr class="table">
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['materias_aula_nome'] ?>">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="card">
                                                            <div class="card-header card-header-primary">
                                                                <h4 class="card-title">ATIVIDADES EFETUADAS</h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                    <th><?= $texto['NomeMi'] ?></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    if($Materias_Realizadas) {
                                                                        foreach ($Materias_Realizadas as $Materias) {
                                                                            $Read->FullRead("SELECT materias_aula_nome FROM sys_materias_aula WHERE materias_aula_status = 0 AND materias_aula_id = :id", "id={$Materias['materia_id']}");
                                                                            if($Read->getResult()) {
                                                                                foreach ($Read->getResult() as $Itens) {
                                                                                    ?>
                                                                                    <tr class="table">
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['materias_aula_nome'] ?>">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr class="table">
                                                                            <td>Nenhuma matéria realizada</td><td></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                else:
                    echo "<b>OPPSS</b>, não existem históricos de Atividades Da Turma X Atividades Efetuadas!";
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
    </div>
</div>