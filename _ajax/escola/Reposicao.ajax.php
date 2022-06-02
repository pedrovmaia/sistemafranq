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

    case 'ReposicaoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['reposicao_id'];
            unset($PostData['reposicao_id']);

            $PostData['reposicao_data'] = (!empty($PostData['reposicao_data']) ? Check::Data($PostData['reposicao_data']) : date('Y-m-d H:i:s'));

            $PostData['reposicao_status'] = (!empty($PostData['reposicao_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_reposicao", $PostData, "WHERE reposicao_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_reposicao&id=" . $PostData['reposicao_projeto_id'];
        endif;

        break;

    case 'ReposicaoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
             $PostData['reposicao_data'] = (!empty($PostData['reposicao_data']) ? Check::Data($PostData['reposicao_data']) : date('Y-m-d H:i:s'));
            $PostData['reposicao_status'] = (!empty($PostData['reposicao_status']) ? '1' : '0');
            $Create->ExeCreate("sys_reposicao", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_reposicao&id=" . $PostData['reposicao_projeto_id'];
        endif;
        break;

            case 'deleteturma':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_reposicao", "WHERE reposicao_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_reposicao", "WHERE reposicao_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/turma/filtro_reposicao&id=" . $Read->getResult()[0]['reposicao_projeto_id'];

        endif;
        break;

    case 'ReposicaoAlunoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['reposicao_id'];
            unset($PostData['reposicao_id']);

            $PostData['reposicao_data'] = (!empty($PostData['reposicao_data']) ? Check::Data($PostData['reposicao_data']) : date('Y-m-d H:i:s'));

            $PostData['reposicao_status'] = (!empty($PostData['reposicao_status']) ? '1' : '0');

            $Update->ExeUpdate("sys_reposicao", $PostData, "WHERE reposicao_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_reposicao&id=" . $PostData['reposicao_projeto_id'];
        endif;

        break;

    case 'ReposicaoAlunoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['reposicao_data'] = (!empty($PostData['reposicao_data']) ? Check::Data($PostData['reposicao_data']) : date('Y-m-d H:i:s'));
            $PostData['reposicao_status'] = (!empty($PostData['reposicao_status']) ? '1' : '0');
            $Create->ExeCreate("sys_reposicao", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_reposicao&id={$PostData['reposicao_projeto_id']}";
        endif;
        break;

    case 'deletealuno':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_reposicao", "WHERE reposicao_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_reposicao", "WHERE reposicao_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_reposicao&id=" . $Read->getResult()[0]['reposicao_pessoa_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);