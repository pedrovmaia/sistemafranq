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
                                <h4 class="card-title">VER CONTRATO</h4>
                                <p class="card-category">Exibição de contrato</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".DOCUMENTOS_CONTRATO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_contratos", "WHERE contrato_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);
                    ?>
                     <form class="form_contrato">
                          <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                              <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="bmd-label-floating">NOME</label>
                                          <input  disabled type="text" name="contrato_nome" value="<?= $contrato_nome ?>" class="form-control">
                                      </div>
                                  </div>





                                  <div class="col-md-12">
                                   <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                                <label  class="bmd-label-floating"><?= $texto['ESTDOC'] ?></label>
                                             
                                               <select disabled style="margin-top: -3px" name="contrato_estagio_id" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                   <option value="0"><?= $texto['SelESTAGi'] ?></option>
                                                 
                                                  <?php
                                                  $Read->ExeRead("sys_estagio_contrato", "WHERE estagio_contrato_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Estagios):
                                                          ?>
                                                           <option value="<?= $Estagios['estagio_contrato_id']?>" <?php if ($contrato_estagio_id == $Estagios['estagio_contrato_id']   ) { echo "selected";}  ?>  ><?php echo $Estagios['estagio_contrato_nome']; ?></option>

                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                              </select>

                                             
                                          </div>
                                        </div>


                                        <div class="col-md-6">
                                          <div class="form-group" >
                                                <label class="bmd-label-floating"><?= $texto['MODELDOC'] ?></label>

                                               <select disabled style="margin-top: -3px" name="contrato_modelo_id" class="form-control jsys_situacao" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                  <option value="0"><?= $texto['SelMODEL'] ?></option>
                                                 
                                                  <?php
                                                  $Read->ExeRead("sys_modelo_contrato", "WHERE modelo_contrato_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Modelos):
                                                          ?>

                                                           <option value="<?= $Modelos['modelo_contrato_id']?>" <?php if ($contrato_modelo_id == $Modelos['modelo_contrato_id']   ) { echo "selected";}  ?>  ><?php echo $Modelos['modelo_contrato_nome']; ?></option>

                                                         
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
                                                <label  class="bmd-label-floating"><?= $texto['TPDEDOC'] ?></label>
                                             
                                               <select disabled style="margin-top: -3px" name="contrato_tipo_id" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                   <option value="0">SELECIONE UM TIPO</option>
                                                 
                                                  <?php
                                                  $Read->ExeRead("sys_tipo_contratos", "WHERE tipo_contrato_status = :st", "st=0");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Tipo):
                                                          ?>
                                                           <option value="<?= $Tipo['tipo_contrato_id']?>" <?php if ($contrato_tipo_id == $Tipo['tipo_contrato_id']   ) { echo "selected";}  ?>  ><?php echo $Tipo['tipo_contrato_nome']; ?></option>

                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                              </select>

                                             
                                          </div>
                                        </div>


                                        <div class="col-md-6">
                                          <div class="form-group" >
                                                <label class="bmd-label-floating"><?= $texto['VALDATEDOC'] ?></label>

                                               
                                                <input disabled type="text" name="contrato_data_vencimento" value="<?= $contrato_data_vencimento ?>" class="form-control">

                                             
                                          </div>
                                       </div> 
                                   </div>

                                </div>


            

                                  
                                  <div class="col-md-12">
                                      <div class="form-group">

                                          <input disabled type="checkbox" name="contrato_status" value="1" <?= ($contrato_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
                    header('Location: painel.php?exe=documentos/cadastro_contrato');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= DOCUMENTOS_CONTRATO ?>
  </div>
</div>
