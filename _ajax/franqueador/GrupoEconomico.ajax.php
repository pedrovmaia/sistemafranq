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

    case 'GrupoEconomicoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['grupo_economico_id'];
            unset($PostData['grupo_economico_id']);

            $PostData['grupo_economico_status'] = (!empty($PostData['grupo_economico_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_grupos_economico", $PostData, "WHERE grupo_economico_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_grupos_economicos";
        endif;

        break;

    case 'GrupoEconomicoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['grupo_economico_status'] = (!empty($PostData['grupo_economico_status']) ? '1' : '0');
            $Create->ExeCreate("sys_grupos_economico", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_grupos_economicos";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_grupos_economico", "WHERE grupo_economico_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_grupos_economico", "WHERE grupo_economico_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_grupos_economicos";

        endif;
        break;

endswitch;

echo json_encode($jSON);