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
    $PDF = new PDF;
endif;

switch ($action):

    case 'list':

        $arr = array();

        $Read->FullRead("SELECT projeto.projeto_descricao,
            pessoas.pessoa_nome,
            grade.projeto_grade_carga_dia, 
            dia.nome

            FROM sys_projetos AS projeto 

            INNER JOIN sys_envolvidos_projeto AS alunos 

            LEFT OUTER JOIN sys_projeto_grade AS grade ON grade.projeto_grade_projeto_id = projeto.projeto_id

            LEFT OUTER JOIN sys_dia_semana AS dia ON grade.projeto_grade_carga_dia = dia.dia_semana_id

            LEFT OUTER JOIN sys_pessoas AS pessoas ON alunos.envolvidos_envolvido_id = pessoas.pessoa_id

            WHERE projeto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} ORDER BY dia.dia_semana_id, grade.projeto_grade_carga_hora_inicial");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

             foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "dia" => $Result['nome'],
                        "turma" => $Result['projeto_descricao'],
                        "aluno" => $Result['pessoa_nome']
                    )
                );
            }

            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'filtro':

        $arr = array();
        $tipo = 'TurmasAlunos';

        //cria o nome do arquivo PDF
        $arquivo = $_SESSION['userSYSFranquia']['unidade_padrao'].'_'.rand(1,9999).'_'.time().'.pdf';

        $Read->FullRead("SELECT projeto.projeto_descricao,
            pessoas.pessoa_nome,
            grade.projeto_grade_carga_dia, 
            dia.nome,
            grade.projeto_grade_carga_hora_inicial,
            grade.projeto_grade_carga_hora_final,
            sala.sala_nome

            FROM sys_projetos AS projeto            

            LEFT OUTER JOIN sys_projeto_grade AS grade ON grade.projeto_grade_projeto_id = projeto.projeto_id

            LEFT OUTER JOIN sys_dia_semana AS dia ON grade.projeto_grade_carga_dia = dia.dia_semana_id

            LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id

            LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id

            WHERE projeto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} ORDER BY pessoas.pessoa_nome, dia.dia_semana_id, grade.projeto_grade_carga_hora_inicial");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

            foreach ($Read->getResult() as $Result){           
                array_push($arr, array(
                        "dia" => $Result['nome'],
                        "turma" => $Result['projeto_descricao'],
                        "dia" => $Result['nome'],
                        "sala" => $Result['sala_nome']
                    )
                );
            }

            $PDF->geraPDFTurmasProfessor($arr, $arquivo, $tipo);

            $manage['arquivo'] = BASE.'/_ajax/relatorios/'.$arquivo;

            $manage['rows'] = $arr;
            echo json_encode($manage);
        }        
    break;
endswitch;