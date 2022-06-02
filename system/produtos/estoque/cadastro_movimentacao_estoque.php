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
                                <h4 class="card-title"><?= $texto['MOVSESTQ'] ?></h4>
                                <p class="card-category"><?= $texto['CadMOVESTQ'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".MOVIMENTACAO_MANUAL_ESTOQUE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        if($Read->getResult()){
                            $permissao = $Read->getResult()[0];
                            $_SESSION['permissao'] = $permissao;
                        } else {
                          echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                          die;
                        }?>
                        <form class="form_movimento_estoque">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                            <input type="text" name="estoque_transacao_descricao" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TPMOVM'] ?></label>
                                             <select style="margin-top: -3px" class="form-control" name="estoque_transacao_operacao">
                                                <option value="0"><?= $texto['IN'] ?></option>
                                                <option value="1"><?= $texto['OUT'] ?></option>
                                             
                                              </select>
                                        </div>
                                    </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTAMOV'] ?></label>
                                            <input disabled value="<?= date('d/m/Y') ?>" type="text" name="estoque_transacao_data" class="form-control">
                                        </div>
                                    </div>



                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ProdM'] ?></label>
                                              <input readonly autocomplete="off" data-toggle="modal" data-target="#getCodeProdutoModal" placeholder="Clique e selecione o produto" id="txt_produtos" type="text"  class="form-control">
                                              <input id="txt_id_produtos" type="hidden" name="estoque_transacao_produto_id" class="form-control">
                                        </div>
                                    </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                            <input type="text" name="estoque_transacao_valor" class="form-control dinheiro">
                                        </div>
                                    </div>

                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="bmd-label-floating"><?= $texto['QNT'] ?></label>
                                                <input type="number" name="estoque_transacao_quantidade" class="form-control">
                                          </div>
                                      </div>
                                </div>
                                <br/>
                            </div>
                            <br/>
                            <input type="hidden" name="action" value="MovimentacaoAdd"/>
                            <input type="hidden" name="estoque_transcao_usuario_id" value="<?= $_SESSION['userSYSFranquia']['pessoa_id'] ?>" />
                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['ENVLANC'] ?></button>
                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                            <div class="clearfix"></div>
                        </form>
                     
                    
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= MOVIMENTACAO_MANUAL_ESTOQUE ?>
  </div>
</div>


<div class="showcase hide-print" id="getCodeProdutoModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_produtos"
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
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>