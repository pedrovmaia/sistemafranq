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

    case 'EtapaProdutoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['etapa_produto_id'];
            unset($PostData['etapa_produto_id']);

            $PostData['etapa_produto_status'] = (!empty($PostData['etapa_produto_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_etapa_produto", $PostData, "WHERE etapa_produto_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
           $jSON['redirect'] = "painel.php?exe=escola/admin/filtro_etapa_produto";
        endif;

        break;

    case 'EtapaProdutoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['etapa_produto_status'] = (!empty($PostData['etapa_produto_status']) ? '1' : '0');
            $Create->ExeCreate("sys_etapa_produto", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/filtro_etapa_produto&id=" . $PostData[''];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_etapa_produto", "WHERE etapa_produto_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_etapa_produto", "WHERE etapa_produto_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/admin/filtro_etapa_produto";

        endif;
        break;

endswitch;

echo json_encode($jSON);