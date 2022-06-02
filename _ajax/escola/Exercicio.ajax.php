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

    case 'ExercicioEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['exercicio_id'];
            $EstagioId  = $PostData['exercicio_estagio_id'];
            unset($PostData['exercicio_id']);

            $PostData['exercicio_status'] = (!empty($PostData['exercicio_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_escola_exercicios", $PostData, "WHERE exercicio_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/avaliacao/filtro_exercicio&id=" . $PostData['exercicio_estagio_id'];
        endif;

        break;

    case 'ExercicioAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['exercicio_status'] = (!empty($PostData['exercicio_status']) ? '1' : '0');
            $Create->ExeCreate("sys_escola_exercicios", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/avaliacao/filtro_exercicio&id=" . $PostData['exercicio_estagio_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_escola_exercicios", "WHERE exercicio_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/avaliacao/filtro_exercicio&id=" . $Read->getResult()[0]['exercicio_estagio_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);