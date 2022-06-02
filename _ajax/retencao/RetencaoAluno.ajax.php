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

    case 'OcorrenciaRetencaoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['ocorrencia_retencao_id'];
            unset($PostData['ocorrencia_retencao_id']);

            $PostData['ocorrencia_retencao_status'] = (!empty($PostData['ocorrencia_retencao_status']) ? '1' : '0');

        
            $Update->ExeUpdate("sys_ocorrencia_retencao_aluno", $PostData, "WHERE ocorrencia_retencao_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=retencao/cadastro_ocorrencia_retencao&id=" . $Id;
        endif;

        break;

    case 'OcorrenciaRetencaoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['ocorrencia_retencao_aluno'] = $PostData["pessoa_id"];
            unset($PostData["pessoa_nome"], $PostData["pessoa_id"]);
            $PostData['ocorrencia_retencao_status'] = (!empty($PostData['ocorrencia_retencao_status']) ? '1' : '0');
            $PostData['ocorrencia_retencao_data'] = (!empty($PostData['ocorrencia_retencao_data']) ? Check::Data($PostData['ocorrencia_retencao_data']) : date('Y-m-d H:i:s'));
            $Create->ExeCreate("sys_ocorrencia_retencao_aluno", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=retencao/cadastro_ocorrencia_retencao";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_ocorrencia_retencao_aluno", "WHERE ocorrencia_retencao_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_ocorrencia_retencao_aluno", "WHERE ocorrencia_retencao_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=retencao/cadastro_ocorrencia_retencao";

        endif;
        break;

endswitch;

echo json_encode($jSON);