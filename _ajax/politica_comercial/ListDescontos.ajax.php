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

        $Read->FullRead("SELECT desconto.desconto_id,
                       desconto.desconto_nome,
                    CASE
                    WHEN desconto.desconto_tipo_valor = '1' THEN 'Valor'
                    ELSE 'Percentual'
                    END AS tipo_valor,
                    CASE
                    WHEN desconto.desconto_aplicavel = '0' THEN 'Produtos'
                    WHEN desconto.desconto_aplicavel = '1' THEN 'Serviços'
                    ELSE 'Produtos e Serviços'
                    END AS aplicavel,
                       tipod.tipo_desconto_nome,
                       desconto.desconto_valor, 
                    DATE_FORMAT(desconto.desconto_data_inicial,'%d/%m/%Y') AS data_inicial ,
                    DATE_FORMAT(desconto.desconto_data_final,'%d/%m/%Y') AS data_final              
                 FROM sys_descontos desconto
                 LEFT OUTER JOIN sys_tipo_desconto tipod ON tipod.tipo_desconto_id = desconto.desconto_tipo_id
                 WHERE desconto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['desconto_id'],
                        "nome" => $Result['desconto_nome'],
                        "tipo" => $Result['tipo_desconto_nome'],
                        "tipovalor" => $Result['tipo_valor'],
                        "valor" =>  number_format($Result['desconto_valor'], 2, ',', '.'),
                        "datainicial" => $Result['data_inicial'],
                        "datafinal" => $Result['data_final'],
                        "aplicavel" => $Result['aplicavel'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/ver_descontos&id={$Result["desconto_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/cadastro_descontos&id={$Result["desconto_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='politica_comercial/Descontos' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["desconto_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;