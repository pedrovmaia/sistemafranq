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
            rateio.rateio_id,
            cc.centro_custo_nome,
            ct.conta_contabil_nome,
            con.conta_bancaria_nome,
            rateio.rateio_tipo_id,
            rateio.rateio_valor
            FROM sys_transacao_rateio rateio
            LEFT OUTER JOIN sys_centro_custo cc ON cc.centro_custo_id = rateio.rateio_centro_custo_id
            LEFT OUTER JOIN sys_conta_contabil ct ON ct.conta_contabil_id = rateio.rateio_conta_contabil_id
            LEFT OUTER JOIN sys_conta_bancaria con ON con.conta_bancaria_id = rateio.rateio_conta_contabil_id
            WHERE rateio.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['rateio_id'],
                        "nome" => $Result['centro_custo_nome'],
                        "contacontabil" => $Result['conta_contabil_nome'],
                        "contabancaria" => $Result['conta_bancaria_nome'],
                        "tipo" => $Result['rateio_tipo_id'],
                        "valor" => number_format($Result['rateio_valor'], 2, ',', '.')

                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;