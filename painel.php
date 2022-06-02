<?php
ob_start();
session_start();
require('_app/Config.inc.php');
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$getidioma = filter_input(INPUT_GET, 'lang', FILTER_DEFAULT);
if (!isset($_SESSION['userSYSFranquia'])):
    unset($_SESSION['userSYSFranquia'], $_SESSION['parametrosSYS'], $_SESSION['caixaSYS']);
    header('Location: index.php?exe=restrito');
    die;
else:
    $userSYSFranquia = $_SESSION['userSYSFranquia'];
endif;
if ($logoff):
    unset($_SESSION['userSYSFranquia']);
    header('Location: index.php?exe=logoff');
    die;
endif;
if(empty($Read)){
    $Read = new Read;
}
if (!isset($_SESSION['userSYSFranquia']["unidade_padrao"])):
    $_SESSION["userSYSFranquia"]["unidade_padrao"] = $userSYSFranquia['unidade_id'];
endif;
if (!isset($_SESSION['userSYSFranquia']["pessoa_idioma"])):

    if(!isset($_COOKIE["lang"])){
        $_SESSION['userSYSFranquia']["pessoa_idioma"] = "pt-br";
        $expire = time() + 2592000;
        setcookie("lang", "pt-br", $expire);
    } else {
        $_SESSION['userSYSFranquia']["pessoa_idioma"] = $_COOKIE["lang"];
    }
    $Update = new Update;
    $ArrUpdate = [
       "pessoa_idioma" => $_COOKIE["lang"]
    ];
    $Update->ExeUpdate("sys_pessoas", $ArrUpdate, "WHERE pessoa_id = :id", "id={$_SESSION['userSYSFranquia']["pessoa_id"]}");
endif;
$langs = ['pt-br', 'es-es', 'en-us'];
if(in_array($getidioma, $langs)):
    $expire = time() + 2592000;
    $lang = $getidioma;
    setcookie("lang", "{$lang}", $expire);
    $_SESSION['userSYSFranquia']["pessoa_idioma"] = $lang;
    $Update = new Update;
    $ArrUpdate = ["pessoa_idioma" => $getidioma];
    $Update->ExeUpdate("sys_pessoas", $ArrUpdate, "WHERE pessoa_id = :id", "id={$_SESSION['userSYSFranquia']['pessoa_id']}");

    if (isset($_SERVER['HTTP_REFERER'])):
        $back = str_replace("/{$lang}", '', $_SERVER['HTTP_REFERER']); // Pega a url antes do click em change e remove o paramentro da lingugem (Ex: remove "change_en")
    else:
        $back = str_replace("{$lang}", '', $_SERVER['REQUEST_URI']);
    endif;
    header('Location: ' . $back); // ao trocar o idioma ele valta a url que estava antes
endif;
$_SESSION['idioma'] = $_SESSION['userSYSFranquia']["pessoa_idioma"];
include_once 'traducoes/'.$_SESSION['idioma'].'.php';
?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="base" href="<?= BASE; ?>"/>
        <title>KNN Idiomas</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="_cdn/fonticon.css"> -->
        <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
        <link href="assets/demo/demo.css" rel="stylesheet" />
        <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/css/cheatsheet.css">
        <link href="https://unpkg.com/bootstrap-table@1.15.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.css" rel="stylesheet">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">

        <style>
            .showcase #close-showcase {
                color: #ffffff;
                background-color: #232F6B;
            }
            .showcase {
                background-color: #232F6B;
            }
            .showcase .pagination-detail {
                display: none;
            }
            #mySidenav{
                display: none;
            }
        </style>
    </head>
    <body>
    <div class="wrapper">

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="sidebar" data-color="purple" data-background-color="white" data-image="<?= BASE ?>/assets/img/sidebar-1.jpg">
                <div class="logo">
                    <a href="./index.php" class="simple-text logo-normal">
                        <img style="width: 130px; height: auto;" src="<?= BASE ?>/assets/img/logo.png">
                    </a>
                </div>

                <?php
                //ATIVA MENU
                if (isset($getexe)):
                    $linkto = explode('/', $getexe);
                else:
                    $linkto = array('');
                endif;
                ?>

                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_DASHBOARD);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=dashboards/dash_escola">
                                        <i class="material-icons">dashboard</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'">Dashboard</p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_FRANQUEADOR);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('franqueador', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=franqueador/home">
                                        <i class="material-icons">insert_chart</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'" ><?= $texto['Franqs'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_SEDE);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('sede', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=sede/home">
                                        <i class="material-icons">location_city</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'" > 
                                            <?= $texto['MenS'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>



                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_ESCOLA);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('favoritos', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=favoritos/home">
                                        <i class="material-icons">star</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'" ><?= $texto['MenF'] ?></p>
                                    </a>
                                </li>

                                <li class="nav-item <?php if (in_array('escola', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=escola/home">
                                        <i class="material-icons">school</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'" ><?= $texto['MenE'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PEDAGOGICO);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('pedagogico', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=pedagogico/home">
                                        <i class="material-icons">local_library</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenP'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_RETENCAO);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('retencao', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=retencao/home">
                                        <i class="material-icons">contacts</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenR'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>



                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PEDIDOS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('pedidos', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=pedidos/home">
                                        <i class="material-icons">shopping_basket</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenPS'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_SUPRIMENTOS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('suprimentos', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=suprimentos/home">
                                        <i class="material-icons">library_books</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSUP'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_FINANCEIRO);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('financeiro', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=financeiro/home">
                                        <i class="material-icons">local_atm</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenFN'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CONTAS_PAGAR);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('contaspagar', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=contaspagar/home">
                                        <i class="material-icons">library_books</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenCP'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CONTAS_RECEBER);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('contasreceber', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=contasreceber/home">
                                        <i class="material-icons">library_books</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenCR'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_RH);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('rh', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=rh/home">
                                        <i class="material-icons">person_pin</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenRH'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CONTABIL);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('contabil', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=contabil/home">
                                        <i class="material-icons">exposure</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenCTB'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>



                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_BIBLIOTECA);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('biblioteca', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=biblioteca/home">
                                        <i class="material-icons">chrome_reader_mode</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenBib'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>



                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_FORNECEDORES);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('fornecedores', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=fornecedores/home">
                                        <i class="material-icons">location_ons</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenForc'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_GESTAO_CONTRATOS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('documentos', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=documentos/home">
                                        <i class="material-icons">book</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSGC'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PARAMETRIZACAO);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('parametrizacao', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=parametrizacao/home">
                                        <i class="material-icons">domain</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSPTZ'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_ALERTAS_PENDENCIAS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('pendencias', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=pendencias/home">
                                        <i class="material-icons">notifications_active</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSAP'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_PRODUTOS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('produtos', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=produtos/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSPO'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_RELATORIOS);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('relatorios', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=relatorios/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSRel'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_INTELIGENCIA_ARTIFICIAL);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('visao_estrategica', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=visao_estrategica/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSIA'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_POLITICA_COMERCIAL);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('politica_comercial', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=politica_comercial/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSPC'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_MARKETING);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('marketing', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=marketing/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'">Marketing</p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>


                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_CRM);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('crm', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=crm/home">
                                        <i class="material-icons">group_add</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenSCRM'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_TRANSPORTE);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('transporte', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=transporte/home">
                                        <i class="material-icons">directions_bus</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenTE'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_ADMINISTRACAO);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('admin', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=admin/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'"><?= $texto['MenADM'] ?></p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE nivel_acesso_id = :nivel AND menu_id = :menu", "nivel={$userSYSFranquia['pessoa_acesso_id']}&menu=" . MENU_RESTAURANTES);
                        if($Read->getResult()){
                            if($Read->getResult()[0]['permissao'] == 1){
                                ?>
                                <li class="nav-item <?php if (in_array('restaurantes', $linkto)) echo ' active'; ?>">
                                    <a class="nav-link" href="<?= BASE ?>/painel.php?exe=restaurantes/home">
                                        <i class="material-icons">language</i>
                                        <p style="font-size: 15px; font-family: 'OpenSans BoldItalic'">Restaurantes</p>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>


                    </ul>
                </div>
            </div>
        </div>

        <div class="main-panel">

            <!-- <nav class="navbar navbar-expand-lg navbar-absolute fixed-top"> -->
            <nav class="navbar fixed-top navbar-expand-md navbar-light white double-nav scrolling-navbar">
                <div class="container-fluid">
                    <div class="navbar-wrapper">

                        <div class="float-left">
                            <a href="#" class="openNav"><i class="material-icons">menu</i><span class="sr-only" aria-hidden="true">Toggle side navigation</span></a href="#">
                        </div>

                        <a class="navbar-brand" style="font-size: 22px; font-family: 'OpenSans Bold'"; href="#pablo">
                            <?php
                            if ('escola/home' == $getexe){
                                echo '<strong>'.$texto['TituloPainelEscola'].'</strong>';
                            } elseif ('escola/matricula/efetuar_matricula' == $getexe){
                                echo '<strong>Fazer Matrícula</strong>';
                            } else {
                                echo '<strong>'.$texto['titulopainel'].'</strong>';
                            }
                            ?>
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">

                        <?php if($userSYSFranquia['pessoa_caixa'] == 2)
                        {?>
                            <form class="navbar-form">
                                <div class="input-group no-border">
                                    <p class="d-lg-none d-md-block">
                                        Franquia
                                    </p>


                                    <a  href="<?= BASE ?>/painel.php?exe=financeiro/ver_caixa"><select name="caixa_id" placeholder="ESCOLHA A EMPRESA" class="text_form jsys_unidade_id_padrao">

                                            <?php if(isset($_SESSION['caixaSYS']))
                                            {?>
                                                <option  selected style="color: #232F6B">Caixa aberto ( <?php echo $_SESSION['caixaSYS']['caixa_id']; ?> )  <?php echo date("d/m/Y", strtotime( $_SESSION['caixaSYS']['caixa_data_abertura'])); ?> </option>
                                            <?php }
                                            ?>

                                            <?php if(!isset($_SESSION['caixaSYS']))
                                            {?>
                                                <option  selected style="color: #232F6B">Caixa fechado </option>
                                            <?php }
                                            ?>


                                        </select></a>
                                </div>
                            </form>
                        <?php }
                        ?>

                        <form class="navbar-form">
                            <div class="input-group no-border">
                                <p class="d-lg-none d-md-block">
                                    Franquia
                                </p>
                                <?php
                                $Read->FullRead("SELECT u.unidade_nome, u.unidade_id FROM sys_relacao_pessoas_unidades AS pu INNER JOIN sys_unidades AS u ON pu.pessoa_unidade_unidade_id = u.unidade_id WHERE pu.pessoa_unidade_pessoa_id = :id", "id={$userSYSFranquia['pessoa_id']}");
                                if(!$Read->getResult()) {
                                    $Read->ExeRead("sys_unidades", "WHERE unidade_id = :id", "id={$userSYSFranquia['unidade_id']}");
                                }
                                ?>
                                <select name="unidade_id" placeholder="ESCOLHA A EMPRESA" class="text_form jsys_unidade_id_padrao">
                                    <?php
                                    if($Read->getResult()){
                                        foreach ($Read->getResult() as $Unidades) {
                                            echo "<option " . ($_SESSION["userSYSFranquia"]["unidade_padrao"] == $Unidades['unidade_id'] ? "selected='selected'" : "") . " value='{$Unidades['unidade_id']}'> <h5>{$Unidades['unidade_nome']}</h5></option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>


                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <span class="nav-link">
                            <a title="Português" href="<?= BASE ?>/painel.php?lang=pt-br" target="_self" rel="pt-br"><img width="35" height="20" src="assets/img/linguagem_portuguese.png"></a>
                            <a title="Español" href="<?= BASE ?>/painel.php?lang=es-es" target="_self" rel="es-es"><img width="35" height="20" src="assets/img/linguagem_spanish.png"></a>
                            <a title="English" href="<?= BASE ?>/painel.php?lang=en-us" target="_self" rel="en-us"><img width="35" height="20" src="assets/img/linguagem_states.png"></a>
                                </span>
                            </li>

                            <?php
                            $Read->FullRead("SELECT o.*, count(o.ocorrencia_id) as total, n.ocorrencias_natureza_nome FROM sys_ocorrencia AS o INNER JOIN sys_ocorrencias_natureza AS n  ON n.ocorrencia_natureza_id = o.ocorrencia_natureza_id WHERE o.ocorrencia_encaminha_id = :id AND o.ocorrencia_status = 0", "id={$_SESSION['userSYSFranquia']["pessoa_id"]}");
                            $num_mensagens = $Read->getResult()[0]['total'];
                            ?>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification sys_mensagens_novas num_mensagens"><?= $num_mensagens ?></span>
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <div class="list_notificacoes_msg">
                                    <?php
                                    echo '<div class="list_notificacoes_msg_novas">';
                                    if ($Read->getResult()):
                                        foreach($Read->getResult() as $MensagensHeader) {
                                            if($MensagensHeader["total"] != 0){
                                                echo '<a class="dropdown-item j_abrir_modal_ocorrencia" rel="'.$MensagensHeader['ocorrencia_id'].'" href="#"><div>';
                                                echo "<div class='text-truncate2'>Natureza: " . Check::Words($MensagensHeader["ocorrencias_natureza_nome"], 15) . "<br>Descrição: " . Check::Words($MensagensHeader["ocorrencia_descricao"], 15) . "</div>";
                                                echo "<div class='small text-gray-500'>" . date('d-m-Y', strtotime($MensagensHeader['ocorrencia_data'])) . "</div>";
                                                echo "</div></a>";
                                            }
                                        }
                                    else:
                                        echo "Sem mensagens a ser exibidas!!!";
                                    endif;
                                    echo "</div>";
                                    ?>
                                    </div>
                                    <hr>
                                    <a class="dropdown-item text-center j_click_abrir_ocorrencia" style="display: block" href="#">ABRIR OCORRÊNCIA</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#atalhosSistema">Atalhos do sistema</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#alterarSenhaSistemaGeral">Alterar Senha</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item wc_logout" href="#">Sair</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
            //QUERY STRING
            if (!empty($getexe)):
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
            else:
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
            endif;
            if (file_exists($includepatch)):
                require_once($includepatch);
            else:
                echo '<div class="content notfound">';
                WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
                echo "</div>";
            endif;
            ?>

            <!-- <footer class="footer">
                 <div class="container-fluid">
                     <nav class="float-left">
                         <ul>
                             <li>
                                 <a href="https://www.creative-tim.com">
                                     Creative Tim
                                 </a>
                             </li>
                             <li>
                                 <a href="https://creative-tim.com/presentation">
                                     About Us
                                 </a>
                             </li>
                             <li>
                                 <a href="http://blog.creative-tim.com">
                                     Blog
                                 </a>
                             </li>
                             <li>
                                 <a href="https://www.creative-tim.com/license">
                                     Licenses
                                 </a>
                             </li>
                         </ul>
                     </nav>
                     <div class="copyright float-right">
                         &copy;
                         <script>
                             document.write(new Date().getFullYear())
                         </script>, made with <i class="material-icons">favorite</i> by
                         <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
                     </div>
                 </div>
             </footer>-->

            <div class="modal fade" id="abrirOcorrenciasGeralDescricao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 650px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ver Ocorrência</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="" action="" method="post" enctype="multipart/form-data">
                                <div class="append_ocorrencia"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="atalhosSistema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atalhos do sistema</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + M
                                        </h3>
                                         <a href="<?= BASE ?>/painel.php?exe=pedidos/matricula/cadastro_pedido" accesskey="M">Nova Matricula</a> 


                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + A
                                        </h3>
                                        <a href="<?= BASE ?>/painel.php?exe=escola/alunos/filtro_alunos" accesskey="A">Gerenciamento de Alunos</a> 
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + C
                                        </h3>
                                        <a href="<?= BASE ?>/painel.php?exe=financeiro/ver_caixa" accesskey="C">Gerenciamento de Caixa</a> 
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + T
                                        </h3>
                                        <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_turma" accesskey="T">Gerenciamento de Turmas</a> 
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + R
                                        </h3>
                                        <a href="<?= BASE ?>/painel.php?exe=escola/turma/filtro_turma" accesskey="R">Recebimento de Parcelas</a> 
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="border: 1px solid; text-align: center">
                                        <h3>
                                            ALT + L
                                        </h3>
                                        <a href="<?= BASE ?>/painel.php?exe=escola/turma/acompanhamento_aula" accesskey="L">Acompanhamento de Aulas</a> 
                                        
                                    </div>
                                </div>




                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="alterarSenhaSistemaGeral" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form_alterar_senha_geral" action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">SENHA ATUAL</label>
                                            <input type="password" placeholder="Digite sua senha atual" name="senha_atual" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">NOVA SENHA</label>
                                            <input type="password" placeholder="Digite uma nova senha" name="usuario_senha" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CONFIRME A SENHA</label>
                                            <input type="password" placeholder="Confirme sua nova senha" name="usuario_senha1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"></label>
                                            <input type="hidden" name="action" value="pass">
                                            <button type="submit" class="btn btn-primary">SALVAR</button>
                                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO...">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="showcase hide-print" id="getCodeEncaminharModalGeral">
                <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="showbox-example" class="showbox">
                                <table  class="table table-hover display"
                                        id="table_modal_funcionarios_geral"
                                        data-locale="pt-BR"
                                        data-filter-control="true"
                                        data-minimum-count-columns="2"
                                        data-url="_ajax/lookups/ListFuncionarios.ajax.php?action=list"
                                        data-pagination="true"
                                        data-id-field="nome"
                                        data-toggle="table"
                                        data-select-item-name="nome"
                                        data-buttons-class="primary"
                                        data-click-to-select="true">
                                    <thead>
                                    <tr>
                                        <th data-radio="true"></th>
                                        <th  data-field="nome" data-filter-control="input">Nome</th>
                                        <th data-field="cpf" data-filter-control="input">Cargo</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

            <div class="showcase hide-print" id="getCodeAlunosModalGeral">
                <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="showbox-example" class="showbox">
                                <table  class="table table-hover display"
                                        id="table_modal_alunos_geral"
                                        data-locale="pt-BR"
                                        data-filter-control="true"
                                        data-minimum-count-columns="2"
                                        data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
                                        data-pagination="true"
                                        data-id-field="nome"
                                        data-toggle="table"
                                        data-select-item-name="nome"
                                        data-buttons-class="primary"
                                        data-click-to-select="true"
                                >
                                    <thead>
                                    <tr>
                                        <th data-radio="true"></th>
                                        <th  data-field="nome" data-filter-control="input">Nome</th>
                                        <th data-field="id" data-filter-control="input">Situação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="abrirOcorrenciasGeral" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 650px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Abrir Ocorrência</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form_ocorrencias_geral" action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CLIENTE / ALUNO</label>
                                            <a data-toggle="modal" data-target="#getCodeAlunosModalGeral">
                                                <input readonly="" type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" id="txt_aluno_geral" class="form-control">
                                            </a>
                                            <input type="hidden" name="ocorrencia_pessoa_id" id="ocorrencia_pessoa_id">
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">NATUREZA</label>
                                            <select class="form-control j_change_natureza_geral" name="ocorrencia_natureza_id">
                                                <option>Selecione um natureza</option>
                                            <?php
                                            $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencias_natureza_status = 0");
                                            if($Read->getResult()){
                                                foreach ($Read->getResult() as $Natureza) {
                                                    echo "<option value='{$Natureza['ocorrencia_natureza_id']}'>{$Natureza['ocorrencias_natureza_nome']}</option>";
                                                }
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">ENCAMINHAR PARA</label>
                                            <input readonly="" type="text" placeholder="Clique e selecione para quem deseja encaminhar" name="pessoa_nome" id="txt_encaminha_geral" class="form-control">
                                            <input type="hidden" name="ocorrencia_encaminha_id" id="geral_ocorrencia_encaminha_id">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">DATA</label>
                                            <input type="date" class="form-control" name="ocorrencia_data">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">DESCRIÇÃO/OBSERVAÇÃO</label>
                                            <textarea name="ocorrencia_descricao" class="form-control"></textarea>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"></label>
                                            <input type="hidden" name="action" value="OcorrenciaGeralAdd">
                                            <button type="submit" class="btn btn-primary">SALVAR</button>
                                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO...">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="abrirAnexos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 650px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Anexos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form_anexo_sistema" action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">TÍTULO</label>
                                            <input type="text" name="anexo_titulo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">ARQUIVO</label>
                                            <input name="anexo_link" type="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"></label>
                                            <input type="hidden" name="action" value="AnexoAdd">
                                            <input type="hidden" class="tabelaid_anexo" name="anexo_tabela" value="">
                                            <input type="hidden" class="origemid_anexo" name="anexo_origem" value="">
                                            <button type="submit" class="btn btn-primary btn-link"><i class="material-icons">save</i></button>
                                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO...">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody class="corpo_tabela_anexo">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="abrirEscolhaParcelasGeral" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 650px; margin-top: 5px;">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 5px 10px;">
                            <h5 class="modal-title" id="exampleModalLabel">Formas de Pagamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form_gerar_parcelas_geral_padrao" action="" method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 text-right mt-1">
                                            <label>Pessoa</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" readonly name="cliente_id_geral_parcelas" class="form-control cliente_id_geral_parcelas">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="cliente_nome_geral_parcelas" class="form-control cliente_nome_geral_parcelas">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>SubTotal</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="subtotal_geral_parcelas" class="form-control subtotal_geral_parcelas text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>Desconto</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" value="0,00" name="valor_desconto_geral_parcelas" class="form-control valor_desconto_geral_parcelas text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>Total a Pagar</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="valor_pos_desconto_geral_parcelas" class="form-control valor_pos_desconto_geral_parcelas text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <table class="table table-hover table_personalizada">
                                            <thead>
                                            <tr>
                                                <th>Forma de Pagamento</th>
                                                <th>Valor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                                            if ($Read->getResult()):
                                                foreach ($Read->getResult() as $FormaPagamento):
                                                    ?>
                                                    <tr>
                                                        <td><?= $FormaPagamento['forma_pagamento_nome'] ?></td>
                                                        <td><input type="text" name="forma_pagamento_<?= $FormaPagamento['forma_pagamento_id'] ?>" value="0,00" class="form-control text-right formMoney forma_pagamento_geral_parcelas"></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3 text-right mt-1">
                                                    <label>Valor Pago</label>
                                                </div>
                                                <div class="col-md-3 mt-1">
                                                    <input type="text" readonly value="0,00" name="valor_pago_geral_parcelas" class="form-control valor_pago_geral_parcelas text-right formMoney">
                                                </div>
                                                <!--<div class="col-md-2 text-right mt-1">
                                                    <label>Troco</label>
                                                </div>
                                                <div class="col-md-3 mt-1">
                                                    <input type="text" readonly value="0,00" name="valor_troco_geral_parcelas" class="form-control valor_troco_geral_parcelas text-right formMoney">
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                             <button disabled type="submit" class="btn btn-primary button_geral_parcelas">
                                                 <i class="material-icons">
                                                     credit_card
                                                 </i>
                                                Concluir
                                             </button>
                                            <input type="hidden" class="formulario_atual_geral_parcelas">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="abrirEscolhaParcelasGeralPedidoMatricula" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 650px; margin-top: 5px;">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 5px 10px;">
                            <h5 class="modal-title" id="exampleModalLabel">Formas de Pagamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form_gerar_parcelas_geral_padrao_pedido_matricula" action="" method="post" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 text-right mt-1">
                                            <label>Pessoa</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" readonly name="cliente_id_geral_parcelas_pedido_matricula" class="form-control cliente_id_geral_parcelas_pedido_matricula">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="cliente_nome_geral_parcelas_pedido_matricula" class="form-control cliente_nome_geral_parcelas_pedido_matricula">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>SubTotal</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="subtotal_geral_parcelas_pedido_matricula" class="form-control subtotal_geral_parcelas_pedido_matricula text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>Desconto</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" value="0,00" name="valor_desconto_geral_parcelas_pedido_matricula" class="form-control valor_desconto_geral_parcelas_pedido_matricula text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>Total a Pagar</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly name="valor_pos_desconto_geral_parcelas_pedido_matricula" class="form-control valor_pos_desconto_geral_parcelas_pedido_matricula text-right formMoney">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-6 text-right mt-2">
                                            <label>Forma de Parcelamento</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="forma_parcelamento_entrada_geral_parcelas_pedido_matricula" class="form-control forma_parcelamento_entrada_geral_parcelas_pedido_matricula">
                                                <option value="" disabled>Selecione uma forma de parcelamento</option>
                                                <?php
                                                $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $FormaPagamento):
                                                        echo "<option value='{$FormaPagamento["forma_parcelamento_id"]}-{$FormaPagamento["forma_parcelamento_entrada"]}'>{$FormaPagamento["forma_parcelamento_nome"]}</option>";
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <table class="table table-hover table_personalizada">
                                            <thead>
                                            <tr>
                                                <th>Forma de Pagamento</th>
                                                <th>Valor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                                            if ($Read->getResult()):
                                                foreach ($Read->getResult() as $FormaPagamento):
                                                    ?>
                                                    <tr>
                                                        <td><?= $FormaPagamento['forma_pagamento_nome'] ?></td>
                                                        <td><input type="text" name="forma_pagamento_pedido_matricula_<?= $FormaPagamento['forma_pagamento_id'] ?>" value="0,00" class="form-control text-right formMoney forma_pagamento_geral_parcelas_pedido_matricula"></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3 text-right mt-1">
                                                    <label>Valor Pago</label>
                                                </div>
                                                <div class="col-md-3 mt-1">
                                                    <input type="text" readonly value="0,00" name="valor_pago_geral_parcelas_pedido_matricula" class="form-control valor_pago_geral_parcelas_pedido_matricula text-right formMoney">
                                                </div>
                                                <!--<div class="col-md-2 text-right mt-1">
                                                    <label>Troco</label>
                                                </div>
                                                <div class="col-md-3 mt-1">
                                                    <input type="text" readonly value="0,00" name="valor_troco_geral_parcelas_pedido_matricula" class="form-control valor_troco_geral_parcelas_pedido_matricula text-right formMoney">
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button disabled type="submit" class="btn btn-primary button_geral_parcelas_pedido_matricula">
                                                <i class="material-icons">
                                                    credit_card
                                                </i>
                                                Concluir
                                            </button>
                                            <input type="hidden" class="formulario_atual_geral_parcelas_pedido_matricula">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="<?= BASE ?>/assets/js/core/jquery.min.js"></script>
    <script src="<?= BASE ?>/assets/js/redirect.js"></script>
    <script src="<?= BASE ?>/assets/js/core/popper.min.js"></script>
    <script src="<?= BASE ?>/assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?= BASE ?>/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="<?= BASE ?>/assets/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="<?= BASE ?>/assets/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="<?= BASE ?>/assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="<?= BASE ?>/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="<?= BASE ?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="<?= BASE ?>/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="<?= BASE ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="<?= BASE ?>/assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="<?= BASE ?>/assets/js/plugins/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/pt-br.js"></script>

    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="<?= BASE ?>/assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="<?= BASE ?>/assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="<?= BASE ?>/assets/js/plugins/arrive.min.js"></script>
    <!-- Chartist JS -->
    <script src="<?= BASE ?>/assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<?= BASE ?>/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= BASE ?>/assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?= BASE ?>/assets/demo/demo.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?= BASE ?>/assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->

    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table-locale-all.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.14.2/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.14.2/dist/extensions/export/bootstrap-table-export.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= BASE ?>/assets/js/loadingoverlay.min.js"></script>
    <script src="<?= BASE ?>/assets/js/jquery.form.js"></script>
    <script src="<?= BASE ?>/assets/js/funcoes.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE ?>/assets/js/maskinput.js"></script>
    <?php
    require 'assets/js/funcoes.php';
    ?>
    <script src="<?= BASE ?>/assets/js/editable.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE ?>/assets/js/editable_parcelas.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE ?>/assets/js/editable_centro_custo.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE ?>/assets/js/lookups.js?v=<?= time(); ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script>

    <script src="_cdn/tinymce/tinymce.min.js"></script>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <script src="https://unpkg.com/bootstrap-table@1.15.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.js"></script>

    <?php
    if (in_array('cadastro_transacao_caixa', $linkto) || in_array('filtro_titulos_receber_por_pessoa', $linkto)) {
        if (!isset($_SESSION['caixaSYS'])) {
            echo "<script>swal('ATENÇÃO!', 'Para funcionalidades que geram caixa, abra o caixa do dia.', 'info');</script>";
        }
    }
    ?>

    <script type="text/javascript">

        tinyMCE.init({
            selector: "textarea.contrato",
            language: 'pt_BR',
            menubar: "file",
            theme: "modern",
            height: 500,
            skin: 'light',
            entity_encoding: "raw",
            theme_advanced_resizing: true,
            plugins: [
                "print advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor media"
            ],
            toolbar: "print | styleselect | forecolor | backcolor | pastetext | removeformat | alignleft aligncenter alignright alignjustify | bold | italic | underline | strikethrough | bullist | numlist |  link | unlink | fullscreen | alignmentsplit | bullist numlist outdent indent",
            style_formats: [
                {title: 'Normal', block: 'p'},
                {title: 'Titulo 3', block: 'h3'},
                {title: 'Titulo 4', block: 'h4'},
                {title: 'Titulo 5', block: 'h5'},
                {title: 'Código', block: 'pre', classes: 'brush: php;'}
            ],
            link_class_list: [
                {title: 'None', value: ''},
                {title: 'Blue CTA', value: 'btn btn_cta_blue'},
                {title: 'Green CTA', value: 'btn btn_cta_green'},
                {title: 'Yellow CTA', value: 'btn btn_cta_yellow'},
                {title: 'Red CTA', value: 'btn btn_cta_red'}
            ],
            link_title: false,
            target_list: false,
            theme_advanced_blockformats: "h1,h2,h3,h4,h5,p,pre",
            media_dimensions: false,
            media_poster: false,
            media_alt_source: false,
            media_embed: false,
            extended_valid_elements: "a[href|target=_blank|rel|class]",
            imagemanager_insert_template: '<img src="{$url}" title="{$title}" alt="{$title}" />',
            image_dimensions: false,
            relative_urls: false,
            remove_script_host: false,
            paste_as_text: true,
        });
    </script>

    <script>

        $(document).ready(function() {
            if($('#calendar').length) {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultDate: Date(),
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    eventTextColor: '#fff',
                    defaultView: 'agendaWeek',
                    slotLabelFormat: "HH:mm",
                    selectable: true,
                    allDaySlot: false,
                    events: [
                        <?php
                        $Read->FullRead("SELECT * FROM sys_planejamento planejamento  
                    LEFT OUTER JOIN sys_projetos projeto ON projeto.projeto_id = planejamento.planejamento_projeto_id 
                    AND planejamento.unidade_id =  :unidade",
                            "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

                        if($Read->getResult()){
                        $manage['total'] = $Read->getRowCount();
                        foreach ($Read->getResult() as $Result){


                        ?>
                        {

                            <?php  $date = new DateTime($Result['planejamento_data']);
                            $time = new DateTime($Result['planejamento_hora_inicial']);
                            // Solution 1, merge objects to new object:
                            $merge_inicial = new DateTime($date->format('Y-m-d') . ' ' . $time->format('H:i:s')); ?>


                            <?php  $date = new DateTime($Result['planejamento_data']);
                            $time = new DateTime($Result['planejamento_hora_final']);
                            // Solution 1, merge objects to new object:
                            $merge_final = new DateTime($date->format('Y-m-d') . ' ' . $time->format('H:i:s')); ?>



                            id: '<?php echo $Result['planejamento_id']; ?>',
                            title: '<?php echo $Result['projeto_codigo'] . '-' . $Result['projeto_descricao']; ?>',
                            start: '<?php echo $merge_inicial->format('Y-m-d H:i:s'); ?>',
                            end: '<?php echo $merge_final->format('Y-m-d H:i:s'); ?>',
                            color: '#B95591',

                        },<?php
                        }
                        }
                        ?>
                    ]
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $('.sidebar');
                $sidebar_img_container = $sidebar.find('.sidebar-background');
                $full_page = $('.full-page');
                $sidebar_responsive = $('body > .navbar-collapse');
                window_width = $(window).width();
                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }
                }
                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });
                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                    var new_color = $(this).data('color');
                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }
                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }
                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });
                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                    var new_color = $(this).data('background-color');
                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });
                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');
                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');
                    var new_image = $(this).find("img").attr('src');
                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }
                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }
                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }
                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });
                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');
                    $input = $(this);
                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }
                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }
                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }
                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }
                        background_image = false;
                    }
                });
                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');
                    $input = $(this);
                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;
                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
                    } else {
                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');
                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }
                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);
                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();
        });
    </script>


    <!-- Step Form Wizard plugin -->
    <link rel="stylesheet" href="wizard/step-form-wizard/css/step-form-wizard-all.css" type="text/css" media="screen, projection">
    <script src="wizard/step-form-wizard/js/step-form-wizard.js"></script>

    <!-- nicer scroll in steps -->


    <script>
        $(document).ready(function () {
            $("#wizard_example").stepFormWizard();
            $("#form_planejamento_aulas").stepFormWizard();
            $("#form_acompanhamento_aulas").stepFormWizard();
            $("#form_lista_assinaturas").stepFormWizard({
                finishBtn: $('<button class="finish-btn sf-right sf-btn sf-btn-finish" id="btn">CLIQUE PARA IMPRIMIR</button>')
            });
            $("#form_renegociacao").stepFormWizard();
        });
        $(window).load(function () {
            /* only if you want use mcustom scrollbar */
            $(".sf-step").mCustomScrollbar({
                theme: "dark-3",
                scrollButtons: {
                    enable: true
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#wizard_example").stepFormWizard();
            $("#form_lista_assinaturas").stepFormWizard();
            var sfw = $("#form_lista_assinaturas").stepFormWizard();
        });
        $(window).load(function () {
            /* only if you want use mcustom scrollbar */
            $(".sf-step").mCustomScrollbar({
                theme: "dark-3",
                scrollButtons: {
                    enable: true
                }
            });
        });
    </script>
    <script>
        $(".openNav").click(function () {
            $('#mySidenav').fadeIn('fast');
            $('body').prepend('<div onclick="closeNav()" id="sidenav-overlay"></div>');
            return false;
        });
        function closeNav() {
            $('#mySidenav').fadeOut('fast', function () {
                $('#sidenav-overlay').remove();
            })
        }
    </script>


    <style>
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            overflow-x: hidden;
            transition: 0.5s;
        }
        .sidenav a {
            display: block;
            transition: 0.3s;
        }
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        #sidenav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 120vh;
            background-color: rgba(0,0,0,.5);
            z-index: 997;
            will-change: opacity;
        }
        pre {margin: 45px 0 60px;}
        h1 {margin: 60px 0 60px 0;}
        p {margin-bottom: 10px;}
    </style>
    </body>
    </html>
<?php
ob_end_flush();