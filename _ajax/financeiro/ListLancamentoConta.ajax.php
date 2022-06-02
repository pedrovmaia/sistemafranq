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
        $conta_bancaria = $PostData['conta'];
        
        $Read->FullRead("SELECT 
                      caixa.transacao_caixa_id,
                      caixa.transacao_caixa_descricao,
                      DATE_FORMAT( caixa.transacao_caixa_data,'%d/%m/%Y') AS transacao_caixa_data ,
                      caixa.transacao_caixa_hora,
                      caixa.transacao_caixa_valor,
                      caixa.transacao_conta_id,
                      conta.conta_bancaria_nome,
                      caixa.transacao_caixa_tipo_id,
                      CASE
                        WHEN caixa.transacao_caixa_tipo_id = 1 THEN 'Entrada'
                        ELSE 'Saida'
                        END AS tipo,
                        
                      pessoa.pessoa_nome,
                      forma.forma_pagamento_nome,
                      caixa.transacao_caixa_caixa_id,
                      caixa.unidade_id
                      FROM sys_transacao_caixa caixa
                      LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = caixa.transacao_caixa_pessoa_id
                      LEFT OUTER JOIN sys_conta_bancaria conta ON conta.conta_bancaria_id = caixa.transacao_conta_bancaria_id
                      LEFT OUTER JOIN sys_forma_pagamento forma  ON forma.forma_pagamento_id = caixa.transacao_caixa_forma
                      WHERE caixa.unidade_id  = {$_SESSION['userSYSFranquia']['unidade_padrao']} AND caixa.transacao_conta_bancaria_id = $conta_bancaria ORDER BY caixa.transacao_caixa_id DESC");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                	    "id" => $Result['transacao_caixa_id'],
                        "descricao" => $Result['transacao_caixa_descricao'],
                        "data" => $Result['transacao_caixa_data'],
                        "hora" => $Result['transacao_caixa_hora'],
                        "valor" => 'R$ ' . number_format($Result['transacao_caixa_valor'], 2, ',', '.'),
                        "conta" => $Result['conta_bancaria_nome'],
                        "tipo" => $Result['tipo'],
                        "pessoa" => $Result['pessoa_nome'],
                        "forma" => $Result['forma_pagamento_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_transacao_caixa&id={$Result["transacao_caixa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/cadastro_transacao_caixa&id={$Result["transacao_caixa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
    }
        break;
endswitch;