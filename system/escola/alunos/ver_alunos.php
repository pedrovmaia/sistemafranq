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
                                <h4 class="card-title"><?= $texto['VERALUNO'] ?></h4>
                                <p class="card-category"><?= $texto['VERALUNOi'] ?></p>
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
                        $Read->FullRead("SELECT * FROM sys_pessoas WHERE pessoa_id = :id", "id={$Id}");
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

                <div >

                <div class="btn-group">

                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['InfFinanc'] ?> <span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                    <li><a href="<?= BASE ?>/painel.php?exe=contasreceber/filtro_titulos_receber_por_pessoa&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['FicFinan'] ?> </a></li>

                   </ul>
                   </div>


                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">CRM <span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                    <li><a href="<?= BASE ?>/painel.php?exe=crm/filtro_ocorrencia&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['OCRRE'] ?> </a></li>
                    <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_indicacao_pessoa&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['INDC'] ?></a></li>
                    <li><a href="<?= BASE ?>/painel.php?exe=crm/filtro_interesse&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['INTS'] ?></a></li>

                   </ul>
                   </div>

                    <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['MOVMNT'] ?><span class="caret"></span></button>



                    <ul class="dropdown-menu" role="menu">

                    <li><a href="<?= BASE ?>/painel.php?exe=contasreceber/filtro_movimentacao_recebimento_por_pessoa&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistCP'] ?></a></li>

                    <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_pedido&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistPD'] ?></a></li>

                    <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_matricula&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistMAT'] ?></a></li>

                    
                  

                   </ul>
                   </div>


                    <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['INFOR'] ?><span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/avaliacoes_aluno&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['AVALi'] ?></a></li>
                        <li><a href="<?= BASE ?>/painel.php?exe=rh/filtro_teste_pessoa&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['TESTNIV'] ?> </a></li>
                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_parentes&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['PARET'] ?></a></li>
                        <li><a href="#" data-tipo="0" data-tabela-id="114" data-origem="<?= $Pessoa["pessoa_id"] ?>" class="j_abrirAnexos"><?= $texto['ANEX'] ?></a></li>
                   </ul>
                   </div>


                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['DOCUMENT'] ?><span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                    <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_contrato_aluno&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['CONTRATC'] ?></a></li>
                  

                   </ul>
                   </div>


                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">MATRÍCULA<span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                    <li><a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/cadastro_pedido&aluno=<?= $Pessoa["pessoa_id"] ?>">Realizar Matrícula</a></li>
                  

                   </ul>
                   </div>


                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['MenP'] ?><span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_avaliacoes&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistAV'] ?></a></li>
                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_homework&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistHW'] ?></a></li>
                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_exercicios&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistEX'] ?></a></li>
                        <li><a href="<?= BASE ?>/painel.php?exe=escola/alunos/historico_pedagogico&id=<?= $Pessoa["pessoa_id"] ?>"><?= $texto['HistPDG'] ?></a></li>
                  

                   </ul>
                   </div>
                </div>

                           <form class="form_colaborador">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['DADPES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_nome'] ?>" name="pessoa_nome" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['APEL'] ?></label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_apelido'] ?>" name="pessoa_apelido" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['GENE'] ?></label>
                                                <select disabled class="form-control" name="pessoa_sexo">
                                                    <option selected disabled value=""><?= $texto['SelGENE'] ?></option>
                                                    <option value="1" <?= ($Pessoa['pessoa_sexo'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['MASC'] ?></option>
                                                    <option value="2" <?= ($Pessoa['pessoa_sexo'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['FEM'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['DTNASC'] ?></label>
                                                <input disabled type="text" value="<?= date('d/m/Y', strtotime($Pessoa['pessoa_nascimento'])) ?>" name="pessoa_nascimento" class="form-control formDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_cpf'] ?>" name="pessoa_cpf" class="form-control formCpf">
                                            </div>
                                        </div>
    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email</label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_email'] ?>" name="pessoa_email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PROFSSA'] ?></label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_profissao'] ?>" name="pessoa_profissao" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">RG</label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_rg'] ?>" name="pessoa_rg" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_emissor'] ?>" name="pessoa_emissor" class="form-control">
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
                                                <input disabled type="text" value="<?= $Endereco['catalogo_cep'] ?>" name="catalogo_cep" class="form-control formCep getCep">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ENDEREC'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_endereco'] ?>" name="catalogo_endereco" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nº</label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_numero'] ?>" name="catalogo_numero" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['COMPLEMT'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_complemento'] ?>" name="catalogo_complemento" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['BAIR'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_bairro'] ?>" name="catalogo_bairro" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_cidade'] ?>" name="catalogo_cidade" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">UF</label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_uf'] ?>" name="catalogo_uf" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PAISS'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_pais'] ?>" name="catalogo_pais" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['OBSi'] ?></label>
                                                <input disabled type="text" value="<?= $Endereco['catalogo_observacao'] ?>" name="catalogo_observacao" class="form-control">
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
                                            <table disabled class="table table-bordered table-responsive-md table-striped text-center table_telefone">
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
                                                                <input disabled type="hidden" name="telid_<?= $i ?>"
                                                                       value="<?= $Telefones['id'] ?>">
                                                                <select disabled name='tipo_telefone_<?= $i ?>' class="form-control">
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
                                                                <input disabled type="tel" name="telefone_<?= $i ?>"
                                                                       placeholder="(00) 0000-0000"
                                                                       class="form-control formPhone"
                                                                       value="<?= $Telefones['telefone'] ?>">
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <input disabled type="number" name="ramal_<?= $i ?>" placeholder="Ramal"
                                                                       class="form-control"
                                                                       value="<?= $Telefones['ramal'] ?>">
                                                            </td>
                                                            <td class="pt-3-half">
                                                                <select disabled name="operadora_<?= $i ?>" class="form-control">
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
                                                                <input disabled name="observacao_<?= $i ?>" type="text"
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
                                    <label class="bmd-label-floating"><strong><?= $texto['RESPONSES'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['RESPFN'] ?></label>
                                                <select disabled name="pessoa_responsavel_financeiro_id" class="form-control">
                                                    <option value="0"><?= $texto['SelRFN'] ?></option>
                                                    <?php
                                                    $Read->ExeRead("sys_pessoas", "WHERE pessoa_status = :st", "st=0");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $RFinanceiro):
                                                            ?>
                                                              <option value="<?= $RFinanceiro['pessoa_id'] ?>" <?php if ($Pessoa['pessoa_responsavel_financeiro_id'] == $RFinanceiro['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $RFinanceiro['pessoa_nome']; ?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_finan_cad" style="margin-top: 2.2rem !important">
                                                <i class="material-icons">remove_red_eye</i>
                                            </span>
                                            <?php
                                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Pessoa['pessoa_responsavel_financeiro_id']}");
                                            if ($Read->getResult()):
                                                $RFinanceiroList = $Read->getResult()[0];
                                                ?>
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
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_nome'] ?>" name="pessoa_nome_responsavel_financeiro" class="form-control pessoa_nome_responsavel_financeiro">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_cpf'] ?>" name="pessoa_cpf_responsavel_financeiro" class="form-control j_sys_change_cpf formCpf">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label  class="bmd-label-floating">RG</label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_rg'] ?>" name="pessoa_rg_responsavel_financeiro" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_emissor'] ?>" name="pessoa_emissor_responsavel_financeiro" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            endif;
                                            ?>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['RESPPD'] ?></label>
                                                <select disabled name="pessoa_responsavel_pedagogico_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0"><?= $texto['SelRPDG'] ?></option>
                                                    <?php
                                                    $Read->ExeRead("sys_pessoas", "WHERE pessoa_status = :st", "st=0");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $RPedagogico):
                                                            ?>
                                                             <option value="<?= $RPedagogico['pessoa_id'] ?>" <?php if ($Pessoa['pessoa_responsavel_pedagogico_id']  == $RPedagogico['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $RPedagogico['pessoa_nome']; ?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <span class="btn btn-success" data-toggle="modal" data-target="#modal_responsavel_peda_cad" style="margin-top: 2.2rem !important">
                                                <i class="material-icons">remove_red_eye</i>
                                            </span>
                                            <?php
                                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Pessoa['pessoa_responsavel_pedagogico_id']}");
                                            if ($Read->getResult()):
                                                $RFinanceiroList = $Read->getResult()[0];
                                                ?>
                                                <div class="modal fade" id="modal_responsavel_peda_cad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 700px !important;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Responsável pedagógico</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['NOMEC'] ?></label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_nome'] ?>" name="pessoa_nome_responsavel_financeiro" class="form-control pessoa_nome_responsavel_financeiro">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_cpf'] ?>" name="pessoa_cpf_responsavel_financeiro" class="form-control j_sys_change_cpf formCpf">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label  class="bmd-label-floating">RG</label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_rg'] ?>" name="pessoa_rg_responsavel_financeiro" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['OrgEM'] ?></label>
                                                                            <input disabled type="text" value="<?= $RFinanceiroList['pessoa_emissor'] ?>" name="pessoa_emissor_responsavel_financeiro" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                            ?>
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
                                                <input disabled type="text" value="<?= $Pessoa['pessoa_observacao'] ?>" name="pessoa_observacao" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    <input disabled type="checkbox" name="pessoa_status" value="1" <?= ($Pessoa['pessoa_status'] == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="ColaboradorEditar"/>
                                <input type="hidden" class="quantidade_telefone" name="quantidade_telefone" value="<?= $QTDTelefones ?>"/>
                               
                                
                                <div class="clearfix"></div>
                            </form>    
                        <?php
                        else:
                            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                            header('Location: painel.php?exe=rh/colaborador/cadastro_colaborador');
                            exit;
                        endif;
                    endif;
                    ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= ESCOLA_ALUNOS ?>
    </div>
  </div>