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

        $Read->FullRead("SELECT treinamento.treinamentos_id,
                       treinamento.treinamentos_nome,
                       treinamento.treinamentos_descricao,
                       DATE_FORMAT(treinamento.treinamentos_data_realizacao,'%d/%m/%Y') AS datar,
                       treinamento.treinamentos_date,
                       unidade.unidade_nome,
                       categoria.categoria_treinamentos_nome
                 FROM escola_treinamentos treinamento
                 LEFT OUTER JOIN sys_unidades  unidade ON unidade.unidade_id = treinamento.local_unidade_id
                 LEFT OUTER JOIN escola_categoria_treinamentos  categoria ON categoria.categoria_treinamentos_id = treinamento.treinamentos_categoria_id WHERE treinamento.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['treinamentos_id'],
                        "nome" => $Result['treinamentos_nome'],
                        "descricao" => $Result['treinamentos_descricao'],
                        "local" => $Result['unidade_nome'],
                        "categoria" => $Result['categoria_treinamentos_nome'],
                        "datarealizacao" => $Result['datar'],
                        "date" => $Result['treinamentos_date'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/ver_treinamentos&id={$Result["treinamentos_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedagogico/cadastro_treinamentos&id={$Result["treinamentos_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Treinamentos' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["treinamentos_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;