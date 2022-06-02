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
                                <h4 class="card-title"><?= $texto['VerPDCMPR'] ?></h4>
                                <p class="card-category"><?= $texto['VerPDCMPRi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".SUPRIMENTOS_PEDIDO_COMPRA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_pedido_compra", "WHERE pedido_compra_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);

                    $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$pedido_fornecedor_id}");
                    $ForncecedorNome = $Read->getResult()[0]['pessoa_nome'];
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">

                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['FORNi'] ?></label>
                                                            <input readonly value="<?= $ForncecedorNome ?>" type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                            <input readonly autocomplete="off" value="<?= number_format($pedido_compra_valor_total, 2, ',', '.') ?>" type="text" name="pedido_compra_valor_total" class="form-control dinheiro">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                            <input readonly value="<?= $pedido_compra_observacao ?>" autocomplete="off" type="text" name="pedido_compra_observacao" class="form-control">
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
                                                                <th class="text-center"><?= $texto['CLAL'] ?></th>
                                                                <th class="text-center"><?= $texto['ProdM'] ?></th>
                                                                <th class="text-center"><?= $texto['QNT'] ?></th>
                                                                <th class="text-center"><?= $texto['TOT'] ?></th>
                                                            </tr>
                                                            <?php
                                                            $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_pedido_compra_item AS I ON P.produto_id = I.pedido_item_produto_id WHERE I.pedido_item_pedido_id = :id", "id={$pedido_compra_id}");
                                                            if($Read->getResult()) {
                                                                foreach ($Read->getResult() as $Produtos) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-4-half">
                                                                            <?php
                                                                            if($Produtos['pedido_item_cliente_id'] != 0){
                                                                                $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$Produtos['pedido_item_cliente_id']}");
                                                                                $PessoaNome = $Read->getResult()[0]['pessoa_nome'];
                                                                            } else {
                                                                                $PessoaNome = "Sem Cliente Selecionado";
                                                                            }
                                                                            ?>
                                                                            <input readonly value="<?= $PessoaNome ?>" placeholder="Clique e selecione o cliente / aluno" id="proposta_item_cliente_0" type="text" name="nome_cliente_0" class="form-control j_cliente_pedido_compra">
                                                                        </td>
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
      ID FUNCIONALIDADE: <?= SUPRIMENTOS_PEDIDO_COMPRA ?>
  </div>
</div>
