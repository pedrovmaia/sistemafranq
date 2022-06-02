<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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

    case 'CoordenadoriaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = "Favor, preencha todos os campos!";
        else:
            $PostData['atividade_status'] = (!empty($PostData['atividade_status']) ? '1' : '0');
            $Create->ExeCreate("sys_coordenadorias", $PostData);
            $jSON['success'] = "Seu registro foi salvo com sucesso!";
             $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_coordenadoria";
        endif;

        break;

endswitch;

echo json_encode($jSON);