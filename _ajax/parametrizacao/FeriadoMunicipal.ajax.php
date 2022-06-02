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

    case 'FeriadoMunicipalEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['feriado_municipal_id'];
            unset($PostData['feriado_municipal_id']);
             $PostData['feriado_municipal_data'] = (!empty($PostData['feriado_municipal_data']) ? Check::Data($PostData['feriado_municipal_data']) : date('Y-m-d H:i:s'));

            $PostData['feriado_status'] = (!empty($PostData['feriado_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_feriado_municipal", $PostData, "WHERE feriado_municipal_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_feriado_municipal";
        endif;

        break;

    case 'FeriadoMunicipalAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['feriado_municipal_data'] = (!empty($PostData['feriado_municipal_data']) ? Check::Data($PostData['feriado_municipal_data']) : date('Y-m-d H:i:s'));
           $PostData['feriado_status'] = (!empty($PostData['feriado_status']) ? '1' : '0');
            $Create->ExeCreate("sys_feriado_municipal", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_feriado_municipal";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_feriado_municipal", "WHERE feriado_municipal_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_feriado_municipal", "WHERE feriado_municipal_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_feriado_municipal";

        endif;
        break;

endswitch;

echo json_encode($jSON);