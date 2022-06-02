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
         $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];

                $Read->FullRead("SELECT aluno.pessoa_nome,
                   (SELECT telefone.telefone FROM sys_telefones_pessoas telefone 
                     WHERE  telefone.pessoa_id = aluno.pessoa_id LIMIT 1) as telefone,
                   turma.projeto_descricao,
                   professor.pessoa_nome as professor,
                   estagio.estagio_produto_nome,
                   count(aulas.planejamento_id) as aulas_periodo,
                   sum(acompanhamento.presenca) as presencas_periodo,
                   count(aulas.planejamento_id) -  sum(acompanhamento.presenca) as faltas_periodo,
                   (((count(aulas.planejamento_id) -  sum(acompanhamento.presenca)) /  count(aulas.planejamento_id)) * 100) as porcentagem_falta,
                   
                   (SELECT ac.date FROM sys_acompanhamento_aula ac 
                       WHERE ac.presenca = 0 
                       AND ac.pessoa_id = aluno.pessoa_id
                       AND ac.projeto_id = turma.projeto_id
                       ORDER BY ac.date DESC LIMIT 1) as ultima_data_falta,
                       
                   (SELECT  ac.date FROM sys_acompanhamento_aula ac 
                       WHERE ac.presenca = 1 
                       AND ac.pessoa_id = aluno.pessoa_id
                       AND ac.projeto_id = turma.projeto_id
                       ORDER BY ac.date DESC LIMIT 1) as ultima_data_presenca,
                       
                   (SELECT count(acc.acompanhamento_id) FROM sys_acompanhamento_aula acc
                       WHERE acc.pessoa_id = aluno.pessoa_id
                       AND acc.projeto_id = turma.projeto_id
                       AND acc.presenca = 0)   as total_faltas,
                
                    (SELECT  (((count(plannn.planejamento_id) -  sum(acomp.presenca)) /  count(plannn.planejamento_id)) * 100) as porcentagem_falta 
                      FROM sys_planejamento plannn 
                      LEFT OUTER JOIN sys_acompanhamento_aula acomp ON acomp.projeto_id = plannn.planejamento_projeto_id
                      WHERE plannn.planejamento_projeto_id = turma.projeto_id
                      AND acomp.pessoa_id = aluno.pessoa_id
                     )  as porcentagem_faltas_totais  
                       
                   FROM sys_envolvidos_projeto alunos_turma
              LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = alunos_turma.envolvidos_envolvido_id
              LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = alunos_turma.envolvidos_projeto_projeto_id
              LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = turma.projeto_produto_id
              LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
              LEFT OUTER JOIN sys_planejamento aulas ON aulas.planejamento_projeto_id = turma.projeto_id
              LEFT OUTER JOIN sys_acompanhamento_aula acompanhamento ON acompanhamento.planejamento_id = aulas.planejamento_id
              WHERE turma.projeto_status = 0
              AND aulas.planejamento_status = 2
              AND acompanhamento.pessoa_id = aluno.pessoa_id
              AND acompanhamento.projeto_id = turma.projeto_id
              AND acompanhamento.date BETWEEN ('".$dataInicio."') AND ('".$dataFim."')
                          ", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
                if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "telefone" => $Result['telefone'],
                        "turma" => $Result['projeto_descricao'],
                        "professor" => $Result['professor'],
                        "aulasperiodo" => $Result['aulas_periodo'],
                        "faltasperiodo" => $Result['faltas_periodo'],
                        "porcentagem" => $Result['porcentagem_falta'],
                        "ultimafalta" => $Result['ultima_data_falta'],
                        "ultimapresenca" => $Result['ultima_data_presenca'],
                        "total" => $Result['total_faltas'],
                        "faltastotal" => $Result['porcentagem_faltas_totais'],
                   
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;