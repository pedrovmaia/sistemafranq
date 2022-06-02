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
                                <h4 class="card-title"><?= $texto['NVMR'] ?></h4>
                                <p class="card-category"><?= $texto['INCMVR'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                      $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_RECEBIMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_movimentacao", "WHERE movimentacao_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_movimentacao_recebimento" autocomplete="false">
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                  <input type="text" name="sala_nome" value="<?= $sala_nome ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['CAPD'] ?></label>
                                                  <input type="text" name="sala_capacidade" value="<?= $sala_capacidade ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-12">
                                              <div class="form-group">

                                                  <input type="checkbox" name="sala_status" value="1" <?= ($sala_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                                      <br/>
                                  </div>
                                  <br/>
                                  <input type="hidden" name="action" value="MovimentacaoEditar"/>
                                  <input type="hidden" name="sala_id" value="<?= $Id; ?>"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='financeiro/MovimentacaoRecebimento' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                      <?php
                                  }
                                  ?>
                                  <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=escola/turma/cadastro_sala');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_RECEBIMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_movimentacao_recebimento">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TNMB'] ?></label>
                                            <input autocomplete="off" type="text" name="movimentacao_numero" class="form-control">
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DATTI'] ?></label>
                                            <input  type="text" value="<?= date('d/m/Y') ?>" name="movimentacao_data" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['CLAL'] ?></label>
                                            <a data-toggle="modal" data-target="#getCodeAlunosModal"> <input readonly placeholder="Clique e selecione o cliente/aluno" id="txt_aluno" type="text" name="movimentacao_pessoa_nome"  class="form-control"></a>
                                            <input  autocomplete="off" id="txt_id_aluno" type="hidden" name="movimentacao_pessoa_id" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TPTT'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="movimentacao_tipo">
                                              <option value="Cobranca"><?= $texto['COB'] ?></option>
                                              <option value="Pagamento"><?= $texto['PAGMNTO'] ?></option>
                                              <option value="PagamentoMaos"><?= $texto['PAGHAND'] ?></option>
                                              <option value="Reembolso"><?= $texto['REEMB'] ?></option>
                                              <option value="Reembolso"><?= $texto['TRANSFERi'] ?></option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                            <input autocomplete="off" type="text" name="movimentacao_descricao" class="form-control">
                                        </div>
                                    </div>
                                   
                                </div>

                                 <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                            <input autocomplete="off" type="text" name="movimentacao_valor_total" class="form-control movimentacao_valor_total dinheiro">
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['Recb'] ?></label>
                                            <select style="margin-top: -3px" class="form-control movimentacao_pago_recebido" name="movimentacao_pago_recebido" id="input-pago-mov-pag">
                                              <option value="0"><?= $texto['NNN'] ?></option>
                                              <option value="1"><?= $texto['SYS'] ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="hidden_div_data" style="display: none" >
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTREC'] ?></label>
                                            <input type="date" name="movimentacao_data_fechamento" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                            <input autocomplete="off" type="text" name="movimentacao_observacao" class="form-control">
                                        </div>
                                    </div>
                                   
                                </div>



                                 <!--<div class="row">
                                    

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">PRODUTO</label>
                                             <a data-toggle="modal" data-target="#getCodeProdutoModal"><input autocomplete="off" required type="text" id="txt_produtos" class="form-control" placeholder="Clique e selecione seu produto"></a>
                                             
                                             <input autocomplete="off" type="hidden" id="txt_id_produtos" class="form-control">

                                        </div>
                                    </div>
                                   


                                 
                                </div>-->






                                <br/>
                            </div>


                             <div id="hidden_div_recorrente" style="display: block;"> 
                             <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['PARCMS'] ?></strong></label>
 
                                 <div class="row">

                                 <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PAYPA'] ?></label>
                                            <select style="margin-top: -3px" class="form-control getTipoParcelamento" name="movimentacao_forma_parcelamento_id" id="movimentacao_forma_parcelamento_id">
                                              <option value="0"><?= $texto['ESCPA'] ?></option>
                                              
                                              <?php
                                                  $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Forma):
                                                          ?>
                                                          <option value="<?= $Forma['forma_parcelamento_id'] ?>">
                                                          <?= $Forma['forma_parcelamento_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>

                                              
                                            </select>
                                        </div>
                                    </div>




                                 <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['QNTPA'] ?></label>
                                            <input readonly autocomplete="off"  type="number" name="movimentacao_total_parcela" id="parcela" class="form-control sys_parcela">
                                        </div>
                                    </div>


                                    

                                    <div class="col-md-3" >
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['INTER'] ?></label>
                                            
                                            <input readonly autocomplete="off"  type="text" name="movimentacao_recorrencia" id="intervalo" class="form-control sys_intervalo">
                                        </div>
                                    </div>

                                    <div class="col-md-3" >
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TP'] ?></label>
                                             <input  autocomplete="off"  type="hidden" name="movimentacao_tipo_parcelamento" id="tipo" class="form-control sys_tipo">
                                            <input readonly autocomplete="off"  type="text"  id="tipo_nome" class="form-control sys_tipo_nome">
                                        </div>
                                    </div>
                                 </div>  

                                </div>
                                </div>

                             <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>

                                 <div class="row">
                                    <div class="col-md-12">
                                       
                                        <span class="table-centro-custo-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> <?= $texto['ADDRAT'] ?></a>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="table-responsive" style="padding: 10px">
                                    <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                        <tr>
                                            <th class="text-center"><?= $texto['CentCost'] ?></th>
                                            <th class="text-center"><?= $texto['CXC'] ?></th>
                                            <th class="text-center"><?= $texto['PriceM'] ?></th>
                                           
                                            <th class="text-center"></th>
                                        </tr>
                                        <tr>
                                            <td class="pt-4-half">
                                              <select style="margin-top: -3px" name="centro_custo_0" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                   <option value="0"><?= $texto['SELCDC'] ?></option>
                                                 
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

                                               <option value="0"><?= $texto['SELUCC'] ?></option>
                                              
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

                            <br/>
                          </div>
                            <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="1"/>
                            
                            <input type="hidden" name="action" value="MovimentacaoAdd"/>
                            <input type="hidden" name="movimentacao_tipo_id" value="2"/>
                            <input type="hidden" name="movimentacao_nome" value="Movimentação de recebimento"/>

                             <?php if(isset($_SESSION['caixaSYS']))
                                    {?> 
                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['LaunchTitles'] ?></button>
                            <?php
                                  }
                                  ?>
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
      ID FUNCIONALIDADE: <?= CONTASRECEBER_RECEBIMENTO ?>
  </div>
</div>


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
                            data-url="_ajax/lookups/ListClientesAlunos.ajax.php?action=list"
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
                            <th  data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
