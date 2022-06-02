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

        $Read->FullRead("SELECT pessoa.pessoa_id, pessoa.pessoa_nome FROM sys_pessoas pessoa WHERE pessoa.pessoa_tipo_id = 7 
AND NOT EXISTS (SELECT * FROM sys_unidades WHERE sys_unidades.franquia_id = pessoa.pessoa_id )");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pessoa_id'],
                        "nome" => $Result['pessoa_nome']
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;