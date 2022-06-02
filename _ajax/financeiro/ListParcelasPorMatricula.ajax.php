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
        
        $Read->FullRead("SELECT r.* FROM sys_movimentacao AS m INNER JOIN sys_movimentacao_recebimento AS r ON m.movimentacao_id = r.mov_recebimento_movimento_id WHERE movimentacao_matricula_id = :id", "id={$PostData['pedido_id']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                //Convert it into a timestamp.
                $timestamp = strtotime( $Result['mov_recebimento_data_vencimento']);
                 
                //Convert it to DD-MM-YYYY
                $dmy = date("d/m/Y", $timestamp);

                array_push($arr, array(
                        "id" => $Result['mov_recebimento_desc_identificador'],
                        "parcela" => $Result['mov_recebimento_parcela'],
                        "vencimento" =>  $dmy,
                        "valor" =>  'R$ ' . number_format($Result['mov_recebimento_valor'], 2, ',', '.') ,
                        "pagamento" => $Result['mov_recebimento_data_recebimento'],
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;