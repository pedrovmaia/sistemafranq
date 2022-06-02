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
                    $dataInicio = $PostData['inicio'];
            $dataFim = $PostData['fim'];

        $Read->FullRead("SELECT 
                  venda.movimentacao_id,
                  DATE_FORMAT( venda.movimentacao_data,'%d/%m/%Y') AS data_venda ,
                  pessoa.pessoa_nome as aluno,
                  atendente.pessoa_nome as atendente,
                  venda.movimentacao_valor_total
                  
                  FROM sys_movimentacao venda
                  LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = venda.movimentacao_pessoa_id
                  LEFT OUTER JOIN sys_pessoas atendente ON atendente.pessoa_id = venda.movimentacao_atendente_id
                   WHERE venda.movimentacao_origem_movimentacao = 1 AND venda.unidade_id  ={$_SESSION['userSYSFranquia']['unidade_padrao']}  AND venda.movimentacao_data BETWEEN ('".$dataInicio."') AND ('".$dataFim."')");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "movimentacao" => $Result['movimentacao_id'],
                        "data" => $Result['data_venda'],
                        "aluno" => $Result['aluno'],
                        "atendente" => $Result['atendente'],
                        "valor" => number_format($Result['movimentacao_valor_total'], 2, ',', '.'),
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;