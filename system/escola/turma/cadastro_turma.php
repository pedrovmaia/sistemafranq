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
                                <h4 class="card-title"><?= $texto['CadTRMS'] ?></h4>
                                <p class="card-category"><?= $texto['CadTRMSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                      $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TURMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_projetos", "WHERE projeto_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_turma">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">

                                     <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['CODMAN'] ?></label>
                                                    <input type="text" name="projeto_codigo" value="<?= $projeto_codigo ?>" class="form-control">
                                                </div>
                                             </div> 
                                     
                                              <div class="col-md-6">
                                                <div class="form-group" >
                                                      <label  class="bmd-label-floating"><?= $texto['Sala'] ?></label>
                                                   
                                                     <select required  style="margin-top: -3px" name="projeto_sala_id" value="<?= $projeto_sala_id ?>" class="form-control jsys_sala" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                        <option value="0"><?= $texto['SELSAL'] ?></option>
                                                        <?php
                                                        $Read->ExeRead("sys_sala", "WHERE sala_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Salas):
                                                                ?>
                                                                <option value="<?= $Salas['sala_id'] ?>" <?php if ($projeto_sala_id == $Salas['sala_id'] ) { echo "selected";}  ?>  ><?php echo $Salas['sala_nome']; ?></option>
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
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                    <input required type="text" name="projeto_descricao" value="<?= $projeto_descricao ?>" class="form-control">
                                                </div>
                                             </div> 

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NMVGS'] ?></label>
                                                    <input required type="number" name="projeto_qtd_participantes" value="<?= $projeto_qtd_participantes ?>" class="form-control" >
                                                </div>
                                             </div> 
                                         </div>

                                      </div>

                                    

                                    <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['CRSEST'] ?></label>
                                                     <select required style="margin-top: -3px" name="projeto_produto_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELCRSO'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Produtos):
                                                                ?>
                                                               
                                                                 <option value="<?= $Produtos['estagio_produto_id'] ?>" <?php if ($projeto_produto_id == $Produtos['estagio_produto_id'] ) { echo "selected";}  ?>  ><?php echo $Produtos['estagio_produto_nome']; ?></option>



                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                              </div>

                                              <div class="col-md-6">
                                                <div class="form-group" >
                                                      <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_modalidade_id" value="<?= $projeto_modalidade_id ?>" class="form-control jsys_modalidades" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                        <option value="0"><?= $texto['SELMODL'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Modalidades):
                                                                ?>
                                                               
                                                                 <option value="<?= $Modalidades['modalidade_id']  ?>" <?php if ($projeto_modalidade_id == $Modalidades['modalidade_id']  ) { echo "selected";}  ?>  ><?php echo $Modalidades['modalidade_nome']; ?></option>



                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group" >
                                                     <label class="bmd-label-floating">CARGA HORÁRIA</label>
                                                     <select required style="margin-top: -3px" name="projeto_grade" class="form-control jsys_modalidades" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                         <option value="0">SELECIONE UMA CARGA HORÁRIA</option>
                                                         <?php
                                                         $Read->ExeRead("sys_carga_horaria_cursos");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Modalidades):
                                                                 ?>
                                                                 <option <?= ($projeto_grade == $Modalidades['carga_horas'] ? "selected='selected'" : ''); ?> value="<?= $Modalidades['carga_horas'] ?>"><?= $Modalidades['carga_horas'] ?></option>
                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['TP'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_tipo_id"  value="<?= $projeto_tipo_id ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTYPEi'] ?></option>

                                                         <?php
                                                         $Read->ExeRead("sys_tipo_projeto", "WHERE tipo_projeto_status = :st", "st=0");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Tipos):
                                                                 ?>


                                                                 <option value="<?= $Tipos['tipo_projeto_id']  ?>" <?php if ($projeto_tipo_id == $Tipos['tipo_projeto_id']   ) { echo "selected";}  ?>  ><?php echo $Tipos['tipo_projeto_nome'] ; ?></option>


                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>


                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group" >
                                                     <label class="bmd-label-floating"><?= $texto['SITAC'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_situacao_id" value="<?= $projeto_situacao_id ?>"  class="form-control jsys_situacao" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELSITi'] ?></option>

                                                         <?php
                                                         $Read->ExeRead("sys_situacao_projeto", "WHERE situacao_projeto_status = :st", "st=0");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Situacao):
                                                                 ?>


                                                                 <option value="<?=  $Situacao['situacao_projeto_id'] ?>" <?php if ($projeto_situacao_id ==  $Situacao['situacao_projeto_id']   ) { echo "selected";}  ?>  ><?php echo $Situacao['situacao_projeto_nome']; ?></option>

                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['Profi'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_gerente_id" value="<?= $projeto_gerente_id ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELPROFF'] ?></option>

                                                         <?php
                                                         $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st AND unidade_id = :unidade", "st=1&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Funcionario):
                                                                 ?>
                                                                 <option value="<?= $Funcionario['pessoa_id']?>" <?php if ($projeto_gerente_id == $Funcionario['pessoa_id']   ) { echo "selected";}  ?>  ><?php echo $Funcionario['pessoa_nome']; ?></option>
                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>

                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group" >


                                                     <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                     <input type="text" name="projeto_observacao"  value="<?= $projeto_observacao ?>"  class="form-control">



                                                 </div>
                                             </div>

                                         </div>
                                      </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" name="projeto_status" value="1" ><?= $texto['InaC'] ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                                <br/>

                                <div id="periodo_vigencia" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['PERDVG'] ?></strong></label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['STRT'] ?></label>
                                                <input required type="date" value="<?= $projeto_data_inicio ?>"  name="projeto_data_inicio" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ENDT'] ?></label>
                                                <input required type="date" value="<?= $projeto_data_termino ?>"  name="projeto_data_termino" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                              <div class="form-group">
                                                  <label  class="bmd-label-floating"><?= $texto['PERDLET'] ?></label>
                                                     <select required style="margin-top: -3px" name="projeto_periodo_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELPERDLET'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_periodo_letivo", "WHERE periodo_letivo_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Periodo):
                                                                ?>
                                                               
                                                                 <option value="<?= $Periodo['periodo_letivo_id'] ?>" <?php if ($projeto_periodo_id == $Periodo['periodo_letivo_id'] ) { echo "selected";}  ?>  ><?php echo $Periodo['periodo_letivo_descricao']; ?></option>



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

                          

                              <div id="periodicidade" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['PERDC'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_periodicidade">
                                                <tr>
                                                     <th class="text-center"><?= $texto['DASEM'] ?></th>
                                                     <th class="text-center"><?= $texto['HRINIC'] ?></th>
                                                     <th class="text-center"><?= $texto['HRFINA'] ?></th>
                                                     <th class="text-center"></th>
                                                </tr>
                                                <?php
                                                $Read->ExeRead("sys_projeto_grade", "WHERE projeto_grade_projeto_id = :id", "id={$Id}");
                                                if($Read->getResult()) {
                                                    $QTDGrades = $Read->getRowCount();
                                                    $i = 0;
                                                    foreach ($Read->getResult() as $Grades) {
                                                        ?>
                                                        <tr>
                                                            <td class="pt-4-half">
                                                                <input type="hidden" name="grade_id_<?= $i ?>"
                                                                       value="<?= $Grades['projeto_grade_id'] ?>">


                                                                <select required name='projeto_grade_carga_dia_<?= $i ?>' class="form-control"  >

                                                                    <option value=""><?= $texto['SELDASEM'] ?></option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_dia_semana");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $Dia):
                                                                            echo "<option " . ($Grades['projeto_grade_carga_dia'] == $Dia['dia_semana_id'] ? 'selected="selected"': '') . " value='{$Dia['dia_semana_id']}'>{$Dia['nome']}</option>";                          

                                                                        endforeach;
                                                                    endif;
                                                                    ?>

                                                             
                                                                </select>
                                                            </td>
                                                            
                                                            <td class="pt-4-half">
                                                                <input required type="time" name="hora_inicial_<?= $i ?>" placeholder="Hora Inicial"
                                                                       class="form-control"
                                                                       value="<?= $Grades['projeto_grade_carga_hora_inicial'] ?>">
                                                            </td>
                                                            
                                                            <td class="pt-4-half">
                                                                <input required type="time" name="hora_final_<?= $i ?>" placeholder="Carga Horária"
                                                                       class="form-control"
                                                                       value="<?= $Grades['projeto_grade_carga_hora_final'] ?>">
                                                            </td>
                                                            <td>
                                                            <span rel="<?= $Grades['projeto_grade_id'] ?>" class="table-remove"><button type="button"
                                                                                               class="btn btn-danger btn-rounded btn-sm my-0"><i
                                                                            class="material-icons">clear</i></button></span>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    $QTDGrades = 0;
                                                }
                                                ?>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                  <input type="hidden" name="action" value="TurmaEditar"/>
                                  <input type="hidden" name="projeto_id" value="<?= $Id; ?>"/>
                                  <input type="hidden" class="quantidade_horarios" name="quantidade_horarios" value="<?= $QTDGrades ?>"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='escola/Turma' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                      <?php
                                  }
                                  ?>
                                  <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=escola/turma/cadastro_turma');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TURMA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_turma">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">

                                     <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['CODMAN'] ?></label>
                                                    <input type="text" name="projeto_codigo" class="form-control">
                                                </div>
                                             </div> 
                                     
                                              <div class="col-md-6">
                                                <div class="form-group" >
                                                      <label  class="bmd-label-floating"><?= $texto['Sala'] ?></label>
                                                   
                                                     <select required  style="margin-top: -3px" name="projeto_sala_id" class="form-control jsys_sala" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                        <option value="0"><?= $texto['SELSAL'] ?></option>
                                                        <?php
                                                        $Read->ExeRead("sys_sala", "WHERE sala_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Salas):
                                                                ?>
                                                                <option value="<?= $Salas['sala_id'] ?>"><?= $Salas['sala_nome'] ?></option>
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
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                    <input required type="text" name="projeto_descricao" class="form-control">
                                                </div>
                                             </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NMVGS'] ?></label>
                                                    <input required type="number" name="projeto_qtd_participantes"  class="form-control" >
                                                </div>
                                             </div> 
                                         </div>
                                      </div>

                                    <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['CRSEST'] ?></label>
                                                     <select required style="margin-top: -3px" name="projeto_produto_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                         <option value="0"><?= $texto['SELCRSO'] ?></option>
                                                        <?php
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Produtos):
                                                                ?>
                                                                <option value="<?= $Produtos['estagio_produto_id'] ?>"><?= $Produtos['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                              </div>

                                             <div class="col-md-6">
                                                <div class="form-group" >
                                                     <label class="bmd-label-floating"><?= $texto['Modal'] ?></label>
                                                     <select required style="margin-top: -3px" name="projeto_modalidade_id" class="form-control jsys_modalidades" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                        <option value="0"><?= $texto['SELMODL'] ?></option>
                                                        <?php
                                                        $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Modalidades):
                                                                ?>
                                                                <option value="<?= $Modalidades['modalidade_id'] ?>"><?= $Modalidades['modalidade_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group" >
                                                     <label class="bmd-label-floating">CARGA HORÁRIA</label>
                                                     <select required style="margin-top: -3px" name="projeto_grade" class="form-control jsys_modalidades" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                         <option value="0">SELECIONE UMA CARGA HORÁRIA</option>
                                                         <?php
                                                         $Read->ExeRead("sys_carga_horaria_cursos");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Modalidades):
                                                                 ?>
                                                                 <option value="<?= $Modalidades['carga_horas'] ?>"><?= $Modalidades['carga_horas'] ?></option>
                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['TP'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_tipo_id" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTYPEi'] ?></option>

                                                         <?php
                                                         $Read->ExeRead("sys_tipo_projeto", "WHERE tipo_projeto_status = :st", "st=0");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Tipos):
                                                                 ?>
                                                                 <option value="<?= $Tipos['tipo_projeto_id'] ?>"><?= $Tipos['tipo_projeto_nome'] ?></option>
                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>


                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group" >
                                                     <label class="bmd-label-floating"><?= $texto['SITAC'] ?></label>
                                                     <select required style="margin-top: -3px" name="projeto_situacao_id" class="form-control jsys_situacao" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELSITi'] ?></option>
                                                         <?php
                                                         $Read->ExeRead("sys_situacao_projeto", "WHERE situacao_projeto_status = :st", "st=0");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Situacao):
                                                                 ?>
                                                                 <option value="<?= $Situacao['situacao_projeto_id'] ?>">
                                                                     <?= $Situacao['situacao_projeto_nome'] ?></option>
                                                             <?php
                                                             endforeach;
                                                         endif;
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>


                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['Profi'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_gerente_id" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELPROFF'] ?></option>

                                                         <?php
                                                         $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st AND unidade_id = :unidade", "st=1&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Funcionario):
                                                                 ?>
                                                                 <option value="<?= $Funcionario['pessoa_id']?>"><?php echo $Funcionario['pessoa_nome']; ?></option>
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
                                                <div class="form-group" >
                                                    
                                                   
                                                    <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                    <input type="text" name="projeto_observacao" class="form-control">
                                             

                                                   
                                                </div>
                                             </div> 
                                         </div>

                                      </div>
   




                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="projeto_status" value="1" ><?= $texto['InaC'] ?></label>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                            </div>
                            <br/>

                            <div id="periodo_vigencia" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['PERDVG'] ?></strong></label>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['STRT'] ?></label>
                                            <input required type="date" name="projeto_data_inicio" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ENDT'] ?></label>
                                            <input required type="date" name="projeto_data_termino" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['PERDLET'] ?></label>

                                                     <select required style="margin-top: -3px" name="projeto_periodo_id" class="form-control jsys_tipo" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SELPERDLET'] ?></option>

                                                         <?php
                                                         $Read->ExeRead("sys_periodo_letivo", "WHERE periodo_letivo_status = :st", "st=0");
                                                         if ($Read->getResult()):
                                                             foreach ($Read->getResult() as $Periodo):
                                                                 ?>
                                                                 <option value="<?= $Periodo['periodo_letivo_id']?>"><?php echo $Periodo['periodo_letivo_descricao']; ?></option>
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

                            <div id="endereco_consumidor" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['PERDC'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="table-add-periodicidade float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                    </div>
                                    <div class="table-responsive">
                                    <div style="padding: 15px;">
                                    <table class="table table-bordered table-responsive-md table-striped text-center table_periodicidade">
                                        <tr>
                                            <th class="text-center"><?= $texto['DASEM'] ?></th>
                                            <th class="text-center"><?= $texto['HRINIC'] ?></th>
                                            <th class="text-center"><?= $texto['HRFINA'] ?></th>
                                            <th class="text-center"></th>
                                        </tr>
                                        <tr>
                                            <td class="pt-3-half">
                                                <select required name='dia_semana_0' class="form-control">
                                                    <option value=""><?= $texto['SELDASEM'] ?></option>
                                                    <?php
                                                    $Read = new Read;
                                                    $Read->ExeRead("sys_dia_semana");
                                                    if($Read->getResult()):
                                                        foreach ($Read->getResult() as $Dia):
                                                            echo "<option value='{$Dia['dia_semana_id'] }'>{$Dia['nome'] }</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>


                                                   

                                                </select>
                                            </td>
                                            <td class="pt-3-half">
                                                <input required type="text" name="hora_inicial_0" placeholder="Hora inicial" class="form-control formTime">
                                            </td>
                                            <td class="pt-3-half">
                                                <input required type="text" name="hora_final_0" placeholder="Hora final" class="form-control formTime">
                                            </td>
                                          
                                            <td>
                                                <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <br/>


                         
                          
                            <input type="hidden" class="quantidade_horarios" name="quantidade_horarios" value="1"/>
                            <input type="hidden" name="action" value="TurmaAdd"/>
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
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
  </div>
</div>

 
</script>
