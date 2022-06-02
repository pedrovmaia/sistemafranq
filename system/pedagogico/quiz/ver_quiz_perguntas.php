<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
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
                                <h4 class="card-title">VER PERGUNTA</h4>
                                <p class="card-category">Exibição de pergunta</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php

if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_QUIZ_PERGUNTAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_quiz_perguntas", "WHERE quiz_pergunta_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
         <div id="toolbar">
                    <br/>
                    <?php
                    if($permissao["inserir"] == 1) {
                        ?>
                        <a href="<?= BASE ?>/painel.php?exe=pedagogico/quiz/filtro_quiz_respostas&id=<?= $FormData["quiz_pergunta_id"] ?>"
                           class="btn btn-primary pull-right">Respostas</a>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>

        <form class="form_quiz_pergunta">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TITÚLO</label>
                            <input type="text" disabled name="quiz_pergunta_titulo" value="<?= $quiz_pergunta_titulo ?>" class="form-control">
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating">SEQUÊNCIA</label>
                            <input type="text" disabled name="quiz_pergunta_seq" value="<?= $quiz_pergunta_seq ?>" class="form-control">

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
        header('Location: painel.php?exe=pedagogico/quiz/cadastro_quiz_perguntas');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDAGOGICO_QUIZ_PERGUNTAS ?>
  </div>
</div>
