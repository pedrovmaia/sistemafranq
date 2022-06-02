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
                                <h4 class="card-title"><?= $texto['VerEXRC'] ?></h4>
                                <p class="card-category"><?= $texto['VerEXRCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_EXERCICIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_tipo_avaliacao">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

               
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                    <input type="text" disabled name="exercicio_nome" value="<?= $exercicio_nome ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['CODi'] ?></label>
                                                    <input type="text" disabled name="exercicio_codigo" value="<?= $exercicio_codigo ?>" class="form-control">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">TIPO</label>
                                                <select disabled class="form-control" name="exercicio_tipo">
                                                    <option value="0" <?= ($FormData['exercicio_tipo'] == 0 ? 'selected="selected"' : ''); ?>>Speaking</option>
                                                    <option value="1" <?= ($FormData['exercicio_tipo'] == 1? 'selected="selected"' : ''); ?>>Listening</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" disabled name="exercicio_status" value="1" <?= ($exercicio_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
        header('Location: painel.php?exe=escola/avaliacao/cadastro_exercicio');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_EXERCICIO ?>
  </div>
</div>
