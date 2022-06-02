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

    case 'DownloadEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['escola_download_id'];
            unset($PostData['escola_download_id']);

            if (!empty($_FILES['escola_download_link'])):
                $File = $_FILES['escola_download_link'];

                $Read->FullRead("SELECT escola_download_link FROM escola_downloads WHERE escola_download_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['escola_download_link']}") && !is_dir("../../uploads/{$Read->getResult()[0]['escola_download_link']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['escola_download_link']}");
                endif;

                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $PostData['escola_download_titulo'] . '-' . time(), "files", 300);
                if ($Upload->getResult()):
                    $PostData['escola_download_link'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR ARQUIVO: ' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['image']);
            endif;

            $PostData['escola_download_status'] = (!empty($PostData['escola_download_status']) ? '1' : '0');
        
            $Update->ExeUpdate("escola_downloads", $PostData, "WHERE escola_download_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_downloads";
        endif;

        break;

    case 'DownloadAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if (!empty($_FILES['escola_download_link'])):
                $File = $_FILES['escola_download_link'];
                $download_titulo = Check::Name($PostData['escola_download_titulo']);
                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $download_titulo . '-' . time(), "files", 300);
                if ($Upload->getResult()):
                    $PostData['escola_download_link'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR ARQUIVO: ' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['image']);
            endif;

            $PostData['escola_download_data'] = (!empty($PostData['escola_download_data']) ? Check::Data($PostData['escola_download_data']) : date('Y-m-d H:i:s'));
            $PostData['escola_download_status'] = (!empty($PostData['escola_download_status']) ? '1' : '0');
            $Create->ExeCreate("escola_downloads", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_downloads";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_downloads", "WHERE escola_download_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_downloads", "WHERE escola_download_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_downloads";

        endif;
        break;

endswitch;

echo json_encode($jSON);