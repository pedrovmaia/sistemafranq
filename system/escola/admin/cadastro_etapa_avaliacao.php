<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$Id = filter_input(INPUT_GET, 'idetapa', FILTER_VALIDATE_INT);
$IdCurso = filter_input(INPUT_GET, 'idcurso', FILTER_VALIDATE_INT);
$IdEstagio = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">CADASTRO DE ETAPA DE AVALIAÇÃO</h4>
                                <p class="card-category">Cadastro de etapa de avaliação</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php                     
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ETAPA_AVALIACAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_etapa_avaliacao", "WHERE etapa_avaliacao_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_etapa_curso">
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">NOME</label>
                                                  <input type="text" name="etapa_avaliacao_nome" value="<?= $etapa_avaliacao_nome ?>" class="form-control">
                                              </div>
                                          </div>

                                           <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Inicial</label>
                                                   
                                                     <select style="margin-top: -3px" name="etapa_produto_materia_inicial_id" class="form-control" data-style="btn btn-link">

                                                         <option value="">SELECIONE A MATÉRIA INICIAL</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st AND materias_aula_estagio_id = :id", "st=0&id={$etapa_estagio_id}");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Inicial):
                                                                ?>
                                                                <option <?= ($etapa_avaliacao_materia_inicial_id == $Inicial['materias_aula_id'] ? "selected='selected'" : "") ?> value="<?= $Inicial['materias_aula_id'] ?>"><?= $Inicial['materias_aula_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Final</label>
                                                   
                                                     <select style="margin-top: -3px" name="etapa_avaliacao_materia_final_id" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE A MATÉRIA FINAL</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st AND materias_aula_estagio_id = :id", "st=0&id={$etapa_estagio_id}");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Inicial):
                                                                ?>
                                                                <option <?= ($etapa_avaliacao_materia_final_id == $Inicial['materias_aula_id'] ? "selected='selected'" : "") ?> value="<?= $Inicial['materias_aula_id'] ?>"><?= $Inicial['materias_aula_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                    </div>
                </div>
                                         </div>
                                         

                                          <div class="col-md-12">
                                              <div class="form-group">

                                                  <input type="checkbox" name="etapa_avaliacao_status" value="1" <?= ($etapa_avaliacao_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                                      <br/>
                                  <br/>
                                  <input type="hidden" name="action" value="EtapaAvaliacaoEditar"/>
                                  <input type="hidden" name="etapa_avaliacao_id" value="<?= $Id; ?>"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='escola/EtapaAvaliacao' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                      <?php
                                  }
                                  ?>
                                  <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=escola/admin/cadastro_etapa_avaliacao&id=<?= $IdCurso ?>');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ETAPA_AVALIACAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_etapa_curso">
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">NOME</label>
                                                  <input type="text" name="etapa_avaliacao_nome" value="" class="form-control">
                                              </div>
                                          </div>

                                           <div class="col-md-6">
                                                  <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Inicial</label>
                                                     <select style="margin-top: -3px" name="etapa_avaliacao_materia_inicial_id" class="form-control" data-style="btn btn-link">
                                                         <option value="">SELECIONE A MATÉRIA INICIAL</option>
                                                        <?php

                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st AND materias_aula_estagio_id = :id", "st=0&id={$IdEstagio}");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Inicial):
                                                                ?>
                                                                <option value="<?= $Inicial['materias_aula_id'] ?>"><?= $Inicial['materias_aula_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                           </div>

                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Final</label>
                                                     <select style="margin-top: -3px" name="etapa_avaliacao_materia_final_id" class="form-control">
                                                        <option value="0">SELECIONE A MATÉRIA FINAL</option>
                                                        <?php
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st AND materias_aula_estagio_id = :id", "st=0&id={$IdEstagio}");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Inicial):
                                                                ?>
                                                                <option value="<?= $Inicial['materias_aula_id'] ?>"><?= $Inicial['materias_aula_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                         </div> 

                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <input type="checkbox" name="etapa_avaliacao_status" value="1">
                                                  <label><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                <br/>
                            </div>
                            <br/>
                            <input type="hidden" name="etapa_estagio_id" value="<?= $IdEstagio ?>"/>
                            <input type="hidden" name="etapa_avaliacao_produto_id" value="<?= $IdCurso ?>"/>
                            <input type="hidden" name="action" value="EtapaAvaliacaoAdd"/>
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
      ID FUNCIONALIDADE: <?= ESCOLA_ETAPA_AVALIACAO ?>
  </div>
</div>
