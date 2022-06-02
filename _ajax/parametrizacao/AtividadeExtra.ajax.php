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

    case 'AtividadeExtraEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['atividades_extra_id'];
            unset($PostData['atividades_extra_id']);
             $PostData['atividades_extra_data_inicial'] = (!empty($PostData['atividades_extra_data_inicial']) ? Check::Data($PostData['atividades_extra_data_inicial']) : date('Y-m-d H:i:s'));
             $PostData['atividades_extra_data_final'] = (!empty($PostData['atividades_extra_data_final']) ? Check::Data($PostData['atividades_extra_data_final']) : date('Y-m-d H:i:s'));

            $PostData['atividades_extra_status'] = (!empty($PostData['atividades_extra_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_atividades_extra_curriculares", $PostData, "WHERE atividades_extra_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_atividade_extra";
        endif;

        break;

    case 'AtividadeExtraAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['atividades_extra_data_inicial'] = (!empty($PostData['atividades_extra_data_inicial']) ? Check::Data($PostData['atividades_extra_data_inicial']) : date('Y-m-d H:i:s'));
            $PostData['atividades_extra_data_final'] = (!empty($PostData['atividades_extra_data_final']) ? Check::Data($PostData['atividades_extra_data_final']) : date('Y-m-d H:i:s'));
           $PostData['atividades_extra_status'] = (!empty($PostData['atividades_extra_status']) ? '1' : '0');
            $Create->ExeCreate("sys_atividades_extra_curriculares", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_atividade_extra";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_atividades_extra_curriculares", "WHERE atividades_extra_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_atividades_extra_curriculares", "WHERE atividades_extra_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_atividade_extra";

        endif;
        break;

endswitch;

echo json_encode($jSON);