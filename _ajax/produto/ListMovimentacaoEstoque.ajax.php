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

        $Read->FullRead("SELECT movimentacao.estoque_transacao_id,
            movimentacao.estoque_transacao_descricao,
            movimentacao.estoque_transacao_quantidade,
             CASE
                    WHEN movimentacao.estoque_transacao_operacao = '0' THEN 'Entrada'
                    ELSE 'Saída'
                    END AS tipo
                    FROM sys_estoque_transacoes movimentacao
                    WHERE movimentacao.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['estoque_transacao_id'],
                        "nome" => $Result['estoque_transacao_descricao'],
                        "tipo" => $Result['tipo'],
                        "quantidade" => $Result['estoque_transacao_quantidade'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=produtos/estoque/ver_movimentacao_estoque&id={$Result["estoque_transacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;