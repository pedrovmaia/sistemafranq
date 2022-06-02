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

    case 'MotivoNaoFechamentoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['motivo_nao_fechamento_id'];
            unset($PostData['motivo_nao_fechamento_id']);

            $PostData['motivo_nao_fechamento_status'] = (!empty($PostData['motivo_nao_fechamento_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_motivo_nao_fechamento", $PostData, "WHERE motivo_nao_fechamento_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivo_nao_fechamento";
        endif;

        break;

    case 'MotivoNaoFechamentoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['motivo_nao_fechamento_status'] = (!empty($PostData['motivo_nao_fechamento_status']) ? '1' : '0');
            $Create->ExeCreate("sys_motivo_nao_fechamento", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivo_nao_fechamento";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_motivo_nao_fechamento", "WHERE motivo_nao_fechamento_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_motivo_nao_fechamento", "WHERE motivo_nao_fechamento_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_motivo_nao_fechamento";

        endif;
        break;

endswitch;

echo json_encode($jSON);