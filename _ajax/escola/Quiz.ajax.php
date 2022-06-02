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

    case 'QuizEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['quiz_id'];
            unset($PostData['quiz_id']);

            $PostData['quiz_status'] = (!empty($PostData['quiz_status']) ? '1' : '0');

            if (!empty($_FILES['quiz_capa'])):
                $File = $_FILES['quiz_capa'];

                $Read->FullRead("SELECT quiz_capa FROM escola_quizzes WHERE quiz_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['quiz_capa']}") && !is_dir("../../uploads/{$Read->getResult()[0]['quiz_capa']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['quiz_capa']}");
                endif;

                $capa_titulo = Check::Name($PostData['quiz_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['quiz_capa'] = $Upload->getResult();
                else:
                    $jSON['error'] = '<b>ERRO AO ENVIAR CAPA:</b> selecione uma imagem JPG ou PNG para enviar como capa!';
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['quiz_capa']);
            endif;
        
            $Update->ExeUpdate("escola_quizzes", $PostData, "WHERE quiz_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz";
        endif;

        break;

    case 'QuizAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if (!empty($_FILES['quiz_capa'])):
                $File = $_FILES['quiz_capa'];

                $capa_titulo = Check::Name($PostData['quiz_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['quiz_capa'] = $Upload->getResult();
                else:
                    $jSON['error'] = '<b>ERRO AO ENVIAR CAPA:</b> selecione uma imagem JPG ou PNG para enviar como capa!';
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['quiz_capa']);
            endif;

            $PostData['quiz_date'] = (!empty($PostData['quiz_date']) ? Check::Data($PostData['quiz_date']) : date('Y-m-d H:i:s'));
            $PostData['quiz_status'] = (!empty($PostData['quiz_status']) ? '1' : '0');
            $Create->ExeCreate("escola_quizzes", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_quizzes", "WHERE quiz_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_quizzes", "WHERE quiz_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/quiz/filtro_quiz";

        endif;
        break;

endswitch;

echo json_encode($jSON);