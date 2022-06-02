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

        $Read->FullRead("SELECT atividade.atividades_extra_id,
            atividade.atividades_extra_descricao,
            atividade.atividades_extra_data_inicial,
            atividade.atividades_extra_data_final,
            estagio.estagio_produto_nome
            FROM sys_atividades_extra_curriculares atividade
            LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = atividade.atividades_extra_estagio_id
            WHERE atividade.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['atividades_extra_id'],
                        "desc" => $Result['atividades_extra_descricao'],
                        "datai" => date('d/m/Y', strtotime($Result['atividades_extra_data_inicial'])),
                        "dataf" => date('d/m/Y', strtotime($Result['atividades_extra_data_final'])),
                        "estagio" => $Result['estagio_produto_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=parametrizacao/ver_atividade_extra&id={$Result["atividades_extra_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=parametrizacao/cadastro_atividade_extra&id={$Result["atividades_extra_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='parametrizacao/AtividadeExtra' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["atividades_extra_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;