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
                                <h4 class="card-title"><?= $texto['VerFORN'] ?></h4>
                                <p class="card-category"><?= $texto['VerFORNi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                    $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    if ($Id):
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FORNECEDORES_FORNECEDOR."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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
                        <form class="form_fornecedor">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['RZAOSOCi'] ?></label>
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
                                                <label class="bmd-label-floating"><?= $texto['RESPONSELi'] ?></label>
                                                 <input type="text" value="<?= $Pessoa['pessoa_responsavel'] ?>" name="pessoa_responsavel" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTACADSTi'] ?></label>
                                           
                                             <input disabled type="date" name="pessoa_data" value="<?= date('d/m/Y', strtotime($Pessoa['pessoa_data'])) ?>" class="form-control">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['DTAABERTi'] ?></label>
                                                <input type="text" value="<?= date('d/m/Y', strtotime($Pessoa['pessoa_nascimento'])) ?>" name="pessoa_nascimento" class="form-control formDate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">CNPJ</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_cnpj'] ?>" name="pessoa_cnpj" class="form-control">
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
                                                <label class="bmd-label-floating">HomePage</label>
                                                <input type="text" value="<?= $Pessoa['pessoa_homepage'] ?>" name="pessoa_homepage" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['INSCESTADi'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_ie'] ?>" name="pessoa_ie" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['INSCMUNIi'] ?></label>
                                                <input type="text" value="<?= $Pessoa['pessoa_im'] ?>" name="pessoa_im" class="form-control">
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
                                                <label class="bmd-label-floating">Nº</label>
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
                                        
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_telefone">
                                                <tr>
                                                    <th class="text-center"><?= $texto['TPi'] ?></th>
                                                    <th class="text-center"><?= $texto['TELF'] ?></th>
                                                    <th class="text-center"><?= $texto['RAMA'] ?></th>
                                                    <th class="text-center"><?= $texto['OPERATO'] ?></th>
                                                    <th class="text-center"><?= $texto['OBSi'] ?></th>
                                                  
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
                                
                                <div class="clearfix"></div>
                            </form>    
                        <?php
                        else:
                            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                            header('Location: painel.php?exe=rh/colaborador/cadastro_fornecedor');
                            exit;
                        endif;
                    endif;
                    ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= FORNECEDORES_FORNECEDOR ?>
    </div>
  </div>