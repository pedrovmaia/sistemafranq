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

    case 'InteresseEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['interesse_id'];
            unset($PostData['interesse_id']);
            $PostData['interesse_idioma_id'] = (!empty($PostData['interesse_idioma_id']) ? implode(',', $PostData['interesse_idioma_id']) : null);

            $PostData['interesse_dia_id'] = (!empty($PostData['interesse_dia_id']) ? implode(',', $PostData['interesse_dia_id']) : null);

            $PostData['interesse_periodo_id'] = (!empty($PostData['interesse_periodo_id']) ? implode(',', $PostData['interesse_periodo_id']) : null);

            $PostData['interesse_data'] = (!empty($PostData['interesse_data']) ? Check::Data($PostData['interesse_data']) : date('Y-m-d H:i:s'));

          $Update->ExeUpdate("sys_crm_interesse", $PostData, "WHERE interesse_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_interesse&id=" . $PostData['interesse_pessoa_id'];
        endif;

        break;

    case 'InteresseAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['interesse_idioma_id'] = (!empty($PostData['interesse_idioma_id']) ? implode(',', $PostData['interesse_idioma_id']) : null);

            $PostData['interesse_dia_id'] = (!empty($PostData['interesse_dia_id']) ? implode(',', $PostData['interesse_dia_id']) : null);

            $PostData['interesse_periodo_id'] = (!empty($PostData['interesse_periodo_id']) ? implode(',', $PostData['interesse_periodo_id']) : null);

            $PostData['interesse_data'] = (!empty($PostData['interesse_data']) ? Check::Data($PostData['interesse_data']) : date('Y-m-d H:i:s'));
            $Create->ExeCreate("sys_crm_interesse", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_interesse&id=" .  $PostData['interesse_pessoa_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_crm_interesse", "WHERE interesse_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_crm_interesse", "WHERE interesse_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=crm/filtro_interesse&id=" . $Read->getResult()[0]['interesse_pessoa_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);