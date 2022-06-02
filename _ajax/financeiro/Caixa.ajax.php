<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
endif;

switch ($action):

    case 'AbrirCaixa':

        $CreateDataCaixa['caixa_data_abertura'] = date('Y/m/d');
        $CreateDataCaixa['caixa_pessoa_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
        $CreateDataCaixa['caixa_status'] = 1;
        $CreateDataCaixa['caixa_hora_abertura'] = date('h:i:s a', time());

        $Create->ExeCreate("sys_caixa", $CreateDataCaixa);
        $CaixaId = $Create->getResult();
        $CreateDataCaixa['caixa_id'] = $CaixaId;
        $_SESSION['caixaSYS'] = $CreateDataCaixa;
        $caixaSYS = $_SESSION['caixaSYS'];


        $jSON['success'] = 'Seu caixa foi aberto com sucesso!';
        $jSON['redirect'] = "painel.php?exe=financeiro/ver_caixa";


        break;

    case 'FecharCaixa':

        $UpdateDataCaixa['caixa_data_fechamento'] = date('Y/m/d');
        $UpdateDataCaixa['caixa_status'] = 2;
        $UpdateDataCaixa['caixa_hora_fechamento'] = date('h:i:s', time());
    
        $id = $_SESSION['caixaSYS']['caixa_id'];
        $UpdateDataCaixa['caixa_id'] =  $id;

    
        $Update->ExeUpdate("sys_caixa", $UpdateDataCaixa, "WHERE caixa_id = :idx", "idx={$id}");

        unset($_SESSION['caixaSYS']);
        
    
        $jSON['success'] = 'Seu caixa foi fechado com sucesso!';
        $jSON['redirect'] = "painel.php?exe=financeiro/ver_caixa";

        break;


    case 'ConferidoCaixa':

        $UpdateDataCaixa['caixa_data_conferencia'] = date('Y/m/d');
        $UpdateDataCaixa['caixa_status'] = 3;
        $UpdateDataCaixa['caixa_hora_conferencia'] = date('h:i:s', time());
        $UpdateDataCaixa['caixa_pessoa_id_conferencia'] = $_SESSION['userSYSFranquia']['pessoa_id'];


        $id = $PostData['caixa_id'];
        unset($PostData['controle_cheque_id']);
    
        $UpdateDataCaixa['caixa_id'] =  $id;

    
        $Update->ExeUpdate("sys_caixa", $UpdateDataCaixa, "WHERE caixa_id = :idx", "idx={$id}");

    
        $jSON['success'] = 'Seu caixa foi conferido com sucesso!';
        $jSON['redirect'] = "painel.php?exe=financeiro/filtro_conferir_caixa";

        break;



endswitch;

echo json_encode($jSON);