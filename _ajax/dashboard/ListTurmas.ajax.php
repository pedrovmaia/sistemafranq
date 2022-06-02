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

    $Read->FullRead("SELECT                 projeto.projeto_id,
       projeto.projeto_descricao,
       professor.pessoa_nome,
       modalidade.modalidade_nome
       FROM sys_projetos projeto 
       LEFT OUTER JOIN sys_modalidades modalidade ON modalidade.modalidade_id = projeto.projeto_modalidade_id
       LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = projeto.projeto_gerente_id
       WHERE projeto.projeto_status = 0 AND projeto.unidade_id = :unidade LIMIT 10", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

    if($Read->getResult()){
        $manage['total'] = $Read->getRowCount();
        foreach ($Read->getResult() as $Result){
            array_push($arr, array(
                "id" => $Result['projeto_id'],
                "nome" => $Result['projeto_descricao'],
                "professor" => $Result['pessoa_nome'],
                "modalidade" => $Result['modalidade_nome'],
                "acoes" => "<span class='td-actions'><a rel='tooltip' href='painel.php?exe=escola/turma/ver_turma&id={$Result["projeto_id"]}' title='Ver' class='btn btn-primary  btn-link mr-1'><i class='material-icons'>visibility</i></a></span>"
            )
        );
        }
        $manage['rows'] = $arr;
        echo json_encode($manage);
    }
    break;
endswitch;