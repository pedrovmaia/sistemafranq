<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'lista_espera':

        $Read->ExeRead("sys_lista_espera_projeto", "WHERE lista_espera_projeto_id = :id", "id={$PostData['list_id']}");
        if($Read->getResult()){
            $ListaEspera = $Read->getResult()[0];

            $Read->FullRead("SELECT p.pessoa_id, p.pessoa_email FROM sys_envolvidos_projeto AS e 
                    INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id 
                    WHERE e.envolvidos_projeto_projeto_id = :id AND p.pessoa_id = :pessoa
                    AND e.unidade_id = :unidade", "id={$PostData['turma_id']}&pessoa={$ListaEspera['lista_espera_projeto_pessoa_id']}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

            if($Read->getResult()){
                $jSON['error'] = 'Aluno já matriculado nessa turma!';
                echo json_encode($jSON);
                die;
            }

            $CreateEnvolvido['envolvidos_projeto_projeto_id'] = $PostData['turma_id'];
            $CreateEnvolvido['envolvidos_envolvido_id'] = $ListaEspera['lista_espera_projeto_pessoa_id'];
            $CreateEnvolvido['envolvidos_envolvido_tipo_id'] = 1;

            $Delete->ExeDelete("sys_lista_espera_projeto", "WHERE lista_espera_projeto_id = :id", "id={$PostData['list_id']}");
            $Create->ExeCreate("sys_envolvidos_projeto", $CreateEnvolvido);

            $jSON['success'] = 'Inclusão em turma realizada com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_lista_espera";

        } else {
            $jSON['error'] = 'Ocorreu algum erro, tente novamente!';
            echo json_encode($jSON);
            die;
        }

        break;
endswitch;

echo json_encode($jSON);