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
                                <h4 class="card-title"><?= $texto['CadCTRLCQ'] ?></h4>
                                <p class="card-category"><?= $texto['CadCTRLCQi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_CONTROLE_CHEQUE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_controle_cheque", "WHERE controle_cheque_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_controle_cheque">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['NUMBM'] ?></label>
                            <input type="text" name="controle_cheque_numero" value="<?= $controle_cheque_numero ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['BANK'] ?></label>
                            <input type="text" name="controle_cheque_banco" value="<?= $controle_cheque_banco ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['AGNCi'] ?></label>
                            <input type="text" name="controle_cheque_agencia" value="<?= $controle_cheque_agencia ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['ACOT'] ?></label>
                            <input type="text" name="controle_cheque_conta" value="<?= $controle_cheque_conta ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                            <input type="text" name="controle_cheque_data" value="<?= $controle_cheque_data ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                             <div class="form-group">
                                        <label><?= $texto['LOCALP'] ?></label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_aluno" type="text" name="controle_cheque_numero_id"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_alunoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_aluno" type="hidden" name="pessoa_id" class="form-control">
                                    </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <input type="text" name="controle_cheque_descricao" value="<?= $controle_cheque_descricao ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['TITE'] ?></label>
                            <input type="text" name="controle_cheque_titulo_id" value="<?= $controle_cheque_titulo_id ?>" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                            <input type="text" name="controle_cheque_valor" value="<?= $controle_cheque_valor ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['GPRA'] ?></label>
                            <input type="text" name="controle_cheque_bom_para" value="<?= $controle_cheque_bom_para ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                            <input type="text" name="controle_cheque_cpf" value="<?= $controle_cheque_cpf ?>" class="form-control formCpf">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CORRENT'] ?></label>
                            <input type="text" name="controle_cheque_correntista" value="<?= $controle_cheque_correntista ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                         <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['SITAC'] ?></label>
                                            <select name="controle_cheque_situacao_id" class="form-control">
                                                <option value="0"><?= $texto['SELMASCA'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_situacao_cheque", "WHERE situacao_cheque_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Situacao):
                                                        ?>
                                                          <option value="<?= $Situacao['situacao_cheque_id'] ?>" <?php if ($FormData['controle_cheque_situacao_id'] == $Situacao['situacao_cheque_id'] ) { echo "selected";}  ?>  ><?php echo $Situacao['situacao_cheque_descricao']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                    <div class="col-md-6">
                        <div class="form-group">

                    <label class="bmd-label-floating">Status</label>
                                                <select class="form-control" name="controle_cheque_status">
                                                    <option selected  value=""><?= $texto['SELOSTAT'] ?></option>
                                                    <option value="0" <?= ($FormData['controle_cheque_status'] == 1 ? 'selected="selected"' : ''); ?>>Cadastrado</option>
                                                    <option value="1" <?= ($FormData['controle_cheque_status'] == 2 ? 'selected="selected"' : ''); ?>>Baixado</option>
                                                     <option value="3" <?= ($FormData['controle_cheque_status'] == 2 ? 'selected="selected"' : ''); ?>>Cancelado</option>
                                                </select>
                                            </div>
                                        </div>

                </div>

                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="ControleChequeEditar"/>
            <input type="hidden" name="controle_cheque_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='financeiro/ControleCheque' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=financeiro/cadastro_controle_cheque');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_CONTROLE_CHEQUE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_controle_cheque">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
              <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['NUMBM'] ?></label>
                            <input type="text" name="controle_cheque_numero"  class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['BANK'] ?></label>
                            <input type="text" name="controle_cheque_banco"  class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['AGNCi'] ?></label>
                            <input type="text" name="controle_cheque_agencia" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['ACOT'] ?></label>
                            <input type="text" name="controle_cheque_conta"  class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                            <input type="text" name="controle_cheque_data" class="form-control formDate">
                        </div>
                    </div>
                 <div class="col-md-6">
                             <div class="form-group">
                                        <label><?= $texto['LOCALP'] ?></label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_pessoa" type="text" name="controle_cheque_pessoa_id"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_pessoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_pessoa" type="hidden" name="controle_cheque_pessoa_id" class="form-control">
                                    </div>
                        </div>
                    </div>
                

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <input type="text" name="controle_cheque_descricao" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['TITE'] ?></label>
                            <input type="text" name="controle_cheque_titulo_id"  class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                            <input type="text" name="controle_cheque_valor"  class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['GPRA'] ?></label>
                            <input type="text" name="controle_cheque_bom_para"  class="form-control formDate">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                            <input type="text" name="controle_cheque_cpf" class="form-control formCpf">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CORRENT'] ?></label>
                            <input type="text" name="controle_cheque_correntista"  class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating"><?= $texto['SITAC'] ?></label>
                                            <select style="margin-top: -3px" class="form-control" name="controle_cheque_situacao_id">
                                                <option value="0"><?= $texto['SELSITi'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_situacao_cheque", "WHERE situacao_cheque_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Situacao):
                                                          ?>
                                                          <option value="<?= $Situacao['situacao_cheque_id'] ?>">
                                                          <?= $Situacao['situacao_cheque_descricao'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                    </div>
                                    </div>

                    <div class="col-md-6">
                        <div class="form-group">

                    <label class="bmd-label-floating">Status</label>
                                                <select class="form-control" name="control_cheque_status">
                                                    <option selected  value=""><?= $texto['SELOSTAT'] ?></option>
                                                    <option value="0"><?= $texto['CADASTR'] ?></option>
                                                    <option value="1"><?= $texto['BAIXAD'] ?></option>
                                                    <option value="2"><?= $texto['CANCELAD'] ?></option>
                                                </select>
                                            </div>
                                        </div>

                </div>

            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="ControleChequeAdd"/>
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
      ID FUNCIONALIDADE: <?= FINANCEIRO_CONTROLE_CHEQUE ?>
  </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_pessoas"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListPessoas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                          <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                          <th data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
