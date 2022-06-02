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
                                <h4 class="card-title"><?= $texto['VerCTRLCQ'] ?></h4>
                                <p class="card-category"><?= $texto['VerCTRLCQi'] ?></p>
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
    if($permissao["ler"] != 1){
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
                            <input disabled type="text" name="controle_cheque_numero" value="<?= $controle_cheque_numero ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['BANK'] ?></label>
                            <input disabled type="text" name="controle_cheque_banco" value="<?= $controle_cheque_banco ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['AGNCi'] ?></label>
                            <input disabled type="text" name="controle_cheque_agencia" value="<?= $controle_cheque_agencia ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['ACOT'] ?></label>
                            <input disabled type="text" name="controle_cheque_conta" value="<?= $controle_cheque_conta ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                            <input disabled type="text" name="controle_cheque_data" value="<?= $controle_cheque_data ?>" class="form-control">
                        </div>
                    </div>
                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PEOPLEi'] ?></label>
                                            <select disabled name="controle_cheque_pessoa_id" class="form-control">
                                                <option value="0">Selecione uma situação</option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                          <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['controle_cheque_pessoa_id'] == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>

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
                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <input disabled type="text" name="controle_cheque_descricao" value="<?= $controle_cheque_descricao ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['TITE'] ?></label>
                            <input disabled type="text" name="controle_cheque_titulo_id" value="<?= $controle_cheque_titulo_id ?>" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                            <input disabled type="text" name="controle_cheque_valor" value="<?= $controle_cheque_valor ?>" class="form-control">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['GPRA'] ?></label>
                            <input disabled type="text" name="controle_cheque_bom_para" value="<?= $controle_cheque_bom_para ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CPF'] ?></label>
                            <input disabled type="text" name="controle_cheque_cpf" value="<?= $controle_cheque_cpf ?>" class="form-control formCpf">
                        </div>
                    </div>
                 <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['CORRENT'] ?></label>
                            <input disabled type="text" name="controle_cheque_correntista" value="<?= $controle_cheque_correntista ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                         <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['SITAC'] ?></label>
                                            <select disabled name="controle_cheque_situacao_id" class="form-control">
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
                                                <select disabled class="form-control" name="controle_cheque_status">
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
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=financeiro/cadastro_controle_cheque');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FINANCEIRO_CONTROLE_CHEQUE ?>
  </div>
</div>
