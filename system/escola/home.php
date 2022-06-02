<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_ESCOLA);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= $texto['GMA'] ?></h4>
        <p class="card-category"><?= $texto['AAS'] ?></p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                                              <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_MATRICULA_ALUNOS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_alunos"><?= $texto['GDA'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_alunos"><?= $texto['GSA'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!--
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">book</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=escola/matricula/efetuar_matricula">REALIZAR MATRÍCULA POR PROPOSTA</a></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="<?= BASE ?>/painel.php?exe=escola/matricula/efetuar_matricula">controle de matrículas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_MATRICULA_MATRICULA);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">book</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/cadastro_pedido"><?= $texto['RM'] ?></a></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/cadastro_pedido"><?= $texto['CDM'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">book</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/filtro_pedido"><?= $texto['VM'] ?></a></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/filtro_pedido"><?= $texto['CDM'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">book</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/filtro_orcamento"><?= $texto['SeeORC'] ?></a></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/filtro_orcamento"><?= $texto['ControlORC'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">attach_money</i>
                                </div>
                                <p class="card-category" ><a href="#pablo"><?= $texto['RCB'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="#pablo"><?= $texto['CDR'] ?></a>
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
        <h4 class="card-title"><?= $texto['CDT'] ?></h4>
        <p class="card-category"><?= $texto['ATP'] ?></p>
    </div>
    <div class="card-body">

        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                         <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_SALAS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_salas"><?= $texto['SLS'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>
                                    <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_salas"><?= $texto['GSS'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_TURMAS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_turma"><?= $texto['TMAS'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_turma"><?= $texto['GAT'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_LISTA_ESPERA);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_lista_espera"><?= $texto['LDE'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_lista_espera"><?= $texto['GLP'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
                    }
                    ?>

                    
                </div>

            </div>



            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                         <?php 
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_CALENDARIO_MENSAL);
                    if($Read->getResult()){
                    ?>
                        <!--<div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">today</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/calendario_mensal"><?= $texto['CLM'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>
                                        <a href="<?= BASE ?>/painel.php?exe=escola/turma/calendario_mensal"><?= $texto['CMDT'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                         <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_LISTA_ASSINATURA);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">toc</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/lista_assinaturas"><?= $texto['LDA'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/lista_assinaturas"><?= $texto['GLA'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_DIARIO_CLASSE);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">folder_open</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/diario_classe"><?= $texto['DDC'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/diario_classe"><?= $texto['ADC'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_LISTA_CHAMADA);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">folder_open</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/lista_chamada"><?= $texto['LDC'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/lista_chamada"><?= $texto['VLDC'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_MAPA_HORARIO);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">event_note</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/mapa_horarios"><?= $texto['MDH'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/mapa_horarios"><?= $texto['AOM'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_PLANEJAMENTO);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">wb_incandescent</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/planejamento"><?= $texto['PLJ'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/planejamento"><?= $texto['PDT'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_ACOMPANHAMENTO_AULA);
                    if($Read->getResult()){
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">wb_incandescent</i>
                                    </div>
                                    <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/acompanhamento_aula"><?= $texto['ADA'] ?></a></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/acompanhamento_aula"><?= $texto['ADAE'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTROLE_TURMA_TRANSFERENCIA_ENVOLVIDOS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_transferencia_envolvidos"><?= $texto['TRNSALNN'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_transferencia_envolvidos"><?= $texto['LISTTRAALN'] ?></a>
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

<div class="container-fluid" style="margin-top: 30px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?= $texto['ADAV'] ?></h4>
        <p class="card-category"><?= $texto['ADMAVL'] ?></p>
    </div>
    <div class="card-body">

        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_AVALIACOES_AVALIACOES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/avaliacao/filtro_avaliacoes"><?= $texto['AVAL'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/bavaliacao/filtro_avaliacoes"><?= $texto['GASV'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_AVALIACOES_TIPO_AVALIACOES);
                    if($Read->getResult()){
                    ?>
                         <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/avaliacao/filtro_tipo_avaliacao"><?= $texto['TDAVL'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/avaliacao/filtro_tipo_avaliacao"><?= $texto['GOTA'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                     <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_AVALIACOES_TIPO_AVALIACOES);
                    if($Read->getResult()){
                    ?>
                         <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/filtro_exercicio2"><?= $texto['ECC'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/filtro_exercicio2"><?= $texto['GOX'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                      <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_AVALIACOES_TIPO_AVALIACOES);
                    if($Read->getResult()){
                    ?>
                         <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">supervisor_account</i>
                                </div>
                                <p class="card-category"><a href="<?= BASE ?>/painel.php?exe=escola/filtro_homework2"><?= $texto['HW'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/filtro_homework2"><?= $texto['GHW'] ?></a>
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
        <h4 class="card-title"><?= $texto['ADE'] ?></h4>
        <p class="card-category"><?= $texto['ASE'] ?></p>
    </div>
    <div class="card-body">


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_ESCOLA_GERENCIAMENTO_CURSO);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_curso"><?= $texto['GDCS'] ?></a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_curso"><?= $texto['GSSC'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_ESCOLA_PROFESSORES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">attach_money</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_professor"><?= $texto['PRFS'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_professor"><?= $texto['GRFS'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ADM_ESCOLA_HAB_PROFESSOR_MATERIA);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=escola/admin/habilitacao_professor_materia"><?= $texto['HPA'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=escola/admin/habilitacao_professor_materia"><?= $texto['GRE'] ?></a>
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