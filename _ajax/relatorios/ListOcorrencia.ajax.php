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

            $Read->FullRead("SELECT ocorrencia.ocorrencia_data,
                       ocorrencia.ocorrencia_descricao,
                       ocorrencia.ocorrencia_id,
                       atendente.pessoa_nome,
                       pessoa.pessoa_nome,
                       natureza.ocorrencias_natureza_nome
                 FROM sys_ocorrencia ocorrencia
                 LEFT OUTER JOIN sys_pessoas  atendente ON atendente.pessoa_id = ocorrencia.ocorrencia_atendente_id
                 LEFT OUTER JOIN sys_pessoas  pessoa ON pessoa.pessoa_id = ocorrencia.ocorrencia_pessoa_id
                 LEFT OUTER JOIN sys_ocorrencias_natureza  natureza ON natureza.ocorrencia_natureza_id = ocorrencia.ocorrencia_natureza_id
                 WHERE ocorrencia.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "id" => $Result['ocorrencia_id'],
                            "data" => date('d/m/Y H:i:s', strtotime($Result['ocorrencia_data'])),
                            "atendente" => $Result['pessoa_nome'],
                            "aluno" => $Result['pessoa_nome'],
                            "natureza" => $Result['ocorrencias_natureza_nome'],
                            "descricao" => $Result['ocorrencia_descricao'],
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/ver_ocorrencia&id={$Result["ocorrencia_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        
        break;
endswitch;