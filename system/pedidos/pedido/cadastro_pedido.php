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
<div class="content" style="padding: 0 5px">
    <div class="container-fluid" style="padding-right: 10px; padding-left: 0px;">
        <form class="form_pedido">
        <div class="row" id="js_alteraSroll" style="min-height: 550px">
          <div class="col-md-4" style="padding-right: 0">
            <div class="topo_pedido_cliente">
                <div class="escolha_aluno_pedido">
                    <a data-toggle="modal" data-target="#getCodeAlunosModal">
                        <input readonly required type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" id="txt_aluno" class="form-control">
                    </a>
                    <input  id="txt_id_aluno" type="hidden" name="pedido_cliente_id" class="form-control">
                </div>

                <div class="escolha_obs_pedido">
                    <input placeholder="Digite uma observação" autocomplete="off" type="text" name="pedido_observacao" class="form-control">
                </div>
            </div>

            <div class="itens_pedido_cliente" id="itens_pedido_cliente">
                <div class="col-md-12">
                    <div class="row item_selecionado"></div>
                </div>
            </div>

          </div>

          <div class="col-md-8" style="padding-left: 0">
            <div class="topo_pedido">
              <?php
              $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
              if($Read->getResult()){
                $NomeUnidade = $Read->getResult()[0]['pessoa_nome'];
              } else {
                $NomeUnidade = "";
              }
              ?>
              <span class="nome_empresa"><?= $NomeUnidade ?></span>
            </div>
            <div class="categorias_produtos">

                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <?php
                            $Read->ExeRead("sys_tipo_produto");
                            if($Read->getResult()) {
                                $i = 0;
                                foreach ($Read->getResult() as $TipoProduto) {
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($i == 0 ? "active" : ""); ?>" href="#<?= Check::Name($TipoProduto['tipo_produto_nome']) ?>" data-toggle="tab">
                                            <?= $TipoProduto['tipo_produto_nome'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-content produtos_listagem" id="produtos_listagem">
                    <?php
                    $Read->ExeRead("sys_tipo_produto");
                    if($Read->getResult()) {
                        $i = 0;
                        foreach ($Read->getResult() as $TipoProduto) {
                            ?>
                            <div class="tab-pane  <?= ($i == 0 ? "active" : ""); ?>" id="<?= Check::Name($TipoProduto['tipo_produto_nome']) ?>">
                                <div class="row produtos_row_pedido">
                                <?php
                                $Read->ExeRead("sys_produto", "WHERE produto_categoria_id = :id AND produto_status = 0", "id={$TipoProduto['tipo_produto_id']}");
                                if($Read->getResult()) {
                                    foreach ($Read->getResult() as $Produto) {
                                        if (!$Produto['produto_capa']){
                                            $Produto['produto_capa'] = "tim.php?src=assets/img/Produto-sem-imagem.jpg&w=400&h=400";
                                        } else {
                                            $Produto['produto_capa'] = "tim.php?src=uploads/{$Produto['produto_capa']}&w=400&h=400";
                                        }
                                        ?>
                                            <div class="col-md-3 j_sys_add_produto_pedido" id="<?= $Produto['produto_id']; ?>">
                                                <div class="card">
                                                    <div class="card-body" style="padding: 5px 10px">
                                                        <img class="img-fluid" style="width: 100%;" src="<?= BASE . '/' . $Produto['produto_capa'] ?>" alt="<?= $Produto['produto_nome'] ?>" title="<?= $Produto['produto_nome'] ?>">
                                                        <p><?= $Produto['produto_nome']; ?></p>
                                                    </div>
                                                    <div class="card-footer" style="padding: 0; margin: 0 10px 10px;">
                                                        <p>Preço(R$) <b><?= number_format($Produto['produto_valor_venda'], 2, ',', '.'); ?></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                                ?>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
          </div>
        </div>
        <div class="row footer_lista_pedidos">
            <div class="col-md-4">
                <p><b>Valor Total:</b> R$ <span class="valor_total_list_pedidos">00,00</span></p>
            </div><div class="col-md-5"></div>
            <!--<div class="col-md-2">
                <div class="form-group">
                    <input autocomplete="off" type="text" placeholder="Valor de entrada" name="pedido_valor_entrada" class="form-control dinheiro">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select required class="form-control" name="pedido_forma_parcelamento_id">
                        <option selected disabled value="">Escolha a forma de parcelamento</option>
                        <?php
                        $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $Forma):
                                ?>
                                <option value="<?= $Forma['forma_parcelamento_id'] ?>"><?= $Forma['forma_parcelamento_nome'] ?></option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>-->
            <?php if(isset($_SESSION['caixaSYS'])) {
                ?>
                <div class="col-md-3">
                    <input type="hidden" name="action" value="PedidoAdd">
                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['LANCPDS'] ?></button>
                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                </div>
                <?php
            }
            ?>
        </div>
        </form>
    </div>
      ID FUNCIONALIDADE: <?= PEDIDOS_PEDIDO ?>
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

<div class="showcase hide-print" id="getCodeAlunosModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_alunos"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-click-to-select="true"
                            data-buttons-class="primary">
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th data-field="id" data-filter-control="input"><?= $texto['SITACi'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var alturaScroll = screen.height - 230;
    document.getElementById("js_alteraSroll").style.height = alturaScroll + "px";
    var alturaScrollItens = screen.height - 340;
    document.getElementById("itens_pedido_cliente").style.height = alturaScrollItens + "px";
    var alturaScrollProdutos = screen.height - 340;
    document.getElementById("produtos_listagem").style.height = alturaScrollProdutos + "px";
</script>