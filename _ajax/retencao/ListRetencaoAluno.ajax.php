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

        $Read->FullRead("SELECT ocorrencia.ocorrencia_retencao_id,
            ocorrencia.ocorrencia_retencao_descricao,
            DATE_FORMAT(ocorrencia.ocorrencia_retencao_data,'%d/%m/%Y') AS data,
            CASE
                    WHEN ocorrencia.ocorrencia_retencao_status = '0' THEN 'Aberto'
                    ELSE 'Resolvido'
                    END AS status,
            aluno.pessoa_nome as aluno_nome,
            funcionario.pessoa_nome as funcionario_nome
            FROM sys_ocorrencia_retencao_aluno ocorrencia
            LEFT OUTER JOIN sys_pessoas aluno on aluno.pessoa_id = ocorrencia.ocorrencia_retencao_aluno
            LEFT OUTER JOIN sys_pessoas funcionario on funcionario.pessoa_id = ocorrencia.ocorrencia_retencao_funcionario
            WHERE ocorrencia.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['ocorrencia_retencao_id'],
                        "status" => $Result['status'],
                        "data" => $Result['data'],
                        "aluno" => $Result['aluno_nome'],
                        "funcionario" => $Result['funcionario_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=retencao/ver_ocorrencia_retencao_aluno&id={$Result["ocorrencia_retencao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=retencao/cadastro_ocorrencia_retencao_aluno&id={$Result["ocorrencia_retencao_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='retencao/RetencaoAluno' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["ocorrencia_retencao_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>")
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;