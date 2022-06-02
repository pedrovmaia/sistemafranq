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

    case 'ControleChequeEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['controle_cheque_data'] = (!empty($PostData['controle_cheque_data']) ? Check::Data($PostData['controle_cheque_data']) : date('Y-m-d H:i:s'));
            $Id = $PostData['controle_cheque_id'];
            unset($PostData['controle_cheque_id']);

            $PostData['controle_cheque_status'] = (!empty($PostData['controle_cheque_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_controle_cheque", $PostData, "WHERE controle_cheque_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=financeiro/filtro_controle_cheque";
        endif;

        break;

    case 'ControleChequeAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['controle_cheque_data'] = (!empty($PostData['controle_cheque_data']) ? Check::Data($PostData['controle_cheque_data']) : date('Y-m-d H:i:s'));

            $PostData['controle_cheque_bom_para'] = (!empty($PostData['controle_cheque_bom_para']) ? Check::Data($PostData['controle_cheque_bom_para']) : date('Y-m-d H:i:s'));
            
            $PostData['controle_cheque_status'] = (!empty($PostData['controle_cheque_status']) ? '1' : '0');
            $Create->ExeCreate("sys_controle_cheque", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=financeiro/filtro_controle_cheque";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_controle_cheque", "WHERE controle_cheque_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_controle_cheque", "WHERE controle_cheque_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=financeiro/filtro_controle_cheque";

        endif;
        break;

endswitch;

echo json_encode($jSON);