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
                                <h4 class="card-title"><?= $texto['CadFMPC'] ?></h4>
                                <p class="card-category"><?= $texto['CadFMPCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_FORMA_PARCELAMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_forma_parcelamento">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                            <input type="text" name="forma_parcelamento_nome" value="<?= $forma_parcelamento_nome ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                                                <div class="form-group">
                                                 <label class="bmd-label-floating"><?= $texto['INi'] ?></label>
                                                <select class="form-control" name="forma_parcelamento_entrada">
                                                    <option selected  value="">Forma de parcelamento possui ou n??o entrada</option>
                                                    <option value="0" <?= ($FormData['forma_parcelamento_entrada'] == 0 ? 'selected="selected"' : ''); ?>>N??o</option>
                                                    <option value="1" <?= ($FormData['forma_parcelamento_entrada'] == 1 ? 'selected="selected"' : ''); ?>>Sim</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">CAR??NCIA</label>
                        <input type="number" name="forma_parcelamento_carencia" value="<?= $forma_parcelamento_carencia ?>" class="form-control">
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">PARCELAS</label>
                        <input type="number" name="forma_parcelamento_parcelas" value="<?= $forma_parcelamento_parcelas ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">TIPO</label>
                                            <select class="form-control" name="forma_parcelamento_tipo">
                                                <option selected  value="">Selecione o tipo</option>
                                                 <option value="0" <?= ($FormData['forma_parcelamento_tipo'] == 0 ? 'selected="selected"' : ''); ?>>A Vista</option>
                                                    <option value="1" <?= ($FormData['forma_parcelamento_tipo'] == 1 ? 'selected="selected"' : ''); ?>>Parcelado</option>
                                                     <option value="2" <?= ($FormData['forma_parcelamento_tipo'] == 2 ? 'selected="selected"' : ''); ?>>Recorr??ncia</option>
                                            </select>
                                        </div>
                                    </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">INTERVALO</label>
                        <input type="text" name="forma_parcelamento_intervalo" value="<?= $forma_parcelamento_intervalo ?>" class="form-control">
                    </div>
                </div>
            </div>

                 <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" name="forma_parcelamento_status" value="1" <?= ($forma_parcelamento_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="FormaParcelamentoEditar"/>
            <input type="hidden" name="forma_parcelamento_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='financeiro/FormaParcelamento' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, voc?? tentou editar um usu??rio que n??o existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=financeiro/cadastro_forma_parcelamento');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_FORMA_PARCELAMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_forma_parcelamento">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                        <input type="text" name="forma_parcelamento_nome" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['INi'] ?></label>
                                            <select class="form-control" name="forma_parcelamento_entrada">
                                                <option selected  value="">Forma de parcelamento possui ou n??o entrada</option>
                                                <option value="0"><?= $texto['SYS'] ?></option>
                                                <option value="1"><?= $texto['NNN'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">CAR??NCIA</label>
                        <input type="number" name="forma_parcelamento_carencia" class="form-control">
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">PARCELAS</label>
                        <input type="number" name="forma_parcelamento_parcelas" class="form-control">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">TIPO</label>
                                            <select class="form-control" name="forma_parcelamento_tipo">
                                                <option selected  value="">Selecione o tipo</option>
                                                <option value="0">A vista</option>
                                                <option value="1">Parcelas</option>
                                                <option value="2">Recorr??ncia</option>
                                            </select>
                                        </div>
                                    </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">INTERVALO</label>
                        <input type="text" name="forma_parcelamento_intervalo" class="form-control">
                    </div>
                </div>
            </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <input type="checkbox" name="forma_parcelamento_status" value="1" ><?= $texto['InaC'] ?></label>
                    </div>
                </div>
           
            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="FormaParcelamentoAdd"/>
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
      ID FUNCIONALIDADE: <?= FINANCEIRO_FORMA_PARCELAMENTO ?>
  </div>
</div>
