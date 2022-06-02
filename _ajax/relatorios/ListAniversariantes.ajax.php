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
         $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];

                $Read->FullRead("SELECT 
                    aniversariantes.pessoa_nome,
                    aniversariantes.pessoa_nascimento,
                    aniversariantes.pessoa_email,
                    telefones.telefone,
                    tipo.tipo_pessoa_descricao
                  from sys_pessoas aniversariantes
                  LEFT OUTER JOIN sys_telefones_pessoas telefones ON telefones.pessoa_id = aniversariantes.pessoa_id
                  LEFT OUTER JOIN sys_tipo_pessoas tipo ON tipo.tipo_pessoa_id = aniversariantes.pessoa_tipo_id
                  Where Month(aniversariantes.pessoa_nascimento)  = ('".$dataInicio."') AND ('".$dataFim."')
                                        ", aniversariantes.unidade={$_SESSION['userSYSFranquia']['unidade_padrao']});
                if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "pessoa" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y', strtotime($Result['data_nascimento'])),
                        "email" => $Result['pessoa_email'],
                        "tipo" => $Result['tipo_pessoa_descricao'],

                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;