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

                $Read->FullRead("SELECT 
                 DATE_FORMAT(movimentacao.movimentacao_data,'%d/%m/%Y') AS data_inscricao ,
                 aluno.pessoa_nome as aluno,
                 turma.projeto_descricao,
                 professor.pessoa_nome as professor,
                 estagio.estagio_produto_nome,
                 modalidades.modalidade_nome,
                 movimentacao.movimentacao_id as numero_inscricao
                 from sys_envolvidos_projeto alunos_turma
                 LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = alunos_turma.envolvidos_envolvido_id
                 LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = alunos_turma.envolvidos_projeto_projeto_id
                 LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
                 LEFT OUTER JOIN sys_movimentacao movimentacao ON movimentacao.movimentacao_id = alunos_turma.envolvidos_movimentacao_id
                 LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = turma.projeto_produto_id
                 LEFT OUTER JOIN sys_modalidades modalidades ON modalidades.modalidade_id = turma.projeto_modalidade_id
                 WHERE (movimentacao.movimentacao_data BETWEEN '2019-01-01' AND '2019-06-14')
                 AND turma.unidade_id ={$_SESSION['userSYSFranquia']['unidade_padrao']}");
                if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "data" => $Result['data_inscricao'],
                        "aluno" => $Result['aluno'],
                        "turma" => $Result['projeto_descricao'],
                        "professor" => $Result['professor'],
                        "estagio" => $Result['estagio_produto_nome'],
                        "modalidade" => $Result['modalidade_nome'],
                        "numero" => $Result['numero_inscricao'],
                   

                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;