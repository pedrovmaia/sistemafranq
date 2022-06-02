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
                                <h4 class="card-title">CADASTRO DE ATIVIDADE EXTRA CURRICULAR</h4>
                                <p class="card-category">Cadastro de atividade</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_ATIVIDADE_EXTRA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_atividades_extra_curriculares", "WHERE atividades_extra_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_atividade_extra">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                          <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                <input type="text" name="atividades_extra_descricao" value="<?= $atividades_extra_descricao ?>" class="form-control">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ESTÁGIO</label>
                                            <select style="margin-top: -3px" class="form-control" name="atividades_extra_estagio_id">
                                                <option value="">SELECIONE O ESTÁGIO</option>
                                               <?php
                                                  $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Estagio):
                                                          ?>
                                                           <option value="<?= $Estagio['estagio_produto_id'] ?>" <?php if ($FormData['atividades_extra_estagio_id'] == $Estagio['estagio_produto_id'] ) { echo "selected";}  ?>  ><?php echo $Estagio['estagio_produto_nome']; ?></option>
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

                                                 <label class="bmd-label-floating">DATA INICIAL</label>
                                                    <input type="text" name="atividades_extra_data_inicial" value="<?= date('d/m/Y', strtotime($atividades_extra_data_inicial)) ?>" class="form-control formDate">
                                            </div>
                                        </div>

                                       <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating">DATA FINAL</label>
                                                    <input type="text" name="atividades_extra_data_final" value="<?= date('d/m/Y', strtotime($atividades_extra_data_final)) ?>" class="form-control formDate">
                                            </div>
                                        </div>
                                    </div>
                                              <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="checkbox" name="atividades_extra_status" value="1" <?= ($atividades_extra_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                            </div>
                                        </div>
                                                                     
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="AtividadeExtraEditar"/>
                                    <input type="hidden" name="atividades_extra_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='parametrizacao/AtividadeExtra' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=parametrizacao/cadastro_feriado_municipal');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_ATIVIDADE_EXTRA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_atividade_extra">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                <input type="text" name="atividades_extra_descricao" class="form-control">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">ESTÁGIO</label>
                                            <select style="margin-top: -3px" class="form-control" name="atividades_extra_estagio_id">
                                                <option value="">SELECIONE O ESTÁGIO</option>
                                               <?php
                                                  $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Estagio):
                                                          ?>
                                                          <option value="<?= $Estagio['estagio_produto_id'] ?>">
                                                          <?= $Estagio['estagio_produto_nome'] ?></option>
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

                                                 <label class="bmd-label-floating">DATA INICIAL</label>
                                                    <input type="text" name="atividades_extra_data_inicial" class="form-control formDate">
                                            </div>
                                        </div>

                                       <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating">DATA FINAL</label>
                                                    <input type="text" name="atividades_extra_data_final" class="form-control formDate">
                                            </div>
                                        </div>
                                    </div>                                    

                                        <div class="col-md-12">
                                            <div class="form-group">
                                             <input type="checkbox" name="atividades_extra_status" value="1" ><?= $texto['InaC'] ?></label>
                                               
                                            </div>
                                        </div>
                                    
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="AtividadeExtraAdd"/>
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
        ID FUNCIONALIDADE: <?= PARAMETRIZACAO_ATIVIDADE_EXTRA ?>
    </div>
</div>
