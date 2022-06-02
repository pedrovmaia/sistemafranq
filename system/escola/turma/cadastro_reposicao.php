<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;

    $IdTurma = filter_input(INPUT_GET, 'idturma', FILTER_VALIDATE_INT);
    $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">CADASTRO DE REPOSIÇÃO DE AULA</h4>
                                <p class="card-category">Cadastro de reposição de aulas</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                      
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_REPOSICAO_AULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_reposicao", "WHERE reposicao_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_reposicao">
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                      <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">DATA</label>
                                                  <input type="text" name="reposicao_data"  value="<?= date('d/m/Y', strtotime($reposicao_data)) ?>" class="form-control formDate">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                  <input type="text" name="reposicao_descricao" value="<?= $reposicao_descricao ?>" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">HORA INICIAL</label>
                                                  <input type="time" name="reposicao_hora_inicial" value="<?= $reposicao_hora_inicial ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">HORA FINAL</label>
                                                  <input type="time" name="reposicao_hora_final" value="<?= $reposicao_hora_final ?>" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">MATÉRIAS</label>
                                                  <input type="text" name="reposicao_materias" value="<?= $reposicao_materias ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label  class="bmd-label-floating">MODALIDADE</label>
                                                     <select style="margin-top: -3px" name="reposicao_modalidade_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="">SELECIONE A MODALIDADE</option>
                                                        <?php
                                                        $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Modalidade):
                                                                ?>
                                                               
                                                                 <option value="<?= $Modalidade['modalidade_id'] ?>" <?php if ($reposicao_modalidade_id == $Modalidade['modalidade_id'] ) { echo "selected";}  ?>  ><?php echo $Modalidade['modalidade_nome']; ?></option>



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
                                                  <label class="bmd-label-floating">ATIVIDADES</label>
                                                  <input type="text" name="reposicao_atividades" value="<?= $reposicao_atividades ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">PAGO</label>
                                                <select class="form-control" name="reposicao_pago">
                                                   <option value="">SELECIONE UMA OPÇÃO</option>
                                                    <option value="0" <?= ($FormData['reposicao_pago'] == 0 ? 'selected="selected"' : ''); ?>>Não</option>
                                                    <option value="1" <?= ($FormData['reposicao_pago'] == 1? 'selected="selected"' : ''); ?>>Pago</option>
                                                </select>
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label>LOCALIZE O ALUNO</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_pessoa" type="text" name="reposicao_pessoa_id"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_pessoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_pessoa" type="hidden" name="reposicao_pessoa_id" class="form-control">
                                              </div>
                                          </div>
                                         </div>


<div class="row">

                                          <div class="col-md-12">
                                              <div class="form-group">

                                                  <input type="checkbox" name="reposicao_status" value="1" <?= ($reposicao_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                                      <br/>
                                  </div>
                                  <br/>
                                  <input type="hidden" name="action" value="ReposicaoEditar"/>
                                  <input type="hidden" name="reposicao_id" value="<?= $Id; ?>"/>
                                  <input type="hidden" name="reposicao_projeto_id" value="<?= $reposicao_projeto_id ?>"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='escola/Reposicao' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
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
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_REPOSICAO_AULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_reposicao">
                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                          
                                           <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">DATA</label>
                                                  <input type="text" name="reposicao_data" class="form-control formDate">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                  <input type="text" name="reposicao_descricao" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">HORA INICIAL</label>
                                                  <input type="time" name="reposicao_hora_inicial" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">HORA FINAL</label>
                                                  <input type="time" name="reposicao_hora_final" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                    
                                                  <label  class="bmd-label-floating">MATÉRIA</label>
                                                     <select style="margin-top: -3px" name="reposicao_materias" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="">SELECIONE A MATÉRIA</option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Materia):
                                                                ?>
                                                               
                                                                 <option value="<?= $Materia['materias_aula_id']?>"><?php echo $Materia['materias_aula_nome']; ?></option>

                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                 <label  class="bmd-label-floating">MODALIDADE</label>
                                                     <select style="margin-top: -3px" name="reposicao_modalidade_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="">SELECIONE A MODALIDADE</option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Modalidade):
                                                                ?>
                                                               
                                                                 <option value="<?= $Modalidade['modalidade_id']?>"><?php echo $Modalidade['modalidade_nome']; ?></option>



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
                                                  <label class="bmd-label-floating">ATIVIDADES</label>
                                                  <input type="text" name="reposicao_atividades" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">PAGO</label>
                                                <select class="form-control" name="reposicao_pago">
                                                  <option selected value="">SELECIONE UMA OPÇÃO</option>
                                                    <option value="0">Não</option>
                                                    <option value="1">Pago</option>
                                                </select>
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label>LOCALIZE O ALUNO</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_pessoa" type="text" name="reposicao_pessoa_id"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_pessoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_pessoa" type="hidden" name="reposicao_pessoa_id" class="form-control">
                                              </div>
                                          </div>
                                         </div>


                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="reposicao_status" value="1" ><?= $texto['InaC'] ?></label>
                                        </div>
                                    </div>
                                  </div>
                                
                                <br/>
                            </div>
                            <br/>
                            <input type="hidden" name="action" value="ReposicaoAdd"/>
                            <input type="hidden" name="reposicao_projeto_id" value="<?= $IdTurma; ?>"/>
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
      ID FUNCIONALIDADE: <?= ESCOLA_REPOSICAO_AULA ?>
  </div>
</div>
<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_alunos_reposicao"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
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
                          <th data-field="id" data-filter-control="input">ID</th>
                          <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>