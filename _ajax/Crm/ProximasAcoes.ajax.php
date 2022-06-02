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

    case 'ProximasAcoesEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['acoes_id'];
            unset($PostData['acoes_id']);

            $PostData['acoes_status'] = (!empty($PostData['acoes_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_crm_proximas_acoes_tipo_atendimento", $PostData, "WHERE acoes_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
             $jSON['redirect'] = "painel.php?exe=crm/cadastro_proximas_acoes_tipo_atendimento&id=" . $Id;
        endif;

        break;

    case 'ProximasAcoesAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['acoes_status'] = (!empty($PostData['acoes_status']) ? '1' : '0');
            $Create->ExeCreate("sys_crm_proximas_acoes_tipo_atendimento", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_proximas_acoes_tipo_atendimento";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_crm_proximas_acoes_tipo_atendimento", "WHERE acoes_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_crm_proximas_acoes_tipo_atendimento", "WHERE acoes_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=crm/filtro_proximas_acoes_tipo_atendimento";

        endif;
        break;

endswitch;

echo json_encode($jSON);