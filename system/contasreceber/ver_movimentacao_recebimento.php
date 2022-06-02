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
                                    <h4 class="card-title"><?= $texto['VerMRCB'] ?></h4>
                                    <p class="card-category"><?= $texto['VerMRCBi'] ?></p>
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

                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$FormData['movimentacao_pessoa_id']}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                die;
                            endif;

                           /* $Read->ExeRead("sys_transacao_rateio", "WHERE rateio_conta_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Rateio = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                $Rateio = "";
                            endif;*/
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


                                        <form class="form_movimentacao_recebimento">
                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['TNMB'] ?></label>
                                                            <input disabled autocomplete="off" type="text" name="movimentacao_numero"  value="<?= $FormData['movimentacao_numero'] ?>"  class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['DATTI'] ?></label>
                                                            <input disabled type="text" value="<?= date('d/m/Y', strtotime($FormData['movimentacao_data'])) ?>"    name="movimentacao_data" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['CLAL'] ?></label>
                                                            <a data-toggle="modal" data-target="#getCodeModal"> <input disabled placeholder="Clique e selecione seu fornecedor" id="txt_fornecedor" type="text" value="<?= $Pessoa['pessoa_nome'] ?>" class="form-control"></a>
                                                            <input autocomplete="off" id="txt_id_fornecedor" type="hidden" name="movimentacao_pessoa_id" class="form-control">
                                                        </div>
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['TPTT'] ?></label>
                                                            <select disabled style="margin-top: -3px" class="form-control" name="movimentacao_tipo">

                                                               <option value="Cobranca" <?= ($FormData['movimentacao_tipo'] == "Cobranca" ? 'selected="selected"' : ''); ?>>Cobrança</option>

                                                               <option value="Pagamento" <?= ($FormData['movimentacao_tipo'] == "Pagamento" ? 'selected="selected"' : ''); ?>>Pagamento</option>

                                                               <option value="PagamentoMaos" <?= ($FormData['movimentacao_tipo'] == "PagamentoMaos" ? 'selected="selected"' : ''); ?>>Pagamentos em mãos</option>

                                                                <option value="Reembolso" <?= ($FormData['movimentacao_tipo'] == "Reembolso" ? 'selected="selected"' : ''); ?>>Reembolso</option>

                                         
                                                               <option value="Transferencia" <?= ($FormData['movimentacao_tipo'] == "Transferencia" ? 'selected="selected"' : ''); ?>>Transferência</option>
 
                                                               
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PYM'] ?></label>
                                                            <select disabled style="margin-top: -3px" class="form-control" name="movimentacao_forma_pagamento_id">
                                                           <?php
                                                              $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                                                              if ($Read->getResult()):
                                                                  foreach ($Read->getResult() as $Forma):
                                                                      ?>
                                                                      <option value="<?= $Forma['forma_pagamento_id'] ?>">
                                                                      <?= $Forma['forma_pagamento_nome'] ?></option>
                                                                  <?php
                                                                  endforeach;
                                                              endif;
                                                              ?>
                                                        </select>
                                                        </div>
                                                    </div>





                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                                            <input  disabled value="<?= $FormData['movimentacao_descricao'] ?>"   autocomplete="off" type="text" name="movimentacao_descricao" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>





                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                            <input disabled autocomplete="off" type="text" name="movimentacao_valor_total"  value="<?= 'R$ ' . number_format($FormData['movimentacao_valor_total'], 2, ',', '.')    ?>"   class="form-control dinheiro">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['Recb'] ?></label>
                                                            <select disabled style="margin-top: -3px" class="form-control" name="movimentacao_pago_recebido" id="input-pago-mov-pag">

                                                               <option value="0" <?= ($FormData['movimentacao_pago_recebido'] == "0" ? 'selected="selected"' : ''); ?>>NÃO</option>

                                                              <option value="1" <?= ($FormData['movimentacao_pago_recebido'] == "1" ? 'selected="selected"' : ''); ?>>SIM</option>
                                                             
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3" id="hidden_div_data" style="display: none">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['DTREC'] ?></label>
                                                            <input disabled autocomplete="off" type="date" name="movimentacao_data_fechamento" value="<?= $FormData['movimentacao_data_fechamento'] ?>"  class="form-control dinheiro">
                                                        </div>
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                            <input disabled value="<?= $FormData['movimentacao_observacao'] ?>"  autocomplete="off" type="text" name="movimentacao_observacao" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>



                                                <br/>
                                            </div>


                                            <div id="hidden_div_recorrente" style="display: block;">
                                                <div id="informacoes_pagamento_recorrente" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                    <label class="bmd-label-floating"><strong><?= $texto['PARCMS'] ?></strong></label>

                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['PAYPA'] ?></label>
                                                                <select disabled style="margin-top: -3px" class="form-control getTipoParcelamento" name="movimentacao_forma_parcelamento_id" id="movimentacao_forma_parcelamento_id">
                                                                  <option value="0"><?= $texto['ESCPA'] ?></option>
                                                                  
                                                                <?php
                                                                $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                                if ($Read->getResult()):
                                                                    foreach ($Read->getResult() as $Parcelamento):
                                                                        ?>
                                                                        <option value="<?= $Parcelamento['forma_parcelamento_id'] ?>" <?= ($Parcelamento['forma_parcelamento_id'] == $FormData['movimentacao_forma_parcelamento_id'] ? 'selected="selected"' : ''); ?>><?= $Parcelamento['forma_parcelamento_nome'] ?></option>
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
                                                                <input disabled autocomplete="off" type="number" name="movimentacao_total_parcela" id="parcela" value="<?= $FormData['movimentacao_total_parcela'] ?>" class="form-control sys_parcela">
                                                            </div>
                                                        </div>




                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['INTER'] ?></label>

                                                                <input disabled autocomplete="off" type="text" name="movimentacao_recorrencia" id="intervalo"  value="<?= $FormData['movimentacao_recorrencia'] ?>"  class="form-control sys_intervalo">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3" >
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"><?= $texto['TP'] ?></label>
                                                                

                                                                <select disabled style="margin-top: -3px" class="form-control" name="movimentacao_tipo_parcelamento" id="input-pago-mov-pag">

                                                                   <option value="0" <?= ($FormData['movimentacao_tipo_parcelamento'] == "0" ? 'selected="selected"' : ''); ?>>A VISTA</option>

                                                                  <option value="1" <?= ($FormData['movimentacao_tipo_parcelamento'] == "1" ? 'selected="selected"' : ''); ?>>PARCELAMENTO</option>

                                                                   <option value="1" <?= ($FormData['movimentacao_tipo_parcelamento'] == "2" ? 'selected="selected"' : ''); ?>>RECORRÊNTE</option>
                                                                 
                                                                </select>


                                                            </div>
                                                        </div>




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

                                                                
                                                            </tr>

                                                            <?php
                                                            $Read->ExeRead("sys_transacao_rateio", "WHERE rateio_conta_id = :id", "id={$Id}");
                                                            if($Read->getResult()) {
                                                                $QTDTelefones = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Rateios) {
                                                                    ?>
                                                            <tr>
                                                               
                                                                <td class="pt-4-half">
                                                                <input disabled type="hidden" name="centro_custo_<?= $i ?>"
                                                                       value="<?= $Rateios['rateio_id'] ?>">
                                                                <select disabled name='centro_custo_<?= $i ?>' class="form-control">
                                                                     <option value="0">SELECIONE UM CENTRO DE CUSTO</option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_centro_custo");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $CentroCusto):
                                                                            echo "<option " . ($Rateios['rateio_centro_custo_id'] == $CentroCusto['centro_custo_id'] ? 'selected="selected"': '') . "  value='{$CentroCusto['centro_custo_nome'] }'>{$CentroCusto['centro_custo_nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                                </td>



                                                                 <td class="pt-4-half">
                                                                <input disabled type="hidden" name="conta_contabil_<?= $i ?>"
                                                                       value="<?= $Rateios['rateio_id'] ?>">
                                                                <select disabled name='conta_contabil_<?= $i ?>' class="form-control">
                                                                     <option value="0">SELECIONE UMA CONTA CONTÁBIL</option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $ContaContabil):
                                                                            echo "<option " . ($Rateios['rateio_conta_contabil_id'] == $ContaContabil['conta_contabil_id'] ? 'selected="selected"': '') . "  value='{$ContaContabil['conta_contabil_nome'] }'>{$ContaContabil['conta_contabil_nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                                </td>


                                                             

                                                                <td class="pt-4-half">
                                                                    <div class="form-group">

                                                                       
                                                                         <input disabled name="valor_rateio_<?= $i ?>" type="text"
                                                                       placeholder="Valor" class="form-control"
                                                                       value="<?= 'R$ ' . number_format($Rateios['rateio_valor'], 2, ',', '.')    ?>">


                                                                    </div>
                                                                </td>


                                                             



                                                            </div>



                                                            </tr>
                                                            <?php
                                                                $i++;
                                                                }
                                                            } else {
                                                                $QTDTelefones = 0;
                                                            }
                                                            ?>


                                                            </table>
                                                </div>
                                            </div>


                                            <br/>

                                            <div class="clearfix"></div>
                                        </form>
                                   
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
                                                        data-url="_ajax/financeiro/ListParcelasPorMovimentoRecebimento.ajax.php?action=list&movimento_id=<?= $Id ?>"
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

                </div>


                                <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=contasreceber/filtro_movimentacao_recebimento');
                    exit;
                endif;
            endif;
            ?>
                        </div>
                    </div>
                </div>
            </div>
            ID FUNCIONALIDADE:
            <?= CONTASRECEBER_RECEBIMENTO ?>
        </div>
    </div>