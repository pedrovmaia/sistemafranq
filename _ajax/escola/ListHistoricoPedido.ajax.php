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

    $Id = $PostData["id"];
        if($Id){

        $arr = array();

        $Read->FullRead("SELECT 
                     pedido.pedido_id,
                     DATE_FORMAT( pedido.pedido_data,'%d/%m/%Y') AS data_pedido ,
                     pedido.pedido_valor_total,
                     funcionario.pessoa_nome as consultor_vendas,
                     convenio.convenio_nome,
                      CASE
                        WHEN pedido.pedido_status = 0 THEN 'Concluída'
                        ELSE 'Cancelada'
                        END AS pedido_status
                        
                     FROM sys_pedidos pedido
                     LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = pedido.pedido_funcionario_id
                     LEFT OUTER JOIN sys_convenio convenio ON convenio.convenio_id = pedido.pedido_convenio_id
                     WHERE pedido.pedido_cliente_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pedido_id'],
                        "data" => $Result['data_pedido'],
                        "valor" => number_format($Result['pedido_valor_total'], 2, ',', '.'),
                        "funcionario" => $Result['consultor_vendas'],
                        "status" => $Result['pedido_status'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/pedido/ver_pedido&id={$Result["pedido_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;