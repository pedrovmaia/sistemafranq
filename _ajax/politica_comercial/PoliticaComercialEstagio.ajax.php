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

    case 'PoliticaEstagioEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['politica_comercial_id'];
            unset($PostData['politica_comercial_id']);

            $PostData['politica_comercial_data_inicio'] = (!empty($PostData['politica_comercial_data_inicio']) ? Check::Data($PostData['politica_comercial_data_inicio']) : date('Y-m-d'));
            $PostData['politica_comercial_data_final'] = (!empty($PostData['politica_comercial_data_final']) ? Check::Data($PostData['politica_comercial_data_final']) : date('Y-m-d'));
            
            $PostData['politica_comercial_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['politica_comercial_valor']));
        
            $Update->ExeUpdate("sys_politica_comercial_estagios", $PostData, "WHERE politica_comercial_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_politica_estagio";
        endif;

        break;

    case 'PoliticaEstagioAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['politica_comercial_data_inicio'] = (!empty($PostData['politica_comercial_data_inicio']) ? Check::Data($PostData['politica_comercial_data_inicio']) : date('Y-m-d'));
            $PostData['politica_comercial_data_final'] = (!empty($PostData['politica_comercial_data_final']) ? Check::Data($PostData['politica_comercial_data_final']) : date('Y-m-d'));
            $PostData['politica_comercial_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['politica_comercial_valor']));
            

            $Create->ExeCreate("sys_politica_comercial_estagios", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_politica_estagio";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_politica_comercial_estagios", "WHERE politica_comercial_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_politica_comercial_estagios", "WHERE politica_comercial_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_politica_estagio";

        endif;
        break;

endswitch;

echo json_encode($jSON);