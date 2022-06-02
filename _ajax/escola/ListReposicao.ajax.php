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

     $Id = $PostData["id"];
        if($Id){
        $arr = array();

        $Read->FullRead("SELECT 
                 reposicao.reposicao_id,
                 reposicao.reposicao_data,
                 reposicao.reposicao_atividades,
                 reposicao.reposicao_descricao,
                 reposicao.reposicao_hora_final,
                 reposicao.reposicao_hora_inicial,
                 reposicao.reposicao_materias,
                 reposicao.reposicao_pago,
                 reposicao.reposicao_status,
                 pessoas.pessoa_nome,
                 turmas.projeto_descricao,
                 modalidades.modalidade_nome,
                  CASE
                    WHEN reposicao.reposicao_pago = 0 THEN 'Não'
                    ELSE 'Sim'
                    END AS pago,
                   CASE
                    WHEN reposicao.reposicao_status = 0 THEN 'Aberto'
                    ELSE 'Fechado'
                    END AS status_reposicao   

                 FROM sys_reposicao reposicao
                 LEFT OUTER JOIN sys_pessoas pessoas ON pessoas.pessoa_id = reposicao.reposicao_pessoa_id
                 LEFT OUTER JOIN sys_projetos turmas ON turmas.projeto_id = reposicao.reposicao_projeto_id
                 LEFT OUTER JOIN sys_modalidades modalidades ON modalidades.modalidade_id = reposicao.reposicao_modalidade_id
                  WHERE reposicao.unidade_id = :unidade AND reposicao.reposicao_projeto_id = :id", "unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}&id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['reposicao_id'],
                        "nome" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y', strtotime($Result['reposicao_data'])),
                        "descricao" => $Result['reposicao_descricao'],
                        "horai" => $Result['reposicao_hora_inicial'],
                        "horaf" => $Result['reposicao_hora_final'],
                        "materia" => $Result['reposicao_materias'],
                        "modalidade" => $Result['modalidade_nome'],
                        "atividade" => $Result['reposicao_atividades'],
                        "pago" => $Result['reposicao_pago'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/ver_reposicao&id={$Result["reposicao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/cadastro_reposicao&id={$Result["reposicao_id"]}&idturma={$Result["reposicao_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Reposicao' action='deleteturma' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["reposicao_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
          }

        }
        break;

    case 'list_aluno':

        $Id = $PostData["id"];
        if($Id){
            $arr = array();

            $Read->FullRead("SELECT reposicao.reposicao_id,
			 reposicao.reposicao_pessoa_id,
			 reposicao.reposicao_data,
			 reposicao.reposicao_atividades,
			 reposicao.reposicao_descricao,
			 reposicao.reposicao_hora_final,
			 reposicao.reposicao_hora_inicial,
			 reposicao.reposicao_materias,
			 reposicao.reposicao_pago,
			 reposicao.reposicao_status,
			 pessoas.pessoa_nome,
			 modalidades.modalidade_nome,
				CASE
					WHEN reposicao.reposicao_pago = 1 THEN 'Pago'
					ELSE 'Não'
					END AS pago,
				 CASE
					WHEN reposicao.reposicao_status = 0 THEN 'Aberto'
					ELSE 'Fechado'
					END AS status_reposicao   
			 FROM sys_reposicao reposicao
			 LEFT OUTER JOIN sys_pessoas pessoas ON pessoas.pessoa_id = reposicao.reposicao_pessoa_id
			 LEFT OUTER JOIN sys_modalidades modalidades ON modalidades.modalidade_id = reposicao.reposicao_modalidade_id
			 WHERE reposicao.unidade_id = :unidade AND reposicao.reposicao_pessoa_id = :id", "unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}&id={$Id}");
        if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "id" => $Result['reposicao_id'],
                            "nome" => $Result['pessoa_nome'],
                            "data" => date('d/m/Y', strtotime($Result['reposicao_data'])),
                            "descricao" => $Result['reposicao_descricao'],
                            "horai" => $Result['reposicao_hora_inicial'],
                            "horaf" => $Result['reposicao_hora_final'],
                            "materia" => $Result['reposicao_materias'],
                            "modalidade" => $Result['modalidade_nome'],
                            "atividade" => $Result['reposicao_atividades'],
                            "pago" => $Result['pago'],
                            "status" => $Result['status_reposicao'],
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_reposicao&id={$Result["reposicao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/cadastro_reposicao&id={$Result["reposicao_id"]}&idaluno={$Result["reposicao_pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Reposicao' action='deletealuno' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["reposicao_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }

        }
        break;
endswitch;