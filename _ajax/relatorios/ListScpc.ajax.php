<?php

session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
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
endif;

switch ($action):

    case 'list':

        $arr = array();

                    $Read->FullRead("SELECT 
             scpc.envio_id,
              pessoa.pessoa_nome,
             DATE_FORMAT(scpc.envio_data_inclusao,'%d/%m/%Y') AS data_inclusao ,
             DATE_FORMAT(scpc.envio_data_retirada,'%d/%m/%Y') AS data_retirada ,
             scpc.envio_movimentacao_recebimento_id as documento,
             scpc.envio_observacao,
             un.unidade_nome
             FROM sys_envio_scpc scpc
             LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = scpc.envio_pessoa_id
             LEFT OUTER JOIN sys_unidades un ON un.unidade_id = scpc.unidade_id
             WHERE scpc.unidade_id  = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                    "id" => $Result['envio_id'],
                    "nome" => $Result['pessoa_nome'],
                    "datainclusao" => $Result['data_inclusao'],
                    "dataretirada" => $Result['data_retirada'],
                    "documento" => $Result['documento'],
                    "observacao" => $Result['envio_observacao'],
                    "unidade" => $Result['unidade_nome'],


                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;