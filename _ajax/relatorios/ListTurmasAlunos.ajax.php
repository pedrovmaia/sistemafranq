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
            dia.nome,
            grade.projeto_grade_carga_hora_inicial,
            grade.projeto_grade_carga_hora_final,
            sala.sala_nome

            FROM sys_projetos AS projeto, 
            sys_pessoas AS pessoas, 
            sys_envolvidos_projeto AS alunos,
            sys_projeto_grade AS grade,
            sys_dia_semana AS dia,
            sys_sala AS sala

            WHERE projeto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND pessoas.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND alunos.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND grade.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 

            AND grade.projeto_grade_projeto_id = projeto.projeto_id
            AND alunos.envolvidos_envolvido_id = pessoas.pessoa_id 
            AND grade.projeto_grade_carga_dia = dia.dia_semana_id 
            AND projeto.projeto_sala_id = sala.sala_id 
            GROUP BY dia.dia_semana_id, grade.projeto_grade_carga_hora_inicial, pessoas.pessoa_nome, sala.sala_nome, pessoas.pessoa_nome, pessoas.pessoa_nome");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

             foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "dia" => $Result['nome'],
                        "turma" => $Result['projeto_descricao'],
                        "sala" => $Result['sala_nome'],
                        "aluno" => $Result['pessoa_nome'],
                        "hora_inicio" => $Result['projeto_grade_carga_hora_inicial'],
                        "hora_final" => $Result['projeto_grade_carga_hora_final']
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

        $Read->FullRead("SELECT projeto.projeto_descricao, projeto.projeto_id,
            pessoas.pessoa_nome,
            grade.projeto_grade_carga_dia, 
            dia.nome,
            grade.projeto_grade_carga_hora_inicial,
            grade.projeto_grade_carga_hora_final,
            sala.sala_nome

            FROM sys_projetos AS projeto, 
            sys_pessoas AS pessoas, 
            sys_envolvidos_projeto AS alunos,
            sys_projeto_grade AS grade,
            sys_dia_semana AS dia,
            sys_sala AS sala

            WHERE projeto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND pessoas.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND alunos.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND grade.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
            AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 

            AND grade.projeto_grade_projeto_id = projeto.projeto_id
            AND alunos.envolvidos_envolvido_id = pessoas.pessoa_id 
            AND grade.projeto_grade_carga_dia = dia.dia_semana_id 
            AND projeto.projeto_sala_id = sala.sala_id 
            GROUP BY dia.dia_semana_id, grade.projeto_grade_carga_hora_inicial, pessoas.pessoa_nome, sala.sala_nome, pessoas.pessoa_nome, pessoas.pessoa_nome");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

             foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "dia" => $Result['nome'],
                        "turma" => $Result['projeto_descricao'],
                        "sala" => $Result['sala_nome'],
                        "aluno" => $Result['pessoa_nome'],
                        "hora_inicio" => $Result['projeto_grade_carga_hora_inicial'],
                        "hora_final" => $Result['projeto_grade_carga_hora_final']
                    )
                );
            }

            $PDF->geraPDF($arr, $arquivo, $tipo);

            $manage['arquivo'] = BASE.'/_ajax/relatorios/'.$arquivo;

            $manage['rows'] = $arr;
            echo json_encode($manage);
        }        
    break;
endswitch;