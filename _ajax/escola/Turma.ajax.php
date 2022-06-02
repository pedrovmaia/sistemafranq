<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
    $trigger = new Trigger;
endif;

if (isset($PostData['quantidade_horarios'])):
    $quantidade_horarios = $PostData['quantidade_horarios'];
    unset($PostData['quantidade_horarios']);
endif;

if (isset($PostData['quantidade_alunos'])):
    $quantidade_alunos = $PostData['quantidade_alunos'];
    unset($PostData['quantidade_alunos']);
endif;

if (isset($PostData['quantidade_avaliacoes'])):
    $quantidade_avaliacoes = $PostData['quantidade_avaliacoes'];
    unset($PostData['quantidade_avaliacoes']);
endif;

if (isset($PostData['quantidade_homework'])):
    $quantidade_homework = $PostData['quantidade_homework'];
    unset($PostData['quantidade_homework']);
endif;

if (isset($PostData['quantidade_exercicios'])):
    $quantidade_exercicios = $PostData['quantidade_exercicios'];
    unset($PostData['quantidade_exercicios']);
endif;
if (isset($PostData['quantidade_materias'])):
    $quantidade_materias = $PostData['quantidade_materias'];
    unset($PostData['quantidade_materias']);
endif;

switch ($action):

    case 'buscarModalidadeGrade':

        $Id = $PostData['modalidade'];
        unset($PostData['modalidade']);

        $Read->ExeRead("sys_carga_horaria_cursos", "WHERE modalidade_id = :id", "id={$Id}");
        if($Read->getResult()){
            $select = "";
            foreach ($Read->getResult() as $Horario) {
                $select .= "<option value='".$Horario['carga_horas']."'>".$Horario['carga_horas']."</option>";
            }
            $jSON['success'] = $select;

        } else {
            $jSON['error'] = "true";
        }

        break;

    case 'acompanhamento_aula':

        if($quantidade_materias == "" || $quantidade_materias == 0 || $quantidade_materias == null){
            $jSON['error'] = 'Preencha as materias realizadas!';
            echo json_encode($jSON);
            die;
        }

        if(empty($PostData['etapa'])){
            $jSON['error'] = 'Ops, etapa está vazia, tente novamente!';
            echo json_encode($jSON);
            die;
        }

        if(empty($PostData['materias_da_aula'])){
            $jSON['error'] = 'Preencha as materias realizadas!';
            echo json_encode($jSON);
            die;
        }

        if($quantidade_alunos){
            $ArrAvaliacao = [];
            $ArrHomeWork = [];
            $ArrExercicio = [];
            $ArrMaterias = [];

            for($i = 0; $i < $quantidade_alunos; $i++){

                $ArrPresenca = [];

                if($PostData["aluno_" . $i]){

                    if(isset($PostData['check_' . $i])) {
                        $presenca = 1;
                    } else {
                        $presenca = 0;
                    }

                    $ArrPresenca[] = Array(
                        'projeto_id' => $PostData['txt_id_turma'],
                        'planejamento_id' => $PostData['planejamento'],
                        'pessoa_id' => $PostData["aluno_" . $i],
                        'presenca' => $presenca,
                        'date' => date("Y-m-d H:i:s"),
                        'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        'etapa' => $PostData['etapa'],
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                    );

                    $Create->ExeCreateMulti("sys_acompanhamento_aula", $ArrPresenca);
                    $AcompanhamentoID = $Create->getResult();

                    for($j = 0; $j < $quantidade_avaliacoes; $j++){

                        if(isset($PostData['avaliacao_'.$i.'_nota_' . $j])) {
                            $avaliacaoID = $PostData['aluno_'.$i.'_avaliacao_' . $j];
                            $notaAvaliacao = $PostData['avaliacao_'.$i.'_nota_' . $j];
                        } else {
                            $avaliacaoID = null;
                            $notaAvaliacao = 0;
                        }

                        $ArrAvaliacao[] = Array(
                            'projeto_id' => $PostData['txt_id_turma'],
                            'planejamento_id' => $PostData['planejamento'],
                            'pessoa_id' => $PostData["aluno_" . $i],
                            'avaliacao_id' => $avaliacaoID,
                            'nota' => $notaAvaliacao,
                            'date' => date("Y-m-d H:i:s"),
                            'acompanhamento_id' => $AcompanhamentoID,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'etapa' => $PostData['etapa'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                    for($j = 0; $j < $quantidade_homework; $j++){

                        if(isset($PostData['homework_'.$i.'_nota_' . $j])) {
                            $homeworkID = $PostData['aluno_'.$i.'_homework_' . $j];
                            $notaHomework = $PostData['homework_'.$i.'_nota_' . $j];
                        } else {
                            $homeworkID = $PostData['aluno_'.$i.'_homework_' . $j];
                            $notaHomework = 0;
                        }

                        $ArrHomeWork[] = Array(
                            'projeto_id' => $PostData['txt_id_turma'],
                            'planejamento_id' => $PostData['planejamento'],
                            'pessoa_id' => $PostData["aluno_" . $i],
                            'homework_id' => $homeworkID,
                            'nota' => $notaHomework,
                            'date' => date("Y-m-d H:i:s"),
                            'acompanhamento_id' => $AcompanhamentoID,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'etapa' => $PostData['etapa'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                    for($j = 0; $j < $quantidade_exercicios; $j++){

                        if(isset($PostData['exercicios_'.$i.'_nota_' . $j])) {
                            $exercicioID = $PostData['aluno_'.$i.'_exercicios_' . $j];
                            $notaExercicio = $PostData['exercicios_'.$i.'_nota_' . $j];
                        } else {
                            $exercicioID = $PostData['aluno_'.$i.'_exercicios_' . $j];
                            $notaExercicio = 0;
                        }

                        $ArrExercicio[] = Array(
                            'projeto_id' => $PostData['txt_id_turma'],
                            'planejamento_id' => $PostData['planejamento'],
                            'pessoa_id' => $PostData["aluno_" . $i],
                            'exercicio_id' => $exercicioID,
                            'nota' => $notaExercicio,
                            'date' => date("Y-m-d H:i:s"),
                            'acompanhamento_id' => $AcompanhamentoID,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'etapa' => $PostData['etapa'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                }
            }

            for($j = 0; $j < $quantidade_materias; $j++){

                if(isset($PostData['materia_check_' . $j])) {
                    $materiaID = $PostData['materia_check_' . $j];

                    $ArrMaterias[] = Array(
                        'projeto_id' => $PostData['txt_id_turma'],
                        'planejamento_id' => $PostData['planejamento'],
                        'materia_id' => $materiaID,
                        'date' => date("Y-m-d H:i:s"),
                        'acompanhamento_id' => $AcompanhamentoID,
                        'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        'etapa' => $PostData['etapa'],
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                    );
                }

            }

            $Create->ExeCreateMulti("sys_acompanhamento_aula_materias", $ArrMaterias);

            $Create->ExeCreateMulti("sys_acompanhamento_aula_avaliacoes", $ArrAvaliacao);
            $Create->ExeCreateMulti("sys_acompanhamento_aula_homework", $ArrHomeWork);
            $Create->ExeCreateMulti("sys_acompanhamento_aula_exercicios", $ArrExercicio);

            $UpdateHorario['planejamento_status'] =  2;
            $UpdateHorario['planejamento_descricao'] = "Aula Realizada";
            $Update->ExeUpdate("sys_planejamento", $UpdateHorario, "WHERE planejamento_id = :id", "id={$PostData['planejamento']}");

            $CreateAtivi = [
                "acompanhamento_ativ_planejamento_id" => $PostData['planejamento'],
                "acompanhamento_ativ_atividade_realizada" => $PostData['materias_da_aula']
            ];
            $Create->ExeCreate("sys_acompanhamento_aula_atividades", $CreateAtivi);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/turma/acompanhamento_aula";

        }

        break;

    case 'buscarListaAssinaturaTurma':

        $Read->FullRead("SELECT t.projeto_descricao, t.projeto_observacao, s.sala_nome, p.produto_nome, 
            m.modalidade_nome, pe.pessoa_nome, ds.nome, pg.projeto_grade_carga_hora_inicial, 
            pg.projeto_grade_carga_hora_final FROM sys_projetos AS t 
            INNER JOIN sys_sala AS s ON t.projeto_sala_id = s.sala_id
            INNER JOIN sys_produto AS p ON t.projeto_produto_id = p.produto_id
            INNER JOIN sys_modalidades AS m ON t.projeto_modalidade_id = m.modalidade_id
            INNER JOIN sys_pessoas AS pe ON t.projeto_gerente_id = pe.pessoa_id
            INNER JOIN sys_projeto_grade AS pg ON t.projeto_id = pg.projeto_grade_projeto_id
            INNER JOIN sys_dia_semana AS ds ON pg.projeto_grade_carga_dia = ds.dia_semana_id
            WHERE t.projeto_id = :id AND t.unidade_id = :unidade", "id={$PostData['projeto_id']}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){

            $quantidade = $Read->getRowCount();

            $jSON['table_3'] = "<tr class='table_3_body'><td>{$Read->getResult()[0]["sala_nome"]}</td><td>{$Read->getResult()[0]["pessoa_nome"]}</td></tr>";

            if($quantidade == 1){
                $jSON['table_1'] = "<tr class='table_1_body'><td>{$Read->getResult()[0]["projeto_descricao"]} " . substr(strtoupper($Read->getResult()[0]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_final'])) . "</td><td>{$Read->getResult()[0]["produto_nome"]} - {$Read->getResult()[0]["projeto_descricao"]}</td></tr>";

                $jSON['table_2'] = "<tr class='table_2_body'><td>" . substr(strtoupper($Read->getResult()[0]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_final'])) . "</td><td>{$Read->getResult()[0]["modalidade_nome"]}</td></tr>";

            } elseif ($quantidade == 2) {
                $jSON['table_1'] = "<tr class='table_1_body'><td>{$Read->getResult()[0]["projeto_descricao"]} " . substr(strtoupper($Read->getResult()[0]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_final'])) . " " . substr(strtoupper($Read->getResult()[1]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[1]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[1]['projeto_grade_carga_hora_final'])) . "</td><td>{$Read->getResult()[0]["produto_nome"]} - {$Read->getResult()[0]["projeto_descricao"]}</td></tr>";

                $jSON['table_2'] = "<tr class='table_2_body'><td>" . substr(strtoupper($Read->getResult()[0]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[0]['projeto_grade_carga_hora_final'])) . " " . substr(strtoupper($Read->getResult()[1]['nome']), 0, 3) . " " . date("H:i", strtotime($Read->getResult()[1]['projeto_grade_carga_hora_inicial'])) . "/" . date("H:i", strtotime($Read->getResult()[1]['projeto_grade_carga_hora_final'])) . "</td><td>{$Read->getResult()[0]["modalidade_nome"]}</td></tr>";

            }

        } else {
            $jSON['error'] = 'Não encontrado!';
        }


        $Read->FullRead("SELECT p.pessoa_nome, p.pessoa_id, p.pessoa_email FROM sys_envolvidos_projeto AS e INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id WHERE e.envolvidos_projeto_projeto_id = :id AND e.unidade_id = :unidade", "id={$PostData['projeto_id']}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){

            $quantidade = $Read->getRowCount();
            $tabela = "";
            $i = 1;
            foreach ($Read->getResult() as $Aluno) {

                $tabela .= "<tr class='table_4_body'><td>{$i}</td><td>{$Aluno['pessoa_id']}</td><td>{$Aluno['pessoa_nome']}</td><td></td></tr>";

                $i++;
            }

            if($i < 10){
                for ($j = $i; $j <= 10; $j++) {
                    $tabela .= "<tr class='table_4_body'><td>{$j}</td><td></td><td></td><td></td>";
                }
            }

            $jSON['success'] = $tabela;
        } else {
            $jSON['error'] = 'Planejamento não encontrado!';
        }

        break;

    case 'buscarPanejamentoTurma':
        $Read->ExeRead("sys_planejamento", "WHERE planejamento_data <= NOW() AND planejamento_status = 0 AND planejamento_projeto_id = :id", "id={$PostData['projeto_id']}");
        if($Read->getResult()){
            $tabela = "";
            foreach ($Read->getResult() as $Planejamento) {
                $tabela .= "<tr class='list_planejamentos'><td>".date("d/m/Y", strtotime($Planejamento['planejamento_data']))."</td><td>{$Planejamento['planejamento_descricao']}</td><td>".date("H:i", strtotime($Planejamento['planejamento_hora_inicial']))."</td><td>".date("H:i", strtotime($Planejamento['planejamento_hora_final']))."</td><td class='td-actions text-left'><button type='button'data-id-turma='{$Planejamento['planejamento_projeto_id']}' data-id-plano='{$Planejamento['planejamento_id']}' rel='tooltip' title='' class='btn btn-primary btn-link btn-sm j_sys_clique_planejamento_acompanhamento_aula' data-original-title='Acessar'><i class='material-icons'>remove_red_eye</i></button></td></tr>";
            }
            $jSON['success'] = $tabela;
        } else {
            $jSON['error'] = 'Planejamento não encontrado!';
        }

        break;

    case 'buscarAlunosPanejamentoTurma':

        $Read->FullRead("SELECT * FROM sys_planejamento WHERE planejamento_status = 0 AND planejamento_projeto_id = :id AND planejamento_id = :p", "id={$PostData['projeto_id']}&p={$PostData['plano_id']}");
        if($Read->getResult()) {

            $materias = $Read->getResult()[0]['materias'];
            $homework = $Read->getResult()[0]['homework'];
            $atividades = $Read->getResult()[0]['atividades'];
            $exercicios = $Read->getResult()[0]['exercicios'];
            $etapa = $Read->getResult()[0]['etapa'];

            $arrMaterias = explode(",", $materias);
            $arrHomework = explode(",", $homework);
            $arrAtividades = explode(",", $atividades);
            $arrExercicios = explode(",", $exercicios);

            $materias_aula = "";
            $homework_aula = "";
            $atividade_aula = "";
            $exercicio_aula = "";

            $Read->FullRead("SELECT p.pessoa_nome, p.pessoa_id, p.pessoa_email FROM sys_envolvidos_projeto AS e INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id WHERE e.envolvidos_projeto_projeto_id = :id AND e.unidade_id = :unidade", "id={$PostData['projeto_id']}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
            if($Read->getResult()){
                $tabela = "";
                $qtd = $Read->getRowCount();
                $i = 0;
                foreach ($Read->getResult() as $Aluno) {
                    $tabela .= "<tr class='list_turma_planejamentos'><input name='aluno_{$i}' type='hidden' value='{$Aluno['pessoa_id']}'><td>{$Aluno['pessoa_nome']}</td><td>{$Aluno['pessoa_email']}</td><td class='td-actions text-left'><div class='form-check'><label class='form-check-label'><input class='form-check-input' name='check_{$i}' type='checkbox' value='{$Aluno['pessoa_id']}'><span class='form-check-sign'><span class='check'></span></span></label></div></td>";
                    $tabela .= "</tr>";

                    for($j = 0; $j < count($arrHomework); $j++){

                        $Read->ExeRead("sys_escola_homework", "WHERE homework_id = :id", "id={$arrHomework[$j]}");
                        if($Read->getResult()){
                            $homework_nome = $Read->getResult()[0]["homework_nome"];
                            $homework_id = $Read->getResult()[0]["homework_id"];
                            $homework_aula .= "<tr class='list_turma_planejamentos'><input name='aluno_{$i}_homework_{$j}' type='hidden' value='{$homework_id}'><td>{$Aluno['pessoa_nome']}</td><td>{$homework_nome}</td><td><input name='homework_{$i}_nota_{$j}' type='number'></td>";
                            $homework_aula .= "</tr>";
                        }

                    }

                    for($j = 0; $j < count($arrAtividades); $j++){

                        $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_id = :id", "id={$arrAtividades[$j]}");
                        if($Read->getResult()){
                            $avaliacao_nome = $Read->getResult()[0]["avaliacao_nome"];
                            $avaliacao_id = $Read->getResult()[0]["avaliacao_id"];
                            $atividade_aula .= "<tr class='list_turma_planejamentos'><input name='aluno_{$i}_avaliacao_{$j}' type='hidden' value='{$avaliacao_id}'><td>{$Aluno['pessoa_nome']}</td><td>{$avaliacao_nome}</td><td><input name='avaliacao_{$i}_nota_{$j}' type='number'></td>";
                            $atividade_aula .= "</tr>";
                        }

                    }

                    for($j = 0; $j < count($arrExercicios); $j++){

                        $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_id = :id", "id={$arrExercicios[$j]}");
                        if($Read->getResult()){
                            $exercicio_nome = $Read->getResult()[0]["exercicio_nome"];
                            $exercicio_id = $Read->getResult()[0]["exercicio_id"];
                            $exercicio_aula .= "<tr class='list_turma_planejamentos'><input name='aluno_{$i}_exercicios_{$j}' type='hidden' value='{$exercicio_id}'><td>{$Aluno['pessoa_nome']}</td><td>{$exercicio_nome}</td><td><input name='exercicios_{$i}_nota_{$j}' type='number'></td>";
                            $exercicio_aula .= "</tr>";
                        } else {
                            $exercicio_aula .= "<tr class='list_turma_planejamentos'>Sem resultados <i class='material-icons'>sentiment_very_dissatisfied</i>";
                            $exercicio_aula .= "</tr>";
                        }

                    }

                    $i++;
                }

                for($j = 0; $j < count($arrMaterias); $j++){

                    $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_id = :id", "id={$arrMaterias[$j]}");
                    if($Read->getResult()){
                        $materias_aula_nome = $Read->getResult()[0]["materias_aula_nome"];
                        $materias_aula_id = $Read->getResult()[0]["materias_aula_id"];

                        $materias_aula .= "<tr class='list_turma_planejamentos'><td>{$materias_aula_nome}</td><td class='td-actions text-right'><div class='form-check'><label class='form-check-label'><input class='form-check-input materia_check' data-nome='{$materias_aula_nome}' name='materia_check_{$j}' type='checkbox' value='{$materias_aula_id}'><span class='form-check-sign'><span class='check'></span></span></label></div></td>";
                        $materias_aula .= "</tr>";
                    }

                }

                if(count($arrHomework) == 0 || $homework_aula == ""){
                    $homework_aula .= "<tr class='list_turma_planejamentos'><td>Sem resultados <i class='material-icons'>sentiment_very_dissatisfied</i></td>";
                    $homework_aula .= "</tr>";
                }

                if(count($arrAtividades) == 0 || $atividade_aula == ""){
                    $atividade_aula .= "<div class='list_turma_planejamentos'><td>Sem resultados <i class='material-icons'>sentiment_very_dissatisfied</i></td>";
                    $atividade_aula .= "</div>";
                }

                if(count($arrMaterias) == 0 || $materias_aula == ""){
                    $materias_aula .= "<tr class='list_turma_planejamentos'><td>Sem resultados <i class='material-icons'>sentiment_very_dissatisfied</i></td>";
                    $materias_aula .= "</tr>";
                }

                if(count($arrExercicios) == 0 || $exercicio_aula == ""){
                    $exercicio_aula .= "<tr class='list_turma_planejamentos'><td>Sem resultados <i class='material-icons'>sentiment_very_dissatisfied</i></td>";
                    $exercicio_aula .= "</tr>";
                }

                $jSON['homework'] = $homework_aula;
                $jSON['materias'] = $materias_aula;
                $jSON['avaliacao'] = $atividade_aula;
                $jSON['exercicio'] = $exercicio_aula;
                $jSON['etapa'] = $etapa;

                $jSON['success'] = $tabela;
                $jSON['qtd'] = $qtd;
                $jSON['qtdMaterias'] = count($arrMaterias);
                $jSON['qtdAvaliacoes'] = count($arrAtividades);
                $jSON['qtdHomeWork'] = count($arrHomework);
                $jSON['qtdExercicios'] = count($arrExercicios);
            }


        } else {
            $jSON['error'] = 'Planejamento não encontrado!';
        }

        break;

    case 'buscar_dados_turma':
        $Read->ExeRead("sys_planejamento", "WHERE planejamento_projeto_id = :id", "id={$PostData['projeto_id']}");
        if($Read->getResult()){
            $jSON['error'] = 'Turma já possui Planejamento!';
            echo json_encode($jSON);
            die;
        }

        $Read->FullRead("SELECT p.projeto_grade, g.projeto_grade_carga_dia, g.projeto_grade_carga_hora_inicial, g.projeto_grade_carga_hora_final FROM sys_projeto_grade AS g INNER JOIN sys_projetos AS p ON p.projeto_id = g.projeto_grade_projeto_id WHERE g.projeto_grade_projeto_id = :id ORDER BY g.projeto_grade_carga_dia", "id={$PostData['projeto_id']}");
        if($Read->getResult()){
            $jSON['success'] = true;
            $Grade1 = $Read->getResult()[0];
            $jSON['primeiro_dia'] = getDiaSemanaIngles($Grade1["projeto_grade_carga_dia"]);
            $jSON['primeiro_dia_hora_inicial'] = $Grade1["projeto_grade_carga_hora_inicial"];
            $jSON['primeiro_dia_hora_final'] = $Grade1["projeto_grade_carga_hora_final"];
            $jSON['projeto_grade'] = $Grade1["projeto_grade"];

            if(isset($Read->getResult()[1])){
                $Grade2 = $Read->getResult()[1];
                $jSON['segundo_dia'] = getDiaSemanaIngles($Grade2["projeto_grade_carga_dia"]);
                $jSON['segundo_dia_hora_inicial'] = $Grade2["projeto_grade_carga_hora_inicial"];
                $jSON['segundo_dia_hora_final'] = $Grade2["projeto_grade_carga_hora_final"];
            } else {
                $jSON['segundo'] = "false";
            }
        } else {
            $jSON['error'] = 'Planejamento não encontrado!';
        }

        break;

    case 'TurmaEditar':

    if ($PostData['projeto_produto_id'] == "0"):
            $jSON['error'] = 'Informe um curso';
        elseif ($PostData['projeto_modalidade_id'] == "0"):
            $jSON['error'] = 'Informe uma modalidade';
            elseif ($PostData['projeto_grade'] == "0"):
            $jSON['error'] = 'Informe uma carga horária';
            elseif ($PostData['projeto_tipo_id'] == "0"):
            $jSON['error'] = 'Informe um tipo';
            elseif ($PostData['projeto_situacao_id'] == "0"):
            $jSON['error'] = 'Informe a situação';
            elseif ($PostData['projeto_gerente_id'] == "0"):
            $jSON['error'] = 'Informe um professor';
            elseif ($PostData['projeto_periodo_id'] == "0"):
            $jSON['error'] = 'Informe um período';
            elseif ($PostData['projeto_sala_id'] == "0"):
            $jSON['error'] = 'Informe uma sala';
        else:
        
        $Id = $PostData['projeto_id'];
        unset($PostData['projeto_id']);

        $CreateData['projeto_status']  = (!empty($PostData['projeto_status']) ? '1' : '0');
        $CreateData['projeto_codigo']  = $PostData['projeto_codigo'];
        $CreateData['projeto_sala_id'] = $PostData['projeto_sala_id'];
        $CreateData['projeto_descricao']         = $PostData['projeto_descricao'];
        $CreateData['projeto_qtd_participantes'] = $PostData['projeto_qtd_participantes'];
        $CreateData['projeto_produto_id']        = $PostData['projeto_produto_id'];
        $CreateData['projeto_modalidade_id']     = $PostData['projeto_modalidade_id'];
        $CreateData['projeto_tipo_id']        = $PostData['projeto_tipo_id'];
        $CreateData['projeto_situacao_id']     = $PostData['projeto_situacao_id'];
        $CreateData['projeto_gerente_id']     = $PostData['projeto_gerente_id'];
        $CreateData['projeto_observacao']     = $PostData['projeto_observacao'];
        $CreateData['projeto_data_inicio']     = $PostData['projeto_data_inicio'];
        $CreateData['projeto_data_termino']     = $PostData['projeto_data_termino'];
        $CreateData['projeto_grade']     = $PostData['projeto_grade'];
        $CreateData['projeto_periodo_id']     = $PostData['projeto_periodo_id'];
        

        $Update->ExeUpdate("sys_projetos",  $CreateData, "WHERE projeto_id = :id", "id={$Id}");
       

        if($quantidade_horarios){
            $ArrHorarios = [];
            
            for($i = 0; $i <= $quantidade_horarios; $i++){
                if(isset($PostData['hora_inicial_' . $i])){
                    if (isset($PostData['grade_id_' . $i])){

                        $entrada =  $PostData['hora_inicial_' . $i];
                        $saida =    $PostData['hora_final_' . $i];
                        $hora1 = explode(":",$entrada);
                        $hora2 = explode(":",$saida);
                        $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60);
                        $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60);
                        $resultado = $acumulador2 - $acumulador1;
                        $hora_ponto = floor($resultado / 3600);
                        $resultado = $resultado - ($hora_ponto * 3600);
                        $min_ponto = floor($resultado / 60);
                       
                        //Grava na variável resultado final
                        $tempo = $hora_ponto.":".$min_ponto;      


                        $UpdateHorario['projeto_grade_carga_horaria'] =  $tempo;
                        $UpdateHorario['projeto_grade_projeto_id'] = $Id;
                        $UpdateHorario['projeto_grade_carga_hora_inicial'] = $PostData['hora_inicial_' . $i];
                        $UpdateHorario['projeto_grade_carga_hora_final'] = $PostData['hora_final_' . $i];
                        $UpdateHorario['projeto_grade_carga_dia'] = $PostData['projeto_grade_carga_dia_' . $i];

                

                        $Update->ExeUpdate("sys_projeto_grade", $UpdateHorario, "WHERE projeto_grade_id = :id", "id={$PostData['grade_id_' . $i]}");
                      //  $jSON['redirect'] = "painel.php?exe=fornecedores/prestador/cadastro_prestador&id=" . $Id;
                    } else {
                        $ArrHorarios[] = Array(
                            'projeto_grade_projeto_id' => $Id,
                            'projeto_grade_carga_horaria' => $PostData['carga_' . $i],
                            'projeto_grade_carga_hora_inicial' => $PostData['hora_inicial_' . $i],
                            'projeto_grade_carga_hora_final' => $PostData['hora_final_' . $i],
                            'projeto_grade_carga_dia' => $PostData['projeto_grade_carga_dia_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
            }
            if(count($ArrHorarios) > 0){
         
                $Create->ExeCreateMulti("sys_projeto_grade", $ArrHorarios);
            }
        }

         $jSON['success'] = 'Seu registro foi salvo com sucesso!';
         $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_turma";

    endif;
    break;

    case 'TurmaAdd':

     if ($PostData['projeto_produto_id'] == "0"):
            $jSON['error'] = 'Informe um curso';
        elseif ($PostData['projeto_modalidade_id'] == "0"):
            $jSON['error'] = 'Informe uma modalidade';
            elseif ($PostData['projeto_grade'] == "0"):
            $jSON['error'] = 'Informe uma carga horária';
            elseif ($PostData['projeto_tipo_id'] == "0"):
            $jSON['error'] = 'Informe um tipo';
            elseif ($PostData['projeto_situacao_id'] == "0"):
            $jSON['error'] = 'Informe a situação';
            elseif ($PostData['projeto_gerente_id'] == "0"):
            $jSON['error'] = 'Informe um professor';
            elseif ($PostData['projeto_periodo_id'] == "0"):
            $jSON['error'] = 'Informe um período';
            elseif ($PostData['projeto_sala_id'] == "0"):
            $jSON['error'] = 'Informe uma sala';
        else:

        $CreateData['projeto_status']  = (!empty($PostData['projeto_status']) ? '1' : '0');
        $CreateData['projeto_codigo']  = $PostData['projeto_codigo'];
        $CreateData['projeto_sala_id'] = $PostData['projeto_sala_id'];
        $CreateData['projeto_descricao']         = $PostData['projeto_descricao'];
        $CreateData['projeto_qtd_participantes'] = $PostData['projeto_qtd_participantes'];
        $CreateData['projeto_produto_id']        = $PostData['projeto_produto_id'];
        $CreateData['projeto_modalidade_id']     = $PostData['projeto_modalidade_id'];
        $CreateData['projeto_tipo_id']        = $PostData['projeto_tipo_id'];
        $CreateData['projeto_situacao_id']     = $PostData['projeto_situacao_id'];
        $CreateData['projeto_gerente_id']     = $PostData['projeto_gerente_id'];
        $CreateData['projeto_observacao']     = $PostData['projeto_observacao'];
        $CreateData['projeto_periodo_id']     = $PostData['projeto_periodo_id'];
        
        $CreateData['projeto_data_inicio']     = $PostData['projeto_data_inicio'];
        $CreateData['projeto_data_termino']     = $PostData['projeto_data_termino'];
        $CreateData['projeto_grade']     = $PostData['projeto_grade'];


        $Create->ExeCreate("sys_projetos",  $CreateData);
  
        $Id = $Create->getResult();

        if($quantidade_horarios){
            $ArrHorarios = [];
            
            for($i = 0; $i <= $quantidade_horarios; $i++){
                if(isset($PostData['hora_inicial_' . $i])){
                    if (isset($PostData['grade_id_' . $i])){

                      
                        $entrada =  $PostData['hora_inicial_' . $i];
                        $saida =    $PostData['hora_final_' . $i];
                        $hora1 = explode(":",$entrada);
                        $hora2 = explode(":",$saida);
                        $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60);
                        $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60);
                        $resultado = $acumulador2 - $acumulador1;
                        $hora_ponto = floor($resultado / 3600);
                        $resultado = $resultado - ($hora_ponto * 3600);
                        $min_ponto = floor($resultado / 60);
                       
                        //Grava na variável resultado final
                        $tempo = $hora_ponto.":".$min_ponto;       


                        $UpdateHorario['projeto_grade_carga_horaria'] = $tempo;
                        $UpdateHorario['projeto_grade_projeto_id'] = $Id;
                        $UpdateHorario['projeto_grade_carga_hora_inicial'] = $PostData['hora_inicial_' . $i];
                        $UpdateHorario['projeto_grade_carga_hora_final'] = $PostData['hora_final_' . $i];
                        $UpdateHorario['projeto_grade_carga_dia'] = $PostData['dia_semana_' . $i];

                     

                        $Update->ExeUpdate("sys_projeto_grade", $UpdateHorario, "WHERE projeto_grade_id = :id", "id={$PostData['grade_id_' . $i]}");
                      //  $jSON['redirect'] = "painel.php?exe=fornecedores/prestador/cadastro_prestador&id=" . $Id;
                    } else {

                     

                        $entrada =  $PostData['hora_inicial_' . $i];
                        $saida =    $PostData['hora_final_' . $i];
                        $hora1 = explode(":",$entrada);
                        $hora2 = explode(":",$saida);
                        $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60);
                        $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60);
                        $resultado = $acumulador2 - $acumulador1;
                        $hora_ponto = floor($resultado / 3600);
                        $resultado = $resultado - ($hora_ponto * 3600);
                        $min_ponto = floor($resultado / 60);
                       
                        //Grava na variável resultado final
                        $tempo = $hora_ponto.":".$min_ponto;          

                        $ArrHorarios[] = Array(
                            'projeto_grade_projeto_id' => $Id,
                            'projeto_grade_carga_horaria' =>  $tempo,
                            'projeto_grade_carga_hora_inicial' => $PostData['hora_inicial_' . $i],
                            'projeto_grade_carga_hora_final' => $PostData['hora_final_' . $i],
                            'projeto_grade_carga_dia' => $PostData['dia_semana_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
            }
            if(count($ArrHorarios) > 0){
    
                $Create->ExeCreateMulti("sys_projeto_grade", $ArrHorarios);
            }
        }

        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        $jSON['redirect'] = "painel.php?exe=escola/turma/cadastro_turma&id=" . $Create->getResult();
        $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_turma";
        endif;
        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_projetos", "WHERE projeto_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_projetos", "WHERE projeto_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_turma";

        endif;
        break;

    case 'add_linha':

        $Read->ExeRead("sys_dia_semana");
        $DiaOption = "";
        if($Read->getResult()):
            foreach ($Read->getResult() as $Dias):
                $DiaOption .= "<option value='{$Dias['dia_semana_id'] }'>{$Dias['nome'] }</option>";
            endforeach;
        endif;
  
        $clone = "<tr><td class='pt-3-half'><select class='form-control' name='dia_semana_".$PostData['numero']."'><option value=''>Selecione dia da semana</option>".$DiaOption."</select></td>";
        $clone .="<td class='pt-3-half'><input type='text' name='hora_inicial_".$PostData['numero']."' placeholder='Hora inicial' class='form-control formTime'></td>";
        $clone .="<td class='pt-3-half'><input type='text' name='hora_final_".$PostData['numero']."' placeholder='Hora final' class='form-control formTime'></td>";
        $clone .="<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;    

    case 'cancelarAlunoTurma':

        $Read->ExeRead("sys_envolvidos_projeto", "WHERE envolvidos_projeto_projeto_id = :id AND envolvidos_envolvido_id = :p", "id={$PostData['turma_id']}&p={$PostData['pessoa_id']}");
        if($Read->getResult()) {

            $projeto = $Read->getResult()[0]['envolvidos_projeto_id'];

            $UpdateArr = [
                'status' => 1
            ];

            $Update->ExeUpdate("sys_envolvidos_projeto", $UpdateArr, "WHERE envolvidos_projeto_id = :id", "id={$projeto}");
            $Read->FullRead("SELECT m.movimentacao_projeto_id FROM sys_movimentacao_recebimento AS mr INNER JOIN sys_movimentacao AS m ON mr.mov_recebimento_movimento_id = m.movimentacao_id WHERE mr.mov_recebimento_status = 0 AND m.movimentacao_projeto_id = :id AND mr.mov_recebimento_pessoa_id = :p", "id={$projeto}&p={$PostData['pessoa_id']}");
            if($Read->getResult()) {
                foreach ($Read->getResult() as $Titulo) {

                    $ArrStatus = [
                        "mov_recebimento_status" => 2
                    ];

                    $ArrLog = [
                        "unidade_id" => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        "pessoa_id" => $_SESSION["userSYSFranquia"]["pessoa_id"],
                        "descricao" => "Cancelamento de título",
                        "date" => date('Y-m-d H:i:s'),
                        "id_titulo" => $Titulo['mov_recebimento_id']
                    ];

                    $Update->ExeUpdate("sys_movimentacao_recebimento", $ArrStatus, "WHERE mov_recebimento_id = :id", "id={$Titulo['mov_recebimento_id']}");
                    $Create->ExeCreate("sys_logs", $ArrLog);

                }
            }
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';

        } else {
            $jSON['error'] = 'Erro, tente novamente!';
        }

        break;

    case 'trancarAlunoTurma':

        $Read->ExeRead("sys_envolvidos_projeto", "WHERE envolvidos_projeto_projeto_id = :id AND envolvidos_envolvido_id = :p", "id={$PostData['turma_id']}&p={$PostData['pessoa_id']}");
        if($Read->getResult()) {

            $projeto = $Read->getResult()[0]['envolvidos_projeto_id'];

            $UpdateArr = [
                'status' => 2
            ];

            $Update->ExeUpdate("sys_envolvidos_projeto", $UpdateArr, "WHERE envolvidos_projeto_id = :id", "id={$projeto}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';

        } else {
            $jSON['error'] = 'Erro, tente novamente!';
        }

        break;

    case 'transferirAlunoTurma':

        $Read->ExeRead("sys_envolvidos_projeto", "WHERE envolvidos_projeto_projeto_id = :id AND envolvidos_envolvido_id = :p", "id={$PostData['turma_id']}&p={$PostData['pessoa_id']}");
        if($Read->getResult()) {

            $Delete->ExeDelete("sys_envolvidos_projeto", "WHERE envolvidos_projeto_id = :id", "id={$Read->getResult()[0]['envolvidos_projeto_id']}");

            $projeto = $Read->getResult()[0]['envolvidos_projeto_id'];
            $aluno = $Read->getResult()[0]["envolvidos_envolvido_id"];

            $UpdateArr = [
                'transferencia_pessoa_id' => $aluno,
                'transferencia_projeto_origem' => $projeto,
                'transferencia_projeto_origem_funcionario_id' => $_SESSION["userSYSFranquia"]["pessoa_id"],
                'transferencia_projeto_origem_data' => date("Y-m-d H:i:s"),
                'transferencia_status' => 0
            ];

            $Create->ExeCreate("sys_transferencia_envolvidos_projeto", $UpdateArr);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';

        } else {
            $jSON['error'] = 'Erro, tente novamente!';
        }

        break;

    case 'transferirAluno':

        $Id = $PostData['solicitacao_id'];
        $TurmaDestino = $PostData["txt_id_turma"];

        $Read->ExeRead("sys_transferencia_envolvidos_projeto", "WHERE transferencia_id = :id", "id={$Id}");
        if($Read->getResult()) {

            $ProjetoOrigem = $Read->getResult()[0]["transferencia_projeto_origem"];
            $Aluno = $Read->getResult()[0]['transferencia_pessoa_id'];

            if($ProjetoOrigem != $TurmaDestino){

                $Read->FullRead("SELECT projeto_produto_id FROM sys_projetos WHERE projeto_id = :id", "id={$ProjetoOrigem}");
                if($Read->getResult()){
                    $projeto_produto_id_Origem = $Read->getResult()[0]['projeto_produto_id'];
                } else {
                    $jSON['error'] = 'Erro ao selecionar turma de origem!';
                    echo json_encode($jSON);
                    die;
                }

                $Read->FullRead("SELECT projeto_produto_id FROM sys_projetos WHERE projeto_id = :id", "id={$TurmaDestino}");
                if($Read->getResult()){
                    $projeto_produto_id_Destino = $Read->getResult()[0]['projeto_produto_id'];
                } else {
                    $jSON['error'] = 'Erro ao selecionar turma de destino!';
                    echo json_encode($jSON);
                    die;
                }

                if($projeto_produto_id_Origem == $projeto_produto_id_Destino){

                    $Read->FullRead("SELECT COUNT(p.planejamento_id) AS total FROM sys_planejamento AS p WHERE p.planejamento_projeto_id = :id AND p.planejamento_status = 2", "id={$TurmaDestino}");
                    if($Read->getResult()) {
                        $TotalDeAulasDestino = $Read->getResult()[0]['total'];
                    } else {
                        $jSON['error'] = 'Erro ao selecionar turma de destino!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT COUNT(p.planejamento_id) AS total FROM sys_planejamento AS p WHERE p.planejamento_projeto_id = :id AND p.planejamento_status = 2", "id={$ProjetoOrigem}");
                    if($Read->getResult()) {
                        $TotalDeAulasOrigem = $Read->getResult()[0]['total'];
                    } else {
                        $jSON['error'] = 'Erro ao selecionar turma de origem!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT COUNT(r.reposicao_id) AS total FROM sys_reposicao AS r WHERE r.reposicao_pessoa_id = :id AND r.reposicao_status = 1", "id={$Aluno}");
                    if($Read->getResult()) {
                        $TotalDeAulasReposicao = $Read->getResult()[0]['total'];
                    } else {
                        $jSON['error'] = 'Erro ao selecionar reposições!';
                        echo json_encode($jSON);
                        die;
                    }

                    $TotalAulasFeitas = $TotalDeAulasOrigem+$TotalDeAulasReposicao;

                    if($TotalDeAulasDestino == $TotalAulasFeitas){

                        $UpdateArr = [
                            'transferencia_status' => 1,
                            'transferencia_projeto_destino' => $TurmaDestino,
                            'transferencia_projeto_destino_funcionario_id' => $_SESSION["userSYSFranquia"]["pessoa_id"],
                            'transferencia_projeto_destino_data' => date("Y-m-d H:i:s")
                        ];

                        $Update->ExeUpdate("sys_transferencia_envolvidos_projeto", $UpdateArr, "WHERE transferencia_id = :id", "id={$Id}");

                        $CreateEnvolvido['envolvidos_projeto_projeto_id'] = $TurmaDestino;
                        $CreateEnvolvido['envolvidos_envolvido_id'] = $Aluno;
                        $CreateEnvolvido['envolvidos_envolvido_tipo_id'] = 1;
                        $CreateEnvolvido['status'] = 0;

                        $Create->ExeCreate("sys_envolvidos_projeto", $CreateEnvolvido);

                        $jSON['success'] = 'Transferência realizada com sucesso!';


                    } else {

                        $jSON['error'] = 'Erro, quantidade de aulas divergente!';
                    }

                } else {

                    $jSON['error'] = 'Erro, estágios divergentes entre as turmas de origem e destino!';
                }

            } else {
                $jSON['error'] = 'Erro, turma de destino é a mesma turma de origem do aluno!';
            }

        } else {
            $jSON['error'] = 'Erro, tente novamente!';
        }

        break;

endswitch;

echo json_encode($jSON);