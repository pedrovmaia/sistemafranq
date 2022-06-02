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

    $Read->FullRead("SELECT o.*, n.ocorrencias_natureza_nome FROM sys_ocorrencia AS o INNER JOIN sys_ocorrencias_natureza AS n ON n.ocorrencia_natureza_id = o.ocorrencia_natureza_id WHERE o.ocorrencia_encaminha_id = :id AND o.unidade_id = :unidade", "id={$_SESSION['userSYSFranquia']['pessoa_id']}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

    if($Read->getResult()){
        $manage['total'] = $Read->getRowCount();
        foreach ($Read->getResult() as $Result){
            array_push($arr, array(
                "id" => $Result['ocorrencia_id'],
                "data" => date('d/m/Y', strtotime($Result['ocorrencia_data'])),
                "natureza" => $Result['ocorrencias_natureza_nome'],
                "descricao" => $Result['ocorrencia_descricao'],
                "status" => ($Result['ocorrencia_status'] == 0 ? 'Novo' : ($Result['ocorrencia_status'] == 1 ? 'Resolvido' : ($Result['ocorrencia_status'] == 2 ? 'Cancelado' : 'Novo'))),
                "acoes" => "<span class='td-actions'><span rel='{$Result["ocorrencia_id"]}' href='#' title='Ver' class='btn btn-primary btn-link mr-1 j_abrir_modal_ocorrencia'><i class='material-icons'>visibility</i></span></span>"
            )
        );
        }
        $manage['rows'] = $arr;
        echo json_encode($manage);
    }
    break;
endswitch;