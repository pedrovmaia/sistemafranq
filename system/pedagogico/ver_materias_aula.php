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
                                <h4 class="card-title">VER MATÉRIA DE AULA</h4>
                                <p class="card-category">Exibição de MATÉRIA</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php

if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_MATERIAS_AULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_materias_aula">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                < 
                    <div class="col-md-12">
                        <div class="row">

                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">NOME</label>
                            <input type="text" disabled name="materias_aula_nome" value="<?= $materias_aula_nome ?>" class="form-control">
                        </div>
                    </div>

                     <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating">LIVRO</label>
                                                   
                                                     <select disabled style="margin-top: -3px" disbled name="materias_aula_livro_id" value="<?= $materias_aula_livro_id ?>"  class="form-control jsys_tipo_conta_bancaria" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0">SELECIONE UM LIVRO</option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("escola_livros");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Livro):
                                                                ?>
                                                                <option value="<?= $Livro['livro_id'] ?>"><?= $Livro['livro_nome'] ?></option>
                                                                <option value="<?= $Livro['livro_id'] ?>" <?= ($Livro['livro_id'] == $FormData['materias_aula_livro_id'] ? 'selected="selected"' : ''); ?>><?= $Livro['livro_nome'] ?></option>
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
                        <div class="form-group">

                            <input type="checkbox" disabled name="materias_aula_status" value="1" <?= ($materias_aula_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
        header('Location: painel.php?exe=pedagogico/cadastro_materias_aula');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_MATERIAS_AULA ?>
  </div>
</div>
