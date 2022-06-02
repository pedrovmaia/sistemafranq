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

          $Read->FullRead("SELECT envio.envio_id,
            envio.envio_observacao,
            envio.envio_data_inclusao,
            envio.envio_data_retirada,
            envio.envio_pessoa_id,
            pessoa.pessoa_nome
            FROM sys_envio_scpc envio
            LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = envio.envio_pessoa_id
             WHERE envio.envio_pessoa_id = :id AND envio.unidade_id = :unidade", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){

            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){


                array_push($arr, array(
                        "id" => $Result['envio_id'],
                        "pessoa" => $Result['pessoa_nome'],
                        "datainclusao" => date('d/m/Y', strtotime($Result['envio_data_inclusao'])),
                        "dataretirada" => date('d/m/Y', strtotime($Result['envio_data_retirada'])),
                        "observacao" => $Result['envio_observacao'],                    
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contasreceber/ver_envio_scpc&id={$Result["envio_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contasreceber/cadastro_envio_scpc&id={$Result["envio_id"]}&idpessoa={$Result["envio_pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='financeiro/EnvioScpc' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["envio_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
         }
        }
        break;
endswitch;