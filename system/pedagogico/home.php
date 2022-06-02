<?php
$Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PEDAGOGICO);
if($Read->getResult()){
    if($Read->getResult()[0]['permissao'] == 1){
        ?>
<div class="container-fluid" style="margin-top: 80px">
<div class="row">
<div class="col-md-12 ml-auto mr-auto">
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">PORTAIS WEB</h4>
        <p class="card-category">Gerencie, administre suas alunos e suas informações.</p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_FAQ);
                    if($Read->getResult()){
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">weekend</i>
                                    </div>
                                    <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_escola_faq">FAQ</a></strong></p>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">person</i>
                                        <a href="#pablo">Gerencie seus faqs</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_CATEGORIA_DOWNLOADS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_escola_categoria_anexo">CATEGORIAS DE ANEXOS/DOWNLOADS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo">Gerencie as categorias de anexos/downloads</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_CATEGORIA_TREINAMENTOS);
                    if($Read->getResult()){
                    ?>
                     <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_escola_categoria_treinamentos">CATEGORIAS DE TREINAMENTOS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo">Gerencie as categorias de treinamentos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_ORIGEM_MATERIA);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_escola_origem_materia">ORIGEM DE MATÉRIA</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo">Gerencie as origens de matérias</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_TIPOS_PORTAIS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_escola_tipo_portal">TIPOS DE PORTAIS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo">Gerencie os tipos de portais</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_TREINAMENTOS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_treinamentos">TREINAMENTOS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="#pablo">Gerencie os treinamentos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_QUIZZES);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/quiz/filtro_quiz">QUIZZES</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedagogico/quiz/filtro_quiz">Gerencie os quizzes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_DOWNLOADS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_downloads">ANEXOS/DOWNLOADS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_downloads">Gerencie os downloads</a>
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
     <div class="card-header card-header-primary">
        <h4 class="card-title">Livros</h4>
        <p class="card-category">Gerencie, administre seus livros e coleções.</p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_COLECAO_LIVROS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_colecao_livros">COLEÇÃO DE LIVROS</a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_colecao_livros">Gerencie as coleções de livros</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_COLECAO_LIVROS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_livros">LIVROS</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_livros">Gerencie os livros</a>
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

     <div class="card-header card-header-primary">
        <h4 class="card-title">Consultores de Campos</h4>
        <p class="card-category">Gerencie, administre os consultores de campo.</p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_COLECAO_LIVROS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=pedagogico/consultor/filtro_consultor">CONSULTORES DE CAMPO</a></strong></p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=pedagogico/consultor/filtro_consultor">Gerencie os consultores de campo</a>
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


<div class="card-header card-header-primary">
        <h4 class="card-title">Franquias KNN</h4>
        <p class="card-category">Gerencie, administre os as franquias.</p>
    </div>
    <div class="card-body">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_COLECAO_LIVROS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_franquia">FRANQUIA</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">person</i>
                                    <a href="<?= BASE ?>/painel.php?exe=franqueador/franquias/filtro_franquia">Sistema de controle gerencial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }

                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :nivel AND submenu_submenu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . SUBMENU_PORTAISWEB_COLECAO_LIVROS);
                    if($Read->getResult()){
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-primary card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">list_alt</i>
                                </div>
                                <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_escola_franquias">LIBERAÇÃO DE FRANQUIA NO PORTAL</a></strong></p>

                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">domain</i>
                                    <a href="<?= BASE ?>/painel.php?exe=franqueador/localizacao/filtro_escola_franquias">Gerenciamento de escola - franquias</a>
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