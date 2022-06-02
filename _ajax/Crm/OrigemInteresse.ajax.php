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
    $trigger = new Trigger;
endif;

switch ($action):

    case 'OrigemInteresseEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['origem_interesse_id'];
            unset($PostData['origem_interesse_id']);

            $PostData['origem_interesse_status'] = (!empty($PostData['origem_interesse_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_crm_origem_interesse", $PostData, "WHERE origem_interesse_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_origem_interesse";
        endif;

        break;

    case 'OrigemInteresseAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['origem_interesse_status'] = (!empty($PostData['origem_interesse_status']) ? '1' : '0');
            $Create->ExeCreate("sys_crm_origem_interesse", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_origem_interesse";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_crm_origem_interesse", "WHERE origem_interesse_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_crm_origem_interesse", "WHERE origem_interesse_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=crm/filtro_origem_interesse";

        endif;
        break;

endswitch;

echo json_encode($jSON);