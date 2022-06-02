<?php
session_start();
if(!empty(isset($_SESSION['userSYSFranquia']["pessoa_id"]))){
    define('DIR_DOWNLOAD', 'uploads/');
    $arquivo = $_GET['arquivo'];
    $arquivo = filter_var($arquivo, FILTER_SANITIZE_STRING);
    $caminho_download = DIR_DOWNLOAD . $arquivo;
    if (!file_exists($caminho_download))
        die('ERRO !');
    header('Content-type: octet/stream');
    header('Content-disposition: attachment; filename="'.$arquivo.'";');
    header('Content-Length: '.filesize($caminho_download));
    readfile($caminho_download);
    exit;
} else {
    die('ERRO!');
}