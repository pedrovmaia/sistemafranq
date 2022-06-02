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

        $Read->FullRead("SELECT pessoa.pessoa_id,
            pessoa.pessoa_nome,
            tel.telefone
           FROM sys_pessoas pessoa
            LEFT OUTER JOIN sys_telefones_pessoas tel ON tel.pessoa_id = pessoa.pessoa_id
            WHERE pessoa.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} AND pessoa.pessoa_tipo_id = 8");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Prospeccao){

                array_push($arr, array(
                    "id" => $Prospeccao['pessoa_id'],
                    "nome" => $Prospeccao['pessoa_nome'],
                    "telefone" => $Prospeccao['telefone'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/ver_prospeccao&id={$Prospeccao["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/cadastro_prospeccao&id={$Prospeccao["pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='Crm/Prospeccao' action='delete' class='j_delete_action_confirm icon-warning btn btn-primary btn-link' id='{$Prospeccao["pessoa_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;