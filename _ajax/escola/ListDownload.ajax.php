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

        $Read->FullRead("SELECT download.escola_download_id,
                       download.escola_download_titulo,
                       download.escola_download_descricao,
                       categoria.escola_categoria_descricao
                 FROM escola_downloads download
                 LEFT OUTER JOIN escola_categoria_anexos  categoria ON categoria.escola_categoria_anexo_id = download.escola_download_tipo WHERE download.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['escola_download_id'],
                        "titulo" => $Result['escola_download_titulo'],
                        "descricao" => $Result['escola_download_descricao'],
                        "tipo" => $Result['escola_categoria_descricao'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/ver_downloads&id={$Result["escola_download_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/cadastro_downloads&id={$Result["escola_download_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Download' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["escola_download_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;