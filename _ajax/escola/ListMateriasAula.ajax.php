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

        $Read->FullRead("SELECT material.materias_aula_estagio_id,
                       material.materias_aula_nome,
                       material.materias_aula_id,
                     livro.livro_nome
                 FROM sys_materias_aula material
                 LEFT OUTER JOIN escola_livros  livro ON livro.livro_id = material.materias_aula_livro_id
                 WHERE material.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} AND material.materias_aula_estagio_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['materias_aula_id'],
                        "nome" => $Result['materias_aula_nome'],
                        "livro" => $Result['livro_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/ver_materias_aula&id={$Result["materias_aula_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/cadastro_materias_aula&id={$Result["materias_aula_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/MateriasAula' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["materias_aula_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;