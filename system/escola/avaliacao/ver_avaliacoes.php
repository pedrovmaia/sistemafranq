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
                                <h4 class="card-title"><?= $texto['VerAVAL'] ?></h4>
                                <p class="card-category"><?= $texto['VerAVALi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_AVALIACOES."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_avaliacoes">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                    <div class="col-md-12">
                                                 <div class="row">
                                                                 <div class="col-md-6">
                                                        <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                    <input disabled type="text" name="avaliacao_nome" value="<?= $avaliacao_nome ?>"  class="form-control">
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                                        <div class="form-group">

                                                    <label class="bmd-label-floating"><?= $texto['CODi'] ?></label>
                                                    <input disabled type="text" name="avaliacao_codigo" value="<?= $avaliacao_codigo ?>"  class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                                    <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['ESTAGi'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="estagio_id"  class="form-control jsys_etapa_produto" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value=""><?= $texto['SelESTAGi'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Estagio):
                                                                ?>
                                                                <option value="<?= $Estagio['estagio_produto_id'] ?>" <?= ($Estagio['estagio_produto_id'] == $FormData['estagio_id'] ? 'selected="selected"' : ''); ?>><?= $Estagio['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    </div>

                                      </div>

                                       <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['ETAPi'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="avaliacao_etapa_id" value="<?= $avaliacao_etapa_id ?>"   class="form-control jsys_etapa_produto" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value=""><?= $texto['SelETAPi'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_etapa_produto", "WHERE etapa_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $EtapaProduto):
                                                                ?>
                                                                <option value="<?= $EtapaProduto['etapa_produto_id'] ?>" <?= ($EtapaProduto['etapa_produto_id'] == $FormData['avaliacao_etapa_id'] ? 'selected="selected"' : ''); ?>><?= $EtapaProduto['etapa_produto_nome'] ?></option>
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
                                        <div class="row">
                                      <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TPAVALi'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="avaliacao_tipo_avaliacao_id" value="<?= $avaliacao_tipo_avaliacao_id ?>"  class="form-control jsys_tipo_avaliacao" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value=""><?= $texto['SelTPAVALi'] ?></option>         
                                                        <?php
                                                        $Read->ExeRead("sys_tipos_avaliacao", "WHERE tipo_avaliacao_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoAvaliacao):
                                                                ?>
                                                            <option value="<?= $TipoAvaliacao['tipo_avaliacao_id'] ?>" <?= ($TipoAvaliacao['tipo_avaliacao_id'] == $FormData['avaliacao_tipo_avaliacao_id'] ? 'selected="selected"' : ''); ?>><?= $TipoAvaliacao['tipo_avaliacao_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    </div>
                                      </div>                                       
                                             <div class="col-md-6">
                                         <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['FORMi'] ?></label>
                                                    <input disabled type="text" name="avaliacao_formula" value="<?= $avaliacao_formula ?>"   class="form-control">
                                         </div>
                                     </div> 
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TPNOTAi'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="avaliacao_tipo_nota_id" value="<?= $avaliacao_tipo_nota_id ?>"  class="form-control jsys_formulacao_nota" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTPNOTAi'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_formulacao_nota");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoNota):
                                                                ?>
                                                                 <option value="<?= $TipoNota['formulacao_nota_id'] ?>" <?= ($TipoNota['formulacao_nota_id'] == $FormData['avaliacao_tipo_nota_id'] ? 'selected="selected"' : ''); ?>><?= $TipoNota['formulacao_nota_nome'] ?></option>

                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                      <input disabled type="checkbox" name="avaliacao_status" value="1" <?= ($avaliacao_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                  </div>
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
        header('Location: painel.php?exe=escola/avaliacao/cadastro_avaliacoes');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_AVALIACOES ?>
  </div>
</div>
