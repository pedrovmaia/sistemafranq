<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$idAluno = filter_input(INPUT_GET, 'idAluno', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(!$idAluno){
    die("Erro!!! Tente novamente.");
}
?>
<style>
    .pt-3-half {
        padding-top: 1.4rem;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-1">
                               <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>                            </div>
                            <div class="col-md-10 text-center">
                                <h4 class="card-title">CADASTRO DE INDICAÇÃO</h4>
                                <p class="card-category">Cadastre os alunos de sua escola</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_INDICACAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                                ?>
                                <form class="form_indicacao_aluno">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                        <div class="row">
                                            <div class="col-md-12">
                                        <span class="table-add-indicacao-aluno float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                            </div>
                                            <div class="table-responsive">

                                                <div style="padding: 15px;">
                                                    <table class="table table-bordered table-responsive-md table-striped text-center table_indicacao_aluno">
                                                        <tr>
                                                            <th class="text-center"><?= $texto['NomeMi'] ?></th>
                                                            <th class="text-center"><?= $texto['TELF'] ?></th>
                                                            <th class="text-center">E-mail</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        <?php
                                                            $Read->ExeRead("sys_indicacao", "WHERE pessoa_id = :id", "id={$Id}");
                                                            if($Read->getResult()){
                                                                $QTDIndicacoes = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Indicacao){
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-3-half">
                                                                            <input type="hidden" name="indic_id_<?= $i ?>"
                                                                                   value="<?= $Indicacao['id'] ?>">
                                                                            <input type="text" name="nome_<?= $i ?>" placeholder="Digite o nome" class="form-control" value="<?= $Indicacao['nome'] ?>">
                                                                        </td>
                                                                        <td class="pt-3-half">
                                                                            <input type="tel" name="telefone_<?= $i ?>"
                                                                                   placeholder="(00) 0000-0000"
                                                                                   class="form-control formPhone"
                                                                                   value="<?= $Indicacao['telefone'] ?>">
                                                                        </td>
                                                                        <td class="pt-3-half">
                                                                            <input type="email" name="email_<?= $i ?>" placeholder="E-mail"
                                                                                   class="form-control"
                                                                                   value="<?= $Indicacao['email'] ?>">
                                                                        </td>
                                                                        <td>
                                                                            <span rel="<?= $Indicacao['id'] ?>" class="table-remove">
                                                                                <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                                    <i class="material-icons">clear</i>
                                                                                </button>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                $QTDIndicacoes = 0;
                                                            }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="IndicacaoEditar"/>
                                    <input type="hidden" class="quantidade_indicacao_aluno" name="quantidade_indicacao_aluno" value="<?= $QTDIndicacoes ?>"/>
                                    <input type="hidden" name="pessoa_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                    <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                         title="CARREGANDO..."/>
                                    <div class="clearfix"></div>
                                </form>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=escola/alunos/cadastro_alunos');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_INDICACAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_indicacao_aluno">

                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>DADOS INDICAÇÃO</strong></label>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add-indicacao-aluno float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                                <table class="table table-bordered table-responsive-md table-striped text-center table_indicacao_aluno">
                                                    <tr>
                                                        <th class="text-center"><?= $texto['NomeMi'] ?></th>
                                                        <th class="text-center"><?= $texto['TELF'] ?></th>
                                                        <th class="text-center">E-mail</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="pt-3-half">
                                                            <input type="text" name="nome_0" placeholder="Digite o nome" class="form-control" value="">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <input type="tel" name="telefone_0"
                                                                   placeholder="(00) 0000-0000"
                                                                   class="form-control formPhone"
                                                                   value="">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <input type="email" name="email_0" placeholder="E-mail"
                                                                   class="form-control"
                                                                   value="">
                                                        </td>
                                                        <td>
                                                            <span class="table-remove">
                                                                <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                    <i class="material-icons">clear</i>
                                                                </button>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br/>

                                <input type="hidden" name="action" value="IndicacaoAdd"/>
                                <input type="hidden" class="quantidade_indicacao_aluno" name="quantidade_indicacao_aluno" value="1"/>
                                <input type="hidden" name="pessoa_id" value="<?= $idAluno ?>"/>
                                <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                     title="CARREGANDO..."/>
                                <div class="clearfix"></div>
                            </form>

                        <?php
                        endif;
                        ?>

                    </div>
                </div>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= CRM_INDICACAO ?>
    </div>
</div>