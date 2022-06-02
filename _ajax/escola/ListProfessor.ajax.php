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

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_cargo_id = 1");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Professor){

                array_push($arr, array(
                    "id" => $Professor['pessoa_id'],
                    "nome" => $Professor['pessoa_nome'],
                    "nome" => $Professor['pessoa_apelido'],
                    "e-mail" => $Professor['pessoa_email'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/ver_professor&id={$Professor["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/cadastro_professor&id={$Professor["pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Professor' action='delete' class='j_delete_action_confirm icon-warning btn btn-primary btn-link' id='{$Professor["pessoa_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;