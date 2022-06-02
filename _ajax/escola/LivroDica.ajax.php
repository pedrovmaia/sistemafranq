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

    case 'LivroDicaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['livro_dica_id'];
            unset($PostData['livro_dica_id']);
        
            $Update->ExeUpdate("escola_livro_dica", $PostData, "WHERE livro_dica_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_dica&id=" . $PostData['livro_dica_livro_id'];
        endif;

        break;

    case 'LivroDicaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
              $PostData['livro_dica_date'] = (!empty($PostData['livro_dica_date']) ? Check::Data($PostData['livro_dica_date']) : date('Y-m-d H:i:s'));
      
            $Create->ExeCreate("escola_livro_dica", $PostData);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_dica&id=" . $PostData['livro_dica_livro_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_livro_dica", "WHERE livro_dica_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_livro_dica", "WHERE livro_dica_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/livros/filtro_livro_dica&id=". $Read->getResult()[0]['livro_dica_livro_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);