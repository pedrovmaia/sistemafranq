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

    case 'EtapaAvaliacaoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['etapa_avaliacao_id'];
            unset($PostData['etapa_avaliacao_id']);

            $PostData['etapa_avaliacao_status'] = (!empty($PostData['etapa_avaliacao_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_etapa_avaliacao", $PostData, "WHERE etapa_avaliacao_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/cadastro_etapa_avaliacao&id={$PostData['etapa_estagio_id']}&idcurso={$PostData['etapa_avaliacao_produto_id']}&idetapa=" . $Id;
        endif;

        break;

    case 'EtapaAvaliacaoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['etapa_avaliacao_status'] = (!empty($PostData['etapa_avaliacao_status']) ? '1' : '0');
            $Create->ExeCreate("sys_etapa_avaliacao", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/filtro_etapa_avaliacao&id={$etapa_estagio_id}&idcurso={$etapa_avaliacao_produto_id}";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_etapa_avaliacao", "WHERE etapa_avaliacao_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_avaliacao_produto", "WHERE etapa_avaliacao_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/admin/filtro_etapa_avaliacao&id={$etapa_estagio_id}&idcurso={$etapa_avaliacao_produto_id}";

        endif;
        break;

endswitch;

echo json_encode($jSON);