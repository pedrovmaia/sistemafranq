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

        $Read->FullRead("SELECT cidade.cidade_id,
            cidade.cidade_nome,
            estado.estado_nome
            FROM sys_cidades cidade
            LEFT OUTER JOIN sys_estados estado ON estado.estado_id = cidade.cidade_estado_id
            WHERE cidade.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
            ORDER BY cidade.cidade_estado_id ORDER BY cidade.cidade_nome");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['cidade_id'],
                        "nome" => $Result['cidade_nome'],
                        "estado" => $Result['estado_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/localizacao/ver_cidades&id={$Result["cidade_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/localizacao/cadastro_cidades&id={$Result["cidade_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='franqueador/Cidades' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["cidade_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;