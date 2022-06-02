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

        $Read->FullRead("SELECT count(pessoa.pessoa_id) as alunos
            FROM sys_pessoas pessoa
            WHERE pessoa.pessoa_tipo_id = 4 
            AND pessoa.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "quantidade_aluno" => $Result['alunos']
                        
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;