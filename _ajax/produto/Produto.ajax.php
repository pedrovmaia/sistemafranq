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

    case 'ProdutoEditar':

        $Id = $PostData['produto_id'];
        unset($PostData['produto_id']);

        if (!empty($_FILES['produto_capa'])):
            $File = $_FILES['produto_capa'];

            $Read->FullRead("SELECT produto_capa FROM sys_produto WHERE produto_id = :id", "id={$Id}");
            if ($Read->getResult() && file_exists("../../uploads/{$Read->getResult()[0]['produto_capa']}") && !is_dir("../../uploads/{$Read->getResult()[0]['produto_capa']}")):
                unlink("../../uploads/{$Read->getResult()[0]['produto_capa']}");
            endif;

            $capa_titulo = Check::Name($PostData['produto_nome']);

            $Upload = new Upload('../../uploads/');
            $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
            if ($Upload->getResult()):
                $PostData['produto_capa'] = $Upload->getResult();
            else:
                $jSON['error'] = 'ERRO AO ENVIAR CAPA: selecione uma imagem JPG ou PNG para enviar como capa!';
                echo json_encode($jSON);
                return;
            endif;
        else:
            unset($PostData['produto_capa']);
        endif;

        $PostData['produto_status'] = (!empty($PostData['produto_status']) ? '1' : '0');

        $Update->ExeUpdate("sys_produto", $PostData, "WHERE produto_id = :id", "id={$Id}");
        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        $jSON['redirect'] = "painel.php?exe=produtos/produto/filtro_produto";


        break;

    case 'ProdutoAdd':

        if (!empty($_FILES['produto_capa'])):
            $File = $_FILES['produto_capa'];

            $capa_titulo = Check::Name($PostData['produto_nome']);

            $Upload = new Upload('../../uploads/');
            $Upload->Image($File, $capa_titulo . '-' . time(), IMAGE_W);
            if ($Upload->getResult()):
                $PostData['produto_capa'] = $Upload->getResult();
            else:
                $jSON['error'] = 'ERRO AO ENVIAR CAPA: selecione uma imagem JPG ou PNG para enviar como capa!';
                echo json_encode($jSON);
                return;
            endif;
        else:
            unset($PostData['produto_capa']);
        endif;
       
        $PostData['produto_status'] = (!empty($PostData['produto_status']) ? '1' : '0');
        $Create->ExeCreate("sys_produto", $PostData);
        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        $jSON['redirect'] = "painel.php?exe=produtos/produto/filtro_produto";

        break;

    case 'delete':
        
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_produto", "WHERE produto_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_produto", "WHERE produto_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=produtos/produto/filtro_produto";

        endif;
        break;

endswitch;

echo json_encode($jSON);