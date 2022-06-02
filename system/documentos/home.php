<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_GESTAO_CONTRATOS);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['GESTCD'] ?></h4>
                    <p class="card-category"><?= $texto['ADMCDM'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_CONTRATO_CONTRATOS_DOCUMENTOS);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=documentos/filtro_contrato"><?= $texto['CEDMS'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=documentos/filtro_contrato"><?= $texto['GECDMS'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                                   <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_CONTRATO_TIPOS_DOCUMENTOS);
                    if($Read->getResult()){
                    ?>



                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=documentos/filtro_tipo_contratos"><?= $texto['TPSDCMS'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=documentos/filtro_tipo_contratos"><?= $texto['GEDMS'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                   <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_CONTRATO_ESTAGIOS_CONTRATO);
                    if($Read->getResult()){
                    ?>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=documentos/filtro_estagio_contrato"><?= $texto['ESTCONT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=documentos/filtro_estagio_contrato"><?= $texto['GEESTCONT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                   <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_GESTAO_CONTRATO_MODELOS_CONTRATO);
                    if($Read->getResult()){
                    ?>

                            
                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=documentos/filtro_modelo_contrato"><?= $texto['MODELCONT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=documentos/filtro_modelo_contrato"><?= $texto['GEMCNT'] ?></a>
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