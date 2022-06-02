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

        $arr = array();

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 6");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Colaborador){

                array_push($arr, array(
                    "id" => $Colaborador['pessoa_id'],
                    "nome" => $Colaborador['pessoa_nome'],
                    "e-mail" => $Colaborador['pessoa_email'],
                    "cpf" => $Colaborador['pessoa_cpf'],
                    "rg" => $Colaborador['pessoa_rg'],
                    "nascimento" => date('d/m/Y', strtotime($Colaborador['pessoa_nascimento'])),
                    "profissao" => $Colaborador['pessoa_profissao'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=rh/colaborador/ver_colaborador&id={$Colaborador["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=rh/colaborador/cadastro_colaborador&id={$Colaborador["pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='rh/Colaborador' action='delete' class='j_delete_action_confirm icon-warning btn btn-primary btn-link' id='{$Colaborador["pessoa_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;