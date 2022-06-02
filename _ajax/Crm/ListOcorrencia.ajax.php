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

            $Read->FullRead("SELECT P.pessoa_nome, O.ocorrencia_data, O.ocorrencia_descricao, O.ocorrencia_id, N.ocorrencias_natureza_nome FROM sys_ocorrencia AS O INNER JOIN sys_pessoas AS P on ocorrencia_atendente_id = pessoa_id INNER JOIN sys_ocorrencias_natureza AS N ON O.ocorrencia_natureza_id = N.ocorrencia_natureza_id WHERE O.ocorrencia_pessoa_id = :id AND O.unidade_id = :unidade", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "id" => $Result['ocorrencia_id'],
                            "data" => date('d/m/Y', strtotime($Result['ocorrencia_data'])),
                            "atendente" => $Result['pessoa_nome'],
                            "natureza" => $Result['ocorrencias_natureza_nome'],
                            "descricao" => $Result['ocorrencia_descricao'],
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/ver_ocorrencia&id={$Result["ocorrencia_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/cadastro_ocorrencia&id={$Result["ocorrencia_id"]}' title='Editar' class='btn btn-primary  btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . "</span>"
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        }
        break;
endswitch;