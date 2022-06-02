<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PRODUTOS);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['MenSPOi'] ?></h4>
                    <p class="card-category"><?= $texto['ADMSPROD'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PRODUTOS_PRODUTOS);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=produtos/produto/filtro_produto"><?= $texto['MenSPOi'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=produtos/tipo/filtro_produto"><?= $texto['GEREPROD'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PRODUTOS_TIPO_PRODUTO);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=produtos/tipo/filtro_tipo_produto"><?= $texto['TPDEPROD'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=produtos/tipo/filtro_tipo_produto"><?= $texto['GERETPDEPROD'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PRODUTOS_MOVIMENTACAO_MANUAL);
                    if($Read->getResult()){
                    ?>


                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=produtos/estoque/filtro_movimentacao_estoque"><?= $texto['MOVMANUEST'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=produtos/estoque/filtro_movimentacao_estoque"><?= $texto['ENTRESAID'] ?></a>
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