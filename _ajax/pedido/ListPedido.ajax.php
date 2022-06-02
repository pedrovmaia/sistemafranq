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

        $Read->FullRead("SELECT pedido.pedido_id,
                       pedido.pedido_data,
                       pedido.pedido_valor_total,
                       pessoa.pessoa_nome
                 FROM sys_pedidos pedido
                 LEFT OUTER JOIN sys_pessoas  pessoa ON pessoa.pessoa_id = pedido.pedido_cliente_id WHERE pedido.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pedido_id'],
                        "nome" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y H:i:s' , strtotime($Result['pedido_data'])),
                        "valor" => number_format($Result['pedido_valor_total'], 2, ',', '.'),
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/pedido/ver_pedido&id={$Result["pedido_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/pedido/cadastro_pedido&id={$Result["pedido_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='pedido/Pedido' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["pedido_id"]}'><i class='material-icons''>close</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;