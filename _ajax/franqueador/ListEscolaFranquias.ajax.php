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

        $Read->FullRead("SELECT f.escola_franquias_id, f.escola_franquias_nome, p.pessoa_nome, uf.estado_nome, ci.cidade_nome FROM escola_franquias AS f
INNER JOIN sys_pessoas AS p ON f.escola_franquias_pessoa_id = p.pessoa_id
INNER JOIN sys_estados AS uf ON uf.estado_id = f.escola_franquias_estado
INNER JOIN sys_cidades AS ci ON ci.cidade_id = f.escola_franquias_cidade");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['escola_franquias_id'],
                        "nome" => $Result['escola_franquias_nome'],
                        "pessoa" => $Result['pessoa_nome'],
                        "estado" => $Result['estado_nome'],
                        "cidade" => $Result['cidade_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/localizacao/ver_escola_franquias&id={$Result["escola_franquias_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/localizacao/cadastro_escola_franquias&id={$Result["escola_franquias_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='franqueador/EscolaFranquias' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["escola_franquias_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;