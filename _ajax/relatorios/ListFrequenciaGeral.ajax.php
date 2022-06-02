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
               estagio.estagio_produto_nome,
                 turma.projeto_descricao,
                 professor.pessoa_nome as professor,
                 (SELECT telefone.telefone FROM sys_telefones_pessoas telefone 
                   WHERE  telefone.pessoa_id = aluno.pessoa_id LIMIT 1) as telefone,
                 count(aulas.planejamento_id) as aulas_dadas,
                 sum(acompanhamento.presenca) as presencas_periodo,
                 (((sum(acompanhamento.presenca)) /  count(aulas.planejamento_id)) * 100) as porcentagem_presenca,
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
                     ORDER BY ac.date DESC LIMIT 1) as ultima_data_presenca
                     
                 FROM sys_envolvidos_projeto alunos_turma
            LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = alunos_turma.envolvidos_envolvido_id
            LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = alunos_turma.envolvidos_projeto_projeto_id
            LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = turma.projeto_produto_id
            LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
            LEFT OUTER JOIN sys_planejamento aulas ON aulas.planejamento_projeto_id = turma.projeto_id
            LEFT OUTER JOIN sys_acompanhamento_aula acompanhamento ON acompanhamento.planejamento_id = aulas.planejamento_id
            WHERE turma.projeto_status = 0
            AND aulas.planejamento_status = 2
            AND acompanhamento.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
            AND acompanhamento.pessoa_id = aluno.pessoa_id
            AND acompanhamento.projeto_id = turma.projeto_id
            AND acompanhamento.date BETWEEN ('".$dataInicio."') AND ('".$dataFim."')");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){
                    if($Result["aulas_dadas"] != 0){

                    array_push($arr, array(
                            "pessoa" => $Result['pessoa_nome'],
                            "estagio" => $Result['estagio_produto_nome'],
                            "professor" => $Result['professor'],
                            "telefone" => $Result['telefone'],
                            "aulasdadas" => $Result['aulas_dadas'],
                            "presenca" => $Result['presencas_periodo'],
                            "porcentagem" => $Result['porcentagem_presenca'],
                            "faltas" => $Result['faltas_periodo'],
                            "porcentagemfalta" => $Result['porcentagem_falta'],
                            "ultimafata" => $Result['ultima_data_falta'],
                            "ultimapresenca" => $Result['ultima_data_presenca'],


                            
                        )
                    );
                }
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        
        break;
endswitch;                                              