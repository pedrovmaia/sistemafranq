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

        $Read->FullRead("SELECT produto.produto_id, produto.produto_nome, tipo.tipo_produto_nome, produto.produto_valor_venda, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_produto produto
                        LEFT OUTER JOIN sys_tipo_produto tipo ON tipo.tipo_produto_id = produto.produto_categoria_id  
                        LEFT OUTER JOIN sys_politica_comercial_produtos AS es ON produto.produto_id = es.politica_comercial_produto_id
                        WHERE produto.produto_tipo_id = 1
                        ");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $nova_data = date('Y-m-d');
                $de = date('Y-m-d', strtotime($Result["politica_comercial_data_inicio"]));
                $ate = date('Y-m-d', strtotime($Result["politica_comercial_data_final"]));

                if(($nova_data >= $de) && ($nova_data <= $ate)) {
                    $valor = $Result["politica_comercial_valor"];
                } else {
                    $valor = $Result["produto_valor_venda"];
                }

                array_push($arr, array(
                        "id" => $Result['produto_id'],
                        "nome" => $Result['produto_nome'],
                        "tipo" => $Result['tipo_produto_nome'],
                        "valor" => number_format($valor, "2", ",", ".")
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;