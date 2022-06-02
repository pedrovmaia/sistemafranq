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
                                <h4 class="card-title"><?= $texto['VerPRODS'] ?></h4>
                                <p class="card-category"><?= $texto['VerPRODSi'] ?></p>
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
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);

                
                $Read->FullRead("SELECT sum(estoque_transacao_quantidade) as soma FROM sys_estoque_transacoes
                      WHERE estoque_transacao_produto_id = :id", "id={$Id}");
                
                $quantidade_estoque = $Read->getResult()[0]['soma'];


                    ?>

  

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-primary">
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                           
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#profile" data-toggle="tab">
                                                         <?= $texto['INFOP'] ?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#messages" data-toggle="tab">
                                                        <?= $texto['MOVSESTQ'] ?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#settings" data-toggle="tab">
                                                         <?= $texto['MOVVNDS'] ?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">
                                            <form class="form_produto">
                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                                                            <input type="text" disabled name="produto_nome" value="<?= $produto_nome ?>" class="form-control">
                                                        </div>
                                                    </div>


                                                     <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label class="bmd-label-floating"><?= $texto['TPDEPROD'] ?></label>
                                                          
                                                          


                                                           <select style="margin-top: -3px"  disabled name="produto_categoria_id"  class="form-control" value="<?= $produto_categoria_id ?>"  >


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
                                                            <input disabled type="text"  value="<?= $produto_valor_custo ?>" name="produto_valor_custo" class="form-control dinheiro">
                                                        </div>
                                                    </div>

                                             
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['VALVNDS'] ?></label>
                                                            <input disabled type="text" value="<?= $produto_valor_venda ?>" name="produto_valor_venda" class="form-control dinheiro">
                                                        </div>
                                                    </div>





                                                    <div class="col-md-12">
                                                        <div class="form-group">

                                                            <input type="checkbox" disabled name="produto_status" value="1" <?= ($produto_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                            </div>
                                            <br/>
                                            <div class="clearfix"></div>
                                        </form>
                                        </div>
                                        <div class="tab-pane" id="messages">

                                           
      
                                           <div class="border_shadow" style="padding: 20px">

                                           <div class="col-md-4 px-0">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['QNTESTQ'] ?></label>
                                                    <input type="text" disabled name="qtd" value="<?= $quantidade_estoque ?>" class="form-control">
                                                </div>
                                            </div>


                                            <table  class="table table-hover display"
                                                    id="table"
                                                    data-toolbar="#toolbar"
                                                    data-locale="pt-BR"
                                                    data-show-export="true"
                                                    data-filter-control="true"
                                                    data-filter-show-clear="true"
                                                    data-show-toggle="true"
                                                    data-show-fullscreen="true"
                                                    data-show-columns="true"
                                                    data-minimum-count-columns="2"
                                                    data-url="_ajax/estoque/ListMovimentacaoEstoquePorProduto.ajax.php?action=list&produto_id=<?= $Id ?>"
                                                    data-pagination="true"
                                                    data-id-field="id"
                                                    data-buttons-class="primary">
                                                <thead>
                                                <tr>
                                                    <th data-field="id" data-filter-control="input">ID</th>
                                                    <th data-field="nome" data-filter-control="input"><?= $texto['dsc'] ?></th>
                                                    <th data-field="operacao" data-filter-control="input"><?= $texto['OPERATION'] ?></th>
                                                    <th data-field="quantidade" data-filter-control="input"><?= $texto['QNTi'] ?></th>
                                                    <th data-field="acoes"><?= $texto['Act'] ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane" id="settings">
                                           
                                              
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                  

                    
                    <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=produtos/produto/cadastro_produto');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PRODUTOS_PRODUTO ?>
  </div>
</div>
