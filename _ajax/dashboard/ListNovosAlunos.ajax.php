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

        $Read->FullRead("SELECT pessoa.pessoa_id, pessoa.pessoa_nome, pessoa.pessoa_cpf 
                FROM sys_pessoas pessoa 
                WHERE pessoa.pessoa_tipo_id = 4 AND pessoa.unidade_id = :unidade LIMIT 10", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pessoa_id'],
                        "nome" => $Result['pessoa_nome'],
                        "cpf" => $Result['pessoa_cpf'],
                        "acoes" => "<span class='td-actions'><a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Result["pessoa_id"]}' title='Ver' class='btn btn-primary  btn-link mr-1'><i class='material-icons'>visibility</i></a></span>"
                        
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;