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

        $Read->FullRead("SELECT cancelamento.cancelamento_id,
                     turmas.projeto_descricao,
                     DATE_FORMAT(cancelamento.cancelamento_data, '%d/%m/%Y') AS cancelamento_data,
                     canc.motivo_cancelamento_nome,
                     funcionario.pessoa_nome as funcionario_nome,
                     aluno.pessoa_nome as aluno_nome,
                     cancelamento.unidade_id,
                     cancelamento.cancelamento_observacao
                FROM sys_cancelamento_projeto cancelamento
                LEFT OUTER JOIN sys_projetos turmas ON turmas.projeto_codigo = cancelamento_projeto_id
                LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = cancelamento.cancelamento_funcionario_id
                LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = cancelamento.cancelamento_aluno_id
                LEFT OUTER JOIN sys_motivos_cancelamento canc ON canc.motivo_cancelamento_id = cancelamento.cancelamento_id
                WHERE cancelamento.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
				");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Aluno){

                array_push($arr, array(
                    "id" => $Aluno['cancelamento_id'],
                    "turma" => $Aluno['projeto_descricao'],
                    "data" => $Aluno['cancelamento_data'],
                    "motivo" => $Aluno['motivo_cancelamento_nome'],
                    "funcionario" => $Aluno['funcionario_nome'],
                    "aluno" => $Aluno['aluno_nome'],
                    "observacao" => $Aluno['cancelamento_observacao'],                    
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Aluno["pessoa_id"]}' title='Ver' class='btn btn-primary  btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;