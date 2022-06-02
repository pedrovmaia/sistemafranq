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

        $Read->FullRead("SELECT contrato.contrato_id,
                    contrato.contrato_nome,
                    tipo.tipo_contrato_nome,
	                contrato.matricula_id
                    FROM sys_contratos contrato
                    LEFT OUTER JOIN sys_tipo_contratos tipo ON tipo.tipo_contrato_id = contrato.contrato_tipo_id AND contrato.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['contrato_id'],
                        "nome" => $Result['contrato_nome'],
                        "tipo" => $Result['tipo_contrato_nome'],
                        "matricula" => $Result['matricula_id'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=documentos/ver_contrato&id={$Result["contrato_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=documentos/cadastro_contrato&id={$Result["contrato_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='documentos/Contrato' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["contrato_id"]}'><i class='material-icons''>delete</i></span>" : '') . "<a href='painel.php?exe=documentos/previa_contrato&id={$Result[ "contrato_id"]}' rel='tooltip' title='Download' rel='single_user_addr' class='btn btn-success btn-link'><i class='material-icons'>cloud_download</i></a></span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;