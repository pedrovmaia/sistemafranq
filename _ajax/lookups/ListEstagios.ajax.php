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

        $Read->FullRead("SELECT e.estagio_produto_id, e.estagio_produto_nome, p.produto_nome, e.estagio_produto_valor, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_estagio_produto AS e INNER JOIN sys_produto AS p ON e.estagio_produto_produto_id = p.produto_id INNER JOIN sys_politica_comercial_estagios AS es ON e.estagio_produto_id = es.politica_comercial_estagio_id WHERE e.estagio_produto_status = 0");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $nova_data = date('Y-m-d');
                $de = date('Y-m-d', strtotime($Result["politica_comercial_data_inicio"]));
                $ate = date('Y-m-d', strtotime($Result["politica_comercial_data_final"]));

                if(($nova_data >= $de) && ($nova_data <= $ate)) {
                    $valor = $Result["politica_comercial_valor"];
                } else {
                    $valor = $Result["estagio_produto_valor"];
                }

                array_push($arr, array(
                        "id" => $Result['estagio_produto_id'],
                        "nome" => $Result['produto_nome'] . " - " . $Result['estagio_produto_nome'],
                        "valor" => number_format($valor, "2", ",", "."),
                        //"entrada" => number_format($Result['proposta_valor_entrada'], "2", ",", ".")
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;