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
                                <h4 class="card-title"><?= $texto['VerORC'] ?></h4>
                                <p class="card-category"><?= $texto['VerORCi'] ?></p>
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
                $Read->ExeRead("sys_orcamento_matricula", "WHERE orcamento_matricula_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-primary">
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">

                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#profile" data-toggle="tab">
                                                        <?= $texto['INFOP'] ?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li><!--
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#messages" data-toggle="tab">
                                                        PARCELAS DA MATRÍCULA
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">

                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['CLAL'] ?></label>
                                                            <input disabled value="<?= $orcamento_matricula_aluno_nome ?>" type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                            <input disabled autocomplete="off" value="<?= number_format($orcamento_matricula_valor_total, 2, ',', '.') ?>" type="text" name="pedido_valor_total" class="form-control dinheiro">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PATR'] ?></label>
                                                            <select disabled style="margin-top: -3px" class="form-control" name="matricula_patrocinador_id">
                                                                <option value=""><?= $texto['EscPATR'] ?></option>
                                                                <?php
                                                                $Read->ExeRead("sys_patrocinadores", "WHERE patrocionador_status = :st", "st=0");
                                                                if ($Read->getResult()):
                                                                    foreach ($Read->getResult() as $Patrocinador):
                                                                        ?>
                                                                        <option <?= ($orcamento_matricula_patrocinador_id == $Patrocinador['patrocionador_id'] ? "selected='selected'" : ""); ?> value="<?= $Patrocinador['patrocionador_id'] ?>"><?= $Patrocinador['patrocionador_nome'] ?></option>
                                                                    <?php
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                            <input disabled value="<?= $orcamento_matricula_observacao ?>" autocomplete="off" type="text" name="pedido_observacao" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="card">
                                                            <div class="card-header card-header-primary">
                                                                <h4 class="card-title"><?= $texto['EstCRS'] ?></h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover j_tabela_matricula_estagios_curso">
                                                                    <thead>
                                                                        <th><?= $texto['EstName'] ?></th>
                                                                        <th style="width: 115px;"><?= $texto['Price'] ?></th>
                                                                        <th style="width: 85px;"></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $i = 0;
                                                                    $Read->FullRead("SELECT P.estagio_produto_nome, I.* FROM sys_estagio_produto AS P INNER JOIN sys_orcamento_matricula_item AS I ON P.estagio_produto_id = I.orcamento_matricula_item_produto_id WHERE I.orcamento_matricula_item_orcamento_id = :id AND I.orcamento_matricula_item_tipo = 1", "id={$orcamento_matricula_id}");
                                                                    if($Read->getResult()) {
                                                                        foreach ($Read->getResult() as $Produtos) {
                                                                            ?>
                                                                            <tr class="table_<?= $i ?>">
                                                                                <td>
                                                                                    <input type="hidden" class="pedido_item_tipo_<?= $i ?>" name="pedido_item_tipo_<?= $i ?>" value="1">
                                                                                    <span class="bmd-form-group is-filled">
                                                                                        <input value="<?= $Produtos['estagio_produto_nome'] ?>" disabled="" type="text" name="nome_produto_<?= $i ?>" class="form-control nome_produto_<?= $i ?>">
                                                                                    </span>
                                                                                    <input value="<?= $Produtos['orcamento_matricula_item_produto_id'] ?>" type="hidden" name="nome_produto_<?= $i ?>_id">
                                                                                </td>
                                                                                    <input value="<?= $Produtos['modalidade_id'] ?>" disabled="" type="hidden" name="proposta_item_modalidade_<?= $i ?>" class="proposta_item_modalidade_<?= $i ?>">
                                                                                <td>
                                                                                    <input disabled="" autocomplete="off" min="0" type="text" name="proposta_item_valor_total_<?= $i ?>" class="form-control proposta_item_valor_total_<?= $i ?> valor_total_tabela formMoney" value="<?= $Produtos['orcamento_matricula_item_valor_total'] ?>">
                                                                                    <input type="hidden" name="proposta_item_valor_original_<?= $i ?>" class="proposta_item_valor_original_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_valor_total_sem_desconto'] ?>">
                                                                                    <input disabled="" type="hidden" name="proposta_item_valor_unitario_<?= $i ?>" class="form-control proposta_item_valor_unitario_<?= $i ?> dinheiro" value="<?= number_format($Produtos['orcamento_matricula_item_valor_unitario'], 2, ',', '.') ?>">
                                                                                    <input type="hidden" name="proposta_item_quantidade_<?= $i ?>" class="form-control proposta_item_quantidade_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_quantidade'] ?>">
                                                                                    <input type="hidden" class="desconto_matricula_<?= $i ?>" name="desconto_matricula_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_desconto_id'] ?>">
                                                                                    <input type="hidden" class="proposta_item_parcelamento_id_<?= $i ?>" name="proposta_item_parcelamento_id_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_forma_parcelamento_id'] ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_entrada'] ?>" name="proposta_entrada_<?= $i ?>" class="proposta_valor_entrada proposta_entrada_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_data_entrada'] ?>" name="proposta_data_entrada_<?= $i ?>" class="proposta_data_entrada_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_dia_vencimento_id'] ?>" name="proposta_dia_vencimento_<?= $i ?>" class="proposta_dia_vencimento_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= date('Y-m-d', strtotime($Produtos['orcamento_matricula_item_data_primeiro_vencimento'])) ?>" name="proposta_data_primeiro_vencimento_<?= $i ?>" class="proposta_data_primeiro_vencimento_<?= $i ?>"
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <span class="td-actions">
                                                                                        <a accesskey="table_<?= $i ?>" title="Ver" class="btn btn-primary btn-link btn-editar">
                                                                                            <i class="material-icons">visibility</i>
                                                                                        </a>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="card">
                                                            <div class="card-header card-header-primary">
                                                                <h4 class="card-title"><?= $texto['MateDN'] ?></h4>
                                                            </div>
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-hover j_tabela_matricula_materia_didaticos_curso">
                                                                    <thead>
                                                                        <th><?= $texto['NomeMAT'] ?></th>
                                                                        <th style="width: 120px;"><?= $texto['Price'] ?></th>
                                                                        <th style="width: 85px;"></th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_orcamento_matricula_item AS I ON P.produto_id = I.orcamento_matricula_item_produto_id WHERE I.orcamento_matricula_item_orcamento_id = :id AND I.orcamento_matricula_item_tipo = 2", "id={$orcamento_matricula_id}");
                                                                    if ($Read->getResult()) {
                                                                        foreach ($Read->getResult() as $Produtos) {
                                                                            ?>
                                                                            <tr class="table_<?= $i ?>">
                                                                                <td>
                                                                                    <input type="hidden" class="pedido_item_tipo_<?= $i ?>" name="pedido_item_tipo_<?= $i ?>" value="2">
                                                                                    <span class="bmd-form-group is-filled">
                                                                                        <input value="<?= $Produtos['produto_nome'] ?>" disabled="" type="text" name="nome_produto_<?= $i ?>" class="form-control nome_produto_<?= $i ?>">
                                                                                    </span>
                                                                                    <input value="<?= $Produtos['orcamento_matricula_item_produto_id'] ?>" type="hidden" name="nome_produto_<?= $i ?>_id">
                                                                                </td>
                                                                                <input value="<?= $Produtos['modalidade_id'] ?>" disabled="" type="hidden" name="proposta_item_modalidade_<?= $i ?>" class="proposta_item_modalidade_<?= $i ?>">
                                                                                <td>
                                                                                    <input disabled="" autocomplete="off" min="0" type="text" name="proposta_item_valor_total_<?= $i ?>" class="form-control proposta_item_valor_total_<?= $i ?> valor_total_tabela formMoney" value="<?= $Produtos['orcamento_matricula_item_valor_total'] ?>">
                                                                                    <input type="hidden" name="proposta_item_valor_original_<?= $i ?>" class="proposta_item_valor_original_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_valor_total_sem_desconto'] ?>">
                                                                                    <input disabled="" type="hidden" name="proposta_item_valor_unitario_<?= $i ?>" class="form-control proposta_item_valor_unitario_<?= $i ?> dinheiro" value="<?= number_format($Produtos['orcamento_matricula_item_valor_unitario'], 2, ',', '.') ?>">
                                                                                    <input type="hidden" name="proposta_item_quantidade_<?= $i ?>" class="form-control proposta_item_quantidade_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_quantidade'] ?>">
                                                                                    <input type="hidden" class="desconto_matricula_<?= $i ?>" name="desconto_matricula_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_desconto_id'] ?>">
                                                                                    <input type="hidden" class="proposta_item_parcelamento_id_<?= $i ?>" name="proposta_item_parcelamento_id_<?= $i ?>" value="<?= $Produtos['orcamento_matricula_item_forma_parcelamento_id'] ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_entrada'] ?>" name="proposta_entrada_<?= $i ?>" class="proposta_valor_entrada proposta_entrada_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_data_entrada'] ?>" name="proposta_data_entrada_<?= $i ?>" class="proposta_data_entrada_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= $Produtos['orcamento_matricula_item_dia_vencimento_id'] ?>" name="proposta_dia_vencimento_<?= $i ?>" class="proposta_dia_vencimento_<?= $i ?>">
                                                                                    <input type="hidden" value="<?= date('Y-m-d', strtotime($Produtos['orcamento_matricula_item_data_primeiro_vencimento'])) ?>" name="proposta_data_primeiro_vencimento_<?= $i ?>" class="proposta_data_primeiro_vencimento_<?= $i ?>"
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <span class="td-actions">
                                                                                        <a accesskey="table_<?= $i ?>" title="Ver" class="btn btn-primary btn-link btn-editar">
                                                                                            <i class="material-icons">visibility</i>
                                                                                        </a>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/finalizar_matricula&id=<?= $orcamento_matricula_id ?>" class="btn btn-primary pull-right orcamento_matricula_button"><?= $texto['TRORC'] ?></a>

                                            <a href="#" rel="<?= $orcamento_matricula_id ?>" class="btn btn-danger pull-right expirar_orcamento_matricula_button"><?= $texto['EXORC'] ?></a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                else:
                    echo "Orçamento não encontrado!!!";
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_CURSO ?>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModalDetalhesItens">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="profile">
                            <div class="border_shadow" style="background-color: #fff; padding: 20px">

                                <div class="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Item</label>
                                                <input disabled type="text" class="form-control nome_item_modal">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Valor Unitário</label>
                                                <input disabled type="text" class="form-control valor_unitario_item_modal dinheiro">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Quantidade</label>
                                                <input disabled type="number" class="form-control quantidade_item_modal">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Desconto</label>
                                                <select disabled style='margin-top: -3px' class='form-control desconto_item_modal'>
                                                    <option value=''>Escolha um desconto</option>
                                                    <?php
                                                    $Read->ExeRead('sys_descontos', 'WHERE desconto_status = :st', 'st=0');
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Desconto):
                                                            echo "<option value='{$Desconto['desconto_id']}'>{$Desconto['desconto_nome']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Valor Total</label>
                                                <input disabled type="text" class="form-control valor_total_item_modal dinheiro">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Valor Original</label>
                                                <input disabled type="text" class="form-control valor_original_item_modal dinheiro">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Forma de Parcelamento</label>
                                                <select disabled style='margin-top: -3px' class='form-control forma_parcelamento_item_modal'>
                                                    <option value=''>Escola a forma de parcelamento</option>
                                                    <?php
                                                    $Read->ExeRead('sys_forma_parcelamento', 'WHERE forma_parcelamento_status = :st', 'st=0');
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Forma):
                                                            echo "<option value='{$Forma['forma_parcelamento_id']}'>{$Forma['forma_parcelamento_nome']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Entrada</label>
                                                <input disabled autocomplete="off" min="0" type="text" class="form-control valor_entrada_item_modal dinheiro">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating"><?= $texto['SDTENi'] ?></label>
                                                <input disabled autocomplete="off" type="date" class="form-control data_entrada_item_modal" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating"><?= $texto['SDDVCi'] ?></label>
                                                <select disabled class="form-control dia_vencimento_item_modal">
                                                    <option value="" selected disabled>Selecione o dia de vencimento</option>
                                                    <?php
                                                    $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                    if($Read->getResult()){
                                                        foreach ($Read->getResult() as $Vencimento) {
                                                            ?>
                                                            <option value="<?= $Vencimento['dias_vencimento_id'] ?>"><?= $Vencimento['dias_vencimento_nome'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Data 1º vencimento</label>
                                                <input disabled autocomplete="off" type="date" class="form-control data_primeiro_vencimento_item_modal" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Modalidade</label>
                                                <select disabled style='margin-top: -3px' class='form-control modalidade_item_modal'>
                                                    <option value=''>Escola a modalidade</option>
                                                    <?php
                                                    $Read->ExeRead('sys_modalidades', 'WHERE modalidade_status = :st', 'st=0');
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Modalidade):
                                                            echo "<option value='{$Modalidade['modalidade_id']}'>{$Modalidade['modalidade_nome']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" class="table_atual_item_modal">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>