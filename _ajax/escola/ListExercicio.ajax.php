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

    $Id = $PostData["id"];
        if($Id){

        $arr = array();

        $Read->FullRead("SELECT exercicio.exercicio_id,
            exercicio.exercicio_nome,
            exercicio.exercicio_codigo,
            CASE
             WHEN exercicio.exercicio_tipo = '0' THEN 'Speaking'
                    ELSE 'Listening'
                    END AS tipo
            FROM sys_escola_exercicios exercicio
            LEFT OUTER JOIN sys_estagio_produto estagio ON exercicio.exercicio_estagio_id = estagio.estagio_produto_id
               WHERE exercicio.unidade_id = :unidade
               AND exercicio.exercicio_estagio_id = :id",  "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['exercicio_id'],
                        "nome" => $Result['exercicio_nome'],
                        "codigo" => $Result['exercicio_codigo'],
                        "tipo" => $Result['tipo'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/avaliacao/ver_exercicio&id={$Result["exercicio_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/avaliacao/cadastro_exercicio&id={$Result["exercicio_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Exercicio' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["exercicio_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;