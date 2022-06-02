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

        $Read->FullRead("SELECT movimentacao.movimentacao_id, movimentacao.movimentacao_descricao,
                 pessoa.pessoa_nome, movimentacao.movimentacao_emissao, movimentacao.movimentacao_valor_total FROM sys_movimentacao movimentacao
                 LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = movimentacao.movimentacao_pessoa_id
                 WHERE movimentacao.movimentacao_tipo_id = 1 AND movimentacao.unidade_id = :unidade
                ", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['movimentacao_id'],
                        "nome" => $Result['movimentacao_descricao'],
                        "fornecedor" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y',strtotime($Result['movimentacao_emissao'])) ,
                        "valor" => 'R$ ' . number_format($Result['movimentacao_valor_total'], 2, ',', '.') ,
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contaspagar/ver_movimentacao_pagamento&id={$Result["movimentacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;