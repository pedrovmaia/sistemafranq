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
                                <h4 class="card-title">CADASTRO DE FAQ</h4>
                                <p class="card-category">Cadastro de faq</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_FAQ."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_faq", "WHERE faq_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_faq">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">TÍTULO</label>
                      <input type="text" name="faq_titulo" value="<?= $faq_titulo ?>" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tipo de Portal</label>
                                            <select name="tipo_portal_id" class="form-control">
                                                <option value="0">SELECIONE O TIPO DE PORTAL</option>
                                                <?php
                                                $Read->ExeRead("escola_tipo_portal");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Tipo):
                                                        ?>
                                                          <option value="<?= $Tipo['tipo_portal_id'] ?>" <?php if ($FormData['tipo_portal_id'] == $Tipo['tipo_portal_id'] ) { echo "selected";}  ?>  ><?php echo $Tipo['tipo_portal_descricao']; ?></option>

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
                      <label class="bmd-label-floating">DESCRIÇÃO</label>
                      <textarea  name="faq_descricao" class="form-control" rows="4" cols="50" ><?= $faq_descricao ?></textarea>
                       </div>
                  </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="checkbox" name="faq_status" value="1" <?= ($faq_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="FaqEditar"/>
            <input type="hidden" name="faq_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='escola/EscolaFaq' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=escola/pedagogico/escola_faq');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_FAQ."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_faq">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
             <div class="row">
                

                    <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">TÍTULO</label>
                      <input type="text" name="faq_titulo" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">Tipo de Portal</label>
                                            <select name="tipo_portal_id" class="form-control">
                                                <option value="0">SELECIONE O TIPO DE PORTAL</option>
                                                <?php
                                                $Read->ExeRead("escola_tipo_portal");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Tipo):
                                                        ?>
                                                          <option value="<?= $Tipo['tipo_portal_id'] ?>"><?= $Tipo['tipo_portal_descricao']; ?></option>

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
                    <label class="bmd-label-floating">DESCRIÇÃO</label>
                     <textarea name="faq_descricao" class="form-control" rows="4" cols="50"></textarea>
                     </div>
                </div>
            </div>
                <div class="col-md-12">
                  <div class="form-group">
                     <input type="checkbox" name="faq_status" value="1"><?= $texto['InaC'] ?></label>
                  </div>
                </div>
              
            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="FaqAdd"/>
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
      ID FUNCIONALIDADE: <?= ESCOLA_FAQ ?>
  </div>
</div>
