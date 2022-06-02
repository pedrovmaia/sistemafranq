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

    case 'MateriasAulaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['materias_aula_id'];
            unset($PostData['materias_aula_id']);

            $PostData['materias_aula_status'] = (!empty($PostData['materias_aula_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_materias_aula", $PostData, "WHERE materias_aula_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_materias_aula&id=" . $PostData['materias_aula_estagio_id'];
        endif;

        break;

    case 'MateriasAulaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $EstagioId = $PostData['materias_aula_estagio_id'];
            $PostData['materias_aula_status'] = (!empty($PostData['materias_aula_status']) ? '1' : '0');
            $Create->ExeCreate("sys_materias_aula", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            //$jSON['redirect'] = "painel.php?exe=pedagogico/cadastro_materias_aula&id=" . $Id;
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_materias_aula&id=" . $PostData['materias_aula_estagio_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_materias_aula", "WHERE materias_aula_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_materias_aula&id=" . $Read->getResult()[0]['materias_aula_estagio_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);