<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once '../_app/Config.inc.php';
include_once ('setting.php');

$relatorio = $_GET['relatorio'];
$relatorio = __DIR__ . '/' . $relatorio.'.jrxml';
require  'vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = $relatorio;

/*
$jasper = new PHPJasper;
try{

$jasper->compile($input)->execute();

} catch (Exception $exception){
    print_r($exception);
}
die;
*/

$output = __DIR__ . "/vendor";

$options = [
    'format' => ['pdf'],
    'params' => [
        'NomeEmpresa' => $_SESSION['NOME_EMPRESA'],
        'EnderecoEmpresa' => $_SESSION['ENDERECO_EMPRESA'],
        'CidadeEmpresa' => $_SESSION['CIDADE_EMPRESA'] ,
        'TelefoneEmpresa' => $_SESSION['TELEFONE_EMAIL_EMPRESA']
    ],
    'locale' => 'en',
    'db_connection' => [
        'driver' => 'mysql',
        'username' => $user,
        'password' => $pass,
        'host' => $server,
        'database' => $db,
        'port' => $pgport
    ]
];

$jasper = new PHPJasper;

try{

    $saida = $jasper->process(
        $input,
        $output,
        $options
    )->execute();

} catch (Exception $exception){
    print_r($exception);
    die;
}

header('Location: ' . BASE . '/reports/vendor/' . $_GET['relatorio'] . '.pdf');
?>