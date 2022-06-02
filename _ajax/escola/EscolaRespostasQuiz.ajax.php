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

    case 'RespostasQuizEditar':

        if ($PostData['escola_respostas_quiz_resposta'] == ""):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['escola_respostas_quiz_id'];
            unset($PostData['escola_respostas_quiz_id']);

            if (!empty($_FILES['escola_respostas_quiz_imagem'])):
                $File = $_FILES['escola_respostas_quiz_imagem'];

                $Read->FullRead("SELECT quiz_capa FROM escola_quizzes WHERE quiz_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['escola_respostas_quiz_imagem']}") && !is_dir("../../uploads/{$Read->getResult()[0]['escola_respostas_quiz_imagem']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['escola_respostas_quiz_imagem']}");
                endif;

                $capa_titulo = Check::Name($PostData['escola_respostas_quiz_resposta']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);

                if ($Upload->getResult()):
                    $PostData['escola_respostas_quiz_imagem'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR CAPA:' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['escola_respostas_quiz_imagem']);
            endif;

            $Update->ExeUpdate("escola_respostas_quiz", $PostData, "WHERE escola_respostas_quiz_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_escola_respostas_quiz&id=" . $PostData['escola_respostas_quiz_quiz_id'];
        endif;

        break;

    case 'RespostasQuizAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if (!empty($_FILES['escola_respostas_quiz_imagem'])):
                $File = $_FILES['escola_respostas_quiz_imagem'];

                $capa_titulo = Check::Name($PostData['escola_respostas_quiz_resposta']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['escola_respostas_quiz_imagem'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR CAPA:' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['escola_respostas_quiz_imagem']);
            endif;
      
            $Create->ExeCreate("escola_respostas_quiz", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_escola_respostas_quiz&id=" . $PostData['escola_respostas_quiz_quiz_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_respostas_quiz", "WHERE escola_respostas_quiz_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_respostas_quiz", "WHERE escola_respostas_quiz_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_escola_respostas_quiz&id=". $Read->getResult()[0]['escola_respostas_quiz_quiz_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);