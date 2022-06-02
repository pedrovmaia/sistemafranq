<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_FRANQUEADOR);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"> <?= $texto['franqAdm'] ?></h4>
                    <p class="card-category"><?= $texto['gerefranq'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                         
                          <?php
                                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_FRANQUIAS_COORDENADORIA);
                    if($Read->getResult()){
                    ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_coordenadorias">COORDENADORIA</a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_coordenadorias">Gerenciamento de coordenadorias</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                    }
                                $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_FRANQUIAS_GRUPOS_MARKETING);
                    if($Read->getResult()){
                    ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_marketing"><?= $texto['grupomrkt'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_marketing"><?= $texto['GereGrupoMrkt'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php
                    }

                 $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_FRANQUIAS_GRUPOS_ECONOMICO);
                            if($Read->getResult()){
                            ?>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_economicos"><?= $texto['grupoeco'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_economicos"><?= $texto['gereGrupoEco'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_FRANQUIAS_GRUPOS_PEDAGOGICO);
                            if($Read->getResult()){
                            ?> 
                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_pedagogicos"><?= $texto['grupoPedag'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_grupos_pedagogicos"><?= $texto['GereGrupoPedag'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                    }
                              $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_FRANQUIAS_FRANQUIA);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_franquia"><?= $texto['Franq'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_franquia">
                                                    <?= $texto['GereFranq'] ?></a>
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
                    <h4 class="card-title"><?= $texto['Domi'] ?></h4>
                    <p class="card-category"><?= $texto['AdmDomi'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                 <?php
                              $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_ATIVIDADE_EXTRA_PROFESSOR);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_extra_professor"><?= $texto['AtvExPro'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_extra_professor"><?= $texto['GereAtvPro'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
           <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_FUNCOES);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_funcoes"><?php echo $texto['funcao'];?></p></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_funcoes">
                                                    <?= $texto['GereFunc'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_GRAU_ESCOLARIDADE);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_grau_escolaridade"><?= $texto['GrausEsc'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_grau_escolaridade"><?= $texto['GereGrausEsc'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_GRAU_PARENTESCO);
                            if($Read->getResult()){
                            ?> 


                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_grau_parentesco"><?= $texto['GrausPar'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_grau_parentesco"><?= $texto['GereGrausPar'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_INT_TIPO_CONTRATO);
                            if($Read->getResult()){
                            ?> 

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_int_tipo_contrato"><?= $texto['IntCont'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_int_tipo_contrato"><?= $texto['GereIntCont'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MODALIDADES);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_modalidades"><?= $texto['Modal']?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_modalides">
                                                    <?= $texto['GereModel'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_CANCELAMENTO);
                            if($Read->getResult()){
                            ?> 

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivos_cancelamento"><?= $texto['MotCanc'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivos_cancelamento"><?= $texto['GereMotCanc'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_DESISTENCIA);
                            if($Read->getResult()){
                            ?> 
                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivos_desistencias"><?= $texto['MotDes'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivos_desistencias"><?= $texto['GereMotDes'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_NAO_FECHAMENTO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_nao_fechamento"><?= $texto['MotFec'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_nao_fechamento"><?= $texto['GereMotFec'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVO_REAT_VENDA);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_reat_venda"><?= $texto['MotReV'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_reat_venda"><?= $texto['GereMotReV'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_TRANC_MATRICULA);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_tranc_matricula"><?= $texto['MotTranc'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_tranc_matricula"><?= $texto['GereMotTranc'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_TRANSFERENCIA);
                            if($Read->getResult()){
                            ?> 
                              
                               <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_transferencia"><?= $texto['MotTrf'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_transferencia"><?= $texto['GereMotTrf'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_OCUPACOES);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_ocupacoes"><?= $texto['Ocup'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_ocupacoes">
                                                    <?= $texto['GereOcup'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_OPERADORAS_CELULAR);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_operadoras_celular"><?= $texto['OpeCel'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_operadoras_celular"><?= $texto['GereOpeCel'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_ORIGENS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_origem"><?= $texto['Orig'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_origem">
                                                    <?= $texto['GereOrig'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_AUTORES);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_autor"><?= $texto['Autr'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_autor">
                                                    <?= $texto['GereAutr'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_IDIOMAS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_idioma"><?= $texto['Idio'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_idioma">
                                                    <?= $texto['GereIdio'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PERIODOS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_periodo"><?= $texto['Per'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_periodo">
                                                    <?= $texto['GerePer'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PROMOCOES);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_promocoes"><?= $texto['Promo'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_promocoes">
                                                    <?= $texto['GerePromo'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_SEGMENTOS);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_segmento"><?= $texto['Seg'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_segmento">
                                                    <?= $texto['GereSeg'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPO_ACRESCIMO_ABATIMENTO);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_acrescimo_abatimento"><?= $texto['TAPA'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_acrescimo_abatimento"><?= $texto['GereTAPA'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPO_CARTA_COBRANCA);
                            if($Read->getResult()){
                            ?> 

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_carta_cobranca"><?= $texto['TCC'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_carta_cobranca"><?= $texto['GereTCC'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPO_CARTA_QUITACAO);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_carta_quitacao"><?= $texto['TCQ'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_carta_quitacao"><?= $texto['GereTCQ'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPOS_DESCONTOS);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_desconto"><?= $texto['TDD'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_desconto">
                                                    <?= $texto['GereTDD'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPOS_FRANQUIAS);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_franquia"><?= $texto['TipFr'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_franquia">
                                                    <?= $texto['GereTipFr'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_ESTAGIO_TURMAS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_estagio_projeto"><?= $texto['EstT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_estagio_projeto"><?= $texto['GereEstT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPO_ALUNOS_TURMA);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_envolvido_projeto"><?= $texto['TipAT'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_envolvido_projeto"><?= $texto['GereTipAT'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_CONVENIO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_convenio"><?= $texto['Conv'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_convenio">
                                                    <?= $texto['GereConv'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPOS_TELEFONE);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_telefone"><?= $texto['TipTel'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipo_telefone">
                                                    <?= $texto['GereTipTel'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_EMPRESAS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_empresas"><?= $texto['Emp'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_empresas">
                                                    <?= $texto['GereEmp'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_UNIDADES);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_unidades"><?= $texto['Uni'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_unidades">
                                                    <?= $texto['GereUni'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_FORMULACAO_NOTA);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_formulacao_nota"><?= $texto['FormN'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_formulacao_nota"><?= $texto['GereFormN'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_FERIADOS);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_feriado"><?= $texto['Fer'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_feriado">
                                                    <?= $texto['GereFer'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MENSAGEM_BOLETIM);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_mensagens"><?= $texto['MenB'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_mensagens">
                                                    <?= $texto['GereMB'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_FORMA_PAGAMENTO);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_forma_pagamento"><?= $texto['FormP'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_forma_pagamento"><?= $texto['GereFormP'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PLANO_CONTA);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_plano_contas"><?= $texto['PlanC'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_plano_contas">
                                                    <?= $texto['GerePlanC'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_TIPO_DOCUMENTO_LIQUIDACAO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipos_doc_liquidacao"><?= $texto['TDL'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_tipos_doc_liquidacao"><?= $texto['GereTDL'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PRECO_PRODUTOS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">domain</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_preco_produto"><?= $texto['PrePrd'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_preco_produto">
                                                    <?= $texto['GerePrePrd'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_ANO_LETIVO);
                            if($Read->getResult()){
                            ?> 

                                                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_ano_letivo"><?= $texto['AnLet'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_ano_letivo">
                                                    <?= $texto['GereAnLet'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PERIODO_LETIVO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_periodo_letivo"><?= $texto['PerLet'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_periodo_letivo">
                                                    <?= $texto['GerePerLet'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_PERIODO_LETIVO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_niveis_empresa"><?= $texto['NvEmp'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_niveis_empresa">
                                                    <?= $texto['GereNvEmp'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_ESTORNO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_estorno"><?= $texto['MotEst'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_estorno">
                                                    <?= $texto['GereMotEst'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_DOMINIOS_MOTIVOS_ALTERAR_VENCIMENTO);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_alterar_vencimento"><?= $texto['MADV'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/dominios/filtro_motivo_alterar_vencimento"><?= $texto['GereMADV'] ?></a>
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
                    <h4 class="card-title"><?= $texto['Locali'] ?></h4>
                    <p class="card-category"><?= $texto['AdmLocal'] ?></p>
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOCALIZACAO_PAISES);
                            if($Read->getResult()){
                            ?> 

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_paises"><?= $texto['Pase'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_paises">
                                                    <?= $texto['GerePase'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOCALIZACAO_ESTADOS);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_estados"><?= $texto['Estad'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_estados">
                                                    <?= $texto['GereEstad'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php
                    }
                     $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_LOCALIZACAO_CIDADES);
                            if($Read->getResult()){
                            ?> 
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_cidades"><?= $texto['Cids'] ?></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">domain</i>
                                                <a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_cidades">
                                                    <?= $texto['GereCids'] ?></a>
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