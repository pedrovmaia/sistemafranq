<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'FuncionalidadesAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $FuncionalidadeId = $PostData['funcionalidade_id'];
            unset($PostData['funcionalidade_id']);

            $Update->ExeUpdate("sys_funcionalidades", $PostData, "WHERE funcionalidade_id = :id", "id={$FuncionalidadeId}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'delete':
        $FuncionalidadeId = $PostData['del_id'];
        $Read->ExeRead("sys_funcionalidades", "WHERE funcionalidade_id = :id", "id={$FuncionalidadeId}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_funcionalidades", "WHERE funcionalidade_id = :id", "id={$FuncionalidadeId}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=admin/acesso/filtro_niveis_acesso";

        endif;
        
        break;

endswitch;

echo json_encode($jSON);