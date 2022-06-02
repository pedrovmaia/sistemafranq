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

    case 'OperadorEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['operador_id'];
            unset($PostData['operador_id']);
            $PostData['senha'] = hash('sha512', $PostData['senha']);
        
            $Update->ExeUpdate("sys_operadores_financeiro", $PostData, "WHERE operador_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_operadores_financeiro";
        endif;

        break;

    case 'OperadorAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['senha'] = hash('sha512', $PostData['senha']);

            $Create->ExeCreate("sys_operadores_financeiro", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_operadores_financeiro";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_operadores_financeiro", "WHERE operador_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_operadores_financeiro", "WHERE operador_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_operadores_financeiro";

        endif;
        break;

endswitch;

echo json_encode($jSON);