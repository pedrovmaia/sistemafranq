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
        $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];
        
        $Read->FullRead("SELECT 
                parcela.mov_pagamento_data_pagamento,
                parcela.mov_pagamento_data_vencimento,
                parcela.mov_pagamento_id,
                parcela.mov_pagamento_movimento_id,
                parcela.mov_pagamento_numero,
                parcela.mov_pagamento_parcela,
                parcela.mov_pagamento_pessoa_id,
                parcela.mov_pagamento_status,
                parcela.mov_pagamento_tipo_id,
                parcela.mov_pagamento_valor,
                pessoa.pessoa_nome
                 FROM sys_movimentacao_pagamento parcela
                 LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_pagamento_pessoa_id
                 WHERE parcela.unidade_id = :unidade
                 AND parcela.mov_pagamento_data_vencimento BETWEEN ('{$dataInicio}') AND ('{$dataFim}')
                 ORDER BY parcela.mov_pagamento_data_vencimento", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            $valor = 0;
            foreach ($Read->getResult() as $Result){

                $valor = $valor + $Result['mov_pagamento_valor'];

                //Convert it into a timestamp.
                $timestamp = strtotime( $Result['mov_pagamento_data_vencimento']);
                 
                //Convert it to DD-MM-YYYY
                $dmy = date("d/m/Y", $timestamp);
                 

                array_push($arr, array(
                        "id" => $Result['mov_pagamento_numero'],
                        "fornecedor" => $Result['pessoa_nome'],
                        "parcela" => $Result['mov_pagamento_parcela'],
                        "vencimento" =>  $dmy,
                        "valor" =>  'R$ ' . number_format($Result['mov_pagamento_valor'], 2, ',', '.') ,
                        "pagamento" => $Result['mov_pagamento_data_pagamento'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contaspagar/ver_titulo_pagar&id={$Result["mov_pagamento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );
            }
            $manage['valor'] = number_format($valor, 2, ',', '.');
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;