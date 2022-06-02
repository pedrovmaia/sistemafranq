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

    case 'InstituicaoFinanceiraEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['instituicao_financeira_id'];
            unset($PostData['instituicao_financeira_id']);

            $PostData['instituicao_financeira_status'] = (!empty($PostData['instituicao_financeira_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_instituicao_financeira", $PostData, "WHERE instituicao_financeira_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=financeiro/caixas_bancos/filtro_instituicao_financeira"; 
        endif;

        break;

    case 'InstituicaoFinanceiraAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['instituicao_financeira_status'] = (!empty($PostData['instituicao_financeira_status']) ? '1' : '0');
            $Create->ExeCreate("sys_instituicao_financeira", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=financeiro/caixas_bancos/filtro_instituicao_financeira";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_instituicao_financeira", "WHERE instituicao_financeira_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_instituicao_financeira", "WHERE instituicao_financeira_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=financeiro/caixas_bancos/filtro_instituicao_financeira";

        endif;
        break;

endswitch;

echo json_encode($jSON);