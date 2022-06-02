<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_ALERTAS_PENDENCIAS);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"><?= $texto['ALERTS'] ?></h4>
                    <p class="card-category"><?= $texto['ADMALERTS'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
<?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ALERTAS_ALUNOS_SEM_TURMA);
                    if($Read->getResult()){
                    ?>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">notifications_active</i>
                                            </div>
                                            <p class="card-category"><strong><a href="painel.php?exe=escola/turma/filtro_lista_espera"><?= $texto['ALNSSEMTRM'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="painel.php?exe=escola/turma/filtro_lista_espera"><?= $texto['GereALNSSEMTRM'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                           <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ALERTAS_PLANEJAMENTO_DESAT);
                    if($Read->getResult()){
                    ?>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">notifications_active</i>
                                            </div>
                                            <p class="card-category"><strong><a href="#pablo"><?= $texto['PLANDES'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="#pablo"><?= $texto['ALERTPLANDES'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                           <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ALERTAS_TURMAS_INICIAR);
                    if($Read->getResult()){
                    ?>



                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">notifications_active</i>
                                            </div>
                                            <p class="card-category"><strong><a href="painel.php?exe=escola/turma/filtro_turmas_iniciar"><?= $texto['TRMSINI'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="painel.php?exe=escola/turma/filtro_turmas_iniciar"><?= $texto['GereTRMSINI'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                           <?php
                    }
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_ALERTAS_TURMAS_TERMINAR);
                    if($Read->getResult()){
                    ?>



                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">notifications_active</i>
                                            </div>
                                            <p class="card-category"><strong><a href="#pablo"><?= $texto['TRMSTERM'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="#pablo"><?= $texto['GereTMSTERM'] ?></a>
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