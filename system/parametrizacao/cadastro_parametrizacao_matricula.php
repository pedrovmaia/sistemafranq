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
$ResultadoParametroM = $Read->getResult();
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
                                <h4 class="card-title"><?= $texto['CADPARMAT'] ?></h4>
                                <p class="card-category"><?= $texto['CADPARMATi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if($ResultadoParametroM):                          
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                                $FormData = array_map('htmlspecialchars', $ResultadoParametroM[0]);
                                extract($FormData);
                                ?>
                                <form class="form_parametrizacao_matricula">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                       <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">FORMA DE PARCELAMENTO DO CURSO</label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_id">
                                                <option value="0">SELECIONE A FORMA DE PARCELAMENTO DO CURSO</option>
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

                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="ParametrizacaoMatriculaEditar"/>
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
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_parametrizacao_matricula">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PAYPA'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_id">
                                                <option value="0"><?= $texto['SelFORM'] ?></option>
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
                                    
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="ParametrizacaoMatriculaAdd"/>
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
        ID FUNCIONALIDADE: <?= PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA ?>
    </div>
</div>
