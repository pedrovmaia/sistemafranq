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

        $Read->FullRead("SELECT  produto.produto_nome,
                sum(transacao.estoque_transacao_quantidade) as quantidade
            FROM sys_estoque_transacoes transacao
            LEFT OUTER JOIN sys_produto produto ON produto.produto_id = transacao.estoque_transacao_produto_id
            WHERE transacao.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
            GROUP BY transacao.estoque_transacao_produto_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "nome" => $Result['produto_nome'],
                        "quantidade" => $Result['quantidade'],
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;