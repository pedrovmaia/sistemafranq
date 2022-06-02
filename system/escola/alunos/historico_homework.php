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
                                <h4 class="card-title">VER HOMEWORKS</h4>
                                <p class="card-category">Exibição de Homeworks Do Aluno</p>
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
                            $Read->FullRead("SELECT * FROM sys_acompanhamento_aula_homework AS a WHERE a.pessoa_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Total_Avaliacoes_Realizadas = $Read->getRowCount();
                                ?>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="profile">
                                                        <?= $Total_Avaliacoes_Realizadas ?> homeworks realizadas
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="card">
                                                                        <div class="card-header card-header-primary">
                                                                            <h4 class="card-title">HOMEWORKS EFETUADAS</h4>
                                                                        </div>
                                                                        <div class="card-body table-responsive">
                                                                            <table class="table table-hover">
                                                                                <thead>
                                                                                <th>Código</th>
                                                                                <th>Nome</th>
                                                                                <th>Nota</th>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                if($Read->getResult()) {
                                                                                    foreach ($Read->getResult() as $Atividades) {
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
                                                                                                    <td>
                                                                                                        <input readonly type="text" class="form-control" value="<?= $Atividades['nota'] ?>">
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            ?>
                                                                                            <tr class="table">
                                                                                                <td>Homework não encontrada</td><td></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <tr class="table">
                                                                                        <td>Nenhuma homework realizada</td><td></td>
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
                                echo "<b>OPPSS</b>, não existem históricos de Avaliações Do Aluno!";
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