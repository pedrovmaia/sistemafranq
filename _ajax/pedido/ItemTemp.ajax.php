<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData['actionItem']):
    require '../../_app/Config.inc.php';
    $action = $PostData['actionItem'];
    unset($PostData['actionItem']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
endif;

var_dump($PostData);

switch ($action):

    case 'ItemEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['cargo_id'];
            unset($PostData['cargo_id']);

            $PostData['cargo_status'] = (!empty($PostData['cargo_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_cargo", $PostData, "WHERE cargo_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/colaborador/cadastro_cargo&id=" . $Create->getResult();
        endif;

        break;

    case 'ItemAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
           
            $Create->ExeCreate("sys_proposta_item_temp", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
           
            $jSON['redirect'] = "painel.php?exe=pedidos/filtro_clientes";


        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_cargo", "WHERE cargo_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_cargo", "WHERE cargo_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=rh/colaborador/filtro_cargo";

        endif;
        break;

endswitch;

echo json_encode($jSON);