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
                                <h4 class="card-title">CADASTRO DE OCORRÊNCIAS DE RETENÇÃO DE ALUNO</h4>
                                <p class="card-category">Cadastro de ocorrências de retenção de aluno</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        $IdFunc = $_SESSION['userSYSFranquia']['pessoa_id'] ;
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RETENCAO_OCORRENCIA_RETENCAO_ALUNO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_ocorrencia_retencao_aluno", "WHERE ocorrencia_retencao_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_ocorrencia_retencao_aluno">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">FUNCIONÁRIO</label>
                                            <select disabled name="ocorrencia_retencao_funcionario" class="form-control">
                                                <option value="0">Selecione o funcionário</option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas", "WHERE pessoa_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Funcionario):
                                                        ?>
                                                          <option value="<?= $Funcionario['pessoa_id'] ?>" <?php if ($FormData['ocorrencia_retencao_funcionario'] == $Funcionario['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Funcionario['pessoa_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select> 
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                                                                   <div class="form-group">
                                      <label class="bmd-label-floating">Aluno</label>
                                            <select disabled name="ocorrencia_retencao_aluno" class="form-control">
                                                <option value="0">Selecione o aluno</option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas", "WHERE pessoa_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Aluno):
                                                        ?>
                                                          <option value="<?= $Aluno['pessoa_id'] ?>" <?php if ($FormData['ocorrencia_retencao_aluno'] == $Aluno['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Aluno['pessoa_nome']; ?></option>

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
                                        <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                    <input type="text" name="ocorrencia_retencao_descricao" value="<?= $ocorrencia_retencao_descricao ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                        <label class="bmd-label-floating">DATA</label>
                                                    <input type="text" name="ocorrencia_retencao_data" value="<?= $ocorrencia_retencao_data ?>" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">                                             <label class="bmd-label-floating">STATUS</label>
                                                <select class="form-control" name="ocorrencia_retencao_status">
                                                    <option selected  value="">Selecione o status:</option>
                                                    <option value="0" <?= ($FormData['ocorrencia_retencao_status'] == 0 ? 'selected="selected"' : ''); ?>>Aberto</option>
                                                    <option value="1" <?= ($FormData['ocorrencia_retencao_status'] == 1 ? 'selected="selected"' : ''); ?>>Resolvido</option>
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="OcorrenciaRetencaoEditar"/>
                                    <input type="hidden" name="ocorrencia_retencao_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='retencao/OcorrenciaRetencao' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=retencao/cadastro_ocorrencia_retencao_aluno');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RETENCAO_OCORRENCIA_RETENCAO_ALUNO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_ocorrencia_retencao_aluno">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating">FUNCIONÁRIO</label>
                                                    <span class="form-control"><?= $_SESSION['userSYSFranquia']['pessoa_nome'] ?></span>

                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                        <label>LOCALIZE O ALUNO</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e selecione o aluno" id="txt_aluno" type="text" name="pessoa_nome"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_aluno" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_aluno" type="hidden" name="pessoa_id" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">DATA</label>
                                                    <input type="text" name="ocorrencia_retencao_data" class="form-control formDate">
                                                </div>
                                            </div>

                                                                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                    <input type="text" name="ocorrencia_retencao_descricao"  class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">STATUS</label>
                                            <select class="form-control" name="ocorrencia_retencao_status">
                                                <option selected  value="">Selecione o status:</option>
                                                <option value="0">Aberto</option>
                                                <option value="1">Resolvido</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="OcorrenciaRetencaoAdd"/>
                                <input type="hidden" name="ocorrencia_retencao_funcionario" value="<?= $IdFunc ?>"/>
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

         <div id="getCodeModal" class="modal fade in" >
  <div class="modal-dialog modal-confirm">
    <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
      <div class="modal-header" style=" border-bottom: none">
         <h4 class="card-title  text-center">LOCALIZAR ALUNOS</h4>
         

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body text-center">
         

          <div class="border_shadow" style="background-color: #fff; padding: 20px">
                  <table  class="table table-hover display"
                          id="table_modal_aluno_matricula"
                          data-toolbar="#table"
                          data-locale="pt-BR"                         
                          data-filter-control="true"
                          data-minimum-count-columns="2"
                          data-url="_ajax/lookups/ListClientesAlunos.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="nome"
                          data-toggle="table"
                          data-select-item-name="nome"
                          data-buttons-class="primary"

                          >
                      <thead>
                      <tr>
                          <th data-radio="true"></th> 
                         
                          <th data-field="id" data-filter-control="input">ID</th>
                           <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                           <th  data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                          
                      </tr>
                      </thead>
                  </table>
                  </div>
      </div>
    </div>


  </div>
</div>
        ID FUNCIONALIDADE: <?= RETENCAO_OCORRENCIA_RETENCAO_ALUNO ?>
    </div>
</div>
