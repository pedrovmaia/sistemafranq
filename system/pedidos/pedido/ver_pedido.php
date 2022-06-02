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
                                <h4 class="card-title"><?= $texto['VerPDS'] ?></h4>
                                <p class="card-category"><?= $texto['VerPDSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDIDOS_PEDIDO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_pedidos", "WHERE pedido_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);
                    $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$pedido_cliente_id}");
                    $PessoaNome = $Read->getResult()[0]['pessoa_nome'];
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
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#messages" data-toggle="tab">
                                                        <?= $texto['PARTRS'] ?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>

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
                                                            <input readonly value="<?= $PessoaNome ?>" type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                            <input readonly autocomplete="off" value="<?= number_format($pedido_valor_total, 2, ',', '.') ?>" type="text" name="pedido_valor_total" class="form-control dinheiro">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['VLRENT'] ?></label>
                                                            <input readonly value="<?= number_format($pedido_valor_entrada, 2, ',', '.') ?>" autocomplete="off" type="text" name="pedido_valor_entrada" class="form-control dinheiro">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                            <input readonly value="<?= $pedido_observacao ?>" autocomplete="off" type="text" name="pedido_observacao" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="hidden_div_recorrente" style="display: block;">
                                                <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                    <label class="bmd-label-floating"><strong><?= $texto['PARCMS'] ?></strong></label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['PAYPA'] ?></label>
                                                                <?php
                                                                $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st AND forma_parcelamento_id = :id", "st=0&id={$pedido_forma_parcelamento_id}");
                                                                if ($Read->getResult()):
                                                                    ?>
                                                                    <input readonly value="<?= $Read->getResult()[0]['forma_parcelamento_nome'] ?>" class="form-control">
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['QNTPA'] ?></label>
                                                                <input readonly value="<?= $pedido_total_parcela ?>" autocomplete="off"  type="number" name="pedido_total_parcela" id="parcela" class="form-control sys_parcela">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['INTER'] ?></label>
                                                                <input readonly value="<?= $pedido_recorrencia ?>" autocomplete="off"  type="text" name="pedido_recorrencia" id="intervalo" class="form-control sys_intervalo">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['TP'] ?></label>
                                                                <?php
                                                                if( $pedido_tipo_parcelamento == 0)
                                                                {
                                                                    $tipo_nome = 'A VISTA';
                                                                }

                                                                if( $pedido_tipo_parcelamento == 1)
                                                                {
                                                                    $tipo_nome = 'PARCELAMENTO';
                                                                }

                                                                if( $pedido_tipo_parcelamento == 2)
                                                                {
                                                                    $tipo_nome = 'RECORRÊNCIA';
                                                                }
                                                                ?>
                                                                <input readonly autocomplete="off" name="proposta_tipo_parcelamento" value="<?= $tipo_nome ?>" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['MenSPOi'] ?></strong></label>
                                                <div class="row">
                                                    <div class="table-responsive" style="padding: 10px">
                                                        <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_proposta">
                                                            <tr>
                                                                <th class="text-center"><?= $texto['ProdM'] ?></th>
                                                                <th class="text-center"><?= $texto['QNT'] ?></th>
                                                                <th class="text-center"><?= $texto['UNIT'] ?></th>
                                                                <th class="text-center"><?= $texto['TOT'] ?></th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                            <?php
                                                            $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_pedido_item AS I ON P.produto_id = I.pedido_item_produto_id WHERE I.pedido_item_proposta_id = :id", "id={$pedido_id}");
                                                            if($Read->getResult()) {
                                                                foreach ($Read->getResult() as $Produtos) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-4-half">
                                                                            <input readonly value="<?= $Produtos['produto_nome'] ?>"
                                                                                   placeholder="Clique e selecione seu produto"
                                                                                   type="text" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <input readonly autocomplete="off" min="0"
                                                                                   type="number" value="<?= $Produtos['pedido_item_quantidade'] ?>"
                                                                                   class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" min="0"
                                                                                       type="text" value="<?= $Produtos['pedido_item_valor_unitario'] ?>"
                                                                                       class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <div class="form-group">
                                                                                <input readonly autocomplete="off" min="0"
                                                                                       type="text" value="<?= $Produtos['pedido_item_valor_total'] ?>"
                                                                                       class="form-control formMoney">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>
                                                <div class="row">
                                                    <div class="table-responsive" style="padding: 10px">
                                                        <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                            <tr>
                                                                <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                                <th class="text-center"><?= $texto['CXC'] ?></th>
                                                                <th class="text-center"><?= $texto['PriceM'] ?></th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                            <?php
                                                            $Read->FullRead("SELECT C.centro_custo_nome, CC.conta_contabil_nome, R.pedido_rateio_valor FROM sys_centro_custo AS C INNER JOIN sys_pedido_rateio AS R ON C.centro_custo_id = R.pedido_rateio_centro_custo_id INNER JOIN sys_conta_contabil AS CC ON R.pedido_rateio_conta_contabil_id = CC.conta_contabil_id WHERE R.pedido_rateio_proposta_id = :id", "id={$pedido_id}");
                                                            if($Read->getResult()) {
                                                                foreach ($Read->getResult() as $Custo) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-4-half">
                                                                            <input readonly value="<?= $Custo['centro_custo_nome'] ?>" type="text" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <input readonly value="<?= $Custo['conta_contabil_nome'] ?>" type="text" class="form-control">
                                                                        </td>
                                                                        <td class="pt-4-half">
                                                                            <input readonly value="<?= number_format($Custo['pedido_rateio_valor'], 2, ',', '.') ?>" type="text" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>



                                        <div class="tab-pane" id="messages">

                                            <div class="border_shadow" style="padding: 20px">


                                                <table  class="table table-hover display"
                                                        id="table"
                                                        data-toolbar="#toolbar"
                                                        data-locale="pt-BR"
                                                        data-show-export="true"
                                                        data-filter-control="true"
                                                        data-filter-show-clear="true"
                                                        data-show-toggle="true"
                                                        data-show-fullscreen="true"
                                                        data-show-columns="true"
                                                        data-minimum-count-columns="2"
                                                        data-url="_ajax/financeiro/ListParcelasPorPedido.ajax.php?action=list&pedido_id=<?= $Id ?>"
                                                        data-pagination="true"
                                                        data-id-field="id"
                                                        data-buttons-class="primary">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="id" data-filter-control="input">ID</th>
                                                        <th data-field="parcela" data-filter-control="input"><?= $texto['PARC'] ?></th>
                                                        <th data-field="vencimento" data-filter-control="input"><?= $texto['DDVC'] ?></th>
                                                        <th data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>
                                                        <th data-field="pagamento" data-filter-control="input"><?= $texto['PAYDA'] ?></th>
                                                        <th data-field="acoes"><?= $texto['Act'] ?></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                        </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=escola/turma/cadastro_sala');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDIDOS_PEDIDO ?>
  </div>
</div>
