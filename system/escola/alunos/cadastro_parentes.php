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
                                <h4 class="card-title">CADASTRO DE PARENTES</h4>
                                <p class="card-category">Cadastre os parentes do aluno</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_PARENTES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                                ?>
                                <form class="form_parente_aluno">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                        <div class="row">
                                            <div class="col-md-12">
                                        <span class="table-add-parente float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                            </div>
                                            <div class="table-responsive">

                                                <div style="padding: 15px;">
                                                    <table class="table table-bordered table-responsive-md table-striped text-center table_parente_aluno">
                                                        <tr>
                                                            <th class="text-center">Localize o Parente</th>
                                                            <th class="text-center"><?= $texto['CPF'] ?></th>
                                                            <th class="text-center">Grau de Parentesco</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        <?php
                                                            $Read->ExeRead("sys_pessoas_parentesco", "WHERE pessoa_id = :id", "id={$Id}");
                                                            if($Read->getResult()){
                                                                $QTDParentes = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Parente){
                                                                    $Read->FullRead("SELECT pessoa_id, pessoa_nome, pessoa_cpf FROM sys_pessoas WHERE pessoa_id = :id", "id={$Parente['pessoas_parentesco_parente_id']}");
                                                                    if($Read->getResult()){
                                                                        $PessoaParente = $Read->getResult()[0];
                                                                    } else {
                                                                        die("ERRO");
                                                                    }
                                                                    ?>
                                                                <tr>
                                                                    <input type="hidden" name="pessoas_parentesco_id_<?= $i ?>" value="<?= $Parente['pessoas_parentesco_id'] ?>">
                                                                <td class="pt-3-half">
                                                                    <input readonly value="<?= $PessoaParente['pessoa_nome'] ?>" type="text" data-cpf="txt_cpf_<?= $i ?>" data-id="txt_id_pessoa_<?= $i ?>" placeholder="Clique e selecione a pessoa" name="pessoas_parentesco_parente_id_<?= $i ?>" id="txt_pessoa_<?= $i ?>" class="form-control j_grau_parentes">
                                                                    <input id="txt_id_pessoa_<?= $i ?>" value="<?= $PessoaParente['pessoa_id'] ?>" type="hidden" name="pessoas_parentesco_parente_id_<?= $i ?>" class="form-control">
                                                                </td>
                                                                <td class="pt-3-half">
                                                                    <input type="text" readonly id="txt_cpf_<?= $i ?>" name="pessoa_parentesco_parente_cpf_<?= $i ?>" class="form-control" value="<?= $PessoaParente['pessoa_cpf'] ?>">
                                                                </td>
                                                                <td class="pt-3-half">
                                                                    <select style="margin-top: -3px" class="form-control" name="pessoas_parentesco_grau_id_<?= $i ?>">
                                                                        <option value="">SELECIONE O GRAU DE PARENTESCO</option>
                                                                        <?php
                                                                        $Read->ExeRead("sys_grau_parentesco", "WHERE grau_parentesco_status = :st", "st=0");
                                                                        if ($Read->getResult()):
                                                                            foreach ($Read->getResult() as $Grau):
                                                                                ?>
                                                                                <option <?= ($Parente['pessoas_parentesco_grau_id'] == $Grau['grau_parentesco_id'] ? "selected='selected'" : ''); ?> value="<?= $Grau['grau_parentesco_id'] ?>"><?= $Grau['grau_parentesco_nome'] ?></option>
                                                                            <?php
                                                                            endforeach;
                                                                        endif;
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <span class="table-remove">
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
                                                                $QTDParentes = 0;
                                                            }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="ParenteEditar"/>
                                    <input type="hidden" class="quantidade_parente_aluno" name="quantidade_parente_aluno" value="<?= $QTDParentes ?>"/>
                                    <input type="hidden" name="pessoa_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                    <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                         title="CARREGANDO..."/>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=escola/alunos/cadastro_alunos');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_PARENTES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_parente_aluno">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add-parente float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                                <table class="table table-bordered table-responsive-md table-striped text-center table_parente_aluno">
                                                    <tr>
                                                        <th class="text-center">Localize o Parente</th>
                                                        <th class="text-center"><?= $texto['CPF'] ?></th>
                                                        <th class="text-center">Grau de Parentesco</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="pt-3-half">
                                                            <input readonly type="text" data-cpf="txt_cpf_0" data-id="txt_id_pessoa_0" placeholder="Clique e selecione a pessoa" name="pessoas_parentesco_parente_id_0" id="txt_pessoa_0" class="form-control j_grau_parentes">
                                                            <input id="txt_id_pessoa_0" type="hidden" name="pessoas_parentesco_parente_id_0" class="form-control">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <input type="text" readonly id="txt_cpf_0" name="pessoa_parentesco_parente_cpf_0" class="form-control">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <select style="margin-top: -3px" class="form-control" name="pessoas_parentesco_grau_id_0">
                                                                <option value="">SELECIONE O GRAU DE PARENTESCO</option>
                                                                <?php
                                                                $Read->ExeRead("sys_grau_parentesco", "WHERE grau_parentesco_status = :st", "st=0");
                                                                if ($Read->getResult()):
                                                                    foreach ($Read->getResult() as $Grau):
                                                                        ?>
                                                                        <option value="<?= $Grau['grau_parentesco_id'] ?>"><?= $Grau['grau_parentesco_nome'] ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
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
                                <input type="hidden" name="action" value="ParenteAdd"/>
                                <input type="hidden" class="quantidade_parente_aluno" name="quantidade_parente_aluno" value="1"/>
                                <input type="hidden" name="unidade_id" value="<?= $_SESSION["userSYSFranquia"]["unidade_padrao"] ?>">
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
        ID FUNCIONALIDADE: <?= ESCOLA_PARENTES ?>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModalGrauParentesco">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_parentes"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListPessoas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th  data-field="id" data-filter-control="input">ID</th>
                            <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>