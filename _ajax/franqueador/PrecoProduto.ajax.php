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

    case 'PrecoProdutoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['preco_produto_id'];
            unset($PostData['preco_produto_id']);
            $PostData['preco_produto_data_inicial'] = (!empty($PostData['preco_produto_data_inicial']) ? Check::Data($PostData['preco_produto_data_inicial']) : date('Y-m-d'));
            $PostData['preco_produto_data_final'] = (!empty($PostData['preco_produto_data_final']) ? Check::Data($PostData['preco_produto_data_final']) : date('Y-m-d'));
            $PostData['preco_produto_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['preco_produto_valor']));

            //$PostData['preco_produto_status'] = (!empty($PostData['preco_produto_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_list_preco_produto", $PostData, "WHERE preco_produto_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_preco_produto";
        endif;

        break;

    case 'PrecoProdutoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
          //  $PostData['preco_produto_status'] = (!empty($PostData['preco_produto_status']) ? '1' : '0');
            $PostData['preco_produto_data_inicial'] = (!empty($PostData['preco_produto_data_inicial']) ? Check::Data($PostData['preco_produto_data_inicial']) : date('Y-m-d'));
            $PostData['preco_produto_data_final'] = (!empty($PostData['preco_produto_data_final']) ? Check::Data($PostData['preco_produto_data_final']) : date('Y-m-d'));
            $PostData['preco_produto_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['preco_produto_valor']));
            $Create->ExeCreate("sys_list_preco_produto", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_preco_produto";
            
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_list_preco_produto", "WHERE preco_produto_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_list_preco_produto", "WHERE preco_produto_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_preco_produto";

        endif;
        break;

endswitch;

echo json_encode($jSON);