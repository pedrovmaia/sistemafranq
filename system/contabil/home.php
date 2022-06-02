<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CONTABIL);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">

    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['RATPLAN'] ?></h4>
                    <p class="card-category"><?= $texto['ADMPLANCT'] ?></p>
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
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_rateio_matricula"><?= $texto['RATMATR'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=parametrizacao/cadastro_rateio_matricula"><?= $texto['ADMMATR'] ?></a>
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
                                                <p class="card-category"><strong><a href="#pablo"><?= $texto['RATPEDS'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="#pablo"><?= $texto['ADMPLANPDS'] ?></a>
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
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=contabil/filtro_centro_custo"><?= $texto['CENTCOSTSS'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=contabil/filtro_centro_custo"><?= $texto['ADMRATCENT'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <?php
                                  }
                                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_RATEIO_RELATORIO_CENTRO_CURSO);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=contabil/relatorio_rateio_centro_custo"><?= $texto['RELRAT'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=contabil/relatorio_rateio_centro_custo"><?= $texto['RELRATCENT'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                      <?php
                                  }
                                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_RATEIO_RELATORIO_CENTRO_CURSO);
                                if($Read->getResult()){
                                    ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header card-header-primary card-header-icon">
                                                <div class="card-icon">
                                                    <i class="material-icons">list_alt</i>
                                                </div>
                                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=contabil/filtro_conta_contabil"><?= $texto['CXC'] ?></a></strong></p>

                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">person</i>
                                                    <a href="<?= BASE ?>/painel.php?exe=contabil/filtro_conta_contabil"><?= $texto['ADMCCBTS'] ?></a>
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