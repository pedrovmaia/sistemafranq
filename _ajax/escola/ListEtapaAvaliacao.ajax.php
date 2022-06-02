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
        $Id = $PostData['id'];

        $Read->FullRead("SELECT eta.etapa_avaliacao_id, eta.etapa_avaliacao_nome, eta.etapa_estagio_id, eta.etapa_avaliacao_produto_id, mi.materias_aula_nome, mf.materias_aula_nome, p.produto_nome, ep.estagio_produto_nome 
            FROM sys_etapa_avaliacao AS eta 
            INNER JOIN sys_estagio_produto AS ep ON eta.etapa_estagio_id = ep.estagio_produto_id
            INNER JOIN sys_produto AS p ON eta.etapa_avaliacao_produto_id = p.produto_id
            INNER JOIN sys_materias_aula AS mi ON eta.etapa_avaliacao_materia_inicial_id = mi.materias_aula_id
            INNER JOIN sys_materias_aula AS mf ON eta.etapa_avaliacao_materia_final_id = mf.materias_aula_id
            WHERE eta.unidade_id = :unidade AND eta.etapa_estagio_id = :id", "id={$Id}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['etapa_avaliacao_id'],
                        "nome" => $Result['etapa_avaliacao_nome'],
                        "inicial" => $Result['materias_aula_nome'],
                        "final" => $Result['materias_aula_nome'],
                        "curso" => $Result['produto_nome'],
                        "estagio" => $Result['estagio_produto_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/ver_etapa_avaliacao&idetapa={$Result["etapa_avaliacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/cadastro_etapa_avaliacao&id={$Result["etapa_estagio_id"]}&idcurso={$Result["etapa_avaliacao_produto_id"]}&idetapa={$Result["etapa_avaliacao_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/EtapaAvaliacao' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["etapa_avaliacao_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;