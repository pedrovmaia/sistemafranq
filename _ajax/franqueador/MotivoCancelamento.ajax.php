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
endif;

switch ($action):

    case 'MotivoCancelamentoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = "Favor, preencha todos os campos!";
        else:
            $Id = $PostData['motivo_cancelamento_id'];
            unset($PostData['motivo_cancelamento_id']);

            $PostData['motivo_cancelamento_status'] = (!empty($PostData['motivo_cancelamento_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_motivos_cancelamento", $PostData, "WHERE motivo_cancelamento_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivos_cancelamento";
        endif;

        break;

          case 'MotivoCancelamentoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['motivo_cancelamento_status'] = (!empty($PostData['motivo_cancelamento_status']) ? '1' : '0');
            $Create->ExeCreate("sys_motivos_cancelamento", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivos_cancelamento";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_motivos_cancelamento", "WHERE motivo_cancelamento_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_motivo_scancelamento", "WHERE motivo_cancelamento_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivos_cancelamento";

        endif;
        break;

endswitch;

echo json_encode($jSON);