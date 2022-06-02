<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_RH);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['COLABS'] ?></h4>
                    <p class="card-category"><?= $texto['ADMCOLABS'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_COLABORADOR_FUNCIONARIO);
                    if($Read->getResult()){
                    ?>
                         
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=rh/colaborador/filtro_colaborador"><?= $texto['FNC'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=rh/colaborador/filtro_colaborador"><?= $texto['GereCOLABS'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_COLABORADOR_CARGO);
                    if($Read->getResult()){
                    ?>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=rh/colaborador/filtro_cargo"><?= $texto['CRGi'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=rh/colaborador/filtro_cargo"><?= $texto['GereCRGS'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>       
                                                                                        <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_COLABORADOR_TIPO_TESTE);
                    if($Read->getResult()){
                    ?>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=rh/filtro_tipo_teste_pessoa"><?= $texto['TPDTSTE'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=rh/colaborador/filtro_tipo_teste_pessoa"><?= $texto['GereTPDTSTE'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTAS_RECEBER_TITULOS_RECEBER);
                    if($Read->getResult()){
                    ?>



                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=rh/relacao_coordenador_professor"><?= $texto['RelCORDPROF'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=rh/relacao_coordenador_professor"><?= $texto['GRE'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTAS_RECEBER_TITULOS_RECEBER);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=rh/relacao_gerente_consultor"><?= $texto['RelGECON'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=rh/relacao_gerente_consultor"><?= $texto['GRE'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTAS_RECEBER_TITULOS_RECEBER);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=rh/relacao_gerente_campo_consultor_campo"><?= $texto['RelGCCC'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=rh/relacao_gerente_consultor"><?= $texto['GRE'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CONTAS_RECEBER_TITULOS_RECEBER);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <p class="card-category" ><a href="<?= BASE ?>/painel.php?exe=rh/filtro_tipo_historico_funcionario"><?= $texto['TPHISTFUNC'] ?></a></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">trending_up</i>   <a href="<?= BASE ?>/painel.php?exe=rh/filtro_tipo_historico_funcionario"><?= $texto['GereTPHIST'] ?></a>
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