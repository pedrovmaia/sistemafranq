<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$idEstagio = filter_input(INPUT_GET, 'idEstagio', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(!$idEstagio){
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
                                <h4 class="card-title">CADASTRO DE MATERIAIS DO ESTÁGIO</h4>
                                <p class="card-category">Cadastre os materiais do estágio</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_MATERIAIS_ESTAGIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_materiais_estagio_produto", "WHERE estagio_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Materiais = array_map('htmlspecialchars', $Read->getResult()[0]);
                                ?>
                                <form class="form_materiais_estagio">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong>DADOS</strong></label>
                                        <div class="row">
                                            <div class="col-md-12">
                                        <span class="table-add-materiais-estagio float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                            </div>
                                            <div class="table-responsive">

                                                <div style="padding: 15px;">
                                                    <table class="table table-bordered table-responsive-md table-striped text-center table_materiais_estagio">
                                                        <tr>
                                                            <th class="text-center">Produto</th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        <?php
                                                            $Read->ExeRead("sys_materiais_estagio_produto", "WHERE estagio_id = :id", "id={$Id}");
                                                            if($Read->getResult()){
                                                                $QTDMateriais = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Material){
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-4-half">
                                                                            <input type="hidden" value="<?= $Material['id'] ?>" name="indic_id_<?= $i ?>">
                                                                            <?php
                                                                            $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$Material['produto_id']}");
                                                                            if($Read->getResult()){
                                                                                $Produto = $Read->getResult()[0];
                                                                                ?>
                                                                                <input autocomplete="off" id="txt_produto_id_<?= $i ?>" type="hidden" name="produto_id_<?= $i ?>" value="<?= $Produto['produto_id'] ?>" class="form-control">
                                                                                <input autocomplete="off" data-id="txt_produto_id_<?= $i ?>" readonly placeholder="Clique e selecione o produto" data-toggle="modal"data-target="#getCodeModal" id="produto_id_<?= $i ?>" value="<?= $Produto['produto_nome'] ?>" type="text" name="produto_nome_<?= $i ?>"  class="form-control j_produto_materias_estagio">
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                        <span rel="<?= $Material['id'] ?>" class="table-remove">
                                                                            <button type="button" value="remove" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                                <i class="material-icons">clear</i>
                                                                            </button>
                                                                        </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                $QTDMateriais = 0;
                                                            }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="MaterialEditar"/>
                                    <input type="hidden" class="quantidade_material_estagio" name="quantidade_material_estagio" value="<?= $QTDMateriais ?>"/>
                                    <input type="hidden" name="estagio_id" value="<?= $Id; ?>"/>
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
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_MATERIAIS_ESTAGIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_materiais_estagio">

                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>DADOS</strong></label>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add-materiais-estagio float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                                <table class="table table-bordered table-responsive-md table-striped text-center table_materiais_estagio">
                                                    <tr>
                                                        <th class="text-center">Produto</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="pt-4-half">
                                                            <input autocomplete="off" id="txt_produto_id_0" type="hidden" name="produto_id_0" class="form-control">
                                                            <input autocomplete="off" data-id="txt_produto_id_0" readonly placeholder="Clique e selecione o produto" id="produto_id_0" type="text"  data-target="#getCodeModal" name="produto_nome_0"  class="form-control j_produto_materias_estagio">
                                                        </td>
                                                        <td>
                                                            <span class="table-remove">
                                                                <button type="button" value="remove" class="btn btn-danger btn-rounded btn-sm my-0">
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

                                <input type="hidden" name="action" value="MaterialAdd"/>
                                <input type="hidden" class="quantidade_material_estagio" name="quantidade_material_estagio" value="1"/>
                                <input type="hidden" name="estagio_id" value="<?= $idEstagio ?>"/>
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
        ID FUNCIONALIDADE: <?= ESCOLA_MATERIAIS_ESTAGIO ?>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_materiais"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListProdutos.ajax.php?action=list"
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
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                            <th  data-field="valor" data-filter-control="input">Valor</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
