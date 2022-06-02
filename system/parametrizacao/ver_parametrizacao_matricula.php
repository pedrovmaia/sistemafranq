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
                                <h4 class="card-title">VER PARAMETRIZAÇÃO DA MATRÍCULA</h4>
                                <p class="card-category">Exibição de parametrização</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_parametros", "WHERE parametro_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
         <form class="form_parametrizacao_matricula">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                       <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating"><?= $texto['PAYPA'] ?></label>
                                            <select disabled style="margin-top: -3px" class="form-control" name="parametro_forma_parcelamento_id">
                                                <option value="0"><?= $texto['SelFORM'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Forma):
                                                          ?>
                                                           <option value="<?= $Forma['forma_parcelamento_id'] ?>" <?php if ($FormData['parametro_forma_parcelamento_id'] == $Forma['forma_parcelamento_id'] ) { echo "selected";}  ?>  ><?php echo $Forma['forma_parcelamento_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>

                                            </div>
                                        </div>

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $texto['SDDVC'] ?></label>
                                            <select disabled style="margin-top: -3px" class="form-control" name="parametro_dia_vencimento_id">
                                                <option value="0"><?= $texto['SelDAY'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Dia):
                                                          ?>
                                                          <option value="<?= $Dia['dias_vencimento_id'] ?>" <?php if ($FormData['parametro_dia_vencimento_id'] == $Dia['dias_vencimento_id'] ) { echo "selected";}  ?>  ><?php echo $Dia['dias_vencimento_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
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
        header('Location: painel.php?exe=parametrizacao/cadastro_parametrizacao_matricula');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA ?>
  </div>
</div>
