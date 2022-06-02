<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CRM);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['CRM'] ?></h4>
                    <p class="card-category"><?= $texto['ADMCRM'] ?></p>
                </div>
                <div class="card-body">

                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_ATENDIMENTOS);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_atendimentos"><?= $texto['ATNDMS'] ?></a></strong></p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_atendimentos"><?= $texto['VSATDNT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_PROSPECCAO);
                    if($Read->getResult()){
                    ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_prospeccao"><?= $texto['PROSP'] ?></a></strong></p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_prospeccao"><?= $texto['VSPROSP'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_PESSOAS);
                    if($Read->getResult()){
                    ?>
                                   <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_pessoas"><?= $texto['PEOPS'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_pessoas"><?= $texto['VSPEOPS'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                    <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_ORIGEM_INTERESSE);
                    if($Read->getResult()){
                    ?>           

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_origem_interesse"><?= $texto['ORGMINT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_origem_interesse"><?= $texto['VSORGM'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_MOTIVO_INTERESSE);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_motivo_interesse"><?= $texto['MOTINT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_motivo_interesse"><?= $texto['VSMOTINT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_TIPO_ATENDIMENTO);
                    if($Read->getResult()){
                    ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">book</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_tipo_atendimento"><?= $texto['TPATNDT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">book</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_tipo_atendimento"><?= $texto['GEREATNDT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_OCORRENCIAS_NATUREZA);
                    if($Read->getResult()){
                    ?>
                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_ocorrencias_natureza"><?= $texto['OCNAT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_ocorrencias_natureza"><?= $texto['GEREOCNAT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_OCORRENCIAS_TIPO_ACAO);
                    if($Read->getResult()){
                    ?>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_ocorrencias_tipo_acao"><?= $texto['OCTPA'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_ocorrencias_tipo_acao"><?= $texto['GEREOCTPA'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_CRM_OCORRENCIAS_TIPO_ACAO);
                    if($Read->getResult()){
                    ?>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=crm/filtro_patrocinador"><?= $texto['PATROC'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=crm/filtro_patrocinador"><?= $texto['GEREPATROC'] ?></a>
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