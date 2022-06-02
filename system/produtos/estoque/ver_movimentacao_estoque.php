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
                                <h4 class="card-title"><?= $texto['VerMOVESTQ'] ?></h4>
                                <p class="card-category"><?= $texto['VerMOVESTQi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".MOVIMENTACAO_MANUAL_ESTOQUE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_estoque_transacoes", "WHERE estoque_transacao_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);

                    if($estoque_transacao_operacao == 0)
                      $tipo = "Entrada";
                    else
                      $tipo = "Saída";
                    ?>
                    <form class="form_movimento_estoque">
                          <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                              <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                          <input disabled type="text" value="<?= $estoque_transacao_descricao ?>"  name="estoque_transacao_descricao" class="form-control">
                                      </div>
                                  </div>
                                  </div>
<div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="bmd-label-floating"><?= $texto['TPMOVM'] ?></label>
                                          <input disabled type="text" value="<?= $tipo ?>"  name="estoque_transacao_operacao" class="form-control">

                                          
                                      </div>
                                  </div>
                                

                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="bmd-label-floating"><?= $texto['DTAMOV'] ?></label>
                                          <input disabled value="<?= date('d/m/Y') ?>" type="text"  value="<?= $estoque_transacao_data ?>"  name="estoque_transacao_data" class="form-control">
                                      </div>
                                  </div>
                                </div>

<div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="bmd-label-floating"><?= $texto['ProdM'] ?></label>
                                            <select disabled value="<?= $FormData['estoque_transacao_produto_id'] ?>" name="estoque_transacao_produto_id" class="form-control" data-style="btn btn-link">
                                                <?php
                                                $Read->ExeRead("sys_produto");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Produto):
                                                        ?>
                                                         <option value="<?= $Produto['produto_id'] ?>" <?php if ($FormData['estoque_transacao_produto_id']  == $Produto['produto_id'] ) { echo "selected";}  ?>  ><?php echo $Produto['produto_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                        </div>
                                      </div>
                                  
                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                          <input  disabled type="text" value="<?= $estoque_transacao_valor ?>"  name="estoque_transacao_valor" class="form-control dinheiro">
                                      </div>
                                  </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['QNT'] ?></label>
                                              <input disabled type="number" value="<?= $estoque_transacao_quantidade ?>" name="estoque_transacao_quantidade" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label disabled class="bmd-label-floating"><?= $texto['USERS'] ?></label>
                                                  <select disabled value="<?= $FormData['estoque_transcao_usuario_id'] ?>" name="estoque_transcao_usuario_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelUSERS'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                         <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['estoque_transcao_usuario_id']  == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
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
                    header('Location: painel.php?exe=produtos/estoque/cadastro_movimentacao_estoque');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= MOVIMENTACAO_MANUAL_ESTOQUE ?>
  </div>
</div>
