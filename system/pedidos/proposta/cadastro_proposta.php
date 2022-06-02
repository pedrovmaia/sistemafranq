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
                                <h4 class="card-title">NOVA PROPOSTA</h4>
                                <p class="card-category">Inclusão de proposta</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                      $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_PROPOSTAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_proposta", "WHERE proposta_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_proposta" autocomplete="false">

                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">NOME</label>
                                                  <input autocomplete="off" value="<?= $proposta_nome ?>" type="text" name="proposta_nome" class="form-control">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">VALOR</label>
                                                  <input readonly autocomplete="off" value="<?= number_format($proposta_valor_total, "2", ",", ".") ?>" type="text" name="proposta_valor_total" class="form-control valor_total dinheiro">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">VALOR DE ENTRADA</label>
                                                  <input autocomplete="off" value="<?= number_format($proposta_valor_entrada, "2", ",", ".") ?>" type="text" name="proposta_valor_entrada" class="form-control dinheiro">
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
                                                      <th class="text-center">PESQUISE O PRODUTO</th>
                                                      <th class="text-center">QUANTIDADE</th>
                                                      <th class="text-center">UNITÁRIO</th>
                                                      <th class="text-center">PARCELA</th>
                                                      <th class="text-center">VENCIMENTO</th>
                                                      <th class="text-center">TOTAL</th>
                                                      <th class="text-center"></th>
                                                  </tr>
                                                  <?php
                                                  $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_proposta_item AS I ON P.produto_id = I.proposta_item_produto_id WHERE I.proposta_item_proposta_id = :id", "id={$proposta_id}");
                                                  if($Read->getResult()) {
                                                      $QTDProdutos = $Read->getRowCount();
                                                      $i = 0;
                                                  foreach ($Read->getResult() as $Produtos) {
                                                  ?>
                                                  <tr>
                                                      <td class="pt-4-half">
                                                          <input type="hidden" name="item_<?= $i ?>" value="<?= $Produtos['proposta_item_id'] ?>">
                                                          <input type='hidden' class='pedido_item_tipo_0' name='pedido_item_tipo_0' value='1'>
                                                          <input readonly placeholder="Clique e selecione seu produto" type="text" data-tipo="pedido_item_tipo_0" data-total="proposta_item_valor_total_0" data-qtd="proposta_item_quantidade_0" id="proposta_item_valor_unitario_0" name="nome_produto_<?= $i ?>" accesskey="<?= $Produtos['proposta_item_produto_id'] ?>" value="<?= $Produtos['produto_nome'] ?>" class="form-control j_produto_proposta">
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <input autocomplete="off" min="0" type="number" data-total="proposta_item_valor_total_<?= $i ?>" data-uni="<?= $Produtos['proposta_item_valor_unitario'] ?>" value="<?= $Produtos['proposta_item_quantidade'] ?>" name="proposta_item_quantidade_<?= $i ?>" class="form-control proposta_item_quantidade_<?= $i ?> qtd_itens_list">
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <div class="form-group">
                                                              <input readonly autocomplete="off" min="0" type="text" value="<?= $Produtos['proposta_item_valor_unitario'] ?>" name="proposta_item_valor_unitario_<?= $i ?>" class="form-control formMoney">
                                                          </div>
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <div class="form-group">
                                                              <select style="margin-top: -3px" class="form-control" name="proposta_item_parcelamento_id_0">
                                                                  <option value="">ESCOLHA A FORMA DE PARCELAMENTO</option>
                                                              <?php
                                                              $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                              if ($Read->getResult()):
                                                                  foreach ($Read->getResult() as $Forma):
                                                                      ?>
                                                                      <option <?= ($Produtos['proposta_item_forma_parcelamento_id'] == $Forma['forma_parcelamento_id'] ? 'selected="selected"' : '') ?> value="$Forma['forma_parcelamento_id']"><?= $Forma['forma_parcelamento_nome'] ?></option>
                                                                      <?php
                                                                  endforeach;
                                                              endif;
                                                              ?>
                                                              </select>
                                                          </div>
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <div class="form-group">
                                                              <input autocomplete="off" min="0"
                                                                     type="date" value="<?= date('Y-m-d', strtotime($Produtos['proposta_item_vencimento'])) ?>"
                                                                     class="form-control">
                                                          </div>
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <div class="form-group">
                                                              <input readonly autocomplete="off" min="0" type="text" value="<?= $Produtos['proposta_item_valor_total'] ?>" name="proposta_item_valor_total_<?= $i ?>" class="form-control valor_total_tabela proposta_item_valor_total_<?= $i ?> formMoney">
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <span rel="<?= $Produtos['proposta_item_id'] ?>" class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
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

                                  <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>
                                      <div class="row">
                                          <div class="col-md-12">
                                        <span class="table-centro-custo-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> Adicionar Rateio</a>
                                        </span>
                                          </div>
                                          <div class="table-responsive" style="padding: 10px">
                                              <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                  <tr>
                                                      <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                      <th class="text-center"><?= $texto['CXC'] ?></th>
                                                      <th class="text-center">VALOR</th>
                                                      <th class="text-center"></th>
                                                  </tr>
                                                  <?php
                                                  $Read->FullRead("SELECT R.proposta_rateio_id, C.centro_custo_nome, CC.conta_contabil_nome, R.proposta_rateio_valor, R.proposta_rateio_centro_custo_id, R.proposta_rateio_conta_contabil_id, R.proposta_rateio_valor FROM sys_centro_custo AS C INNER JOIN sys_proposta_rateio AS R ON C.centro_custo_id = R.proposta_rateio_centro_custo_id INNER JOIN sys_conta_contabil AS CC ON R.proposta_rateio_conta_contabil_id = CC.conta_contabil_id WHERE R.proposta_rateio_proposta_id = :id", "id={$proposta_id}");
                                                  if($Read->getResult()) {
                                                      $QTDCentroCusto = $Read->getRowCount();
                                                      $j = 0;
                                                  foreach ($Read->getResult() as $Custo) {
                                                  ?>
                                                  <tr>
                                                      <td class="pt-4-half">
                                                          <input type="hidden" name="rateio_<?= $j ?>" value="<?= $Custo['proposta_rateio_id'] ?>">
                                                          <select style="margin-top: -3px" name="centro_custo_<?= $j ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                              <option value="0">SELECIONE UM CENTRO DE CUSTO</option>
                                                              <?php
                                                              $Read->ExeRead("sys_centro_custo", "WHERE centro_custo_status = :st", "st=0");
                                                              if ($Read->getResult()):
                                                                  foreach ($Read->getResult() as $CentroCusto):
                                                                      ?>
                                                                      <option <?= ($CentroCusto['centro_custo_id'] == $Custo['proposta_rateio_centro_custo_id'] ? "selected='selected'" : '') ?> value="<?= $CentroCusto['centro_custo_id'] ?>"><?= $CentroCusto['centro_custo_nome'] ?></option>
                                                                  <?php
                                                                  endforeach;
                                                              endif;
                                                              ?>
                                                          </select>

                                                      </td>
                                                      <td class="pt-4-half">
                                                          <select style="margin-top: -3px" class="form-control" name="conta_contabil_<?= $j ?>">
                                                              <option value="0">SELECIONE UMA CONTA CONTÁBIL</option>
                                                              <?php
                                                              $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                                              if ($Read->getResult()):
                                                                  foreach ($Read->getResult() as $ContaContabil):
                                                                      ?>
                                                                      <option <?= ($ContaContabil['conta_contabil_id'] == $Custo['proposta_rateio_conta_contabil_id'] ? "selected='selected'" : '') ?> value="<?= $ContaContabil['conta_contabil_id'] ?>"><?= $ContaContabil['conta_contabil_nome'] ?></option>
                                                                  <?php
                                                                  endforeach;
                                                              endif;
                                                              ?>
                                                          </select>
                                                      </td>
                                                      <td class="pt-4-half">
                                                          <div class="form-group">
                                                              <input autocomplete="off" type="text" value="<?= $Custo['proposta_rateio_valor'] ?>" name="valor_rateio_<?= $j ?>" class="form-control formMoney">
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <span rel="<?= $Custo['proposta_rateio_id'] ?>" class="table-remove">
                                                              <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                <i class="material-icons">clear</i>
                                                              </button>
                                                          </span>
                                                      </td>
                                          </tr>
                                          <?php
                                                      $j++;
                                          }
                                          } else {
                                              $QTDCentroCusto = 0;
                                          }
                                          ?>
                                          </table>
                                      </div>
                                  </div>

                                  <div id="mais_info" class="border_shadow" style="padding: 15px;">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="checkbox-inline">
                                                      <input type="checkbox" name="proposta_status" value="1" <?= ($proposta_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <br/>
                                  <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="<?= $QTDCentroCusto ?>"/>
                                  <input type="hidden" class="quantidade_produto_proposta" name="quantidade_produto_proposta" value="<?= $QTDProdutos ?>"/>
                                  <input type="hidden" name="action" value="PropostaEditar"/>
                                  <input type="hidden" name="proposta_id" value="<?= $Id; ?>"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='pedido/Proposta' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                      <?php
                                  }
                                  ?>
                                  <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=pedidos/proposta/filtro_propostas');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_PROPOSTAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_proposta">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">NOME</label>
                                            <input autocomplete="off" type="text" name="proposta_nome" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">VALOR</label>
                                            <input readonly autocomplete="off" type="text" name="proposta_valor_total" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">VALOR DE ENTRADA</label>
                                            <input autocomplete="off" type="text" name="proposta_valor_entrada" class="form-control dinheiro">
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                <label class="bmd-label-floating"><strong>PRODUTOS / ESTÁGIOS</strong></label>
                                 <div class="row">
                                     <div class="col-md-12">

                                        <span class="table-produtos-add-proposta float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> <?= $texto['ADDPRODD'] ?></a>
                                        </span>
                                     </div>
                                     <div class="table-responsive" style="padding: 10px">
                                         <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_proposta">
                                             <tr>
                                                 <th class="text-center">PESQUISE O PRODUTO</th>
                                                 <th class="text-center">QUANTIDADE</th>
                                                 <th class="text-center">UNITÁRIO</th>
                                                 <th class="text-center">PARCELA</th>
                                                 <th class="text-center">VENCIMENTO</th>
                                                 <th class="text-center">TOTAL</th>
                                                 <th class="text-center"></th>
                                             </tr>
                                             <tr>
                                                 <td class="pt-4-half">
                                                     <input readonly placeholder="Clique e selecione seu produto" data-total="proposta_item_valor_total_0" data-qtd="proposta_item_quantidade_0" id="proposta_item_valor_unitario_0" type="text" name="nome_produto_0" class="form-control j_produto_proposta">
                                                 </td>
                                                 <td class="pt-4-half" style="width: 61px;">
                                                     <input autocomplete="off" min="0" type="number" data-uni="0" data-total="proposta_item_valor_total_0" name="proposta_item_quantidade_0" class="form-control proposta_item_quantidade_0 qtd_itens_list">
                                                 </td>
                                                 <td class="pt-4-half" style="width: 110px;">
                                                     <div class="form-group">
                                                         <input readonly autocomplete="off" min="0" type="text" name="proposta_item_valor_unitario_0" class="form-control proposta_item_valor_unitario_0 formMoney">
                                                     </div>
                                                 </td>
                                                 <td class="pt-4-half">
                                                     <div class="form-group">
                                                         <select style="margin-top: -3px" class="form-control" name="proposta_item_parcelamento_id_0">
                                                             <option value="">ESCOLHA A FORMA DE PARCELAMENTO</option>
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
                                                 </td>
                                                 <td class="pt-4-half">
                                                     <div class="form-group">
                                                         <input autocomplete="off" type="date" name="proposta_item_vencimento_0" class="form-control" placeholder="dd/mm/yyyy">
                                                     </div>
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

                             <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>
                                 <div class="row">
                                    <div class="col-md-12">
                                        <span class="table-centro-custo-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> Adicionar Rateio</a>
                                        </span>
                                    </div>
                                    <div class="table-responsive" style="padding: 10px">
                                    <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                        <tr>
                                            <th class="text-center"><?= $texto['CentCost'] ?></th>
                                            <th class="text-center"><?= $texto['CXC'] ?></th>
                                            <th class="text-center">VALOR</th>
                                            <th class="text-center"></th>
                                        </tr>
                                        <tr>
                                            <td class="pt-4-half">
                                              <select style="margin-top: -3px" name="centro_custo_0" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                   <option value="0">SELECIONE UM CENTRO DE CUSTO</option>
                                                  <?php
                                                  $Read->ExeRead("sys_centro_custo", "WHERE centro_custo_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $CentroCusto):
                                                          ?>
                                                          <option value="<?= $CentroCusto['centro_custo_id'] ?>"><?= $CentroCusto['centro_custo_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                              </select>

                                            </td>
                                            <td class="pt-4-half">
                                                <select style="margin-top: -3px" class="form-control" name="conta_contabil_0">
                                               <option value="0">SELECIONE UMA CONTA CONTÁBIL</option>
                                               <?php
                                              $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                              if ($Read->getResult()):
                                                  foreach ($Read->getResult() as $ContaContabil):
                                                      ?>
                                                      <option value="<?= $ContaContabil['conta_contabil_id'] ?>"><?= $ContaContabil['conta_contabil_nome'] ?></option>
                                                  <?php
                                                  endforeach;
                                              endif;
                                              ?>
                                            </select>
                                            </td>
                                             <td class="pt-4-half">
                                              <div class="form-group">
                                                  <input autocomplete="off" type="text" name="valor_rateio_0" class="form-control formMoney">
                                              </div>
                                              </td>
                                            <td>
                                                <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                            </td>
                                    </div>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                            <br/>
                            <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="1"/>
                            <input type="hidden" class="quantidade_produto_proposta" name="quantidade_produto_proposta" value="1"/>
                            <input type="hidden" name="action" value="PropostaAdd"/>                        
                            <button type="submit" class="btn btn-primary pull-right">CRIAR PROPOSTA</button>
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
      ID FUNCIONALIDADE: <?= FRANQUEADOR_PROPOSTAS ?>
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
  <div id="getCodeModal" class="modal fade in" >
  <div class="modal-dialog modal-confirm">
    <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
      <div class="modal-header" style=" border-bottom: none">
         <h4 class="card-title  text-center">LOCALIZAR PRODUTOS / ESTÁGIOS</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body text-center">

          <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                  <ul class="nav nav-tabs" data-tabs="tabs" style="padding: 0">
                      <li class="nav-item">
                          <a class="nav-link active show" href="#profile" data-toggle="tab">
                              Produtos
                              <div class="ripple-container"></div>
                              <div class="ripple-container"></div></a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                              Estágios
                              <div class="ripple-container"></div>
                              <div class="ripple-container"></div></a>
                      </li>
                  </ul>
              </div>
          </div>

          <div class="tab-content">
              <div class="tab-pane active show" id="profile">

                  <div class="border_shadow" style="background-color: #fff; padding: 20px">
                      <table  class="table table-hover display"
                              id="table_modal_produtos_proposta"
                              data-toolbar="#table"
                              data-locale="pt-BR"
                              data-filter-control="true"
                              data-minimum-count-columns="2"
                              data-url="_ajax/lookups/ListProdutosProposta.ajax.php?action=list"
                              data-pagination="true"
                              data-id-field="nome"
                              data-toggle="table"
                              data-select-item-name="nome"
                              data-buttons-class="primary"
                      >
                          <thead>
                          <tr>
                              <th data-radio="true"></th>
                              <th data-field="id" data-filter-control="input">ID</th>
                              <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                              <th data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                          </tr>
                          </thead>
                      </table>
                  </div>

              </div>
              <div class="tab-pane" id="messages">

                  <div class="border_shadow" style="background-color: #fff; padding: 20px">
                      <table  class="table table-hover display"
                              id="table_modal_estagios_proposta"
                              data-toolbar="#table"
                              data-locale="pt-BR"
                              data-filter-control="true"
                              data-minimum-count-columns="2"
                              data-url="_ajax/lookups/ListEstagios.ajax.php?action=list"
                              data-pagination="true"
                              data-id-field="nome"
                              data-toggle="table"
                              data-select-item-name="nome"
                              data-buttons-class="primary"
                      >
                          <thead>
                          <tr>
                              <th data-radio="true"></th>
                              <th data-field="id" data-filter-control="input">ID</th>
                              <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          </tr>
                          </thead>
                      </table>
                  </div>

              </div>

          </div>
      </div>
    </div>


  </div>
</div>


  
    


