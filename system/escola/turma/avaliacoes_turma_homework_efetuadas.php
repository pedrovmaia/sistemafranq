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
                                <h4 class="card-title">VER HOMEWORKS DA TURMA X HOMEWORKS EFETUADAS</h4>
                                <p class="card-category">Exibição de Homeworks Da Turma X Homeworks Efetuadas</p>
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
                $Read->FullRead("SELECT * FROM sys_acompanhamento_aula_homework AS a WHERE a.projeto_id = :id", "id={$Id}");
                $HomeWork_Realizadas = $Read->getResult();
                $Total_HomeWork_Realizadas = $Read->getRowCount();

                $Read->FullRead("SELECT p.homework FROM sys_planejamento AS p WHERE p.homework != '' AND p.planejamento_projeto_id = :id", "id={$Id}");
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
                                            $parte = $Total_HomeWork_Realizadas;
                                            if($total > 0){
                                              $x= $parte*100/$total;
                                            } else {
                                              $x = 0;
                                            }
                                            $x=substr($x,0,strpos($x,'.')+3);
                                            ?>
                                            <?= $Total_HomeWork_Realizadas ?> de <?= $TotalARealizar ?> homeworks realizadas

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $x ?>%" aria-valuenow="<?= $Total_HomeWork_Realizadas ?>" aria-valuemin="0" aria-valuemax="<?= $TotalARealizar ?>"></div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="card">
                                                            <div class="card-header card-header-primary">
                                                                <h4 class="card-title">HOMEWORKS DA TURMA</h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                        <th><?= $texto['Code'] ?></th>
                                                                        <th><?= $texto['NomeMi'] ?></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php var_dump($Read->getResult());
                                                                    foreach ($Read->getResult() as $Atividade){
                                                                        $Atividades = explode(",", $Atividade['homework']);
                                                                        for($i = 0; $i < count($Atividades); $i++){
                                                                            $Read->FullRead("SELECT homework_codigo, homework_nome FROM sys_escola_homework WHERE homework_status = 0 AND homework_id = :id", "id={$Atividades[$i]}");
                                                                            if($Read->getResult()) {
                                                                                foreach ($Read->getResult() as $Itens) {
                                                                                    ?>
                                                                                    <tr class="table_<?= $i ?>">
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['homework_codigo'] ?>">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['homework_nome'] ?>">
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
                                                                <h4 class="card-title">HOMEWORKS EFETUADAS</h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                    <th><?= $texto['Code'] ?></th>
                                                                    <th><?= $texto['NomeMi'] ?></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    if($HomeWork_Realizadas) {
                                                                        foreach ($HomeWork_Realizadas as $Atividades) {
                                                                            $Read->FullRead("SELECT homework_codigo, homework_nome FROM sys_escola_homework WHERE homework_status = 0 AND homework_id = :id", "id={$Atividades['homework_id']}");
                                                                            if($Read->getResult()) {
                                                                                foreach ($Read->getResult() as $Itens) {
                                                                                    ?>
                                                                                    <tr class="table">
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['homework_codigo'] ?>">
                                                                                        </td>
                                                                                        <td>
                                                                                            <input readonly type="text" class="form-control" value="<?= $Itens['homework_nome'] ?>">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr class="table">
                                                                            <td>Nenhuma avaliação realizada</td><td></td>
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
                    echo "<b>OPPSS</b>, não existem históricos de Homeworks Da Turma X Homeworks Efetuadas!";
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