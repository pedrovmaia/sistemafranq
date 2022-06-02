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

        $Read->FullRead("SELECT p.proposta_id, p.proposta_nome, p.proposta_valor_total, p.proposta_valor_entrada 
                FROM sys_proposta as p
                WHERE p.proposta_status = 0");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "id" => $Result['proposta_id'],
                        "nome" => $Result['proposta_nome'],
                        "total" => number_format($Result['proposta_valor_total'], "2", ",", "."),
                        "entrada" => number_format($Result['proposta_valor_entrada'], "2", ",", ".")
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;