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
                                <h4 class="card-title"><?= $texto['CadALNOS'] ?></h4>
                                <p class="card-category"><?= $texto['CadALNOSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                    $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    if ($Id):
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ALUNOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                            <form class="form_aluno">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                <input autofocus type="text" value="<?= $Pessoa['pessoa_nome'] ?>" name="pessoa_nome"  class="form-control">
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
                                                    <option selected  value=""><?= $texto['SelGENE'] ?></option>
                                                    <option value="1" <?= ($Pessoa['pessoa_sexo'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['MASC'] ?></option>
                                                    <option value="2" <?= ($Pessoa['pessoa_sexo'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['FEM'] ?></option>
                                                </select>
                                            </div>
                                        </div>

                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['DTNASC'] ?></label>
                                                <input type="text" value="<?= date('d/m/Y', strtotime($Pessoa['pessoa_nascimento'])) ?>" name="pessoa_nascimento" class="form-control formDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">CPF</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_cpf'] ?>" name="pessoa_cpf" class="form-control formCpf">
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_email'] ?>" name="pessoa_email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PROFSSA'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_profissao'] ?>" name="pessoa_profissao" class="form-control">
                                            </div>
                                        </div>
                                    
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">RG</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_rg'] ?>" name="pessoa_rg" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_emissor'] ?>" name="pessoa_emissor" class="form-control">
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
                                                <label class="bmd-label-floating"><?= $texto['CEP'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_cep'] ?>" name="catalogo_cep" class="form-control formCep getCep">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ENDEREC'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_endereco'] ?>" name="catalogo_endereco" class="form-control sys_logradouro">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nº</label>
                                                <input type="text" value="<?= $Endereco['catalogo_numero'] ?>" name="catalogo_numero" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['COMPLEMT'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_complemento'] ?>" name="catalogo_complemento" class="form-control sys_complemento">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['BAIR'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_bairro'] ?>" name="catalogo_bairro" class="form-control sys_bairro">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_cidade'] ?>" name="catalogo_cidade" class="form-control sys_localidade">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">UF</label>
                                                <input type="text" value="<?= $Endereco['catalogo_uf'] ?>" name="catalogo_uf" class="form-control sys_uf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PAISS'] ?></label>
                                                <input type="text" value="<?= $Endereco['catalogo_pais'] ?>" name="catalogo_pais" class="form-control sys_pais">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['OBSi'] ?></label>
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
                                                                    <option value=""><?= $texto['SelTYPE'] ?></option>
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
                                                                       placeholder="Observação" class="form-control"
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
                                <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['REFSS'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ESTD'] ?></label>
                                                <select class="form-control" name="pessoa_estuda">
                                                    
                                                    <option value="1" <?= ($Pessoa['pessoa_estuda'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['NOi'] ?></option>
                                                    <option value="2" <?= ($Pessoa['pessoa_estuda'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['SIMi'] ?></option>
                                                </select>
                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['TRABL'] ?></label>
                                                <select class="form-control" name="pessoa_trabalha">
                                                    <option value="1" <?= ($Pessoa['pessoa_trabalha'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['NOi'] ?></option>
                                                    <option value="2" <?= ($Pessoa['pessoa_trabalha'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['SIMi'] ?></option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['Schooli'] ?></label>
                                            <select name="pessoa_escola_id" class="form-control">
                                                <option value="0"><?= $texto['SelSchool'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_escola", "WHERE escola_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Escolas):
                                                        ?>
                                                          <option value="<?= $Escolas['escola_id'] ?>" <?php if ($Pessoa['pessoa_escola_id'] == $Escolas['escola_id'] ) { echo "selected";}  ?>  ><?php echo $Escolas['escola_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['Compny'] ?></label>
                                            <select value="<?= $Pessoa['pessoa_trabalho_id'] ?>" name="pessoa_trabalho_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelCompny'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_empresas", "WHERE empresa_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Empresas):
                                                        ?>
                                                         <option value="<?= $Empresas['empresa_id'] ?>" <?php if ($Pessoa['pessoa_trabalho_id']  == $Empresas['empresa_id'] ) { echo "selected";}  ?>  ><?php echo $Empresas['empresa_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                    </div>
                                    
                                </div>

                                <br/>

                                <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['RESPONSES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['RESPFN'] ?></label>
                                                <?php
                                                $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_id = :st", "st={$Pessoa['pessoa_responsavel_financeiro_id']}");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $RFinanceiro):
                                                        $NomeFinanceiro = $RFinanceiro['pessoa_nome'];
                                                        $IdFinanceiro = $RFinanceiro['pessoa_id'];
                                                    endforeach;
                                                else:
                                                    $NomeFinanceiro = "";
                                                    $IdFinanceiro = "";
                                                endif;
                                                ?>
                                    <a data-toggle="modal" data-target="#getCodeModalFinanceiro">
                                    <input value=" <?= $NomeFinanceiro ?>" readonly type="text" placeholder="Clique e selecione o responsável financeiro" name="nome" id="pessoa_nome_responsavel_financeiro" class="form-control">
                                    </a>
                                    <input id="txt_id_pessoa_financeiro" type="hidden" name="pessoa_responsavel_financeiro_id" value=" <?= $IdFinanceiro ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_finan_cad" style="margin-top: 2.2rem !important">
                                            <i class="material-icons">add</i>
                                        </span>
                                            <div class="modal fade" id="modal_responsavel_finan_cad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document" style="max-width: 700px !important;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Responsável financeiro</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                                        <input autofocus type="text" value="" name="pessoa_nome_responsavel_financeiro" class="form-control pessoa_nome_responsavel_financeiro">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                        <input type="text" value="" name="pessoa_cpf_responsavel_financeiro" class="form-control j_sys_change_cpf formCpf">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label  class="bmd-label-floating">RG</label>
                                                                        <input type="text" value="" name="pessoa_rg_responsavel_financeiro" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                        <input type="text" value="" name="pessoa_emissor_responsavel_financeiro" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating">Telefone</label>
                                                                        <input type="text" value="" name="pessoa_telefone_responsavel_financeiro" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success ok_modal_responsavel_financeiro">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['RESPPD'] ?></label>
                                               <?php
                                                $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_id = :st", "st={$Pessoa['pessoa_responsavel_pedagogico_id']}");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $RPedagogico):
                                                        $NomePedagogico = $RPedagogico['pessoa_nome'];
                                                        $IdPedagogico = $RPedagogico['pessoa_id'];
                                                    endforeach;
                                                else:
                                                    $NomePedagogico = "";
                                                    $IdPedagogico = "";
                                                endif;
                                                ?>
                                    <a data-toggle="modal" data-target="#getCodeModalPedagogico">
                                    <input value=" <?= $NomePedagogico ?>" readonly type="text" placeholder="Clique e selecione o responsável pedagógico" name="nome" id="pessoa_nome_responsavel_pedagogico" class="form-control">
                                    </a>
                                    <input id="txt_id_pessoa_pedagogico" type="hidden" name="pessoa_responsavel_pedagogico_id" value=" <?= $IdPedagogico ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_peda_cad" style="margin-top: 2.2rem !important">
                                            <i class="material-icons">add</i>
                                        </span>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="repetir_responsavel" class="custom-control-input" id="repetir_responsavel">
                                                <label class="custom-control-label" for="repetir_responsavel">Igual ao financeiro?</label>
                                            </div>
                                            <div class="modal fade" id="modal_responsavel_peda_cad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document" style="max-width: 700px !important;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Responsável Pedagógico</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                                        <input autofocus type="text" value="" name="pessoa_nome_responsavel_pedagogico" class="form-control pessoa_nome_responsavel_pedagogico">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                        <input type="text" value="" name="pessoa_cpf_responsavel_pedagogico" class="form-control j_sys_change_cpf formCpf">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label  class="bmd-label-floating">RG</label>
                                                                        <input type="text" value="" name="pessoa_rg_responsavel_pedagogico" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                        <input type="text" value="" name="pessoa_emissor_responsavel_pedagogico" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success ok_modal_responsavel_pedagogico">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <label class="bmd-label-floating"><?= $texto['OBSSi'] ?></label>
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
                                <input type="hidden" name="pessoa_tipo_id" value="4"/>
                                <input type="hidden" name="action" value="AlunoEditar"/>
                                <input type="hidden" class="quantidade_telefone" name="quantidade_telefone" value="<?= $QTDTelefones ?>"/>
                                <input type="hidden" name="pessoa_id" value="<?= $Id; ?>"/>
                                <?php
                                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ALUNOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                                $permissao = $Read->getResult()[0];
                                if($permissao["inserir"] == 1) {
                                    ?>
                                    <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                    <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                         title="CARREGANDO..."/>
                                    <button type="button" data-tipo="1" data-tabela-id="114" data-origem="<?= $Id ?>" class="btn btn-primary j_abrirAnexos"><?= $texto['ANEXi'] ?></button>
                                    <?php
                                }
                                ?>
                                <div class="clearfix"></div>
                            </form>
                        <?php
                        else:
                            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                            header('Location: painel.php?exe=escola/alunos/cadastro_alunos');
                            exit;
                        endif;
                    else:
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ALUNOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["inserir"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                        ?>
                        <form class="form_aluno">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                            <input autofocus required type="text" value="" name="pessoa_nome" class="form-control">
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
                                                <option selected  value=""><?= $texto['SelGENE'] ?></option>
                                                <option value="1"><?= $texto['MASC'] ?></option>
                                                <option value="2"><?= $texto['FEM'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTNASC'] ?></label>
                                            <input type="text" value="" name="pessoa_nascimento" class="form-control formDate">
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                            <input type="text" value="" name="pessoa_cpf" class="form-control j_sys_change_cpf formCpf">
                                        </div>
                                    </div>
                                
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="text" value="" name="pessoa_email" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PROFSSA'] ?></label>
                                            <input type="text" value="" name="pessoa_profissao" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  class="bmd-label-floating">RG</label>
                                            <input type="text" value="" name="pessoa_rg" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                            <input type="text" value="" name="pessoa_emissor" class="form-control">
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
                                            <input required type="text" value="" name="catalogo_cep" class="form-control formCep getCep">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ENDEREC'] ?></label>
                                            <input required type="text" value="" name="catalogo_endereco" class="form-control sys_logradouro">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nº</label>
                                            <input required type="text" value="" name="catalogo_numero" class="form-control">
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
                                            <input required type="text" value="" name="catalogo_bairro" class="form-control sys_bairro">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                            <input required type="text" value="" name="catalogo_cidade" class="form-control sys_localidade">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">UF</label>
                                            <input required type="text" value="" name="catalogo_uf" class="form-control sys_uf">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PAISS'] ?></label>
                                            <input required type="text" value="" name="catalogo_pais" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OBSi'] ?></label>
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
                                                    <option value=""><?= $texto['SelTYPE'] ?></option>
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
                                                <input required type="tel" name="telefone_0" placeholder="(00) 0000-0000" class="form-control formPhone">
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
                                                <input name="observacao_0" type="text" placeholder="Observação" class="form-control">
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

                             <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['REFSS'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ESTD'] ?></label>
                                            <select class="form-control" name="pessoa_estuda">   
                                                <option value="1"><?= $texto['NOi'] ?></option>
                                                <option value="2"><?= $texto['SIMi'] ?></option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TRABL'] ?></label>
                                            <select class="form-control" name="pessoa_trabalha">   
                                                <option value="1"><?= $texto['NOi'] ?></option>
                                                <option value="2"><?= $texto['SIMi'] ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['Schooli'] ?></label>
                                            <select name="pessoa_escola_id" class="form-control">
                                                <option value="0"><?= $texto['SelSchool'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_escola", "WHERE escola_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Escolas):
                                                        ?>
                                                        <option value="<?= $Escolas['escola_id'] ?>"><?= $Escolas['escola_nome'] ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['Compny'] ?></label>
                                            <select name="pessoa_trabalho_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelCompny'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_empresas", "WHERE empresa_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Empresas):
                                                        ?>
                                                        <option value="<?= $Empresas['empresa_id'] ?>"><?= $Empresas['empresa_nome'] ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>




                                </div>
                                
                            </div>

                            <br/>

                             <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['RESPONSES'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['RESPFN'] ?></label>
                                             <a data-toggle="modal" data-target="#getCodeModalFinanceiro">
                                                  <input readonly type="text" placeholder="Clique e selecione o responsável financeiro" name="nome" id="pessoa_nome_responsavel_financeiro" class="form-control">
                                                              </a>
                                                              <input id="txt_id_pessoa_financeiro" type="hidden" name="pessoa_responsavel_financeiro_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_finan_cad" style="margin-top: 2.2rem !important">
                                            <i class="material-icons">add</i>
                                        </span>
                                        <div class="modal fade" id="modal_responsavel_finan_cad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="max-width: 700px !important;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Responsável financeiro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                                    <input autofocus type="text" value="" name="pessoa_nome_responsavel_financeiro" class="form-control pessoa_nome_responsavel_financeiro">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                    <input type="text" value="" name="pessoa_cpf_responsavel_financeiro" class="form-control j_sys_change_cpf formCpf">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label  class="bmd-label-floating">RG</label>
                                                                    <input type="text" value="" name="pessoa_rg_responsavel_financeiro" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                    <input type="text" value="" name="pessoa_emissor_responsavel_financeiro" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating">Telefone</label>
                                                                    <input type="text" value="" name="pessoa_telefone_responsavel_financeiro" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success ok_modal_responsavel_financeiro">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['RESPPD'] ?></label>
                                             <a data-toggle="modal" data-target="#getCodeModalPedagogico">
                                                                  <input readonly type="text" placeholder="Clique e selecione o responsável pedagógico" name="nome" id="pessoa_nome_responsavel_pedagogico" class="form-control">
                                                              </a>
                                                              <input id="txt_id_pessoa_pedagogico" type="hidden" name="pessoa_responsavel_pedagogico_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_peda_cad" style="margin-top: 2.2rem !important">
                                            <i class="material-icons">add</i>
                                        </span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="repetir_responsavel" class="custom-control-input" id="repetir_responsavel">
                                            <label class="custom-control-label" for="repetir_responsavel">Igual ao financeiro?</label>
                                        </div>
                                        <div class="modal fade" id="modal_responsavel_peda_cad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="max-width: 700px !important;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Responsável Pedagógico</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                                    <input autofocus type="text" value="" name="pessoa_nome_responsavel_pedagogico" class="form-control pessoa_nome_responsavel_pedagogico">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                    <input type="text" value="" name="pessoa_cpf_responsavel_pedagogico" class="form-control j_sys_change_cpf formCpf">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label  class="bmd-label-floating">RG</label>
                                                                    <input type="text" value="" name="pessoa_rg_responsavel_pedagogico" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                    <input type="text" value="" name="pessoa_emissor_responsavel_pedagogico" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success ok_modal_responsavel_pedagogico">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                                  
                                  </br>

                            
                            <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['MoreINFO'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OBSSi'] ?></label>
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
                            <input type="hidden" name="action" value="AlunoAdd"/>
                            <input type="hidden" class="quantidade_telefone" name="quantidade_telefone" value="1"/>
                            <input type="hidden" name="pessoa_tipo_id" value="4"/>
                            <button type="submit" id="btnSubmit" value="btnSubmit" class="btn btn-primary" ><?= $texto['sav'] ?></button>
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
        ID FUNCIONALIDADE: <?= ESCOLA_ALUNOS ?>
    </div>
  </div>
      <div class="showcase hide-print" id="getCodeModalFinanceiro">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_responsavel_financeiro"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListResponsavel.ajax.php?action=list"
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
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="cpf" data-filter-control="input">CPF</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="showcase hide-print" id="getCodeModalPedagogico">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_responsavel_pedagogico"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListResponsavel.ajax.php?action=list"
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
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="cpf" data-filter-control="input">CPF</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>