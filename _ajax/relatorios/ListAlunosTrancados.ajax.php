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

        $Read->FullRead("SELECT trancamento.trancamento_id,
					 turmas.projeto_descricao,
				     DATE_FORMAT(trancamento.trancamento_data, '%d/%m/%Y') AS trancamento_data,
				     DATE_FORMAT(trancamento.trancamento_data_prevista_reintegracao, '%d/%m/%Y') AS trancamento_data_prevista_reintegracao,
				     DATE_FORMAT(trancamento.trancamento_reintegracao, '%d/%m/%Y') AS trancamento_reintegracao,
				     tranc.motivo_tranc_matricula_nome,
				     funcionario.pessoa_nome as funcionario_nome,
				     aluno.pessoa_nome as aluno_nome,
				     trancamento.unidade_id,
				     trancamento.trancamento_observacao
				FROM sys_trancamento_projeto trancamento
				LEFT OUTER JOIN sys_projetos turmas ON turmas.projeto_codigo = trancamento_projeto_id
				LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = trancamento.trancamento_funcionario_id
				LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = trancamento.trancamento_aluno_id
				LEFT OUTER JOIN sys_motivo_tranc_matricula tranc ON tranc.motivo_tranc_matricula_id = trancamento.trancamento_id
				WHERE trancamento.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
				");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Aluno){

                array_push($arr, array(
                    "id" => $Aluno['trancamento_id'],
                    "turma" => $Aluno['projeto_descricao'],
                    "data" => $Aluno['trancamento_data'],
                    "datar" => $Aluno['trancamento_data_prevista_reintegracao'],
                    "reintegracao" => $Aluno['trancamento_reintegracao'],
                    "motivo" => $Aluno['motivo_tranc_matricula_nome'],
                    "funcionario" => $Aluno['funcionario_nome'],
                    "aluno" => $Aluno['aluno_nome'],
                    "observacao" => $Aluno['trancamento_observacao'],                    
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Aluno["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;