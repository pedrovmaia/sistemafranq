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

        $Read->FullRead("SELECT transacao.estoque_transacao_id,
                        transacao.estoque_transacao_produto_id,
                        transacao.estoque_transacao_quantidade,
                         IF(transacao.estoque_transacao_operacao ='0','Compra','Venda') estoque_transacao_operacao, 
                        transacao.estoque_transacao_data,
                        transacao.estoque_transacao_hora,
                        transacao.estoque_transacao_descricao,
                        transacao.estoque_transacao_valor,
                        produto.produto_nome
                    FROM sys_estoque_transacoes transacao
                    LEFT OUTER JOIN sys_produto produto ON produto.produto_id = transacao.estoque_transacao_produto_id
                    WHERE transacao.estoque_transacao_produto_id = :id AND transacao.unidade_id = :unidade", "id={$PostData['produto_id']}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['estoque_transacao_id'],
                        "nome" => $Result['estoque_transacao_descricao'],
                        "quantidade" => $Result['estoque_transacao_quantidade'],
                        "operacao" => $Result['estoque_transacao_operacao'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=produtos/estoque/ver_movimentacao_estoque&id={$Result["estoque_transacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;