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
                                <h4 class="card-title"><?= $texto['CadPLT'] ?></h4>
                                <p class="card-category"><?= $texto['CadPLTi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_PERIODO_LETIVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_periodo_letivo", "WHERE periodo_letivo_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_periodo_letivo">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <input type="text" name="periodo_letivo_descricao" value="<?= $periodo_letivo_descricao ?>" class="form-control">
                        </div>
                    </div>

                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['AnoM'] ?></label>
                                            <select name="periodo_letivo_ano_id" class="form-control">
                                                <option value="0"><?= $texto['SelAL'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_ano_letivo", "WHERE ano_letivo_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Ano):
                                                        ?>
                                                          <option value="<?= $Ano['ano_letivo_id'] ?>" <?php if ($Pessoa['periodo_letivo_ano_id'] == $Ano['ano_letivo_id'] ) { echo "selected";}  ?>  ><?php echo $Ano['ano_letivo_descricao']; ?></option>

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

                            <input type="checkbox" name="periodo_letivo_status" value="1" <?= ($periodo_letivo_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="PeriodoLetivoEditar"/>
            <input type="hidden" name="periodo_letivo_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='franqueador/PeriodoLetivo' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, voc?? tentou editar um usu??rio que n??o existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=franqueador/dominios/cadastro_periodo_letivo');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_PERIODO_LETIVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_periodo_letivo">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">DESCRI????O</label>
                        <input type="text" name="periodo_letivo_descricao" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating">Ano</label>
                                            <select name="periodo_letivo_ano_id" class="form-control">
                                                <option value="0">Selecione o ano letivo</option>
                                                <?php
                                                $Read->ExeRead("sys_ano_letivo", "WHERE ano_letivo_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Ano):
                                                        ?>
                                                        <option value="<?= $Ano['ano_letivo_id'] ?>"><?= $Ano['ano_letivo_descricao'] ?></option>
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
                        <input type="checkbox" name="periodo_letivo_status" value="1" ><?= $texto['InaC'] ?></label>
                    </div>
                </div>
            
            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="PeriodoLetivoAdd"/>
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
      <?= $texto['IDFunc'] ?> <?= FRANQUEADOR_PERIODO_LETIVO ?>
  </div>
</div>
