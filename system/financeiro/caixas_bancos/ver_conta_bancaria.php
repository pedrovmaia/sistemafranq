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
                                <h4 class="card-title"><?= $texto['VerACCTS'] ?></h4>
                                <p class="card-category"><?= $texto['VerACCTSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_CONTA_BANCARIA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_conta_bancaria">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

               <div class="row">                    
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                        <input disabled type="text" name="conta_bancaria_nome" value="<?= $conta_bancaria_nome ?>" class="form-control">
                    </div>
                </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TP'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="conta_bancaria_tipo_id" value="<?= $FormData['conta_bancaria_tipo_id'] ?>"  class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELTDCB'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_tipo_conta_bancaria", "WHERE tipo_conta_bancaria_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoContaBancaria):
                                                                ?>
                                                                 <option value="<?= $TipoContaBancaria['tipo_conta_bancaria_id'] ?>" <?php if ($FormData['conta_bancaria_tipo_id']  == $TipoContaBancaria['tipo_conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $TipoContaBancaria['tipo_conta_bancaria_nome']; ?></option>
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
                                                      <label  class="bmd-label-floating"><?= $texto['INSTFNi'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="conta_bancaria_banco_id" value="<?= $FormData['conta_bancaria_banco_id'] ?>"   class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SELUMINST'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_instituicao_financeira", "WHERE instituicao_financeira_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $InstituicaoFinanceira):
                                                                ?> <option value="<?= $InstituicaoFinanceira['instituicao_financeira_id'] ?>" <?php if ($FormData['conta_bancaria_banco_id']  == $InstituicaoFinanceira['instituicao_financeira_id'] ) { echo "selected";}  ?>  ><?php echo $InstituicaoFinanceira['instituicao_financeira_nome']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    </div>

                                      </div>
                                       <div class="col-md-6">
                                                <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['AGNCi'] ?></label>
                        <input disabled type="text" name="conta_bancaria_agencia" value="<?= $conta_bancaria_agencia ?>"  class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                                                <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DVANC'] ?></label>
                        <input disabled type="text" name="conta_bancaria_digito_agencia" value="<?= $conta_bancaria_digito_agencia ?>" class="form-control">
                    </div>
                </div>
                                            
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">C/C</label>
                        <input disabled type="text" name="conta_bancaria_conta" value="<?= $conta_bancaria_conta ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['DVCTi'] ?></label>
                        <input disabled type="text" name="conta_bancaria_digito_conta" value="<?= $conta_bancaria_digito_conta ?>" class="form-control">
                                            </div>
                </div>
            </div>
<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input disabled type="checkbox" name="conta_bancaria_status" value="1" <?= ($conta_bancaria_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
        header('Location: painel.php?exe=financeiro/caixas_bancos/cadastro_conta_bancaria');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FINANCEIRO_CONTA_BANCARIA ?>
  </div>
</div>
