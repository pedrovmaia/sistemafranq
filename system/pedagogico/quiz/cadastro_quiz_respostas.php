<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdPergunta = filter_input(INPUT_GET, 'idpergunta', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">CADASTRO DE RESPOTAS</h4>
                                <p class="card-category">Cadastro de respostas</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php

if ($Id):
    

    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_QUIZ_RESPOSTAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_quiz_respostas", "WHERE quiz_respostas_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_quiz_respostas">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" name="quiz_respostas_descricao" value="<?= $quiz_respostas_descricao ?>"   class="form-control">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">OPÇÃO</label>
                            <input type="text" name="quiz_respostas_opcao" value="<?= $quiz_respostas_opcao ?>"  class="form-control">    
                        </div>   </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                             <label class="bmd-label-floating">SEQUÊNCIA</label>
                            <input type="text" name="quiz_respostas_seq" value="<?= $quiz_respostas_seq ?>"  class="form-control">   

                        </div>
                    </div>
                </div>
                

                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="QuizRespostasEditar"/>
            <input type="hidden" name="quiz_respostas_id" value="<?= $Id; ?>"/>
            <input type="hidden" name="quiz_respostas_pergunta_id" value="<?= $quiz_respostas_pergunta_id ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='escola/QuizRespostas' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=pedagogico/quiz_respostas/cadastro_quiz_respostas');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_QUIZ_RESPOSTAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_quiz_respostas">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" name="quiz_respostas_descricao"   class="form-control">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">OPÇÃO</label>
                            <input type="text" name="quiz_respostas_opcao" placeholder="A,B,C,D,E..."  class="form-control">    
                        </div>   </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                             <label class="bmd-label-floating">SEQUÊNCIA</label>
                            <input type="text" name="quiz_respostas_seq" class="form-control">   

                        </div>
                    </div>
                </div>
           

            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="QuizRespostasAdd"/>
        <input type="hidden" name="quiz_respostas_pergunta_id" value="<?= $IdPergunta ?>"/>
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
      ID FUNCIONALIDADE: <?= PEDAGOGICO_QUIZ_RESPOSTAS ?>
  </div>
</div>
