<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdCurso = filter_input(INPUT_GET, 'idcurso', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">VER ETAPA DE AVALIAÇÃO</h4>
                                <p class="card-category">Exibição de etapa de avaliação</p>
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
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_etapa_produto", "WHERE etapa_produto_id = :id", "id={$Id}");
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
                                                  <input disabled type="text" name="etapa_produto_nome" value="<?= $etapa_produto_nome ?>" class="form-control">
                                              </div>
                                          </div>

                                           <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Inicial</label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="etapa_produto_materia_inicial_id" value="<?= $etapa_produto_materia_inicial_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE A MATÉRIA INICIAL</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st", "st=0");
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
                                         
                                         <div class="row">
                                              <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating">Matérial Final</label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="etapa_produto_materia_final_id" value="<?= $etapa_produto_materia_final_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE A MATÉRIA FINAL</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_status = :st", "st=0");
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

                                                  <input disabled type="checkbox" name="etapa_produto_status" value="1" <?= ($etapa_produto_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                            <br/>
                        </div>
                        <br/>
                        <div class="clearfix"></div>
                    </form>
                    <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=empresa/admin/cadastro_etapa_avaliacao');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_ETAPA_AVALIACAO ?>
  </div>
</div>
