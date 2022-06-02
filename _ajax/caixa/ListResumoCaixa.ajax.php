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

        $Id = $PostData["caixa_id"];

        $Read->FullRead("
               SELECT 
                 forma.forma_pagamento_nome,
                 (SELECT sum(sys_transacao_caixa.transacao_caixa_valor)
                    FROM sys_transacao_caixa 
                    WHERE sys_transacao_caixa.transacao_caixa_forma = forma.forma_pagamento_id 
                    AND sys_transacao_caixa.transacao_caixa_caixa_id = :id
                    AND sys_transacao_caixa.unidade_id = :unidade)
                    as valor
                 FROM sys_forma_pagamento forma ", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "forma_pagamento_nome" => $Result['forma_pagamento_nome'],
                        "valor" => 'R$ ' . number_format($Result['valor'], 2, ',', '.')  
                        
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;