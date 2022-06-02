<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$Read->ExeRead("sys_parametros", "WHERE unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
$ResultadoParametro = $Read->getResult();
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
                                <h4 class="card-title"><?= $texto['CADPARSIS'] ?></h4>
                                <p class="card-category"><?= $texto['CADPARSISi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if($ResultadoParametro):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_SISTEMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                                $FormData = array_map('htmlspecialchars', $ResultadoParametro[0]);
                                extract($FormData);
                                ?>
                                <form class="form_parametrizacao_sistema">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                         <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CNTBANCMAT'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_matricula_conta_id">
                                                <option value="0"><?= $texto['SelCNTBANCMAT'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB1):
                                                          ?>
                                                           <option value="<?= $ContaB1['conta_bancaria_id'] ?>" <?php if ($FormData['parametro_matricula_conta_id'] == $ContaB1['conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $ContaB1['conta_bancaria_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $texto['CONTBANCBP'] ?> </label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_baixa_parcela_conta_id">
                                                <option value="0"><?= $texto['SelCONTBANBP'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB2):
                                                          ?>
                                                          <option value="<?= $ContaB2['conta_bancaria_id'] ?>" <?php if ($FormData['parametro_baixa_parcela_conta_id'] == $ContaB2['conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $ContaB2['conta_bancaria_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CNTBANCX'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_caixa_conta_id">
                                                <option value="0"><?= $texto['SelCNTBANCX'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB3):
                                                          ?>
                                                           <option value="<?= $ContaB3['conta_bancaria_id'] ?>" <?php if ($FormData['parametro_caixa_conta_id'] == $ContaB3['conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $ContaB3['conta_bancaria_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $texto['CNTBANCMOV'] ?> </label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_movimentacao_conta_id">
                                                <option value="0"><?= $texto['SelCNTBANCMOV'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB4):
                                                          ?>
                                                          <option value="<?= $ContaB4['conta_bancaria_id'] ?>" <?php if ($FormData['parametro_movimentacao_conta_id'] == $ContaB4['conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $ContaB4['conta_bancaria_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                       <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">FORMA DE PARCELAMENTO DO CURSO</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_id">
                                                <option value="">SELECIONE A FORMA DE PARCELAMENTO DO CURSO</option>
                                               <?php
                                                  $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Forma):
                                                          ?>
                                                           <option value="<?= $Forma['forma_parcelamento_id'] ?>" <?php if ($FormData['parametro_forma_parcelamento_id'] == $Forma['forma_parcelamento_id'] ) { echo "selected";}  ?>  ><?php echo $Forma['forma_parcelamento_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $texto['SDDVC'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_dia_vencimento_id">
                                                <option value="0"><?= $texto['SelDAY'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Dia):
                                                          ?>
                                                          <option value="<?= $Dia['dias_vencimento_id'] ?>" <?php if ($FormData['parametro_dia_vencimento_id'] == $Dia['dias_vencimento_id'] ) { echo "selected";}  ?>  ><?php echo $Dia['dias_vencimento_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_modalidade_id">
                                                <option value="0"><?= $texto['SelMODAL'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Moda):
                                                          ?>
                                                           <option value="<?= $Moda['modalidade_id'] ?>" <?php if ($FormData['parametro_modalidade_id'] == $Moda['modalidade_id'] ) { echo "selected";}  ?>  ><?php echo $Moda['modalidade_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">FORMA DE PARCELAMENTO DO MATERIAL</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_material_id">
                                                <option value="">SELECIONE A FORMA DE PARCELAMENTO DE MATERIAL</option>
                                               <?php
                                                  $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Forma):
                                                          ?>
                                                           <option value="<?= $Forma['forma_parcelamento_id'] ?>" <?php if ($FormData['parametro_forma_parcelamento_material_id'] == $Forma['forma_parcelamento_id'] ) { echo "selected";}  ?>  ><?php echo $Forma['forma_parcelamento_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                      </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['TPCALCAT'] ?></label>
                                                <select class="form-control" name="parametro_tipo_calculo_atraso">
                                                    <option selected  value=""><?= $texto['SelTPCALCAT'] ?></option>
                                                    <option value="0" <?= ($FormData['parametro_tipo_calculo_atraso'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['PERCENTAG'] ?></option>
                                                    <option value="1" <?= ($FormData['parametro_tipo_calculo_atraso'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['Price'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['MLTATRAS'] ?></label>
                                            <input autocomplete="off" type="text" value="<?= $parametro_multa_atraso ?>" name="parametro_multa_atraso" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['JRSAT'] ?></label>
                                            <input autocomplete="off" type="text" name="parametro_juros_atraso" value=" <?= $parametro_juros_atraso ?>" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>
                                  

                                 
<div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['FORMCALCJS'] ?></label>
                                                <select class="form-control" name="parametro_forma_calculo_juros">
                                                    <option selected  value=""><?= $texto['SelFORMCALC'] ?></option>
                                                    <option value="0" <?= ($FormData['parametro_forma_calculo_juros'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['JRSMLT'] ?></option>
                                                    <option value="1" <?= ($FormData['parametro_forma_calculo_juros'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['PERDDESC'] ?></option>
                                                    <option value="2" <?= ($FormData['parametro_forma_calculo_juros'] ==  2 ? 'selected="selected"' : ''); ?>><?= $texto['AMBS'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DASCARA'] ?></label>
                                            <input autocomplete="off"  type="number" name="parametro_dias_carencia"
                                            value="<?= $parametro_dias_carencia ?>" class="form-control">
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['SENSEGP'] ?></label>
                                                <select class="form-control" name="parametro_seguranca_senha_parcelas">
                                                    <option selected  value=""><?= $texto['SelOPTS'] ?></option>
                                                    <option value="0" <?= ($FormData['parametro_seguranca_senha_parcelas'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['NOi'] ?></option>
                                                    <option value="1" <?= ($FormData['parametro_seguranca_senha_parcelas'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['SIMi'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['SENSEGCAX'] ?></label>
                                                <select class="form-control" name="parametro_seguranca_senha_caixa">
                                                    <option selected  value=""><?= $texto['SelOPTS'] ?></option>
                                                    <option value="0" <?= ($FormData['parametro_seguranca_senha_caixa'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['NOi'] ?></option>
                                                    <option value="1" <?= ($FormData['parametro_seguranca_senha_caixa'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['SIMi'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>

                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="ParametrizacaoSistemaEditar"/>
                                    <input type="hidden" name="parametro_id" value="<?= $parametro_id ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='parametrizacao/ParametrizacaoMatricula' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_SISTEMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_parametrizacao_sistema">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CNTBANCMAT'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_matricula_conta_id">
                                                <option value="0"><?= $texto['SelCNTBANCMAT'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB1):
                                                          ?>
                                                          <option value="<?= $ContaB1['conta_bancaria_id'] ?>">
                                                          <?= $ContaB1['conta_bancaria_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                               <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CONTBANCBP'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_baixa_parcela_conta_id">
                                                <option value="0"><?= $texto['SelCONTBANBP'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB2):
                                                          ?>
                                                          <option value="<?= $ContaB2['conta_bancaria_id'] ?>">
                                                          <?= $ContaB2['conta_bancaria_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['CNTBANCX'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_caixa_conta_id">
                                                <option value="0">><?= $texto['SelCNTBANCX'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB3):
                                                          ?>
                                                          <option value="<?= $ContaB3['conta_bancaria_id'] ?>">
                                                          <?= $ContaB3['conta_bancaria_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                               <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">CONTA BANCÁRIA DA BAIXA DE MOVIMENTAÇÃO</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_movimentacao_conta_id">
                                                <option value="0">SELECIONE A CONTA DA DE MOVIMENTAÇÃO</option>
                                               <?php
                                                  $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $ContaB4):
                                                          ?>
                                                          <option value="<?= $ContaB4['conta_bancaria_id'] ?>">
                                                          <?= $ContaB4['conta_bancaria_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">FORMA DE PARCELAMENTO DO CURSO</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_id">
                                                <option value="">SELECIONE A FORMA DE PARCELAMENTO DO CURSO</option>
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

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $texto['SDDVC'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_dia_vencimento_id">
                                                <option value="0"><?= $texto['SelDAY'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Dia):
                                                          ?>
                                                          <option value="<?= $Dia['dias_vencimento_id'] ?>">
                                                          <?= $Dia['dias_vencimento_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_modalidade_id">
                                                <option value="0"><?= $texto['SelMODAL'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Moda):
                                                          ?>
                                                          <option value="<?= $Moda['modalidade_id'] ?>">
                                                          <?= $Moda['modalidade_nome'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">FORMA DE PARCELAMENTO DO MATERIAL</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_material_id">
                                                <option value="">SELECIONE A FORMA DE PARCELAMENTO DE MATERIAL</option>
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
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['TPCALCAT'] ?></label>
                                                <select class="form-control" name="parametro_tipo_calculo_atraso">
                                                    <option selected  value=""><?= $texto['SelTPCALCAT'] ?></option>
                                                    <option value="0" ><?= $texto['PERCENTAG'] ?></option>
                                                    <option value="1" ><?= $texto['Price'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['MLTATRAS'] ?></label>
                                            <input autocomplete="off" type="text" name="parametro_multa_atraso" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['JRSAT'] ?></label>
                                            <input autocomplete="off" type="text" name="parametro_juros_atraso" class="form-control valor_total dinheiro">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['FORMCALCJS'] ?></label>
                                                <select class="form-control" name="parametro_forma_calculo_juros">
                                                    <option selected  value=""><?= $texto['SelFORMCALC'] ?></option>
                                                    <option value="0" ><?= $texto['JRSMLT'] ?></option>
                                                    <option value="1" ><?= $texto['PERDDESC'] ?></option>
                                                    <option value="2" ><?= $texto['AMBS'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>
<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DASCARA'] ?></label>
                                            <input autocomplete="off" type="number" name="parametro_dias_carencia" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['SENSEGP'] ?></label>
                                                <select class="form-control" name="parametro_seguranca_senha_parcelas">
                                                    <option selected  value=""><?= $texto['SelOPTS'] ?></option>
                                                    <option value="1" >Sim</option>
                                                    <option value="0" >Não</option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>

<div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['SENSEGCAX'] ?></label>
                                                <select class="form-control" name="parametro_seguranca_senha_caixa">
                                                    <option selected  value=""><?= $texto['SelOPTS'] ?></option>
                                                    <option value="1" >Sim</option>
                                                    <option value="0" >Não</option>
                                                </select>
                                            </div>
                                        </div>
                                      </div>
                                    
                                    <br/>
                                </div>
                                <input type="hidden" name="action" value="ParametrizacaoSistemaAdd"/>
                                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
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
        ID FUNCIONALIDADE: <?= PARAMETRIZACAO_SISTEMA ?>
    </div>
</div>
