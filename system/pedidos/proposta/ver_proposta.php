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
                                <h4 class="card-title">VER PROPOSTA</h4>
                                <p class="card-category">Ver detalhes da proposta</p>
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
                                                  <input readonly autocomplete="off" type="text" value="<?= $proposta_nome ?>" name="proposta_nome" class="form-control">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">VALOR</label>
                                                  <input readonly autocomplete="off" type="text" value="<?= number_format($proposta_valor_total, 2, ',', '.') ?>" name="proposta_valor_total" class="form-control dinheiro">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">VALOR DE ENTRADA</label>
                                                  <input readonly autocomplete="off" type="text" value="<?= number_format($proposta_valor_entrada, 2, ',', '.') ?>" name="proposta_valor_entrada" class="form-control dinheiro">
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!--<div id="hidden_div_recorrente" style="display: block;">
                                      <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                          <label class="bmd-label-floating"><strong>PARCELAS</strong></label>
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating">FORMA DE PARCELAMENTO</label>
                                                          <?php
                                                          $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st AND forma_parcelamento_id = :id", "st=0&id={$proposta_forma_parcelamento_id}");
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
                                                      <label class="bmd-label-floating">QUANTIDADE DE PARCELAS</label>
                                                      <input readonly autocomplete="off"  type="number" value="<?= $proposta_total_parcela ?>" name="proposta_total_parcela" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating">INTERVALO</label>
                                                      <input readonly autocomplete="off" value="<?= $proposta_recorrencia ?>" type="text" name="proposta_recorrencia" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating">TIPO</label>
                                                      <?php
                                                      if( $proposta_tipo_parcelamento == 0)
                                                      {
                                                          $tipo_nome = 'A VISTA';
                                                      }

                                                      if( $proposta_tipo_parcelamento == 1)
                                                      {
                                                          $tipo_nome = 'PARCELAMENTO';
                                                      }

                                                      if( $proposta_tipo_parcelamento == 2)
                                                      {
                                                          $tipo_nome = 'RECORRÊNCIA';
                                                      }
                                                      ?>
                                                      <input readonly autocomplete="off" name="proposta_tipo_parcelamento" value="<?= $tipo_nome ?>" type="text" class="form-control">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>-->

                                  <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                      <label class="bmd-label-floating"><strong>PRODUTOS</strong></label>
                                      <div class="row">
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
                                                   $Read->FullRead("SELECT P.produto_nome, I.* FROM sys_produto AS P INNER JOIN sys_proposta_item AS I ON P.produto_id = I.proposta_item_produto_id WHERE I.proposta_item_proposta_id = :id AND I.proposta_item_tipo = 1", "id={$proposta_id}");
                                                   if($Read->getResult()) {
                                                       foreach ($Read->getResult() as $Produtos) {
                                                           ?>
                                                           <tr>
                                                               <td class="pt-4-half">
                                                                   <input readonly value="<?= $Produtos['produto_nome'] ?>"
                                                                          placeholder="Clique e selecione seu produto"
                                                                          type="text" class="form-control">
                                                               </td>
                                                               <td class="pt-4-half" style="width: 61px">
                                                                   <input readonly autocomplete="off" min="0"
                                                                          type="number" value="<?= $Produtos['proposta_item_quantidade'] ?>"
                                                                          class="form-control">
                                                               </td>
                                                               <td class="pt-4-half">
                                                                   <div class="form-group">
                                                                       <input readonly autocomplete="off" min="0"
                                                                              type="text" value="<?= $Produtos['proposta_item_valor_unitario'] ?>"
                                                                              class="form-control formMoney">
                                                                   </div>
                                                               </td>
                                                               <td class="pt-4-half">
                                                                   <div class="form-group">
                                                                       <?php
                                                                       $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                                       if ($Read->getResult()):
                                                                           foreach ($Read->getResult() as $Forma):
                                                                               if($Produtos['proposta_item_forma_parcelamento_id'] == $Forma['forma_parcelamento_id']){
                                                                                   ?>
                                                                                   <input readonly autocomplete="off" min="0" type="text" value="<?= $Forma['forma_parcelamento_nome'] ?>" class="form-control">
                                                                                   <?php
                                                                               }
                                                                           endforeach;
                                                                       endif;
                                                                       ?>
                                                                   </div>
                                                               </td>
                                                               <td class="pt-4-half">
                                                                   <div class="form-group">
                                                                       <input readonly autocomplete="off" min="0"
                                                                              type="text" value="<?= date('d/m/Y', strtotime($Produtos['proposta_item_vencimento'])) ?>"
                                                                              class="form-control">
                                                                   </div>
                                                               </td>
                                                               <td class="pt-4-half">
                                                                   <div class="form-group">
                                                                       <input readonly autocomplete="off" min="0"
                                                                              type="text" value="<?= $Produtos['proposta_item_valor_total'] ?>"
                                                                              class="form-control formMoney">
                                                                   </div>
                                                               </td>
                                                           </tr>
                                                           <?php
                                                       }
                                                   } else {
                                                       $Read->FullRead("SELECT P.estagio_produto_nome, I.* FROM sys_estagio_produto AS P INNER JOIN sys_proposta_item AS I ON P.estagio_produto_id = I.proposta_item_produto_id WHERE I.proposta_item_proposta_id = :id AND I.proposta_item_tipo = 2", "id={$proposta_id}");
                                                       if ($Read->getResult()) {
                                                           foreach ($Read->getResult() as $Produtos) {
                                                               ?>
                                                               <tr>
                                                                   <td class="pt-4-half">
                                                                       <input readonly value="<?= $Produtos['estagio_produto_nome'] ?>"
                                                                              placeholder="Clique e selecione seu produto"
                                                                              type="text" class="form-control">
                                                                   </td>
                                                                   <td class="pt-4-half" style="width: 61px">
                                                                       <input readonly autocomplete="off" min="0"
                                                                              type="number"
                                                                              value="<?= $Produtos['proposta_item_quantidade'] ?>"
                                                                              class="form-control">
                                                                   </td>
                                                                   <td class="pt-4-half">
                                                                       <div class="form-group">
                                                                           <input readonly autocomplete="off" min="0"
                                                                                  type="text"
                                                                                  value="<?= $Produtos['proposta_item_valor_unitario'] ?>"
                                                                                  class="form-control formMoney">
                                                                       </div>
                                                                   </td>
                                                                   <td class="pt-4-half">
                                                                       <div class="form-group">
                                                                           <?php
                                                                           $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                                           if ($Read->getResult()):
                                                                               foreach ($Read->getResult() as $Forma):
                                                                                   if($Produtos['proposta_item_forma_parcelamento_id'] == $Forma['forma_parcelamento_id']){
                                                                                   ?>
                                                                                   <input readonly autocomplete="off" min="0" type="text" value="<?= $Forma['forma_parcelamento_nome'] ?>" class="form-control">
                                                                               <?php
                                                                               }
                                                                               endforeach;
                                                                           endif;
                                                                           ?>
                                                                       </div>
                                                                   </td>
                                                                   <td class="pt-4-half">
                                                                       <div class="form-group">
                                                                           <input readonly autocomplete="off" min="0"
                                                                                  type="text" value="<?= date('d/m/Y', strtotime($Produtos['proposta_item_vencimento'])) ?>"
                                                                                  class="form-control">
                                                                       </div>
                                                                   </td>
                                                                   <td class="pt-4-half">
                                                                       <div class="form-group">
                                                                           <input readonly autocomplete="off" min="0"
                                                                                  type="text"
                                                                                  value="<?= $Produtos['proposta_item_valor_total'] ?>"
                                                                                  class="form-control formMoney">
                                                                       </div>
                                                                   </td>
                                                               </tr>
                                                               <?php
                                                           }
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
                                                      <th class="text-center">VALOR</th>
                                                  </tr>
                                                  <?php
                                                  $Read->FullRead("SELECT C.centro_custo_nome, CC.conta_contabil_nome, R.proposta_rateio_valor FROM sys_centro_custo AS C INNER JOIN sys_proposta_rateio AS R ON C.centro_custo_id = R.proposta_rateio_centro_custo_id INNER JOIN sys_conta_contabil AS CC ON R.proposta_rateio_conta_contabil_id = CC.conta_contabil_id WHERE R.proposta_rateio_proposta_id = :id", "id={$proposta_id}");
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
                                                                  <input readonly value="<?= number_format($Custo['proposta_rateio_valor'], 2, ',', '.') ?>" type="text" class="form-control">
                                                              </td>
                                                          </tr>
                                                          <?php
                                                      }
                                                  }
                                                  ?>
                                          </table>
                                      </div>
                                  </div>

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
                    endif;
                    ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FRANQUEADOR_PROPOSTAS ?>
  </div>
</div>