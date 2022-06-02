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
                                    <h4 class="card-title">Ver titulos receber</h4>
                                    <p class="card-category">Exibição de títulos a receber</p>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_TITULOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["alterar"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                            $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                               $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);

                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$FormData['mov_recebimento_pessoa_id']}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                die;
                            endif;

                           /* $Read->ExeRead("sys_transacao_rateio", "WHERE rateio_conta_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Rateio = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                $Rateio = "";
                            endif;*/
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
                                         INFORMAÇÕES PRINCIPAIS
                                        <div class="ripple-container"></div>
                                    </a>
                                            </li>

                                              <li class="nav-item">
                                                <a class="nav-link" href="#spc" data-toggle="tab">
                                        ENVIO AO SPC
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


                                        <form class="form_movimentacao_recebimento">
                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">ID</label>
                                                            <input disabled autocomplete="off" type="text" name="mov_recebimento_id"  value="<?= $FormData['mov_recebimento_id'] ?>"  class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">DATA DE EMISSÃO</label>
                                                            <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_recebimento_emissao'])) ?>"  name="mov_recebimento_emissao" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['CLAL'] ?></label>
                                                            <input disabled type="text" value="<?= $Pessoa['pessoa_nome'] ?>"  name="mov_recebimento_pessoa_id" class="form-control">
                                                        </div>
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    
                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">DATA DE VENCIMENTO</label>
                                                            <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_recebimento_data_vencimento']))    ?>"  name="mov_recebimento_data_vencimento" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">DATA DE RECEBIMENTO</label>
                                                            <?php
                                                            if(!empty($FormData['mov_recebimento_data_recebimento'])){
                                                                ?>
                                                                <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_recebimento_data_recebimento'])) ?>"  name="mov_recebimento_data_recebimento" class="form-control">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input disabled type="text" value="dd/mm/yyyy"  name="mov_recebimento_data_recebimento" class="form-control">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">PARCELA</label>
                                                            <input disabled type="text" value="<?= $FormData['mov_recebimento_parcela'] ?>"  name="mov_recebimento_parcela" class="form-control">
                                                        </div>
                                                    </div>

                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">VALOR</label>
                                                            <input disabled type="text" value="<?= 'R$ ' . number_format($FormData['mov_recebimento_valor'], 2, ',', '.')    ?>"  name="mov_recebimento_valor" class="form-control">
                                                        </div>
                                                     </div>

                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">NÚMERO</label>
                                                            <input disabled type="text" value="<?= $FormData['mov_recebimento_numero'] ?>"  name="mov_recebimento_numero" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                            </div>


                                            <br/>

                                            <div class="clearfix"></div>
                                        </form>

                                        <div class="tab-pane" id="spc">


                                         <div class="border_shadow" style="padding: 20px">

                                                              <div id="toolbar">
                      <br/>
                      <?php
                      if($permissao["inserir"] == 1) {
                          ?>
                          <a href="<?= BASE ?>/painel.php?exe=contasreceber/cadastro_envio_scpc&idpessoa=<?= $Pessoa['pessoa_id'] ?>&idmov=<?= $FormData['mov_recebimento_id'] ?>" class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                          <?php
                      }
                      ?>
                      <div class="clearfix"></div>
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
                                                        data-url="_ajax/financeiro/ListEnvioScpc.ajax.php?action=list&id=<?= $Pessoa['pessoa_id'] ?>"
                                                        data-pagination="true"
                                                        data-id-field="id"
                                                        data-buttons-class="primary">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="id" data-filter-control="input">ID</th>
                                                        <th data-field="pessoa" data-filter-control="input"><?= $texto['PEOPLE'] ?></th>
                                                        <th data-field="datainclusao" data-filter-control="input">Data Inclusão</th>
                                                        <th data-field="dataretirada" data-filter-control="input">Data Retirada</th>
                                                        <th data-field="observacao" data-filter-control="input"><?= $texto['OBSi'] ?></th>     
                                                        <th data-field="acoes"><?= $texto['Act'] ?></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                                </div>

                                    </div>
                         

                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                                <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=escola/turma/cadastro_sala');
                    exit;
                endif;
            endif;
            ?>
                        </div>
                    </div>
                </div>
            </div>
            ID FUNCIONALIDADE:
            <?= CONTASRECEBER_TITULOS ?>
        </div>
    </div>