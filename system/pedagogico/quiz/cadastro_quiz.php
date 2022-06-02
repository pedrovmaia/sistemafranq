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
                                <h4 class="card-title">CADASTRO DE QUIZZES</h4>
                                <p class="card-category">Cadastro de quizzes</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_QUIZ."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_quizzes", "WHERE quiz_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_quiz" action="" method="post" enctype="multipart/form-data" >
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TITÚLO</label>
                            <input type="text" name="quiz_titulo" value="<?= $quiz_titulo ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" name="quiz_descricao" value="<?= $quiz_descricao ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">  
                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">QUANTIDADE DE PERGUNTAS</label>
                            <input type="text" name="quiz_quantidade_perguntas" value="<?= $quiz_quantidade_perguntas ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">CAPA</label>
                            <input name="quiz_capa" type="file" class="form-control">
                        </div>
                    </div>
                </div> 

                  <div class="row">
                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating">TIPO DE PORTAL</label>
                                            <select style="margin-top: -3px" class="form-control" name="quiz_tipo_portal">
                                                <option value="">SELECIONE O TIPO DE PORTAL</option>
                                               <?php
                                                  $Read->ExeRead("escola_tipo_portal");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Tipo):
                                                          ?>
                                                          <option <?= ($quiz_tipo_portal == $Tipo['tipo_portal_id'] ? "selected='selected'" : "") ?> value="<?= $Tipo['tipo_portal_id'] ?>"><?= $Tipo['tipo_portal_descricao'] ?></option> 
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                    </div>
                                    </div>
                </div>
<div class="row">
                <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" name="quiz_status" value="1" <?= ($quiz_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="QuizEditar"/>
            <input type="hidden" name="quiz_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='escola/Quiz' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=pedagogico/quiz/cadastro_quiz');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_QUIZ."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_quiz" action="" method="post" enctype="multipart/form-data" >
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TITÚLO</label>
                            <input type="text" name="quiz_titulo" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" name="quiz_descricao" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">QUANTIDADE DE PERGUNTAS</label>
                            <input type="text" name="quiz_quantidade_perguntas"  class="form-control">              </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">CAPA</label>
                            <input name="quiz_capa" type="file" class="form-control">
                        </div>
                    </div>
                </div>
                       
                       <div class="row">
                 <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating">TIPO DE PORTAL</label>
                                            <select style="margin-top: -3px" class="form-control" name="quiz_tipo_portal">
                                                <option value="">SELECIONE O TIPO DE PORTAL</option>
                                               <?php
                                                  $Read->ExeRead("escola_tipo_portal");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Tipo):
                                                          ?>
                                                          <option value="<?= $Tipo['tipo_portal_id'] ?>">
                                                          <?= $Tipo['tipo_portal_descricao'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>
                                    </div>
                                    </div>  
                            <input type="text" hidden value="<?= date('d/m/Y') ?>" name="quiz_date" class="form-control formDate">
                </div>

                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="checkbox" name="quiz_status" value="1" ><?= $texto['InaC'] ?></label>
                    </div>
                </div>
            </div>
            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="QuizAdd"/>
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
      ID FUNCIONALIDADE: <?= PEDAGOGICO_QUIZ ?>
  </div>
</div>
