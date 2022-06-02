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

        $Read->FullRead("SELECT 
                         caixa.caixa_id,
                         funcionario.pessoa_nome,
                         DATE_FORMAT(caixa.caixa_data_conferencia, '%d/%m/%Y') AS data_conferencia,
                         DATE_FORMAT(caixa.caixa_data_abertura,'%d/%m/%Y') AS data_abertura ,
                         caixa.caixa_hora_abertura,
                         DATE_FORMAT(caixa.caixa_data_fechamento,'%d/%m/%Y') AS data_fechamento ,
                         caixa.caixa_hora_fechamento,
                         caixa.unidade_id,
                        CASE
                            WHEN caixa.caixa_status = 1 THEN 'Aberto'
                            WHEN caixa.caixa_status = 2 THEN 'Fechado'
                            WHEN caixa.caixa_status = 3 THEN 'Conferido'
                            END AS caixa_status
                            
                         FROM sys_caixa caixa
                         LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = caixa.caixa_pessoa_id
                         WHERE caixa.unidade_id =  1
                         AND (caixa.caixa_status = 2
                         || caixa.caixa_status = 3)
                         ORDER BY caixa.caixa_id DESC
				");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                	    "id" => $Result['caixa_id'],
                        "financeiro" => $Result['pessoa_nome'],
                        "dataa" => $Result['data_abertura'],
                        "dataf" => $Result['data_fechamento'],
                        "horaf" => $Result['caixa_hora_fechamento'],
                        "status" => $Result['caixa_status'],
                        "datac" => $Result['data_conferencia'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_caixa_conferencia&id={$Result["caixa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;