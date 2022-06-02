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

        $Read->ExeRead("sys_transacao_caixa", "WHERE 1=1");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['transacao_caixa_id'],
                        "tipo" => $Result['transacao_caixa_tipo_id'],
                        "data" => date('d/m/Y', strtotime($Result['transacao_caixa_data'])),
                        "descricao" => $Result['transacao_caixa_descricao'],
                        "valor" => number_format($Result['transacao_caixa_valor'], 2, ',', '.'),
                       //"observacao" => $Result['transacao_caixa_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_transacao_caixa&id={$Result["transacao_caixa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;