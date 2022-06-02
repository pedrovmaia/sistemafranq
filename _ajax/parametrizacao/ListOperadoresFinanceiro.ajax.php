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

        $Read->FullRead("SELECT operador.operador_id,
            pessoa.pessoa_nome
            FROM sys_operadores_financeiro operador
            LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = operador.pessoa_id
            WHERE operador.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['operador_id'],
                        "nome" => $Result['pessoa_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=parametrizacao/cadastro_operadores_financeiro&id={$Result["operador_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='parametrizacao/OperadoresFinanceiro' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["operador_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;