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
             produtos.produto_nome,
             politica.politica_comercial_valor,
             DATE_FORMAT(politica.politica_comercial_data_inicio ,'%d/%m/%Y') AS politica_comercial_data_inicio,
             DATE_FORMAT(politica.politica_comercial_data_final ,'%d/%m/%Y') AS politica_comercial_data_final
             FROM sys_politica_comercial_produtos politica
             LEFT OUTER JOIN sys_produto produtos ON produtos.produto_id = politica.politica_comercial_produto_id
             WHERE politica.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['politica_comercial_id'],
                        "valor" => number_format($Result['politica_comercial_valor'], 2, ',', '.'),                      
                        "produto" => $Result['produto_nome'],
                        "datainicial" => $Result['politica_comercial_data_inicio'],
                        "datafinal" => $Result['politica_comercial_data_final'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/cadastro_politica_comercial_produto&id={$Result["politica_comercial_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='politica_comercial/PoliticaProduto' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["politica_comercial_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;