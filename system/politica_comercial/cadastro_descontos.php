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
                                <h4 class="card-title"><?= $texto['CadDSCNTS'] ?></h4>
                                <p class="card-category"><?= $texto['CadDSCNTSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_DESCONTOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_descontos", "WHERE desconto_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_descontos">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        
            
                                       <div class="col-md-12">
                        <div class="row">
                    
                    <div class="col-md-6">

                    <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                
                                                <input type="text" name="desconto_nome" value="<?= 
                                                $desconto_nome ?>"  class="form-control">
                                            </div>
                                        </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TPDSCNT'] ?></label>
                                                   
                                                     <select style="margin-top: -3px" name="desconto_tipo_id" value="<?= $desconto_tipo_id ?>"  class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_tipo_desconto", "WHERE tipo_desconto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoDesconto):
                                                                ?>
                                                                   <option value="<?= $TipoDesconto['tipo_desconto_id'] ?>" <?= ($TipoDesconto['tipo_desconto_id'] == $FormData['desconto_tipo_id'] ? 'selected="selected"' : ''); ?>><?= $TipoDesconto['tipo_desconto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>

                                                    </div>

                                      </div>
                                                </div>
                                            </div>

                                     <div class="col-md-12">
                                       <div class="row">
                                       
                                        <div class="col-md-6">
                                        <div class="form-group">
                                         <label class="bmd-label-floating"><?= $texto['TPDVAL'] ?></label>
                                          <select style="margin-top: -3px" name="desconto_tipo_valor" value="<?= $desconto_tipo_valor ?>"  class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                             
                                             <option value=""><?= $texto['SelTYPEi'] ?></option>

                                               <option value="1"><?= $texto['Price'] ?></option>
                                               <option value="0"><?= $texto['PERCNT'] ?></option>
                                               <option value="0" <?= ($FormData['desconto_tipo_valor'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['Price'] ?></option>
                                                    <option value="1" <?= ($FormData['desconto_tipo_valor'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['PERCNT'] ?></option>
                                               </select>
                                            </div>
                                        </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                         <input type="text" name="desconto_valor" value="<?=number_format($desconto_valor, 2, ',', '.') ?>" class="form-control dinheiro">
                                            </div>
                                                </div>
                                            </div>
                                                                                                                               
                                            <div class="col-md-12">
                                                <div class="row">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="desconto_data_inicial" value="<?= date('d/m/Y', strtotime($desconto_data_inicial)) ?>"  class="form-control formDate">
                                                </div>
                                            </div>

                                              <div class="col-md-6">

                    <div class="form-group">

                        <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="desconto_data_final" value="<?= date('d/m/Y', strtotime($desconto_data_final)) ?>"  class="form-control">
                                                </div>
                                            </div>
                    </div>
                </div>

                                     <div class="col-md-12">
                                        <div class="row">
                                              <div class="col-md-6">
                                        <div class="form-group">
                                         <label class="bmd-label-floating"><?= $texto['APLCV'] ?></label>
                                          <select style="margin-top: -3px" name="desconto_aplicavel" value="<?= $desconto_aplicavel ?>"  class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                             
                                             <option value=""><?= $texto['APLCVA'] ?></option>

                                               <option value="0"><?= $texto['MenSPO'] ?></option>
                                               <option value="1"><?= $texto['SERVICES'] ?></option>
                                               <option value="2"><?= $texto['PRODSERV'] ?></option>
                                               <option value="0" <?= ($FormData['desconto_aplicavel'] == 0 ? 'selected="selected"' : ''); ?>><?= $texto['MenSPO'] ?></option>
                                                    <option value="1" <?= ($FormData['desconto_aplicavel'] == 1 ? 'selected="selected"' : ''); ?>><?= $texto['SERVICES'] ?></option>
                                                    <option value="2" <?= ($FormData['desconto_aplicavel'] == 2 ? 'selected="selected"' : ''); ?>><?= $texto['PRODSERV'] ?></option>
                                               </select>
                                            </div>
                                        </div>

                                        </div>
                                        </div>

                                         <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" name="desconto_status" value="1" <?= ($desconto_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>


                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="DescontosEditar"/>
                                    <input type="hidden" name="desconto_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='politica_comercial/Descontos' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=politica_comercial/cadastro_descontos');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_DESCONTOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_descontos">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                           
                                    <div class="col-md-12">
                                            <div class="row">               
                                        <div class="col-md-6">
                                        <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                
                                                <input type="text" name="desconto_nome"  class="form-control">
                                            </div>
                                        </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TPDSCNT'] ?></label>
                                                   
                                                     <select style="margin-top: -3px" name="desconto_tipo_id"  class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_tipo_desconto", "WHERE tipo_desconto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoDesconto):
                                                                ?>
                                                                <option value="<?= $TipoDesconto['tipo_desconto_id'] ?>"><?= $TipoDesconto['tipo_desconto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>

                                                    </div>

                                      </div>
                                                </div>
                                            </div>

                                     <div class="col-md-12">
                                       <div class="row">
                                       
                                        <div class="col-md-6">
                                        <div class="form-group">
                                         <label class="bmd-label-floating"><?= $texto['TPDVAL'] ?></label>
                                          <select style="margin-top: -3px" name="desconto_tipo_valor"  class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                             
                                             <option value=""><?= $texto['SelTYPEi'] ?></option>

                                               <option value="1"><?= $texto['Price'] ?></option>
                                               <option value="0"><?= $texto['PERCNT'] ?></option>
                                               </select>
                                            </div>
                                        </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                        <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                         <input type="text" name="desconto_valor" class="form-control dinheiro">
                                               </div>
                                            </div>
                                                </div>
                                            </div>

                                                                   
                                                            
                                            <div class="col-md-12">
                                                <div class="row">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="desconto_data_inicial"  class="form-control formDate">
                                                </div>
                                            </div>

                                              <div class="col-md-6">

                    <div class="form-group">

                        <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="desconto_data_final"  class="form-control formDate">
                                                </div>
                                            </div>
                    </div>
                </div>

                                     <div class="col-md-12">
                                        <div class="row">
                                              <div class="col-md-6">
                                        <div class="form-group">
                                         <label class="bmd-label-floating"><?= $texto['APLCV'] ?></label>
                                          <select style="margin-top: -3px" name="desconto_aplicavel"  class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                             
                                             <option value=""><?= $texto['APLCVA'] ?></option>

                                               <option value="0"><?= $texto['MenSPO'] ?></option>
                                               <option value="1"><?= $texto['SERVICES'] ?></option>
                                               <option value="2"><?= $texto['PRODSERV'] ?></option>
                                               </select>
                                            </div>
                                        </div>

                                        </div>
                                        </div>


                <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" name="desconto_status" value="1" ><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                                       
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="DescontosAdd"/>
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
        ID FUNCIONALIDADE: <?= POLITICA_DESCONTOS ?>
    </div>
</div>
