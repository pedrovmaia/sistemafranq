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
        $Id = $PostData['projeto_id'];

        $Read->FullRead("SELECT planejamento.planejamento_id,
                   planejamento.planejamento_data,
                   planejamento.planejamento_descricao,
                   planejamento.planejamento_hora_inicial,
                   planejamento.planejamento_hora_final,
                    CASE
                    WHEN planejamento.planejamento_status = '0' THEN 'Pendente'
                    WHEN planejamento.planejamento_status = '1' THEN 'Feriado'
                    ELSE 'Concluído'
                    END AS aula_status
                   FROM sys_planejamento planejamento
                   WHERE planejamento.planejamento_projeto_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['planejamento_id'],
                        "data" => date('d/m/Y', strtotime($Result['planejamento_data'])),
                        "descricao" => $Result['planejamento_descricao'],
                        "inicio" => date('H:i', strtotime($Result['planejamento_hora_inicial'])),
                        "fim" => date('H:i', strtotime($Result['planejamento_hora_final'])),
                        "status" => $Result['aula_status'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/planejamento_aula_turma&id={$Result["planejamento_id"]}' title='Ver' class='btn btn-warning btn-link mr-1'><i class='material-icons'>menu_book</i></a>" : '') . " " . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/acompanhamento_turma&id={$Result["planejamento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    break;

    case 'listamaterias':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT e.materias_aula_nome, am.date FROM sys_materias_aula AS e 
            INNER JOIN sys_acompanhamento_aula_materias AS am ON am.materia_id = e.materias_aula_id
            WHERE am.planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "materia" => $Result['materias_aula_nome'],
                        "data" => date('d/m/Y', strtotime($Result['date']))
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listamateriasrealizar':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT materias, planejamento_data FROM sys_planejamento WHERE planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $Planejamento = $Read->getResult();
            $manage['total'] = $Read->getRowCount();
            $materiasArr = explode(",", $Read->getResult()[0]['materias']);
            foreach ($materiasArr as $materia){
                $Read->FullRead("SELECT materias_aula_nome FROM sys_materias_aula WHERE materias_aula_id = :id", "id={$materia}");
                if($Read->getResult()){

                    foreach ($Planejamento as $Result){

                        array_push($arr, array(
                                "materia" => $Read->getResult()[0]['materias_aula_nome'],
                                "data" => date('d/m/Y', strtotime($Result['planejamento_data']))
                            )
                        );
                    }
                }
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listaexercicios':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT p.pessoa_nome, e.exercicio_nome, am.date, am.nota FROM sys_escola_exercicios AS e 
        INNER JOIN sys_acompanhamento_aula_exercicios AS am ON am.exercicio_id = e.exercicio_id
            INNER JOIN sys_pessoas AS p ON p.pessoa_id = am.pessoa_id
        WHERE am.planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "aluno" => $Result['pessoa_nome'],
                        "exercicio" => $Result['exercicio_nome'],
                        "nota" => $Result['nota'],
                        "data" => date('d/m/Y', strtotime($Result['date']))
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listaexerciciosrealizar':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT exercicios, planejamento_data FROM sys_planejamento WHERE planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $Planejamento = $Read->getResult();
            $manage['total'] = $Read->getRowCount();
            $exerciciosArr = explode(",", $Read->getResult()[0]['exercicios']);
            foreach ($exerciciosArr as $exercicios){
                $Read->FullRead("SELECT exercicio_nome FROM sys_escola_homework WHERE exercicio_id = :id", "id={$exercicios}");
                if($Read->getResult()){

                    foreach ($Planejamento as $Result){

                        array_push($arr, array(
                                "homework" => $Read->getResult()[0]['exercicio_nome'],
                                "data" => date('d/m/Y', strtotime($Result['planejamento_data']))
                            )
                        );
                    }
                }
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listahomework':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT p.pessoa_nome, e.homework_nome, am.date, am.nota FROM sys_escola_homework AS e 
        INNER JOIN sys_acompanhamento_aula_homework AS am ON am.homework_id = e.homework_id
            INNER JOIN sys_pessoas AS p ON p.pessoa_id = am.pessoa_id
        WHERE am.planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "aluno" => $Result['pessoa_nome'],
                        "homework" => $Result['homework_nome'],
                        "nota" => $Result['nota'],
                        "data" => date('d/m/Y', strtotime($Result['date']))
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listahomeworkrealizar':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT homework, planejamento_data FROM sys_planejamento WHERE planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $Planejamento = $Read->getResult();
            $manage['total'] = $Read->getRowCount();
            $homeworkArr = explode(",", $Read->getResult()[0]['homework']);
            foreach ($homeworkArr as $homework){
                $Read->FullRead("SELECT homework_nome FROM sys_escola_homework WHERE homework_id = :id", "id={$homework}");
                if($Read->getResult()){

                    foreach ($Planejamento as $Result){

                        array_push($arr, array(
                                "homework" => $Read->getResult()[0]['homework_nome'],
                                "data" => date('d/m/Y', strtotime($Result['planejamento_data']))
                            )
                        );
                    }
                }
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listaavaliacoes':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT p.pessoa_nome, e.avaliacao_nome, am.date, am.nota FROM sys_avaliacoes AS e 
        INNER JOIN sys_acompanhamento_aula_avaliacoes AS am ON am.avaliacao_id = e.avaliacao_id
            INNER JOIN sys_pessoas AS p ON p.pessoa_id = am.pessoa_id
        WHERE am.planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "aluno" => $Result['pessoa_nome'],
                        "avaliacao" => $Result['avaliacao_nome'],
                        "nota" => $Result['nota'],
                        "data" => date('d/m/Y', strtotime($Result['date']))
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listaavaliacoesrealizar':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT atividades, planejamento_data FROM sys_planejamento WHERE planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $Planejamento = $Read->getResult();
            $manage['total'] = $Read->getRowCount();
            $atividadesArr = explode(",", $Read->getResult()[0]['atividades']);
            foreach ($atividadesArr as $atividade){
                $Read->FullRead("SELECT avaliacao_nome FROM sys_avaliacoes WHERE avaliacao_id = :id", "id={$atividade}");
                if($Read->getResult()){

                    foreach ($Planejamento as $Result){

                        array_push($arr, array(
                                "avaliacao" => $Read->getResult()[0]['avaliacao_nome'],
                                "data" => date('d/m/Y', strtotime($Result['planejamento_data']))
                            )
                        );
                    }
                }
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listacompanamento':
        $arr = array();
        $Id = $PostData['planejamento_id'];

        $Read->FullRead("SELECT p.pessoa_nome, p.pessoa_id, p.pessoa_email, pl.* FROM sys_envolvidos_projeto AS e 
                          INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id
                          INNER JOIN sys_planejamento AS pl ON pl.planejamento_projeto_id = e.envolvidos_projeto_projeto_id
                        WHERE pl.planejamento_id = :id", "id={$Id}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $Read->ExeRead("sys_acompanhamento_aula", "WHERE presenca = 1 AND pessoa_id = :pessoa", "pessoa={$Result['pessoa_id']}");
                if($Read->getResult()){
                    $tabela = "Presente";
                } else {
                    $tabela = "Faltou";
                }

                array_push($arr, array(
                        "id" => $Result['planejamento_id'],
                        "aluno" => $Result['pessoa_nome'],
                        "presenca" => $tabela,
                        "data" => date('d/m/Y', strtotime($Result['planejamento_data'])),
                        "descricao" => $Result['planejamento_descricao'],
                        "inicio" => date('H:i', strtotime($Result['planejamento_hora_inicial'])),
                        "fim" => date('H:i', strtotime($Result['planejamento_hora_final']))
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;