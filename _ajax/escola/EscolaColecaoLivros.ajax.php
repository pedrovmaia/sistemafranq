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

    case 'EscolaColecaoLivrosEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['escola_colecao_livros_id'];
            unset($PostData['escola_colecao_livros_id']);

            $PostData['escola_colecao_livros_status'] = (!empty($PostData['escola_colecao_livros_status']) ? '1' : '0');
        
            $Update->ExeUpdate("escola_colecao_livros", $PostData, "WHERE escola_colecao_livros_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/cadastro_colecao_livros&id=" . $Id;
        endif;

        break;

    case 'EscolaColecaoLivrosAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['escola_colecao_livros_status'] = (!empty($PostData['escola_colecao_livros_status']) ? '1' : '0');
            $Create->ExeCreate("escola_colecao_livros", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_colecao_livros";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_colecao_livros", "WHERE escola_colecao_livros_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_colecao_livros", "WHERE escola_colecao_livros_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_colecao_livros";

        endif;
        break;

endswitch;

echo json_encode($jSON);