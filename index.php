<?php
ob_start();
session_start();
require '_app/Config.inc.php';
if(isset($_SESSION['userSYSFranquia'])):
    header('Location: ' . BASE . '/painel.php');
endif;
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
$getidioma = filter_input(INPUT_GET, 'lang', FILTER_DEFAULT);

$langs = ['pt-br', 'es-es', 'en-us']; // Array com as linguas

if(in_array($getidioma, $langs)):
    $expire = time() + 2592000;
    $lang = $getidioma; // Pega a linguagem

    $_SESSION['idioma'] = $lang;
    setcookie("lang", "{$lang}", $expire);

    if (isset($_SERVER['HTTP_REFERER'])):
        $back = str_replace("/{$lang}", '', $_SERVER['HTTP_REFERER']); // Pega a url antes do click em change e remove o paramentro da lingugem (Ex: remove "change_en")
    else:
        $back = str_replace("{$lang}", '', $_SERVER['REQUEST_URI']);
    endif;
    header('Location: ' . $back); // ao trocar o idioma ele valta a url que estava antes
endif;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="base" href="<?= BASE; ?>"/>
    <?php
    if(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'pt-br'):
        echo "<title>Acesso ao sistema</title>";
    elseif(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'en-us'):
        echo "<title>System access</title>";
    else:
        echo "<title>Acceso al sistema</title>";
    endif;
    ?>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body style="background-image: url('assets/img/cover.jpg');">

<div class="content" style="margin-top: 50px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <a href="#" class="simple-text logo-normal">
                    <img  class="img-responsive" style="display:block; margin-left: auto; margin-right: auto;" src="assets/img/logo.png">
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" >
    <div class="row">
        <div class="col-md-4 ml-auto mr-auto">
            <?php
            if (!empty($getexe) && $getexe == "restrito"):
              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
            endif;
            ?>
            <div class="card">
                <div class="card-header card-header-primary">
                    <?php
                    if(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'pt-br'):
                        echo "<h4 class='card-title'>ACESSO AO SISTEMA</h4>";
                        echo "<p class='card-category'>Por favor, insira seu usuário e senha para entrar no sistema.</p>";
                    elseif(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'en-us'):
                        echo "<h4 class='card-title'>SYSTEM ACCESS</h4>";
                        echo "<p class='card-category'>Please enter your username and password to log in.</p>";
                    else:
                        echo "<h4 class='card-title'>ACCESO AL SISTEMA</h4>";
                        echo "<p class='card-category'>Por favor ingrese su nombre de usuario y contraseña para iniciar sesión.</p>";
                    endif;
                    ?>
                </div>
                <div class="card-body">
                    <form class="login_form" name="work_login" action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" name="funcionario_email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                    if(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'pt-br'):
                                        echo "<label class='bmd-label-floating'>Senha</label>";
                                    elseif(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'en-us'):
                                        echo "<label class='bmd-label-floating'>Password</label>";
                                    else:
                                        echo "<label class='bmd-label-floating'>Contraseña</label>";
                                    endif;
                                    ?>
                                    <input type="password" name="funcionario_senha" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating d-none"> Esqueci minha senha.</label>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="callback_action" value="admin_login" >
                        <input type="hidden" name="callback" value="Login" >
                        <?php
                        if(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'pt-br'):
                            echo '<button type="submit" class="btn btn-primary pull-left">ACESSAR SISTEMA</button>';
                        elseif(empty($_COOKIE["lang"]) || $_COOKIE["lang"] == 'en-us'):
                            echo '<button type="submit" class="btn btn-primary pull-left">ACCESS SYSTEM</button>';
                        else:
                            echo '<button type="submit" class="btn btn-primary pull-left">SISTEMA DE ACCESO</button>';
                        endif;
                        ?>
                        <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO...">
                        <div class="pull-right mt-2">
                            <a title="Português" href="<?= BASE ?>/index.php?lang=pt-br" target="_self" rel="pt-br"><img width="35" height="20" src="assets/img/linguagem_portuguese.png"></a>
                            <a title="Español" href="<?= BASE ?>/index.php?lang=es-es" target="_self" rel="es-es"><img width="35" height="20" src="assets/img/linguagem_spanish.png"></a>
                            <a title="English" href="<?= BASE ?>/index.php?lang=en-us" target="_self" rel="en-us"><img width="35" height="20" src="assets/img/linguagem_states.png"></a>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<!--   Core JS Files   -->
<script src="<?= BASE ?>/assets/js/core/jquery.min.js"></script>
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
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?= BASE ?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?= BASE ?>/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="<?= BASE ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?= BASE ?>/assets/js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?= BASE ?>/assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?= BASE ?>/assets/js/plugins/fullcalendar.min.js"></script>
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
<script src="<?= BASE ?>/assets/js/login.js"></script>
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
</body>
</html>
<?php
ob_end_flush();
