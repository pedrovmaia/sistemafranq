<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_FINANCEIRO);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= $texto['FNGFR'] ?></h4>
        <p class="card-category"><?= $texto['FNADM'] ?></p>
    </div>
    <div class="card-body">


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_IMPRESSAO_CARNE);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_matriculas"><?= $texto['FNIC'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo"><?= $texto['FNIMC'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                                                     <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_TRANSACOES_MANUAIS);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_transacao_caixa"><?= $texto['FNTMC'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo"><?= $texto['FNTMCi'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_TITULOS_ATRASO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_titulos_aberto">TÍTULOS EM ABERTO</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_titulos_aberto">Relatórios de titulos em aberto</a>
                                </div>
                            </div>
                        </div>
                    </div>

                                <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_TITULOS_ATRASO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/list_parcelas_recebidas">PARCELAS RECEBIDAS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/list_parcelas_recebidas">Relatórios de parcelas recebidas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_NEGOCIACOES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_motivo_negociacao"><?= $texto['FNMN'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_motivo_negociacao"><?= $texto['FNRMN'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_NEGOCIACOES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_negociacao"><?= $texto['FNN'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_negociacao"><?= $texto['FNRN'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_RECEBIMENTO_DETALHADO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_recebimento_detalhado"><?= $texto['FNRD'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_recebimento_detalhado"><?= $texto['FNRDi'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>


                                 <?php
                    }
                  /*  $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_RECEBIMENTO_SIMPLIFICADO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><a href="#pablo">RECEBIMENTO SIMPLIFICADO</a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="#pablo">Recebimentos simplificado</a>
                                </div>
                            </div>
                        </div>
                    </div>
                                 <?php
                    }*/
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_FINANCEIRA_FORMA_PARCELAMENTO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_forma_parcelamento"><?= $texto['FNFP'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_forma_parcelamento"><?= $texto['FNGFP'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                          <?php
                                }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PARAMETRIZACAO_SISTEMA);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_matriz_perda_desconto">MATRIZ DE DESCONTOS DE PARCELAS</a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_matriz_perda_desconto">Gerenciamento de matriz de descontos de parcelas</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


<?php
                    }
                    ?>




                </div>

            </div>

        </div>


    </div>
</div>
</div>
</div>
</div>


<div class="container-fluid" style="margin-top: 30px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= $texto['FNCB'] ?></h4>
        <p class="card-category"><?= $texto['FNACB'] ?></p>
    </div>
    <div class="card-body">

        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    /*
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_REMESSA);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="#pablo">REMESSA</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="#pablo">Arquivos de remessa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                      <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_RETORNO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="#pablo">RETORNO</a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="#pablo">Importação de arquivo de retorno</a>
                                </div>
                            </div>
                        </div>
                    </div>
                      <?php
                    }*/
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_CONFERIR_CAIXA);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_conferir_caixa"><?= $texto['FNCC'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_conferir_caixa"><?= $texto['FNCCi'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

          
                          <?php
                    /*}
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_CONFIGURAÇÃO_BOLETOS);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">toc</i>
                                    </div>
                                    <p class="card-category"><a href="#pablo">CONFIGURA BOLETO</a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="#pablo">Configuração de boletos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_CREDITO_CLIENTES);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">folder_open</i>
                                    </div>
                                    <p class="card-category"><a href="#pablo">CRÉDITO DE CLIENTES</a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="#pablo">Credito de clientes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                      <?php
                      */
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_LANCAMENTO);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">folder_open</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/list_lancamento_conta"><?= $texto['FNL'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/list_lancamento_conta"><?= $texto['FNLi'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

  <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_TRANSFERIR);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">folder_open</i>
                                    </div>
                                    <p class="card-category"><a href="#pablo"><?= $texto['FNTRS'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="#pablo"><?= $texto['FNTEC'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>


  <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_CONTAS);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_conta_bancaria"><?= $texto['FNCTS'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_conta_bancaria"><?= $texto['FNTECS'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

  <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_INSTITUICAOS_FINANCEIRAS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_instituicao_financeira"><?= $texto['FNCTN'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_instituicao_financeira"><?= $texto['FNGSC'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

  <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_TIPOS_CONTAS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_tipo_conta_bancaria"><?= $texto['FNIF'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/caixas_bancos/filtro_tipo_conta_bancaria"><?= $texto['FNGIF'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
  <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_CONTROLE_CHEQUES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_controle_cheque"><?= $texto['FNCCS'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_controle_cheque"><?= $texto['FNGCCS'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                      <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CAIXA_BANCOS_SITUACAO_CHEQUES);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">event_note</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_situacao_cheque"><?= $texto['FNCCH'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_situacao_cheque"><?= $texto['FNGCCH'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                <?php
                    }
                    ?>


                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="margin-top: 80px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= $texto['FNSDQ'] ?></h4>
        <p class="card-category"><?= $texto['FNGSDQ'] ?></p>
    </div>
    <div class="card-body">


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOG_CANCELAMENTO_PARCELA);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/log_cancelamento_parcela"><?= $texto['FNLDI'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/log_cancelamento_parcela"><?= $texto['FNVLDI'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                                                     <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOG_ESTORNO_PARCELA);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/log_estorno_parcela"><?= $texto['FNLCP'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/log_estorno_parcela"><?= $texto['FNLCDP'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOG_ALTERACAO_VENCIMENTO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=financeiro/log_alteracao_vencimento"><?= $texto['FNLEP'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=financeiro/log_alteracao_vencimento"><?= $texto['FNLEPi'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

<?php
                    }
                    ?>




                </div>

            </div>

        </div>


    </div>
</div>
</div>
</div>
</div>
   <?php
    } else {
        ?>
        <div class="container-fluid" style="margin-top: 80px">
<?php
        die("Acesso restrito");
?>
</div>
        <?php
    }
}
?>