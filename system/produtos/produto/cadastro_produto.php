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
                                <h4 class="card-title"><?= $texto['CadPRODS'] ?>S</h4>
                                <p class="card-category"><?= $texto['CadPRODSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                      $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                      if ($Id):
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PRODUTOS_PRODUTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_produto" action="" method="post" enctype="multipart/form-data" >
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                  <input required type="text" name="produto_nome" value="<?= $produto_nome ?>" class="form-control">
                                              </div>
                                          </div>

 
                                         <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['TPDEPROD'] ?></label>
                                                  
                                                  


                                                   <select required style="margin-top: -3px" name="produto_categoria_id"  class="form-control" value="<?= $produto_categoria_id ?>"  >


                                                    <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                                    <?php
                                                      $Read->ExeRead("sys_tipo_produto");
                                                      if ($Read->getResult()):
                                                          foreach ($Read->getResult() as $Tipos):
                                                              ?>
                                                             
                                                               

                                                                 <option value="<?= $Tipos['tipo_produto_id'] ?>" <?php if ($produto_categoria_id == $Tipos['tipo_produto_id'] ) { echo "selected";}  ?>  ><?php echo $Tipos['tipo_produto_nome']; ?></option>


                                                          <?php
                                                          endforeach;
                                                      endif;
                                                      ?>
                                                  </select>

                                              </div>
                                          </div>


                                           <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['VALCST'] ?></label>
                                                  <input type="text"  value="<?= $produto_valor_custo ?>" name="produto_valor_custo" class="form-control dinheiro">
                                              </div>
                                          </div>

                                   
                                           <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating"><?= $texto['VALVNDS'] ?></label>
                                                  <input required type="text" value="<?= $produto_valor_venda ?>" name="produto_valor_venda" class="form-control dinheiro">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">CAPA</label>
                                                  <input name="produto_capa" type="file" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-12">
                                              <div class="form-group">

                                                  <input type="checkbox" name="produto_status" value="1" <?= ($produto_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                              </div>
                                          </div>
                                      </div>
                                      <br/>
                                  </div>
                                  <br/>
                                  <input type="hidden" name="action" value="ProdutoEditar"/>
                                  <input type="hidden" name="produto_id" value="<?= $Id; ?>"/>
                                  <input type="hidden" name="produto_tipo_id" value="1"/>
                                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                  <?php
                                  if($permissao["deletar"] == 1) {
                                      ?>
                                      <span rel='single_user_addr' callback='produto/Produto' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                      <?php
                                  }
                                  ?>
                                  <div class="clearfix"></div>
                              </form>
                              <?php
                          else:
                              $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                              header('Location: painel.php?exe=produtos/produto/cadastro_produto');
                              exit;
                          endif;
                      else:
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PRODUTOS_PRODUTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["inserir"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                          ?>
                        <form class="form_produto" action="" method="post" enctype="multipart/form-data" >
                            <div id="informacoes_basicas" class="border border-secondary" style="padding: 15px;">
                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                            <input required type="text" name="produto_nome" class="form-control">
                                        </div>
                                    </div>


                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['TPDEPROD'] ?></label>
                                            
                                            <select required style="margin-top: -3px" name="produto_categoria_id"  class="form-control" >
                                              <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                              <?php
                                                $Read->ExeRead("sys_tipo_produto");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Tipos):
                                                        ?>
                                                       
                                                           <option value="<?= $Tipos['tipo_produto_id'] ?>"><?= $Tipos['tipo_produto_nome'] ?></option>


                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['VALCST'] ?></label>
                                            <input type="text" name="produto_valor_custo" class="form-control dinheiro">
                                        </div>
                                    </div>

                             
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['VALVNDS'] ?></label>
                                            <input required type="text" name="produto_valor_venda" class="form-control dinheiro">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CAPA</label>
                                            <input name="produto_capa" type="file" class="form-control">
                                        </div>
                                    </div>
                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="produto_status" value="1" ><?= $texto['InaC'] ?></label>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                            </div>
                            <br/>
                            <input type="hidden" name="action" value="ProdutoAdd"/>
                            <input type="hidden" name="produto_tipo_id" value="1"/>
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
      ID FUNCIONALIDADE: <?= PRODUTOS_PRODUTO ?>
  </div>
</div>
