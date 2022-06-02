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

        $Read->FullRead("SELECT sala.sala_nome, 
            projeto.projeto_descricao, 
            situacao.situacao_projeto_nome, 
            pessoas.pessoa_nome, 
            projeto.data_criacao 
            FROM sys_projetos AS projeto
            LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
            LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
            LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
            WHERE sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} ORDER BY sala.sala_nome");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

            foreach ($Read->getResult() as $Result){           
                array_push($arr, array(
                        "sala" => $Result['sala_nome'],
                        "turma" => $Result['projeto_descricao'],
                        "situacao" => $Result['situacao_projeto_nome'],
                        "professor" => $Result['pessoa_nome'],
                        "data_criacao" => date('d/m/Y', strtotime($Result['data_criacao']))
                    )
                );
            }

            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'filtro':

        $arr = array();

        $tipo = 'TurmasSalas';

        $data = str_replace('-', '', $PostData['data']);

        //cria o nome do arquivo PDF
        $arquivo = $_SESSION['userSYSFranquia']['unidade_padrao'].'_'.rand(1,9999).'_'.time().'.pdf';

        if(empty($PostData['sala']) && empty($PostData['turma']) && empty($PostData['situacao']) && empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} ORDER BY sala.sala_nome");
        }

        if(!empty($PostData['sala']) && empty($PostData['turma']) && empty($PostData['situacao']) && empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id  
                AND sala.sala_id = {$PostData['sala']}                
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                ORDER BY sala.sala_nome");
        }

        if(!empty($PostData['sala']) && !empty($PostData['turma']) && empty($PostData['situacao']) && empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.sala_id = {$PostData['sala']} 
                AND projeto.projeto_id = {$PostData['turma']}
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                ORDER BY sala.sala_nome");
        }

        if(!empty($PostData['sala']) && !empty($PostData['turma']) && !empty($PostData['situacao']) && empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id
                AND sala.sala_id = {$PostData['sala']} 
                AND projeto.projeto_id = {$PostData['turma']} 
                AND situacao.situacao_projeto_id = {$PostData['situacao']}               
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
                ORDER BY sala.sala_nome");
        }

        if(!empty($PostData['sala']) && !empty($PostData['turma']) && !empty($PostData['situacao']) && !empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.sala_id = {$PostData['sala']} 
                AND projeto.projeto_id = {$PostData['turma']}
                AND situacao.situacao_projeto_id = {$PostData['situacao']} 
                AND DATE_FORMAT(projeto.data_criacao, '%Y%m%d') = {$data}
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
                ORDER BY sala.sala_nome");
       
        }

        if(!empty($PostData['sala']) && empty($PostData['turma']) && !empty($PostData['situacao']) && !empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.sala_id = {$PostData['sala']}
                AND situacao.situacao_projeto_id = {$PostData['situacao']} 
                AND DATE_FORMAT(projeto.data_criacao, '%Y%m%d') = {$data}
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
                ORDER BY sala.sala_nome");
       
        }

        if(!empty($PostData['sala']) && empty($PostData['turma']) && empty($PostData['situacao']) && !empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.sala_id = {$PostData['sala']}
                AND DATE_FORMAT(projeto.data_criacao, '%Y%m%d') = {$data}
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
                ORDER BY sala.sala_nome");
       
        }

        if(empty($PostData['sala']) && empty($PostData['turma']) && !empty($PostData['situacao']) && empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} 
                AND situacao.situacao_projeto_id = {$PostData['situacao']} 
                ORDER BY sala.sala_nome");
        }

        if(empty($PostData['sala']) && empty($PostData['turma']) && !empty($PostData['situacao']) && !empty($PostData['data'])) {

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                AND DATE_FORMAT(projeto.data_criacao, '%Y%m%d') = {$data}
                AND situacao.situacao_projeto_id = {$PostData['situacao']} 
                ORDER BY sala.sala_nome");
        }

        if(empty($PostData['sala']) && empty($PostData['turma']) && empty($PostData['situacao']) && !empty($PostData['data'])) {            

            $Read->FullRead("SELECT sala.sala_nome, 
                projeto.projeto_descricao, 
                situacao.situacao_projeto_nome, 
                pessoas.pessoa_nome, 
                projeto.data_criacao 
                FROM sys_projetos AS projeto
                LEFT OUTER JOIN sys_pessoas AS pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_sala AS sala ON projeto.projeto_sala_id = sala.sala_id
                LEFT OUTER JOIN sys_situacao_projeto AS situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                WHERE projeto.projeto_sala_id = sala.sala_id 
                AND situacao.situacao_projeto_id = projeto.projeto_situacao_id 
                AND DATE_FORMAT(projeto.data_criacao, '%Y%m%d') = {$data}
                AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                ORDER BY sala.sala_nome");
        }

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

            foreach ($Read->getResult() as $Result){           
                array_push($arr, array(
                        "sala" => $Result['sala_nome'],
                        "turma" => $Result['projeto_descricao'],                        
                        "professor" => $Result['pessoa_nome'],
                        "situacao" => $Result['situacao_projeto_nome'],
                        "data_criacao" => date('d/m/Y', strtotime($Result['data_criacao']))
                    )
                );
            }

            $PDF->geraPDF($arr, $arquivo, $tipo);

            $manage['arquivo'] = BASE.'/_ajax/relatorios/'.$arquivo;
            $manage['rows'] = $arr;
            echo json_encode($manage);

        }
    break;

    case 'filtro_salas':

        $arr = array();

        $Read->FullRead("SELECT projeto_id, projeto_descricao FROM sys_projetos AS projeto, sys_sala AS sala
            WHERE projeto.projeto_sala_id = sala.sala_id AND sala.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} AND sala.sala_id = {$PostData['sala']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();

            foreach ($Read->getResult() as $Result){           
                array_push($arr, array(
                        "id" => $Result['projeto_id'],
                        "turma" => $Result['projeto_descricao']
                    )
                );
            }

            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    break;
endswitch;