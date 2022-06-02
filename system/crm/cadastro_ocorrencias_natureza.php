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
                                <h4 class="card-title"><?= $texto['CadOCRRNAT'] ?></h4>
                                <p class="card-category"><?= $texto['CadOCRRNATi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_OCORRENCIAS_NATUREZA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencia_natureza_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_ocorrencias_natureza">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="row">
<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"><?= $texto['RESPONSEL'] ?></label>
                                                        <a data-toggle="modal" data-target="#getCodeModal">
                                                            <input readonly type="text" placeholder="Clique e selecione a pessoa"  id="txt_pessoa" class="form-control">
                                                        </a>
                                                        <input  id="txt_id_pessoa" type="hidden" name="responsavel_id" class="form-control">
                                                    </div>
                                                </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                    <input type="text" name="ocorrencias_natureza_nome" value="<?= $ocorrencias_natureza_nome ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <input type="checkbox" name="ocorrencias_natureza_status" value="1" <?= ($ocorrencias_natureza_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="OcorrenciasNaturezaEditar"/>
                                    <input type="hidden" name="ocorrencia_natureza_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='Crm/OcorrenciasNatureza' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=crm/cadastro_ocorrencias_natureza');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_OCORRENCIAS_NATUREZA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_ocorrencias_natureza">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                    <div class="row">

                                        <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"><?= $texto['RESPONSEL'] ?></label>
                                                        <a data-toggle="modal" data-target="#getCodeModal">
                                                            <input readonly type="text" placeholder="Clique e selecione a pessoa"  id="txt_pessoa" class="form-control">
                                                        </a>
                                                        <input  id="txt_id_pessoa" type="hidden" name="responsavel_id" class="form-control">
                                                    </div>
                                                </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                <input type="text" name="ocorrencias_natureza_nome" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="ocorrencias_natureza_status" value="1" ><?= $texto['InaC'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="OcorrenciasNaturezaAdd"/>
                                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                <div class="clearfix"></div>
                            </form>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= FRANQUEADOR_OCORRENCIAS_NATUREZA ?>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_funcionarios"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListFuncionarios.ajax.php?action=list"
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
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th data-field="cpf" data-filter-control="input"><?= $texto['CRG'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
