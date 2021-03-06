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
                                <h4 class="card-title"><?= $texto['CadPLTCEST'] ?></h4>
                                <p class="card-category"><?= $texto['CadPLTCESTi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_COMERCIAL_ESTAGIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_politica_comercial_estagios", "WHERE politica_comercial_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_politica_comercial_estagio">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
               
                                        <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['ESSTT'] ?></label>
                                                     <select style="margin-top: -3px" name="politica_comercial_estagio_id" value="<?= $politica_comercial_estagio_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value=""><?= $texto['SelESTAGi'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status  = :st", "st=0"
                                                        );
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Estagio):
                                                                ?>
                                                                 <option value="<?= $Estagio['estagio_produto_id'] ?>" <?= ($Estagio['estagio_produto_id'] == $FormData['politica_comercial_estagio_id'] ? 'selected="selected"' : ''); ?>><?= $Estagio['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                    <input type="text" name="politica_comercial_valor" value="<?=number_format($politica_comercial_valor, 2, ',', '.') ?>" class="form-control dinheiro">
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_inicio" value="<?= date('d/m/Y', strtotime($politica_comercial_data_inicio)) ?>" class="form-control formDate">
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_final" value="<?= date('d/m/Y', strtotime($politica_comercial_data_inicio)) ?>" class="form-control formDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
<div class="col-md-12">
                     <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="modalidade_id">
                                                <option value=""><?= $texto['SelMODAL'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Moda):
                                                          ?>
                                                           <option value="<?= $Moda['modalidade_id'] ?>" <?php if ($FormData['modalidade_id'] == $Moda['modalidade_id'] ) { echo "selected";}  ?>  ><?php echo $Moda['modalidade_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="PoliticaEstagioEditar"/>
                                    <input type="hidden" name="politica_comercial_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='politica_comercial/PoliticaEstagio' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, voc?? tentou editar um usu??rio que n??o existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=politica_comercial/filtro_politica_comercial_estagio');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_COMERCIAL_ESTAGIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_politica_comercial_estagio">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['ESSTT'] ?></label>
                                                     <select style="margin-top: -3px" name="politica_comercial_estagio_id" class="form-control" data-style="btn btn-link">

                                                         <option value=""><?= $texto['SelESTAGi'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_estagio_produto",
                                                           "WHERE estagio_produto_status = :st", "st=0 "
                                                        );
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Estagio):
                                                                ?>
                                                                <option value="<?= $Estagio['estagio_produto_id'] ?>"><?= $Estagio['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                    <input type="text" name="politica_comercial_valor" class="form-control dinheiro">
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_inicio" class="form-control formDate">
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_final" class="form-control formDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

 <div class="col-md-12">
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>
                                            <select required style="margin-top: -3px" class="form-control" name="modalidade_id">
                                                <option value=""><?= $texto['SelMODAL'] ?></option>
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
                                      </div>   
                                      </div>      
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="PoliticaEstagioAdd"/>
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
        ID FUNCIONALIDADE: <?= POLITICA_COMERCIAL_ESTAGIO ?>
    </div>
</div>
