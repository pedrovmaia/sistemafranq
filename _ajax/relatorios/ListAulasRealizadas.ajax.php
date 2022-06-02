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
                 turma.projeto_descricao,
                 professor.pessoa_nome,
                 count(planejamento.planejamento_id) as aulas
                 FROM sys_projetos turma
                 LEFT OUTER JOIN sys_planejamento planejamento ON planejamento.planejamento_projeto_id = turma.projeto_id
                 LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
                 WHERE planejamento.planejamento_status = 2
                 AND turma.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                 GROUP BY turma.projeto_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "descricao" => $Result['projeto_descricao'],
                        "professor" => $Result['pessoa_nome'],
                        "aulas" => $Result['aulas'],
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;