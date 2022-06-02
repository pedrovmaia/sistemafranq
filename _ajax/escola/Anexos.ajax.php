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

            if (!empty($_FILES['anexo_link'])):
                $File = $_FILES['anexo_link'];

                $Read->FullRead("SELECT anexo_link FROM escola_downloads WHERE escola_download_id = :id", "id={$Id}");
                if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['anexo_link']}") && !is_dir("../../uploads/{$Read->getResult()[0]['anexo_link']}")):
                    unlink("../../uploads/{$Read->getResult()[0]['anexo_link']}");
                endif;

                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $PostData['anexo_titulo'] . '-' . time(), "files", 300);
                if ($Upload->getResult()):
                    $PostData['anexo_link'] = $Upload->getResult();
                else:
                    $jSON['trigger'] = $trigger->notify('<b>ERRO AO ENVIAR ARQUIVO:</b> ' . $Upload->getError() . ' ', 'orange', 'icon-bullhorn', 4000);
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['image']);
            endif;

            $PostData['escola_download_status'] = (!empty($PostData['escola_download_status']) ? '1' : '0');
        
            $Update->ExeUpdate("escola_downloads", $PostData, "WHERE escola_download_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'AnexoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if (!empty($_FILES['anexo_link'])):
                $File = $_FILES['anexo_link'];
                $anexo_titulo = Check::Name($PostData['anexo_titulo']);
                $Upload = new Upload('../../uploads/');
                $Upload->File($File, $anexo_titulo . '-' . time(), "anexos", 400);
                if ($Upload->getResult()):
                    $PostData['anexo_link'] = $Upload->getResult();
                else:
                    $jSON['error'] = '<b>ERRO AO ENVIAR ARQUIVO:</b> ' . $Upload->getError();
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['anexo_link']);
            endif;

            $PostData['anexo_data'] = (!empty($PostData['anexo_data']) ? Check::Data($PostData['anexo_data']) : date('Y-m-d H:i:s'));

            $Create->ExeCreate("sys_anexos", $PostData);

            $origem = $PostData['anexo_origem'];
            $tabela = $PostData['anexo_tabela'];
            $resultado = "";
            $Read->ExeRead("sys_anexos", "WHERE anexo_origem = :o AND anexo_tabela = :t", "o={$origem}&t={$tabela}");
            if($Read->getResult()){
                foreach ($Read->getResult() as $Anexo) {
                    $resultado .= "<tr class='anexos_list'><td>{$Anexo['anexo_titulo']}</td><td class='td-actions'>";
                    $resultado .= "<a href='download-file.php?arquivo={$Anexo['anexo_link']}' class='btn btn-primary btn-link btn-sm'>";
                    $resultado .= "<i class='material-icons'>cloud_download</i></a></td></tr>";
                }
            } else {
                $resultado .= "<tr class='anexos_list'><td>Sem resultados</td></tr>";
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['clear'] = "true";
            $jSON['tabela'] = $resultado;
        endif;

        break;

    case 'buscarAnexos':

        $origem = $PostData['origem'];
        $tabela = $PostData['tabela'];
        $resultado = "";
        $Read->ExeRead("sys_anexos", "WHERE anexo_origem = :o AND anexo_tabela = :t", "o={$origem}&t={$tabela}");
        if($Read->getResult()){
            foreach ($Read->getResult() as $Anexo) {
                $resultado .= "<tr class='anexos_list'><td>{$Anexo['anexo_titulo']}</td><td class='td-actions'>";
                $resultado .= "<a href='download-file.php?arquivo={$Anexo['anexo_link']}' class='btn btn-primary btn-link btn-sm'>";
                $resultado .= "<i class='material-icons'>cloud_download</i></a></td></tr>";
            }
        } else {
            $resultado .= "<tr class='anexos_list'><td>Sem resultados</td></tr>";
        }

        $jSON['success'] = $resultado;

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