<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdPessoa = filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);
$IdMov = filter_input(INPUT_GET, 'idmov', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">CADASTRO DE INCLUSÃO AO SCPC</h4>
                                <p class="card-category">Cadastro de inclusão ao scpc</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php

if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_ENVIO_SCPC."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_envio_scpc", "WHERE envio_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_envio_scpc">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                 <div class="row">
              
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DATA DE INCLUSÃO</label>
                            <input type="text" value="<?= $envio_data_inclusao ?>" name="envio_data_inclusao" class="form-control">
                        </div>
                    </div>
                     
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DATA DE RETIRADA</label>
                            <input type="text" value="<?= $envio_data_retirada ?>" name="envio_data_retirada" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">OBSERVAÇÃO</label>
                            <input type="text" value="<?= $envio_observacao ?>" name="envio_observacao" class="form-control">
                        </div>
                    </div>
                </div>

         
                    
                

                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="EnvioScpcEditar"/>
            <input type="hidden" name="envio_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='financeiro/EnvioScpc' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php

        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_ENVIO_SCPC."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }

     $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :idpessoa AND unidade_id = :unidade", "idpessoa={$IdPessoa}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

    ?>
    <form class="form_envio_scpc">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            
               <div class="row">
                                    
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">PESSOA</label>
                            <span class="form-control"><?= $Read->getResult()[0]['pessoa_nome'] ?></span>
                        </div>
                    </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DATA DE INCLUSÃO</label>
                            <input type="text"name="envio_data_inclusao" class="form-control formDate">
                        </div>
                    </div>
                </div>
                     
                     <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DATA DE RETIRADA</label>
                            <input type="text" name="envio_data_retirada" class="form-control formDate">
                        </div>
                    </div>
                  <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">OBSERVAÇÃO</label>
                            <input type="text" name="envio_observacao" class="form-control">
                        </div>
                    </div>

                </div>
           

            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="EnvioScpcAdd"/>
        <input type="hidden" name="envio_pessoa_id" value="<?= $IdPessoa ?>"/>
        <input type="hidden" name="envio_movimentacao_recebimento_id" value="<?= $IdMov ?>"/>
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
      ID FUNCIONALIDADE: <?= CONTASRECEBER_ENVIO_SCPC ?>
  </div>
</div>
