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

    case 'OcupacoesEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['ocupacao_id'];
            unset($PostData['ocupacao_id']);

            $PostData['ocupacao_status'] = (!empty($PostData['ocupacao_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_ocupacoes", $PostData, "WHERE ocupacao_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_ocupacoes";
        endif;

        break;

    case 'OcupacoesAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['ocupacao_status'] = (!empty($PostData['ocupacao_status']) ? '1' : '0');
            $Create->ExeCreate("sys_ocupacoes", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_ocupacoes";
            
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_ocupacoes", "WHERE ocupacao_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_ocupacoes", "WHERE ocupacao_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_ocupacoes";

        endif;
        break;

endswitch;

echo json_encode($jSON);