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

    case 'AtendimentoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['atendimento_atendente_id'] = $_SESSION["userSYSFranquia"]["pessoa_id"];
            $PostData['atendimento_date'] = date("Y-m-d H:i:s");

            if(isset($PostData['atendimento_agenda_data'])){
                $PostData['atendimento_agendamento'] = 1;
                $PostData['atendimento_agenda_data'] = date("Y-m-d H:i:s", strtotime($PostData['atendimento_agenda_data']));
            }

            unset($PostData['pessoa_nome']);

            $Create->ExeCreate("sys_atendimentos", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/ver_atendimento&id=" . $Create->getResult();
        endif;

        break;

endswitch;

echo json_encode($jSON);