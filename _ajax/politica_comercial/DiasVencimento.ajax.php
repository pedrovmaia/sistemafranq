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

    case 'DiasVencimentoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['dias_vencimento_id'];
            unset($PostData['dias_vencimento_id']);

            $PostData['dias_vencimento_status'] = (!empty($PostData['dias_vencimento_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_dias_vencimento", $PostData, "WHERE dias_vencimento_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_dias_vencimento";
        endif;

        break;

    case 'DiasVencimentoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['dias_vencimento_status'] = (!empty($PostData['dias_vencimento_status']) ? '1' : '0');
            $Create->ExeCreate("sys_dias_vencimento", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_dias_vencimento";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_dias_vencimento", "WHERE dias_vencimento_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_dias_vencimento";

        endif;
        break;

endswitch;

echo json_encode($jSON);