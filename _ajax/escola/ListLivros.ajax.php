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

        $Read->FullRead("SELECT c.escola_colecao_livros_nome, l.livro_nome, l.livro_id FROM escola_livros AS l INNER JOIN escola_colecao_livros AS c ON l.livro_colecao_id = c.escola_colecao_livros_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['livro_id'],
                        "nome" => $Result['livro_nome'],
                        "colecao" => $Result['escola_colecao_livros_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/ver_livros&id={$Result["livro_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;