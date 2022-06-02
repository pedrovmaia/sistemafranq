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
                                <h4 class="card-title"><?= $texto['VerTRMS'] ?></h4>
                                <p class="card-category"><?= $texto['VerTRMSi'] ?></p>
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
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_projetos", "WHERE projeto_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);
                    ?>
                    <div class="btn-group">

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['REV'] ?> <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacao_turma&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['AVALi'] ?></a></li>
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes_turma&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['AvalTRM'] ?></a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['INFOR'] ?> <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/ver_alunos&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['ALMATR'] ?></a></li>
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/grade_horarios&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['GRAH'] ?></a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['REPS'] ?> <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_reposicao&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['REPALA'] ?></a></li>
                                
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?= $texto['ACOMPH'] ?> <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes_turma_atividades_efetuadas&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['ATXEF'] ?></a></li>
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes_turma_avaliacoes_efetuadas&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['ATXAV'] ?></a></li>
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes_turma_exercicios_efetuados&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['EXxEX'] ?></a></li>
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes_turma_homework_efetuadas&id=<?= $Id ?>" class="btn btn-primary"><?= $texto['HWXHW'] ?></a></li>

                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Avaliações <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?= BASE ?>/painel.php?exe=escola/turma/avaliacoes&id=<?= $Id ?>" class="btn btn-primary">Relatório da Turma</a></li>
                            </ul>
                        </div>

                    </div>

                    <form class="form_turma">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">

                                     <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['CODMAN'] ?></label>
                                                    <input disabled type="text" name="projeto_codigo" value="<?= $projeto_codigo ?>" class="form-control">
                                                </div>
                                             </div> 
                                     
                                              <div class="col-md-6">
                                                <div class="form-group" >
                                                      <label  class="bmd-label-floating"><?= $texto['Sala'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="projeto_sala_id" value="<?= $projeto_sala_id ?>" class="form-control jsys_sala" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                        <option value="0"><?= $texto['SELSAL'] ?></option>
                                                        <?php
                                                        $Read->ExeRead("sys_sala", "WHERE sala_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Salas):
                                                                ?>
                                                                <option value="<?= $Salas['sala_id'] ?>" <?php if ($projeto_sala_id == $Salas['sala_id'] ) { echo "selected";}  ?>><?php echo $Salas['sala_nome']; ?></option>
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
                                                    <input disabled type="text" name="projeto_descricao" value="<?= $projeto_descricao ?>" class="form-control">
                                                </div>
                                             </div> 

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NMVGS'] ?></label>
                                                    <input disabled type="number" name="projeto_qtd_participantes" value="<?= $projeto_qtd_participantes ?>" class="form-control" >
                                                </div>
                                             </div> 
                                         </div>

                                      </div>

                                    

                                    <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['CRSEST'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="projeto_produto_id" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELCRSO'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_estagio_produto");
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

                                                     <select disabled style="margin-top: -3px" name="projeto_modalidade_id" value="<?= $projeto_modalidade_id ?>" class="form-control jsys_modalidades" data-style="btn btn-link" id="exampleFormControlSelect1">

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
                                         </div>

                                      </div>
  


                                    <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TP'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="projeto_tipo_id"  value="<?= $projeto_tipo_id ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

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

                                                     <select disabled style="margin-top: -3px" name="projeto_situacao_id" value="<?= $projeto_situacao_id ?>"  class="form-control jsys_situacao" data-style="btn btn-link" id="exampleFormControlSelect1">

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
                                         </div>

                                      </div>
   
 

                                    <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['Profi'] ?></label>
                                                   
                                                      <select  disabled style="margin-top: -3px" name="projeto_gerente_id" value="<?= $projeto_gerente_id ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELPROFF'] ?></option>
                                                       
                                                        <?php
                                                        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st", "st=1");
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
                                                    <input disabled type="text" name="projeto_observacao"  value="<?= $projeto_observacao ?>"  class="form-control">
                                             

                                                   
                                                </div>
                                             </div> 
                                         </div>

                                      </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input disabled type="checkbox" name="projeto_status" value="1" ><?= $texto['InaC'] ?></label>
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
                                                <input disabled type="date" value="<?= $projeto_data_inicio ?>"  name="projeto_data_inicio" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['ENDT'] ?></label>
                                                <input disabled type="date" value="<?= $projeto_data_termino ?>"  name="projeto_data_termino" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                              <div class="form-group">
                                                  <label  class="bmd-label-floating"><?= $texto['PERDLET'] ?></label>
                                                     <select disabled style="margin-top: -3px" name="projeto_periodo_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

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
                                       
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_periodicidade">
                                                <tr>
                                                     <th class="text-center"><?= $texto['DASEM'] ?></th>
                                                     <th class="text-center"><?= $texto['HRINIC'] ?></th>
                                                     <th class="text-center"><?= $texto['HRFINA'] ?></th>
                                      
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
                                                                <select disabled name='projeto_grade_carga_dia_<?= $i ?>' class="form-control">
                                                               
                                                                    <option value=""><?= $texto['SELDASEM'] ?></option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_dia_semana");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $Dia):
                                                                            echo "<option " . ($Grades['projeto_grade_carga_dia'] == $Dia['dia_semana_id'] ? 'selected="selected"': '') . "  value='{$Dia['dia_semana_id'] }'>{$Dia['nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>    
                                                             
                                                                </select>
                                                            </td>
                                                            
                                                            <td class="pt-4-half">
                                                                <input disabled type="time" name="hora_inicial_<?= $i ?>" placeholder="Hora Inicial"
                                                                       class="form-control"
                                                                       value="<?= $Grades['projeto_grade_carga_hora_inicial'] ?>">
                                                            </td>
                                                            
                                                            <td class="pt-4-half">
                                                                <input disabled type="time" name="hora_final_<?= $i ?>" placeholder="Carga Horária"
                                                                       class="form-control"
                                                                       value="<?= $Grades['projeto_grade_carga_hora_final'] ?>">
                                                            </td>
                                                           
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    echo "<tr>Sem resultados</tr>";
                                                    $QTDGrades = 0;
                                                }
                                                ?>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>



                                  <div class="clearfix"></div>
                              </form>
                    <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=escola/turma/cadastro_turma');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
  </div>
</div>
