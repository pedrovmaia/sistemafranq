<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PARAMETRIZACAO);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['GERENC'] ?></h4>
                    <p class="card-category"><?= $texto['ADMINF'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_ESCOLAS);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_sys_escola"><?= $texto['CADESC'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_sys_escola"><?= $texto['GEREESC'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_RECESSO);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_recesso"><?= $texto['RECCES'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_recesso"><?= $texto['GEREREC'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_FERIADO_MUNICIPAL);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_feriado_municipal"><?= $texto['HLMUNI'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_feriado_municipal"><?= $texto['GEREHLMUNI'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                              <?php
                                }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_OPERADORES_FINANCEIRO);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_operadores_financeiro"><?= $texto['OPFINANC'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_operadores_financeiro"><?= $texto['GEREOPFINANC'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                              <?php
                                }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PARAMETRIZACAO_ATIVIDADE_EXTRA);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_atividade_extra">ATIVIDADES EXTRA CURRICULARES</a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/filtro_atividade_extra">Atividades extra curriculares</a>
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

    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['RATPLAN'] ?></h4>
                    <p class="card-category"><?= $texto['ADMRATPLAN'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_RATEIO_MATRICULA);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_rateio_matricula"><?= $texto['RATMAT'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_rateio_matricula"><?= $texto['GERERATMAT'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GERENCIAMENTO_RATEIO_PEDIDO);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="#pablo"><?= $texto['RATPED'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="#pablo"><?= $texto['GERERATPED'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                          <?php
                                }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PARAMETRIZACAO_MATRICULA);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_parametrizacao_matricula"><?= $texto['PRMMAT'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_parametrizacao_matricula"><?= $texto['GEREPRMMAT'] ?></a>
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
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_parametrizacao_sistema"><?= $texto['PRMSIS'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_parametrizacao_sistema"><?= $texto['GEREPRMSIS'] ?></a>
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