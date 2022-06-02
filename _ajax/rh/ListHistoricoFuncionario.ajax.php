<?php

session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'list':
 
        $Id = $PostData["id"];
        if($Id){

        $arr = array();

        $Read->ExeRead("sys_historicos_pessoa", "WHERE  historico_pessoa_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['historico_id'],
                        "descricao" => $Result['historico_descricao'],
                        "franquia" => $Result['historico_franquia_id'],
                        "data" => $Result['historico_data'],
                        "tipo" => $Result['historico_tipo_id'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=rh/colaborador/ver_historico_funcionario&id={$Result["historico_id"]}' title='Ver' class='btn btn-primary  btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=rh/colaborador/cadastro_historico_funcionario&id={$Result["historico_id"]}' title='Editar' class='btn btn-warning   btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='rh/HistoricoFuncionario' action='delete' class='j_delete_action_confirm btn btn-danger  btn-link' id='{$Result["historico_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;