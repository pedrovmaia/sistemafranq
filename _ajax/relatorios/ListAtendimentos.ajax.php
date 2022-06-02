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

        $Read->FullRead("SELECT 
                     aluno.pessoa_nome,
                     count(atendimento.atendimento_id) as quantidade_atendimentos,
                     SUM(CASE 
                         WHEN atendimento.atendimento_status = 0  THEN 1
                         ELSE 0
                       END) AS quantidade_atendimento_pendente,
                     SUM(CASE 
                         WHEN atendimento.atendimento_status = 1  THEN 1
                         ELSE 0
                       END) AS quantidade_atendimento_concluido
                       
                     FROM sys_atendimentos atendimento
                     LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = atendimento.atendimento_pessoa_id
                     WHERE atendimento.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                     GROUP BY atendimento.atendimento_pessoa_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "aluno" => $Result['pessoa_nome'],
                        "concluidos" => $Result['quantidade_atendimento_concluido'],
                        "pendentes" => $Result['quantidade_atendimento_pendente'],
                        "todos" => $Result['quantidade_atendimentos'],

                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;