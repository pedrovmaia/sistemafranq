<?php

session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'list':

            $arr = array();

            $Read->FullRead("SELECT negociacao.negociacoes_id,
                DATE_FORMAT(negociacao.negociacoes_data, '%d/%m/%Y') AS negociacoes_data,
                       unidade.unidade_nome,
                       cliente.pessoa_nome as cliente,
                       funcionario.pessoa_nome as funcionario,
                       negociacao.negociacoes_descricao,
                       negociacao.negociacoes_hora
                 FROM sys_negociacoes negociacao
                 LEFT OUTER JOIN sys_unidades unidade ON unidade.unidade_id = negociacao.unidade_id
                 LEFT OUTER JOIN sys_pessoas cliente ON cliente.pessoa_id = negociacao.negociacoes_pessoa_id
                 LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = negociacao.negociacoes_pessoa_id
                 ");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "id" => $Result['negociacoes_id'],
                            "data" => $Result['negociacoes_data'],
                            "unidade" => $Result['unidade_nome'],
                            "cliente" => $Result['cliente'],
                            "funcionario" => $Result['funcionario'],
                            "descricao" => $Result['negociacoes_descricao'],
                            "hora" => $Result['negociacoes_hora'],
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_negociacao&id={$Result["negociacoes_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        
        break;
endswitch;