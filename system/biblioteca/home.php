<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_BIBLIOTECA);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $Texto['BIBLOT'] ?></h4>
                    <p class="card-category"><?= $Texto['ADMBIBLOT'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_BIBLIOTECA_EMPRESTIMO_ACERVO);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_emprestimo_acervo"><?= $Texto['EMPREACV'] ?></a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_emprestimo_acervo"><?= $Texto['ADMEMPREACV'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_BIBLIOTECA_ACERVO);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_acervo"><?= $Texto['ACRV'] ?></a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_acervo"><?= $Texto['ADMACRV'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_BIBLIOTECA_CLASSIFICACAO_LITERARIA);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_classificacao_literaria"><?= $Texto['CLASLIT'] ?></a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_classificacao_literaria"><?= $Texto['ADMCLASLIT'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_BIBLIOTECA_EDITORA);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_editora"><?= $Texto['EDITRA'] ?></a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_editora"><?= $Texto['ADMEDITRA'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                                                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_BIBLIOTECA_TIPOS_OBRAS);
                    if($Read->getResult()){
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_tipo_obra"><?= $Texto['TPOBRAS'] ?></a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=biblioteca/filtro_tipo_obra"><?= $Texto['ADMTPOBRAS'] ?></a>
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



