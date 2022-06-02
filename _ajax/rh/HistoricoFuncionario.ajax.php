<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
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

    case 'HistoricoFuncionarioEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['historico_data'] = (!empty($PostData['historico_data']) ? Check::Data($PostData['historico_data']) : date('Y-m-d'));
            $Id = $PostData['historico_id'];
            unset($PostData['historico_id']);
        
            $Update->ExeUpdate("sys_historicos_pessoa", $PostData, "WHERE historico_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/colaborador/cadastro_historico_funcionario&id=" . $Id;
        endif;

        break;

    case 'HistoricoFuncionarioAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['historico_data'] = (!empty($PostData['historico_data']) ? Check::Data($PostData['historico_data']) : date('Y-m-d'));
            $Create->ExeCreate("sys_historicos_pessoa", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/colaborador/filtro_historico_funcionario";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_historicos_pessoa", "WHERE historico_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_historicos_pessoa", "WHERE historico_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=rh/colaborador/filtro_historico_funcionario";

        endif;
        break;

endswitch;

echo json_encode($jSON);