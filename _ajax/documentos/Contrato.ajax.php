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

    case 'ContratoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['contrato_id'];
            unset($PostData['contrato_id']);
            $PostData['contrato_data_vencimento'] = (!empty($PostData['contrato_data_vencimento']) ? Check::Data($PostData['contrato_data_vencimento']) : date('Y-m-d'));

            $PostData['contrato_status'] = (!empty($PostData['contrato_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_contratos", $PostData, "WHERE contrato_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=documentos/cadastro_contrato&id=" . $Id;
        endif;

        break;

    case 'ContratoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['contrato_status'] = (!empty($PostData['contrato_status']) ? '1' : '0');
            $PostData['contrato_data_vencimento'] = (!empty($PostData['contrato_data_vencimento']) ? Check::Data($PostData['contrato_data_vencimento']) : date('Y-m-d'));
            $Create->ExeCreate("sys_contratos", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=documentos/filtro_contrato";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_contratos", "WHERE contrato_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_contratos", "WHERE contrato_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=documentos/filtro_contrato";

        endif;
        break;

endswitch;

echo json_encode($jSON);