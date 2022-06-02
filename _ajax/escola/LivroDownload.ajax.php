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
    $error = new error;
endif;

switch ($action):

    case 'LivroDownloadEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['livro_download_id'];
            unset($PostData['livro_download_id']);

            if (!empty($_FILES['livro_download_arquivo'])):
                $File = $_FILES['livro_download_arquivo'];

                $Read->FullRead("SELECT escola_livro_download FROM escola_downloads WHERE livro_download_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['livro_download_arquivo']}") && !is_dir("../../uploads/{$Read->getResult()[0]['livro_download_arquivo']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['livro_download_arquivo']}");
                endif;

                $download_titulo = Check::Name($PostData['livro_download_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $download_titulo . '-' . time(), "files", 300);
                if ($Upload->getResult()):
                    $PostData['livro_download_arquivo'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR ARQUIVO:</b> ' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['livro_download_arquivo']);
            endif;

            if (!empty($_FILES['livro_download_capa'])):
                $File = $_FILES['livro_download_capa'];

                $Read->FullRead("SELECT livro_download_capa FROM escola_downloads WHERE livro_download_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['livro_download_capa']}") && !is_dir("../../uploads/{$Read->getResult()[0]['livro_download_capa']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['livro_download_capa']}");
                endif;

                $capa_titulo = Check::Name($PostData['livro_download_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['livro_download_capa'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR CAPA: selecione uma imagem JPG ou PNG para enviar como capa!';
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['livro_download_capa']);
            endif;
        
            $Update->ExeUpdate("escola_livro_download", $PostData, "WHERE livro_download_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_download&id=" . $PostData['livro_download_livro_id'];
        endif;

        break;

    case 'LivroDownloadAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['livro_download_data'] = (!empty($PostData['livro_download_data']) ? Check::Data($PostData['livro_download_data']) : date('Y-m-d H:i:s'));

            if (!empty($_FILES['livro_download_arquivo'])):
                $File = $_FILES['livro_download_arquivo'];

                $download_titulo = Check::Name($PostData['livro_download_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $download_titulo . '-' . time(), "files", 300);
                if ($Upload->getResult()):
                    $PostData['livro_download_arquivo'] = $Upload->getResult();
                else:
                    $jSON['error'] ='ERRO AO ENVIAR ARQUIVO:' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['livro_download_arquivo']);
            endif;

            if (!empty($_FILES['livro_download_capa'])):
                $File = $_FILES['livro_download_capa'];

                $capa_titulo = Check::Name($PostData['livro_download_titulo']);

                $Upload = new Upload('../../uploads/');
                $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['livro_download_capa'] = $Upload->getResult();
                else:
                    $jSON['error'] = 'ERRO AO ENVIAR CAPA: selecione uma imagem JPG ou PNG para enviar como capa!';
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['livro_download_capa']);
                
            $Create->ExeCreate("escola_livro_download", $PostData);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_download&id=" . $PostData['livro_download_livro_id'];
            endif;

        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_livro_download", "WHERE livro_download_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['error'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_livro_download", "WHERE livro_download_id = :user", "user={$Id}");
            //$jSON['error'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_download&id=". $Read->getResult()[0]['livro_download_livro_id'];


        endif;
        break;

endswitch;

echo json_encode($jSON);