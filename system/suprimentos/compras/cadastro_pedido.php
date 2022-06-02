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
                                <h4 class="card-title"><?= $texto['NEWPED'] ?></h4>
                                <p class="card-category"><?= $texto['INCLPED'] ?></p>
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
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_pedido_compra", "WHERE pedido_compra_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);

                              $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_id = :id", "id={$pedido_fornecedor_id}");
                              $ForncecedorNome = $Read->getResult()[0]['pessoa_nome'];
                              $ForncecedorId = $Read->getResult()[0]['pessoa_id'];
                              ?>
                              <form class="form_proposta" autocomplete="false">

                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">FORNECEDOR</label>
                                                  <a data-toggle="modal" data-target="#getCodeModalFornecedor">
                                                      <input readonly value="<?= $ForncecedorNome ?>" type="text" placeholder="Clique e selecione seu fornecedor" name="nome_fornecedor" id="nome_fornecedor" class="form-control">
                                                  </a>
                                                  <input id="txt_id_fornecedor" value="<?= $ForncecedorId ?>" type="hidden" name="txt_id_fornecedor" class="form-control">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">VALOR</label>
                                                  <input readonly autocomplete="off" value="<?= number_format($pedido_compra_valor_total, "2", ",", ".") ?>" type="text" name="pedido_compra_valor_total" class="form-control valor_total dinheiro">
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">OBSERVAÇÃO</label>
                                                  <input autocomplete="off" value="<?= $pedido_compra_observacao ?>" type="text" name="pedido_observacao" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                      <label class="bmd-label-floating"><strong>PRODUTOS</strong></label>
                                      <div class="row">
                                          <div class="col-md-12">

                                        <span class="table-produtos-add-proposta float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> <?= $texto['ADDPRODD'] ?></a>
                                        </span>
                                          </div>
                                          <div class="table-responsive" style="padding: 10px">
                                              <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_proposta">
                                                  <tr>
                                                      <th class="text-center">PESQUISE O CLIENTE/ALUNO</th>
                                                      <th class="text-center">PESQUISE O PRODUTO</th>
                                                      <th class="text-center">QUANTIDADE</th>
                                                      <th class="text-center">TOTAL</th>
                                                      <th class="text-center"></th>
                                                  </tr>
                                                  <?php
                                                  $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_pedido_compra_item AS I ON P.produto_id = I.pedido_item_produto_id WHERE I.pedido_item_pedido_id = :id", "id={$pedido_compra_id}");
                                                  if($Read->getResult()) {
                                                      $QTDProdutos = $Read->getRowCount();
                                                      $i = 0;
                                                      foreach ($Read->getResult() as $Produtos) {

                                                          if($Produtos['pedido_item_cliente_id'] != 0) {
                                                              $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id",
                                                                  "id={$Produtos['pedido_item_cliente_id']}");
                                                              $PessoaNome = $Read->getResult()[0]['pessoa_nome'];
                                                          } else {
                                                              $PessoaNome = "";
                                                          }
                                                          ?>
                                                          <tr>
                                                              <td class="pt-4-half">
                                                                  <input readonly accesskey="<?= $Produtos['pedido_item_cliente_id'] ?>" value="<?= $PessoaNome ?>" placeholder="Clique e selecione o cliente / aluno" id="proposta_item_cliente_<?= $i ?>" type="text" name="nome_cliente_<?= $i ?>" class="form-control j_cliente_pedido_compra">
                                                              </td>
                                                              <td class="pt-4-half">
                                                                  <input type="hidden" name="item_<?= $i ?>" value="<?= $Produtos['pedido_item_id'] ?>">
                                                                  <input readonly accesskey="<?= $Produtos['pedido_item_produto_id'] ?>" placeholder="Clique e selecione seu produto" value="<?= $Produtos['produto_nome'] ?>" data-total="proposta_item_valor_total_<?= $i ?>" data-qtd="proposta_item_quantidade_<?= $i ?>" id="proposta_item_valor_unitario_<?= $i ?>" type="text" name="nome_produto_<?= $i ?>" class="form-control j_produto_proposta">
                                                              </td>
                                                              <td class="pt-4-half">
                                                                  <input autocomplete="off" min="0" type="number" data-uni="<?= $Produtos['pedido_item_valor_total'] / $Produtos['pedido_item_quantidade'] ?>" value="<?= $Produtos['pedido_item_quantidade'] ?>" data-total="proposta_item_valor_total_<?= $i ?>" name="proposta_item_quantidade_<?= $i ?>" class="form-control proposta_item_quantidade_<?= $i ?> qtd_itens_list">
                                                              </td>
                                                              <td class="pt-4-half">
                                                                  <div class="form-group">
                                                                      <input readonly autocomplete="off" value="<?= $Produtos['pedido_item_valor_total'] ?>" type="text" name="proposta_item_valor_total_<?= $i ?>" class="form-control proposta_item_valor_total_<?= $i ?> valor_total_tabela formMoney">
                                                                  </div>
                                                              </td>
                                                              <td>
                                                                  <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                                              </td>
                                                          </tr>
                                                          <?php
                                                          $i++;
                                                      }
                                                  } else {
                                                      $QTDProdutos = 0;
                                                  }
                                                  ?>
                                              </table>
                                          </div>
                                      </div>
                                  </div>

                                      <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="checkbox-inline">
                                                          <input type="checkbox" name="pedido_compra_status" value="1" <?= ($pedido_compra_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      <br/>
                                      <input type="hidden" class="quantidade_produto_proposta" name="quantidade_produto_proposta" value="<?= $QTDProdutos ?>"/>
                                      <input type="hidden" name="action" value="PropostaEditar"/>
                                      <input type="hidden" name="proposta_id" value="<?= $Id; ?>"/>
                                      <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                      <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                      <?php
                                      if($permissao["deletar"] == 1) {
                                          ?>
                                          <span rel='single_user_addr' callback='suprimentos/Suprimentos' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                          <?php
                                      }
                                      ?>
                                      <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=pedidos/pedido/cadastro_pedido');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".SUPRIMENTOS_PEDIDO_COMPRA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_pedido_compra">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['FORNi'] ?></label>
                                            <a data-toggle="modal" data-target="#getCodeModalFornecedor">
                                                <input readonly type="text" placeholder="Clique e selecione seu fornecedor" name="nome_fornecedor" id="nome_fornecedor" class="form-control">
                                            </a>
                                            <input id="txt_id_fornecedor" type="hidden" name="txt_id_fornecedor" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                            <input readonly autocomplete="off" type="text" name="pedido_compra_valor_total" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                            <input autocomplete="off" type="text" name="pedido_observacao" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['MenSPOi'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">

                                        <span class="table-produtos-add-pedido-compra float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> <?= $texto['ADDPRODD'] ?></a>
                                        </span>
                                    </div>
                                    <div class="table-responsive" style="padding: 10px">
                                        <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_compra">
                                            <tr>
                                                <th class="text-center"><?= $texto['SearchCLA'] ?></th>
                                                <th class="text-center"><?= $texto['SearchPROD'] ?></th>
                                                <th class="text-center"><?= $texto['QNT'] ?></th>
                                                <th class="text-center"><?= $texto['TOT'] ?></th>
                                                <th class="text-center"></th>
                                            </tr>
                                            <tr>
                                                <td class="pt-4-half">
                                                    <input readonly placeholder="Clique e selecione o cliente / aluno" id="proposta_item_cliente_0" type="text" name="nome_cliente_0" class="form-control j_cliente_pedido_compra">
                                                </td>
                                                <td class="pt-4-half">
                                                    <input type='hidden' class='pedido_item_tipo_0' name='pedido_item_tipo_0' value='1'>
                                                    <input readonly placeholder="Clique e selecione seu produto" data-tipo="pedido_item_tipo_0" data-total="proposta_item_valor_total_0" data-qtd="proposta_item_quantidade_0" id="proposta_item_valor_unitario_0" type="text" name="nome_produto_0" class="form-control j_produto_proposta">
                                                </td>
                                                <td class="pt-4-half">
                                                    <input autocomplete="off" min="0" type="number" data-uni="0" data-total="proposta_item_valor_total_0" name="proposta_item_quantidade_0" class="form-control proposta_item_quantidade_0 qtd_itens_list">
                                                </td>
                                                <td class="pt-4-half">
                                                    <div class="form-group">
                                                        <input readonly autocomplete="off" min="0" type="text" name="proposta_item_valor_total_0" class="form-control proposta_item_valor_total_0 valor_total_tabela formMoney">
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <input type="hidden" class="quantidade_produto_proposta" name="quantidade_produto_proposta" value="1"/>
                            <input type="hidden" name="action" value="PedidoAdd"/>
                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['LANCPDS'] ?></button>
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
      ID FUNCIONALIDADE: <?= SUPRIMENTOS_PEDIDO_COMPRA ?>
  </div>
</div>
<style>
    .nav-tabs .nav-item .nav-link{
        color: #000 !important;
    }
    .nav-tabs .nav-item .nav-link:hover{
        color: #F33527 !important;
    }
    .nav-tabs .nav-item .nav-link.active{
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>
<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_produtos_proposta"
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
                                    <th data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                                    <th data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="showcase hide-print" id="getCodeAlunosModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_alunos_pedido_compra"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
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
                            <th data-field="id" data-filter-control="input">Situação</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModalFornecedor">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_fornecedores"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListFornecedores.ajax.php?action=list"
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
                            <th data-field="email" data-filter-control="input">E-mail</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
