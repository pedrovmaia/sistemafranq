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

        $Read->FullRead("SELECT 
             politica.politica_comercial_id,
             estagio.estagio_produto_nome,
             politica.unidade_id,
             politica.politica_comercial_valor,
             modalidade.modalidade_nome,
             DATE_FORMAT(politica.politica_comercial_data_inicio ,'%d/%m/%Y') AS politica_comercial_data_inicio,
             DATE_FORMAT(politica.politica_comercial_data_final ,'%d/%m/%Y') AS politica_comercial_data_final
             FROM sys_politica_comercial_estagios politica
             LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = politica.politica_comercial_estagio_id
             LEFT OUTER JOIN  sys_modalidades modalidade ON modalidade.modalidade_id = politica.modalidade_id
             WHERE politica.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['politica_comercial_id'],
                        "valor" => number_format($Result['politica_comercial_valor'], 2, ',', '.'),
                        "estagio" => $Result['estagio_produto_nome'],
                        "datainicial" => $Result['politica_comercial_data_inicio'],
                        "datafinal" => $Result['politica_comercial_data_final'],
                        "modalidade" => $Result['modalidade_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/ver_politica_estagio&id={$Result["politica_comercial_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/cadastro_politica_estagio&id={$Result["politica_comercial_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='politica_comercial/PoliticaComercialEstagio' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["politica_comercial_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;