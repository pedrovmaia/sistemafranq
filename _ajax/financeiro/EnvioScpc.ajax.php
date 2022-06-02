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

    case 'EnvioScpcEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['envio_id'];
            unset($PostData['envio_id']);
          $PostData['envio_data_inclusao'] = (!empty($PostData['envio_data_inclusao']) ? Check::Data($PostData['envio_data_inclusao']) : date('Y-m-d H:i:s'));
          $PostData['envio_data_retirada'] = (!empty($PostData['envio_data_retirada']) ? Check::Data($PostData['envio_data_retirada']) : date('Y-m-d H:i:s'));
        
            $Update->ExeUpdate("sys_envio_scpc", $PostData, "WHERE envio_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=contasreceber/cadastro_envio_spc&id=" . $Id;
        endif;

        break;

    case 'EnvioScpcAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['envio_data_inclusao'] = (!empty($PostData['envio_data_inclusao']) ? Check::Data($PostData['envio_data_inclusao']) : date('Y-m-d H:i:s'));
            $PostData['envio_data_retirada'] = (!empty($PostData['envio_data_retirada']) ? Check::Data($PostData['envio_data_retirada']) : date('Y-m-d H:i:s'));
            $Create->ExeCreate("sys_envio_scpc", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=contasreceber/ver_titulo_receber&id=" . $PostData['envio_movimentacao_recebimento_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_envio_scpc", "WHERE envio_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_envio_scpc", "WHERE envio_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=contasreceber/ver_titulo_receber&id=" . $envio_movimentacao_recebimento_id;

        endif;
        break;

endswitch;

echo json_encode($jSON);