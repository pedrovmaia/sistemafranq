<?php

session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'list':

        $arr = array();
        $Read->FullRead("SELECT
            pedido.pedido_compra_id,
            DATE_FORMAT(pedido.pedido_compra_data, '%d/%m/%Y') AS pedido_compra_data,
            pedido.pedido_compra_valor_total,
            pedido.pedido_compra_observacao,
            funcionario.pessoa_nome as funcionario,
            unidade.unidade_nome,
            fornecedor.pessoa_nome as fornecedor,
            produto.produto_nome,
            item.pedido_item_quantidade,
            item.pedido_item_valor_total
            FROM sys_pedido_compra pedido
            LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = pedido.pedido_compra_funcionario_id
            LEFT OUTER JOIN sys_unidades unidade ON unidade.unidade_id = pedido.unidade_id
            LEFT OUTER JOIN sys_pessoas fornecedor ON fornecedor.pessoa_id = pedido.pedido_fornecedor_id
            LEFT OUTER JOIN sys_pedido_compra_item item ON item.pedido_item_pedido_id = pedido.pedido_compra_id
            LEFT OUTER JOIN sys_produto produto ON produto.produto_id = item.pedido_item_produto_id

                      WHERE pedido.pedido_compra_status = 0
                    
                     ");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pedido_compra_id'],
                        "unidade" => $Result['unidade_nome'],
                        "produto" => $Result['produto_nome'],
                        "quantidade" => $Result['pedido_item_quantidade'],
                        "data" => $Result['pedido_compra_data'],
                        "valort" => number_format($Result['pedido_item_valor_total'], 2, ',', '.'),
                        "obs" => $Result['pedido_compra_observacao'],
                        "funcionario" => $Result['funcionario'],
                        "fornecedor" => $Result['fornecedor']
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;