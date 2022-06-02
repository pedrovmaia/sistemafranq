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

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 4" "AND unidade_id  = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Aluno){

                array_push($arr, array(
                    "id" => $Aluno['pessoa_id'],
                    "nome" => $Aluno['pessoa_nome'],
                    "sexo" => $Aluno['pessoa_sexo'],
                    "apelido" => $Aluno['pessoa_apelido'],
                    "nascimento" => $Aluno['pessoa_nascimento'],
                    "cpf" => $Aluno['pessoa_cpf'],
                    "e-mail" => $Aluno['pessoa_email'],
                    "rg" => $Aluno['pessoa_rg'],
                    "emissor" => $Aluno['pessoa_emissor'],
                    "profissao" => $Aluno['pessoa_profissao'],
                    "tipo" => $Aluno['pessoa_tipo_id'],
                    "observacao" => $Aluno['pessoa_tipo_id'],
                    "status" => $Aluno['pessoa_status'],
                    "unidade" => $Aluno['unidade_id'],
                    "responsavel" => $Aluno['pessoa_responsavel'],
                    "data" => $Aluno['pessoa_data'],
                    "escola" => $Aluno['pessoa_escola_id'],
                    "grauescolaridade" => $Aluno['pessoa_grau_escolaridade'],
                    "estuda" => $Aluno['pessoa_estuda'],
                    "trabalha" => $Aluno['pessoa_trabalha'],
                    "trabalho" => $Aluno['pessoa_trabalho_id'],
                    "periodo" => $Aluno['pessoa_periodo'],
                    "serie" => $Aluno['pessoa_serie'],
                    "sobre" => $Aluno['pessoa_sobre_voce'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Aluno["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;