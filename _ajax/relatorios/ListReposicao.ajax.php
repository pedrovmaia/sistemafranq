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
                 reposicao.reposicao_id,
                 reposicao.reposicao_data,
                 reposicao.reposicao_atividades,
                 reposicao.reposicao_descricao,
                 reposicao.reposicao_hora_final,
                 reposicao.reposicao_hora_inicial,
                 reposicao.reposicao_materias,
                 reposicao.reposicao_pago,
                 reposicao.reposicao_status,
                 pessoas.pessoa_nome,
                 turmas.projeto_descricao,
                 modalidades.modalidade_nome,
                  CASE
                    WHEN reposicao.reposicao_pago = 0 THEN 'Não'
                    ELSE 'Sim'
                    END AS pago,
                   CASE
                    WHEN reposicao.reposicao_status = 0 THEN 'Aberto'
                    ELSE 'Fechado'
                    END AS status_reposicao   

                 FROM sys_reposicao reposicao
                 LEFT OUTER JOIN sys_pessoas pessoas ON pessoas.pessoa_id = reposicao.reposicao_pessoa_id
                 LEFT OUTER JOIN sys_projetos turmas ON turmas.projeto_id = reposicao.reposicao_projeto_id
                 LEFT OUTER JOIN sys_modalidades modalidades ON modalidades.modalidade_id = reposicao.reposicao_modalidade_id
                 WHERE reposicao.unidade_id  = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['reposicao_id'],
                        "turma" => $Result['projeto_descricao'],
                        "nome" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y', strtotime($Result['reposicao_data'])),
                        "descricao" => $Result['reposicao_descricao'],
                        "horai" => $Result['reposicao_hora_inicial'],
                        "horaf" => $Result['reposicao_hora_final'],
                        "materia" => $Result['reposicao_materias'],
                        "modalidade" => $Result['modalidade_nome'],
                        "atividade" => $Result['reposicao_atividades'],
                        "pago" => $Result['reposicao_pago'],
                
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
          }

        
        break;
endswitch;