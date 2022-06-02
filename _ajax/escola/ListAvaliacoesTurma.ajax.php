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

        $Id = $PostData['id'];

        $arr = array();

        $Read->FullRead("SELECT pro.produto_nome, es.estagio_produto_nome, av.avaliacao_id, av.avaliacao_nome, avp.data_avaliacao, avp.nota FROM sys_avaliacao_pessoa AS avp 
                        INNER JOIN sys_pessoas AS p ON avp.pessoa_id = p.pessoa_id
                        INNER JOIN sys_produto AS pro ON avp.produto_id = pro.produto_id
                        INNER JOIN sys_estagio_produto AS es ON avp.estagio_id = es.estagio_produto_id
                        INNER JOIN sys_avaliacoes AS av on avp.cod_avaliacao_id = av.avaliacao_id
                        WHERE pro.produto_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "curso" => $Result['produto_nome'],
                        "estagio" => $Result['estagio_produto_nome'],
                        "avaliacao" => $Result['avaliacao_nome'],
                        "data" => date("d/m/Y H:i", strtotime($Result['data_avaliacao'])),
                        "nota" => number_format($Result['nota'], "2", ",", "."),
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/avaliacao/ver_avaliacoes&id={$Result["avaliacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;