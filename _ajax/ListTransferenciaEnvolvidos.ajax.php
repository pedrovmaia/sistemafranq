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

        $Read->FullRead("SELECT  transferencia.transferencia_id,
                transferencia.transferencia_projeto_origem_data, 
                transferencia.transferencia_projeto_destino_data,
                 CASE
                    WHEN transferencia.transferencia_status = '0' THEN 'Nova'
                    ELSE 'Transferência Realizada'
                    END AS status,
                                aluno.pessoa_nome AS aluno,
                funcionarioo.pessoa_nome AS funcionaro_origem,
                funcionariod.pessoa_nome AS funcionario_destino,
                origem.projeto_descricao AS turma_origem,
                destino.projeto_descricao AS turma_destino
            FROM sys_transferencia_envolvidos_projeto transferencia
            LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = transferencia.transferencia_pessoa_id
            LEFT OUTER JOIN sys_pessoas funcionarioo ON funcionarioo.pessoa_id = transferencia.transferencia_projeto_origem_funcionario_id
            LEFT OUTER JOIN sys_pessoas funcionariod ON funcionariod.pessoa_id = transferencia.transferencia_projeto_destino_funcionario_id
            LEFT OUTER JOIN sys_projetos origem ON origem.projeto_id = transferencia.transferencia_projeto_origem
            LEFT OUTER JOIN sys_projetos destino ON destino.projeto_id = transferencia.transferencia_projeto_destino
            WHERE transferencia.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
            GROUP BY transferencia.transferencia_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['transferencia_id'],
                        "datao" => $Result['transferencia_projeto_origem_data'],
                        "datad" => $Result['transferencia_projeto_destino_data'],
                        "aluno" => $Result['aluno'],
                        "funcionaro_origem" => $Result['funcionaro_origem'],
                        "funcionario_destino" => $Result['funcionario_destino'],
                        "turma_origem" => $Result['turma_origem'],
                        "turma_destino" => $Result['turma_destino'],
                        "status" => $Result['status']
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;