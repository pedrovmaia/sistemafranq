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

    case 'TipoHistoricoFuncionarioEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['tipo_id'];
            unset($PostData['tipo_id']);

            $PostData['tipo_status'] = (!empty($PostData['tipo_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_tipo_historicos_pessoa", $PostData, "WHERE tipo_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/filtro_tipo_historico_funcionario";
        endif;

        break;

    case 'TipoHistoricoFuncionarioAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['tipo_status'] = (!empty($PostData['tipo_status']) ? '1' : '0');
            $Create->ExeCreate("sys_tipo_historicos_pessoa", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/filtro_tipo_historico_funcionario";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_tipo_historicos_pessoa", "WHERE tipo_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_tipo_historicos_pessoa", "WHERE tipo_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=rh/filtro_tipo_historico_funcionario";

        endif;
        break;

endswitch;

echo json_encode($jSON);