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
                                <h4 class="card-title"><?= $texto['VerNGC'] ?></h4>
                                <p class="card-category"><?= $texto['VerNGCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_NEGOCIACOES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_negociacoes", "WHERE negociacoes_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$negociacoes_pessoa_id}");
                    $PessoaNome = $Read->getResult()[0]['pessoa_nome'];
                     $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$negociacoes_funcionario_id}");
                    $FuncionarioNome = $Read->getResult()[0]['pessoa_nome'];
                    ?>

        <form class="form_editora">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['OriTitl'] ?></strong></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['ALNS'] ?></label>
                            <input type="text" disabled name="pessoa_nome" readonly value="<?= $PessoaNome ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                            <input type="text" disabled name="negociacoes_data" value="<?= date('d/m/Y', strtotime($negociacoes_data)) ?>"  class="form-control">
                        </div>
                    </div>
                </div>
                                                                        <div class="row">
                                                         <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['HR'] ?></label>
                            <input type="text" disabled name="negociacoes_hora" value="<?= $negociacoes_hora ?>" class="form-control">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <input type="text" disabled name="negociacoes_descricao" value="<?= $negociacoes_descricao ?>" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['FNC'] ?></label>
                            <input type="text" disabled name="pessoa_nome" readonly value="<?= $FuncionarioNome ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

                                           <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['PARCMS'] ?></strong></label>
                                                <div class="row">
                                                    <div class="table-responsive" style="padding: 10px">

                                                        <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_matricula">
                                                            <tr class="table_0">
                                                                <th class="text-center"><?= $texto['ProdM'] ?></th>
                                                                <th class="text-center"><?= $texto['QNT'] ?></th>
                                                                <th class="text-center"><?= $texto['UNIT'] ?></th>
                                                                <th class="text-center"><?= $texto['DSCT'] ?></th>
                                                                <th class="text-center"><?= $texto['TOT'] ?></th>
                                                            </tr>
                                                            <?php
                                                            $Read->FullRead("SELECT P.estagio_produto_nome, I.* FROM sys_estagio_produto AS P INNER JOIN sys_matricula_item AS I ON P.estagio_produto_id = I.matricula_item_produto_id WHERE I.matricula_item_proposta_id = 1 AND I.matricula_item_tipo = 1", );
                                                            if($Read->getResult()) {
                                                                foreach ($Read->getResult() as $Produtos) {
                                                                    ?>
                                                                    <tr class="table_0">
                                                                        <td class="pt-4-half">
                                                                            <input readonly placeholder="Clique e selecione seu produto" value="<?= $Produtos['estagio_produto_nome'] ?>" type="text" name="nome_produto_0" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <input readonly autocomplete="off" min="0" type="number" value="<?= $Produtos['matricula_item_quantidade'] ?>" name="proposta_item_quantidade_0" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" value="<?= $Produtos['matricula_item_valor_unitario'] ?>" min="0" type="text" name="proposta_item_valor_unitario_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled style="margin-top: -3px" class="form-control" name="proposta_desconto_0">
                                                                                    <option value=""><?= $texto['SDSCT'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_descontos", "WHERE desconto_status = :st", "st=0");
                                                                                    if ($Read->getResult()):
                                                                                        foreach ($Read->getResult() as $Desconto):
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_desconto_id'] == $Desconto['desconto_id'] ? "selected='selected'" : ''); ?> value="<?= $Desconto['desconto_id'] ?>"><?= $Desconto['desconto_nome'] ?></option>
                                                                                        <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" value="<?= $Produtos['matricula_item_valor_total'] ?>" min="0" type="text" name="proposta_item_valor_total_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table_0">
                                                                        <th class="text-center"><?= $texto['PARCM'] ?></th>
                                                                        <th class="text-center"><?= $texto['INi'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDTEN'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDDVC'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDDPVC'] ?></th>
                                                                    </tr>
                                                                    <tr class="table_0">
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled style="margin-top: -3px" class="form-control" name="proposta_item_parcelamento_id_0">
                                                                                    <option value=""><?= $texto['ESCPAi'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                                                    if ($Read->getResult()):
                                                                                        foreach ($Read->getResult() as $Forma):
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_item_forma_parcelamento_id'] == $Forma['forma_parcelamento_id'] ? "selected='selected'" : ''); ?> value="<?= $Forma['forma_parcelamento_id'] ?>"><?= $Forma['forma_parcelamento_nome'] ?></option>
                                                                                        <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" min="0" value="<?= $Produtos['matricula_item_entrada'] ?>" type="text" name="proposta_entrada_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <?php
                                                                                if($Produtos['matricula_data_entrada'] == "0000-00-00 00:00:00" || $Produtos['matricula_data_entrada'] == null) {
                                                                                  ?>
                                                                                    <input readonly autocomplete="off" type="date" name="proposta_data_entrada_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                  <?php
                                                                                } else {
                                                                                  ?>
                                                                                    <input readonly autocomplete="off" type="date" value="<?= date('Y-m-d', strtotime($Produtos['matricula_data_entrada'])) ?>" name="proposta_data_entrada_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                  <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled class="form-control matricula_dia_vencimento" name="proposta_dia_vencimento_0">
                                                                                    <option value="" selected disabled><?= $texto['SSDDVC'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                                                    if($Read->getResult()){
                                                                                        foreach ($Read->getResult() as $Vencimento) {
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_dia_vencimento_id'] == $Vencimento['dias_vencimento_id'] ? "selected='selected'" : ''); ?> value="<?= $Vencimento['dias_vencimento_id'] ?>"><?= $Vencimento['dias_vencimento_nome'] ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <?php
                                                                                if($Produtos['matricula_data_primeiro_vencimento'] == "0000-00-00 00:00:00") {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" name="proposta_data_primeiro_vencimento_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" value="<?= date('Y-m-d', strtotime($Produtos['matricula_data_primeiro_vencimento'])) ?>" name="proposta_data_primeiro_vencimento_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class='separar'></tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_matricula_item AS I ON P.produto_id = I.matricula_item_produto_id WHERE I.matricula_item_proposta_id = 1 AND I.matricula_item_tipo = 2");
                                                            if ($Read->getResult()) {
                                                                foreach ($Read->getResult() as $Produtos) {
                                                                    ?>
                                                                    <tr class="table_0">
                                                                        <td class="pt-4-half">
                                                                            <input readonly placeholder="Clique e selecione seu produto" value="<?= $Produtos['produto_nome'] ?>" type="text" name="nome_produto_0" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <input readonly autocomplete="off" min="0" type="number" value="<?= $Produtos['matricula_item_quantidade'] ?>" name="proposta_item_quantidade_0" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" value="<?= $Produtos['matricula_item_valor_unitario'] ?>" min="0" type="text" name="proposta_item_valor_unitario_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled style="margin-top: -3px" class="form-control" name="proposta_desconto_0">
                                                                                    <option value=""><?= $texto['SDSCT'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_descontos", "WHERE desconto_status = :st", "st=0");
                                                                                    if ($Read->getResult()):
                                                                                        foreach ($Read->getResult() as $Desconto):
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_desconto_id'] == $Desconto['desconto_id'] ? "selected='selected'" : ''); ?> value="<?= $Desconto['desconto_id'] ?>"><?= $Desconto['desconto_nome'] ?></option>
                                                                                        <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" value="<?= $Produtos['matricula_item_valor_total'] ?>" min="0" type="text" name="proposta_item_valor_total_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table_0">
                                                                        <th class="text-center"><?= $texto['PARCM'] ?></th>
                                                                        <th class="text-center">?= $texto['INi'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDTEN'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDDVC'] ?></th>
                                                                        <th class="text-center"><?= $texto['SDDPVC'] ?></th>
                                                                    </tr>
                                                                    <tr class="table_0">
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled style="margin-top: -3px" class="form-control" name="proposta_item_parcelamento_id_0">
                                                                                    <option value=""><?= $texto['ESCPAi'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                                                    if ($Read->getResult()):
                                                                                        foreach ($Read->getResult() as $Forma):
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_item_forma_parcelamento_id'] == $Forma['forma_parcelamento_id'] ? "selected='selected'" : ''); ?> value="<?= $Forma['forma_parcelamento_id'] ?>"><?= $Forma['forma_parcelamento_nome'] ?></option>
                                                                                        <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" min="0" value="<?= $Produtos['matricula_item_entrada'] ?>" type="text" name="proposta_entrada_0" class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <?php
                                                                                if($Produtos['matricula_data_entrada'] == "0000-00-00 00:00:00") {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" name="proposta_data_entrada_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" value="<?= date('Y-m-d', strtotime($Produtos['matricula_data_entrada'])) ?>" name="proposta_data_entrada_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <select disabled class="form-control matricula_dia_vencimento" name="proposta_dia_vencimento_0">
                                                                                    <option value="" selected disabled><?= $texto['SSDDVC'] ?></option>
                                                                                    <?php
                                                                                    $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                                                    if($Read->getResult()){
                                                                                        foreach ($Read->getResult() as $Vencimento) {
                                                                                            ?>
                                                                                            <option <?= ($Produtos['matricula_dia_vencimento_id'] == $Vencimento['dias_vencimento_id'] ? "selected='selected'" : ''); ?> value="<?= $Vencimento['dias_vencimento_id'] ?>"><?= $Vencimento['dias_vencimento_nome'] ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <?php
                                                                                if($Produtos['matricula_data_primeiro_vencimento'] == "0000-00-00 00:00:00") {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" name="proposta_data_primeiro_vencimento_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <input readonly autocomplete="off" type="date" value="<?= date('Y-m-d', strtotime($Produtos['matricula_data_primeiro_vencimento'])) ?>" name="proposta_data_primeiro_vencimento_0" class="form-control" placeholder="dd/mm/yyyy">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class='separar'></tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </table>

                                                </div>
                                            </div>

                                    </div>


                                                    </div>
                                                </div>
                                            </div>



                <br/>
            </div>
            <br/>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=financeiro/cadastro_negociacao');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      <?= $texto['IDFunc'] ?> <?= FINANCEIRO_NEGOCIACOES ?>
  </div>
</div>
