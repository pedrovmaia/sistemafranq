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
                                <h4 class="card-title">VER QUIZ</h4>
                                <p class="card-category">Exibição de quiz</p>
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
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_quizzes", "WHERE quiz_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <div class="row">
                    <div class="ml-3">
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                             <a href="<?= BASE ?>/painel.php?exe=pedagogico/quiz/filtro_quiz_perguntas&id=<?= $FormData["quiz_id"] ?>"
                           class="btn btn-primary pull-right">PERGUNTAS</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                              <a href="<?= BASE ?>/painel.php?exe=pedagogico/quiz/filtro_escola_respostas_quiz&id=<?= $FormData["quiz_id"] ?>"
                           class="btn btn-primary pull-right">RESULTADO</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>

        <form class="form_quiz">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TITÚLO</label>
                            <input type="text" disabled name="quiz_titulo" value="<?= $quiz_titulo ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" disabled name="quiz_descricao" value="<?= $quiz_descricao ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">  
                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">QUANTIADE DE PERGUNTAS</label>
                            <input type="text" disabled name="quiz_quantidade_perguntas" value="<?= $quiz_quantidade_perguntas ?>" class="form-control">

                            
                        </div>
                    </div>
                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating">TIPO DE PORTAL</label>
                                            <select disabled style="margin-top: -3px" class="form-control" name="quiz_tipo_portal">
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
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"></label>
                            <img disabled src="<?= BASE ?>/uploads/<?= $quiz_capa ?>" height="150" width="150">
                        </div>
                    </div>

                </div>

                  <div class="row">
                <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" disabled name="quiz_status" value="1" <?= ($quiz_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
        header('Location: painel.php?exe=pedagogico/quiz/cadastro_quiz');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDAGOGICO_QUIZ ?>
  </div>
</div>
