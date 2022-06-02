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

        
        $Read->ExeRead("sys_movimentacao_pagamento", "WHERE mov_pagamento_movimento_id = :id", "id={$PostData['movimento_id']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                //Convert it into a timestamp.
                $timestamp = strtotime( $Result['mov_pagamento_data_vencimento']);
                 
                //Convert it to DD-MM-YYYY
                $dmy = date("d/m/Y", $timestamp);
                 

                array_push($arr, array(
                        "id" => $Result['mov_pagamento_numero'],
                        "parcela" => $Result['mov_pagamento_parcela'],
                        "vencimento" =>  $dmy,
                        "valor" =>  'R$ ' . number_format($Result['mov_pagamento_valor'], 2, ',', '.') ,
                        "pagamento" => $Result['mov_pagamento_data_pagamento'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contaspagar/ver_titulo_pagar&id={$Result["mov_pagamento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;