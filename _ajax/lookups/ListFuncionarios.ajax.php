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

        $Read->FullRead("SELECT pessoa.pessoa_id, pessoa.pessoa_nome, c.cargo_descricao FROM sys_pessoas pessoa 
                INNER JOIN sys_cargo AS c ON c.cargo_id = pessoa.pessoa_cargo_id
                WHERE pessoa.pessoa_tipo_id = 6 AND pessoa.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pessoa_id'],
                        "nome" => $Result['pessoa_nome'],
                        "cpf" => $Result['cargo_descricao']
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;