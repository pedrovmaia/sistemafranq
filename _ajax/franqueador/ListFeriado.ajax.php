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

        $Read->ExeRead("sys_feriado", "WHERE 1=1");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['feriado_id'],
                        "nome" => $Result['feriado_nome'],
                        "data" => date('d/m/Y', strtotime($Result['feriado_data'])),
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/dominios/ver_feriado&id={$Result["feriado_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/dominios/cadastro_feriado&id={$Result["feriado_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='franqueador/Feriado' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["feriado_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;