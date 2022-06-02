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

        $Read->FullRead("SELECT pessoa.pessoa_nome,
            pessoa.pessoa_id,
            pessoa.pessoa_email,
            YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(pessoa.pessoa_nascimento))) AS idade,
            pessoa.pessoa_cpf,
            pedagogico.pessoa_nome as rpedagogico,
            financeiro.pessoa_nome as rfinanceiro
            FROM sys_pessoas pessoa USE INDEX (UNIDADE_ID)
            LEFT OUTER JOIN sys_pessoas pedagogico ON pedagogico.pessoa_id = pessoa.pessoa_responsavel_financeiro_id
            LEFT OUTER JOIN sys_pessoas financeiro ON financeiro.pessoa_id = pessoa.pessoa_responsavel_pedagogico_id
            WHERE pessoa.pessoa_tipo_id = 4 AND pessoa.unidade_id = :id", "id={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){


            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Aluno){

                $turma = "";

                $Read->FullRead("SELECT projeto_descricao, matricula_cliente_id FROM sys_projetos, sys_matriculas WHERE projeto_id = matricula_curso_id AND matricula_cliente_id = :aluno","aluno={$Aluno['pessoa_id']}");

                if($Read->getResult()){
                    foreach ($Read->getResult() as $Projeto) {
                        $turma = $Projeto['projeto_descricao'];
                    }
                }

                $Read->FullRead("SELECT projeto_descricao, lista_espera_projeto_pessoa_id FROM sys_projetos, sys_lista_espera_projeto WHERE projeto_id = lista_espera_projeto_periodo_preferencia AND lista_espera_projeto_pessoa_id = :aluno","aluno={$Aluno['pessoa_id']}");

                if($Read->getResult()){
                    foreach ($Read->getResult() as $Projeto) {
                        $turma = 'lista de espera '.$Projeto['projeto_descricao'];
                    }
                }

                $Telefone = "";

                $Read->FullRead("SELECT telefone FROM sys_telefones_pessoas WHERE pessoa_id = :id", "id={$Aluno['pessoa_id']}");
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Phone) {
                        $Telefone .= $Phone['telefone'] . ";";
                    }
                }

                $Telefone = str_replace(";", ", ", substr_replace($Telefone, '', -1));

                array_push($arr, array(
                    "id" => $Aluno['pessoa_id'],
                    "nome" => $Aluno['pessoa_nome'],
                    "e-mail" => $Aluno['pessoa_email'],
                    "turma" => $turma,                    
                    "cpf" => $Aluno['pessoa_cpf'],
                    "idade" => $Aluno['idade'],
                    "phone" => $Telefone,
                    "pedagogico" => $Aluno['rpedagogico'],
                    "financeiro" => $Aluno['rfinanceiro'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Aluno["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/cadastro_alunos&id={$Aluno["pessoa_id"]}' title='Editar' class='btn btn-primary btn-link btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;