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

     case 'TestePessoaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
             $PostData['testes_pessoa_data_realizada'] = (!empty($PostData['testes_pessoa_data_realizada']) ? Check::Data($PostData['testes_pessoa_data_realizada']) : date('Y-m-d'));
              $PostData['testes_pessoa_data'] = (!empty($PostData['testes_pessoa_data']) ? Check::Data($PostData['testes_pessoa_data']) : date('Y-m-d'));
            $Create->ExeCreate("sys_testes_pessoa", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/filtro_teste_pessoa&id=" .  $PostData['testes_pessoa_pessoa_id'];

        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_testes_pessoa", "WHERE testes_pessoa_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_testes_pessoa", "WHERE testes_pessoa_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=rh/filtro_teste_pessoa&id=" . $Read->getResult()[0]['testes_pessoa_pessoa_id'];


        endif;
        break;

endswitch;

echo json_encode($jSON);