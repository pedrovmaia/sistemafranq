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

        $Id = $PostData["pessoa_id"];

        $Read->FullRead("
               SELECT 
                     caixa.caixa_id,
                     DATE_FORMAT(caixa.caixa_data_abertura,'%d/%m/%Y') AS data_abertura ,
                     caixa.caixa_hora_abertura,
                     DATE_FORMAT(caixa.caixa_data_fechamento,'%d/%m/%Y') AS data_fechamento ,
                     caixa.caixa_hora_fechamento,
                     caixa.caixa_pessoa_id,
                     caixa.unidade_id,
                    CASE
                        WHEN caixa.caixa_status = 1 THEN 'Aberto'
                        WHEN caixa.caixa_status = 2 THEN 'Fechado'
                        WHEN caixa.caixa_status = 3 THEN 'Conferido'
                        END AS caixa_status

                            
                     FROM sys_caixa caixa
                     WHERE caixa.caixa_pessoa_id = :id
                     AND caixa.unidade_id =  :unidade 
                     ORDER BY caixa.caixa_id DESC  LIMIT 10 ", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['caixa_id'],
                        "data_abertura" => $Result['data_abertura'],
                        "hora_abertura" => $Result['caixa_hora_abertura'],
                        "data_fechamento" => $Result['data_fechamento'],
                        "hora_fechamento" => $Result['caixa_hora_fechamento'] ,
                        "caixa_status" => $Result['caixa_status'] ,
                        "acoes" => "<span class='td-actions'><a rel='tooltip' href='painel.php?exe=relatorios/list_transacao_caixa&id={$Result["caixa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a></span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;