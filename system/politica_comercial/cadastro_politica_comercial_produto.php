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
                                <h4 class="card-title"><?= $texto['CadPLTCSSERV'] ?></h4>
                                <p class="card-category"><?= $texto['CadPLTCSSERVi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_COMERCIAL_PRODUTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_politica_comercial_produtos", "WHERE politica_comercial_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_politica_comercial_produto">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
               
                                        <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['Prod'] ?></label>
                                                     <select style="margin-top: -3px" name="politica_comercial_produto_id" value="<?= $politica_comercial_produto_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelPD'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_produto", "WHERE produto_tipo_id = 1"
                                                           // "WHERE produto_status = :st", "st=0 "
                                                        );
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Produto):
                                                                ?>
                                                                 <option value="<?= $Produto['produto_id'] ?>" <?= ($Produto['produto_id'] == $FormData['politica_comercial_produto_id'] ? 'selected="selected"' : ''); ?>><?= $Produto['produto_nome'] ?></option>
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
                                                    <input type="text" name="politica_comercial_valor" value="<?=number_format($politica_comercial_valor, 2, ',', '.') ?>" class="form-control dinheiro">
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_inicio"
                                                    value="<?= date('d/m/Y', strtotime($politica_comercial_data_inicio)) ?>" class="form-control formDate">
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_final"
                                                    value="<?= date('d/m/Y', strtotime($politica_comercial_data_final)) ?>" class="form-control formDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="PoliticaProdutoEditar"/>
                                    <input type="hidden" name="politica_comercial_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='politica_comercial/PoliticaProduto' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, voc?? tentou editar um usu??rio que n??o existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=politica_comercial/filtro_politica_comercial_produto');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_COMERCIAL_PRODUTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_politica_comercial_produto">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['Prod'] ?></label>
                                                     <select style="margin-top: -3px" name="politica_comercial_produto_id" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelPD'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_produto", "WHERE produto_tipo_id = 1"
                                                           // "WHERE produto_status = :st", "st=0 "
                                                        );
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Produto):
                                                                ?>
                                                                <option value="<?= $Produto['produto_id'] ?>"><?= $Produto['produto_nome'] ?></option>
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
                                                    <input type="text" name="politica_comercial_valor" class="form-control dinheiro">
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_inicio" class="form-control formDate">
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" name="politica_comercial_data_final" class="form-control formDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>         
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="PoliticaProdutoAdd"/>
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
        ID FUNCIONALIDADE: <?= POLITICA_COMERCIAL_PRODUTO ?>
    </div>
</div>
