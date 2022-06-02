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

    case 'QuizRespostasEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['quiz_respostas_id'];
            unset($PostData['quiz_respostas_id']);
        
            $Update->ExeUpdate("escola_quiz_respostas", $PostData, "WHERE quiz_respostas_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz_respostas&id="  . $PostData['quiz_respostas_pergunta_id'];
        endif;

        break;

    case 'QuizRespostasAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
      
            $Create->ExeCreate("escola_quiz_respostas", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz_respostas&id=" . $PostData['quiz_respostas_pergunta_id'];        
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_quiz_respostas", "WHERE quiz_respostas_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_quiz_respostas", "WHERE quiz_respostas_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz_respostas&id=". $Read->getResult()[0]['quiz_respostas_pergunta_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);