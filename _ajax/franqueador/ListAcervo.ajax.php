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

        $Read->FullRead("SELECT acervo.acervo_id,
            acervo.acervo_subtitulo,
            acervo.acervo_titulo,
            acervo.acervo_volume,
            acervo.acervo_numero_paginas,
            acervo.acervo_edicao,
            acervo.acervo_ano_edicao,
            acervo.acervo_ISBN,
            acervo.acervo_palavra_chave,
            classificacao.classificacao_literaria_nome,
            editora.editora_nome,
            tipo.tipo_obra_nome
FROM sys_acervo acervo
            LEFT OUTER JOIN sys_classificacao_literaria classificacao ON classificacao.classificacao_literaria_id = acervo.acervo_classificacao_id
            LEFT OUTER JOIN sys_editora editora ON editora.editora_id = acervo.acervo_editora_id
            LEFT OUTER JOIN sys_tipo_obra tipo ON tipo.tipo_obra_id = acervo.acervo_tipo_obra_id
            WHERE acervo.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['acervo_id'],
                        "titulo" => $Result['acervo_titulo'],
                        "subtitulo" => $Result['acervo_subtitulo'],
                        "tipoobra" => $Result['tipo_obra_nome'],
                        "editora" => $Result['editora_nome'],
                        "volume" => $Result['acervo_volume'],
                        "numeropagina" => $Result['acervo_numero_paginas'],
                        "edicao" => $Result['acervo_edicao'],
                        "anoedicao" => $Result['acervo_ano_edicao'],
                        "isbn" => $Result['acervo_ISBN'],
                        "palavrachave" => $Result['acervo_palavra_chave'],
                        "classificacao" => $Result['classificacao_literaria_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=biblioteca/ver_acervo&id={$Result["acervo_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=biblioteca/cadastro_acervo&id={$Result["acervo_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Acervo' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["acervo_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;