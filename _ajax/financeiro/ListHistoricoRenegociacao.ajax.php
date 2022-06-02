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
     
     $Id = $PostData["id"];
        if($Id){

        $arr = array();

        
        $Read->FullRead("SELECT 
             negociacao.negociacoes_id,            
             DATE_FORMAT(negociacao.negociacoes_data,'%d/%m/%Y') AS data,
             negociacao.negociacoes_hora,
             negociacao.negociacoes_pessoa_id,
             pessoa.pessoa_nome as cliente,
             funcionario.pessoa_nome,
             negociacao.negociacoes_descricao
             FROM sys_negociacoes negociacao
             LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = negociacao.negociacoes_pessoa_id
             LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = negociacao.negociacoes_funcionario_id WHERE negociacao.negociacoes_pessoa_id = :id AND negociacao.unidade_id = :unidade", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "id" => $Result['negociacoes_id'],
                        "data" => $Result['data'],
                        "hora" => $Result['negociacoes_hora'],
                        "cliente" => $Result['cliente'],
                        "funcionario" => $Result['pessoa_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_negociacao&id={$Result["negociacoes_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;