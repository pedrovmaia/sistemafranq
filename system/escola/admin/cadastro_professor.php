
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
                              <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                            </div>
                            <div class="col-md-10 text-center">
                                <h4 class="card-title"><?= $texto['CadPROFSS'] ?></h4>
                                <p class="card-category"><?= $texto['CadPROFSSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                    $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    if ($Id):
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CAD_COLABORADOR."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["alterar"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                        $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                        if ($Read->getResult()):
                            $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);

                            $Read->ExeRead("sys_catalogo_endereco_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Endereco = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                die;
                            endif;

                            $Read->ExeRead("escola_acesso", "WHERE escola_acesso_funcionario_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $PortalAcesso = $Read->getResult()[0]['escola_acesso_tipo'];
                            else:
                                $PortalAcesso = "";
                            endif;
                        ?>
                            <form class="form_colaborador">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_nome'] ?>" name="pessoa_nome" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['APEL'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_apelido'] ?>" name="pessoa_apelido" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['GENE'] ?></label>
                                                <select class="form-control" name="pessoa_sexo">
                                                    <option selected disabled value=""><?= $texto['SelGENE'] ?></option>
                                                    <option value="1" <?= ($Pessoa['pessoa_sexo'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['MASC'] ?></option>
                                                    <option value="2" <?= ($Pessoa['pessoa_sexo'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['FEM'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['NVLACSS'] ?></label>
                                                <select name="pessoa_acesso_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0"><?= $texto['SelNVLAC'] ?></option>
                                                    <?php
                                                    $Read->ExeRead("sys_niveis_acesso", "WHERE niveis_acesso_status = :st", "st=0");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Funcionalidades):
                                                            ?>
                                                            <option value="<?= $Funcionalidades['niveis_acesso_id'] ?>" <?= ($Funcionalidades['niveis_acesso_id'] == $Pessoa['pessoa_acesso_id'] ? 'selected="selected"' : ''); ?>><?= $Funcionalidades['niveis_acesso_nome'] ?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['DTNASC'] ?></label>
                                                <input type="text" value="<?= date('d/m/Y', strtotime($Pessoa['pessoa_nascimento'])) ?>" name="pessoa_nascimento" class="form-control formDate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_cpf'] ?>" name="pessoa_cpf" class="form-control formCpf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_email'] ?>" name="pessoa_email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PROFSSA'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_profissao'] ?>" name="pessoa_profissao" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">RG</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_rg'] ?>" name="pessoa_rg" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_emissor'] ?>" name="pessoa_emissor" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['TPCOLAB'] ?></label>
                                                <select class="form-control" name="pessoa_tipo_id">
                                                    <option selected disabled value=""><?= $texto['SelTPCOLAB'] ?></option>
                                                    <?php
                                                    $Read = new Read;
                                                    $Read->ExeRead("sys_tipo_pessoas");
                                                    if($Read->getResult()):
                                                        foreach ($Read->getResult() as $TipoPessoa):
                                                            echo "<option " . ($Pessoa['pessoa_tipo_id'] == $TipoPessoa['tipo_pessoa_id'] ? 'selected="selected"' : '') . " value='{$TipoPessoa['tipo_pessoa_id'] }'>{$TipoPessoa['tipo_pessoa_descricao'] }</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PORTACC'] ?></label>
                                                <select class="form-control" name="acesso_tipo">
                                                    <option selected disabled value=""><?= $texto['SelACCS'] ?></option>
                                                    <?php
                                                    $Read = new Read;
                                                    $Read->ExeRead("sys_portal_acesso", "WHERE portal_status = 1");
                                                    if($Read->getResult()):
                                                        foreach ($Read->getResult() as $TipoPortal):
                                                            echo "<option " . ($PortalAcesso == $TipoPortal['portal_nome'] ? 'selected="selected"' : '') . " value='{$TipoPortal['portal_nome'] }'>{$TipoPortal['portal_nome'] }</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div id="endereco_consumidor" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['ENDRES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">CEP</label>
                                                <input type="text" value="<?= $Endereco['catalogo_cep'] ?>" name="catalogo_cep" class="form-control formCep getCep">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ENDEREC'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_endereco'] ?>" name="catalogo_endereco" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">N??</label>
                                                <input type="text" value="<?= $Endereco['catalogo_numero'] ?>" name="catalogo_numero" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['COMPLEMT'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_complemento'] ?>" name="catalogo_complemento" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['BAIR'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_bairro'] ?>" name="catalogo_bairro" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_cidade'] ?>" name="catalogo_cidade" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">UF</label>
                                                <input type="text" value="<?= $Endereco['catalogo_uf'] ?>" name="catalogo_uf" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PAISS'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_pais'] ?>" name="catalogo_pais" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Observa????o</label>
                                                <input type="text" value="<?= $Endereco['catalogo_observacao'] ?>" name="catalogo_observacao" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div id="endereco_consumidor" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['TELEF'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_telefone">
                                                <tr>
                                                    <th class="text-center"><?= $texto['TPi'] ?></th>
                                                    <th class="text-center"><?= $texto['TELF'] ?></th>
                                                    <th class="text-center"><?= $texto['RAMA'] ?></th>
                                                    <th class="text-center"><?= $texto['OPERATO'] ?></th>
                                                    <th class="text-center"><?= $texto['OBSi'] ?></th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                <?php
                                                $Read->ExeRead("sys_telefones_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                                                if($Read->getResult()) {
                                                    $QTDTelefones = $Read->getRowCount();
                                                    $i = 0;
                                                    foreach ($Read->getResult() as $Telefones) {
                                                        ?>
                                                        <tr>
                                                            <td class="pt-3-half">
                                                                <input type="hidden" name="telid_<?= $i ?>"
                                                                       value="<?= $Telefones['id'] ?>">
                                                                <select name='tipo_telefone_<?= $i ?>' class="form-control">
                                                                    <option value="">Selecione um Tipo</option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_tipo_telefone");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $Tipo):
                                                                            echo "<option " . ($Telefones['tipo_telefone'] == $Tipo['tipo_telefone_nome'] ? 'selected="selected"': '') . "  value='{$Tipo['tipo_telefone_nome'] }'>{$Tipo['tipo_telefone_nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <input type="tel" name="telefone_<?= $i ?>"
                                                                       placeholder="(00) 0000-0000"
                                                                       class="form-control formPhone"
                                                                       value="<?= $Telefones['telefone'] ?>">
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <input type="number" name="ramal_<?= $i ?>" placeholder="Ramal"
                                                                       class="form-control"
                                                                       value="<?= $Telefones['ramal'] ?>">
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <select name="operadora_<?= $i ?>" class="form-control">
                                                                    <option value="" disabled selected><?= $texto['SelOPET'] ?>
                                                                    </option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_operadoras_celular", "WHERE operadora_celular_status = :st", "st=0");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $Operadoras):
                                                                            echo "<option " . ($Telefones['operadora'] == $Operadoras['operadora_celular_nome'] ? 'selected="selected"': '') . " value='{$Operadoras['operadora_celular_nome']}'>{$Operadoras['operadora_celular_nome']}</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <input name="observacao_<?= $i ?>" type="text"
                                                                       placeholder="Observa????o" class="form-control"
                                                                       value="<?= $Telefones['observacao'] ?>">
                                                            </td>
                                                            <td>
                                                            <span rel="<?= $Telefones['id'] ?>" class="table-remove"><button type="button"
                                                                                               class="btn btn-danger btn-rounded btn-sm my-0"><i
                                                                            class="material-icons">clear</i></button></span>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    $QTDTelefones = 0;
                                                }
                                                ?>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div id="acessos" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['AACCSS'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input name="acesso_sistema" class="form-check-input" type="checkbox" <?= ($Pessoa['pessoa_acesso_sistema'] == 1 ? 'checked' : ''); ?> value="1">
                                                    <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                                    <?= $texto['ACESSSIS'] ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input name="acesso_portal" class="form-check-input" type="checkbox" <?= ($Pessoa['pessoa_acesso_portal'] == 1 ? 'checked' : ''); ?> value="1">
                                                    <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                                    <?= $texto['ACESSPORT'] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['MoreINFO'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">OBSERVA????ES</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_observacao'] ?>" name="pessoa_observacao" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="pessoa_status" value="1" <?= ($Pessoa['pessoa_status'] == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="ColaboradorEditar"/>
                                <input type="hidden" class="quantidade_telefone" name="quantidade_telefone" value="<?= $QTDTelefones ?>"/>
                                <input type="hidden" name="pessoa_id" value="<?= $Id; ?>"/>
                                <?php
                                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CAD_COLABORADOR."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                                $permissao = $Read->getResult()[0];
                                if($permissao["inserir"] == 1) {
                                    ?>
                                    <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                    <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                         title="CARREGANDO..."/>
                                    <?php
                                }
                                if($permissao["deletar"] == 1) {
                                    ?>
                                    <span rel='single_user_addr' callback='rh/Colaborador' action="delete"
                                          class='j_delete_action_confirm icon-warning btn btn-danger'
                                          id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                    <?php
                                }
                                ?>
                                <div class="clearfix"></div>
                            </form>
                        <?php
                        else:
                            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, voc?? tentou editar um usu??rio que n??o existe ou que foi removido recentemente!";
                            header('Location: painel.php?exe=rh/colaborador/cadastro_colaborador');
                            exit;
                        endif;
                    else:
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CAD_COLABORADOR."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["inserir"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                        ?>
                        <form class="form_colaborador">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                            <input type="text" value="" name="pessoa_nome" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['APEL'] ?></label>
                                            <input type="text" value="" name="pessoa_apelido" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['GENE'] ?></label>
                                            <select class="form-control" name="pessoa_sexo">
                                                <option selected disabled value=""><?= $texto['SelGENE'] ?></option>
                                                <option value="1"><?= $texto['MASC'] ?></option>
                                                <option value="2"><?= $texto['FEM'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['NVLACSS'] ?></label>
                                            <select name="pessoa_acesso_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelNVLAC'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_niveis_acesso", "WHERE niveis_acesso_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Funcionalidades):
                                                        ?>
                                                        <option value="<?= $Funcionalidades['niveis_acesso_id'] ?>"><?= $Funcionalidades['niveis_acesso_nome'] ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTNASC'] ?></label>
                                            <input type="text" value="" name="pessoa_nascimento" class="form-control formDate">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                            <input type="text" value="" name="pessoa_cpf" class="form-control formCpf">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="text" value="" name="pessoa_email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PROFSSA'] ?></label>
                                            <input type="text" value="" name="pessoa_profissao" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">RG</label>
                                            <input type="text" value="" name="pessoa_rg" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                            <input type="text" value="" name="pessoa_emissor" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TPCOLAB'] ?></label>
                                            <select class="form-control" name="pessoa_tipo_id">
                                                <option selected disabled value=""><?= $texto['SelTPCOLAB'] ?></option>
                                                <?php
                                                $Read = new Read;
                                                $Read->ExeRead("sys_tipo_pessoas");
                                                if($Read->getResult()):
                                                    foreach ($Read->getResult() as $TipoPessoa):
                                                        echo "<option value='{$TipoPessoa['tipo_pessoa_id'] }'>{$TipoPessoa['tipo_pessoa_descricao'] }</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PORTACC'] ?></label>
                                            <select class="form-control" name="acesso_tipo">
                                                <option selected disabled value=""><?= $texto['SelACCS'] ?></option>
                                                <?php
                                                $Read = new Read;
                                                $Read->ExeRead("sys_portal_acesso", "WHERE portal_status = 1");
                                                if($Read->getResult()):
                                                    foreach ($Read->getResult() as $TipoPortal):
                                                        echo "<option value='{$TipoPortal['portal_nome'] }'>{$TipoPortal['portal_nome'] }</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="endereco_consumidor" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['ENDRES'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CEP</label>
                                            <input type="text" value="" name="catalogo_cep" class="form-control formCep getCep">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ENDEREC'] ?></label>
                                            <input type="text" value="" name="catalogo_endereco" class="form-control sys_logradouro">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">N??</label>
                                            <input type="text" value="" name="catalogo_numero" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['COMPLEMT'] ?></label>
                                            <input type="text" name="catalogo_complemento" class="form-control sys_complemento">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['BAIR'] ?></label>
                                            <input type="text" value="" name="catalogo_bairro" class="form-control sys_bairro">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                            <input type="text" value="" name="catalogo_cidade" class="form-control sys_localidade">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">UF</label>
                                            <input type="text" value="" name="catalogo_uf" class="form-control sys_uf">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PAISS'] ?></label>
                                            <input type="text" value="" name="catalogo_pais" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Observa????o</label>
                                            <input type="text" value="" name="catalogo_observacao" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="endereco_consumidor" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['TELEF'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="table-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                    </div>
                                    <div class="table-responsive">
                                    <div style="padding: 15px;">
                                    <table class="table table-bordered table-responsive-md table-striped text-center table_telefone">
                                        <tr>
                                            <th class="text-center"><?= $texto['TPi'] ?></th>
                                            <th class="text-center"><?= $texto['TELF'] ?></th>
                                            <th class="text-center"><?= $texto['RAMA'] ?></th>
                                            <th class="text-center"><?= $texto['OPERATO'] ?></th>
                                            <th class="text-center"><?= $texto['OBSi'] ?></th>
                                            <th class="text-center"></th>
                                        </tr>
                                        <tr>
                                            <td class="pt-3-half">
                                                <select name='tipo_telefone_0' class="form-control">
                                                    <option value="">Selecione um Tipo</option>
                                                    <?php
                                                    $Read = new Read;
                                                    $Read->ExeRead("sys_tipo_telefone");
                                                    if($Read->getResult()):
                                                        foreach ($Read->getResult() as $Tipo):
                                                            echo "<option value='{$Tipo['tipo_telefone_nome'] }'>{$Tipo['tipo_telefone_nome'] }</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                            <td class="pt-3-half">
                                                <input type="tel" name="telefone_0" placeholder="(00) 0000-0000" class="form-control formPhone">
                                            </td>
                                            <td class="pt-3-half">
                                                <input type="number" name="ramal_0" placeholder="Ramal" class="form-control">
                                            </td>
                                            <td class="pt-3-half">
                                                <select name="operadora_0" class="form-control">
                                                    <option value="" disabled selected><?= $texto['SelOPET'] ?></option>
                                                    <?php
                                                        $Read = new Read;
                                                        $Read->ExeRead("sys_operadoras_celular", "WHERE operadora_celular_status = :st", "st=0");
                                                        if($Read->getResult()):
                                                            foreach ($Read->getResult() as $Operadoras):
                                                                echo "<option value='{$Operadoras['operadora_celular_nome'] }'>{$Operadoras['operadora_celular_nome'] }</option>";
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </td>
                                            <td class="pt-3-half">
                                                <input name="observacao_0" type="text" placeholder="Observa????o" class="form-control">
                                            </td>
                                            <td>
                                                <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="acessos" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['AACCSS'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="acesso_sistema" class="form-check-input" type="checkbox" value="1">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                                <?= $texto['ACESSSIS'] ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="acesso_portal" class="form-check-input" type="checkbox" value="1">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                                <?= $texto['ACESSPORT'] ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['MoreINFO'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">OBSERVA????ES</label>
                                            <input type="text" value="" name="pessoa_observacao" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="pessoa_status" value="1"><?= $texto['InaC'] ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <input type="hidden" name="action" value="ColaboradorAdd"/>
                            <input type="hidden" class="quantidade_telefone" name="quantidade_telefone" value="1"/>
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
        ID FUNCIONALIDADE: <?= CAD_COLABORADOR ?>
    </div>
  </div>