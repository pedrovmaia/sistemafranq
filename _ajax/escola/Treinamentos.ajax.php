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

    case 'TreinamentosEditar':
        
        $Id = $PostData['treinamentos_id'];
        unset($PostData['treinamentos_id']);

       // $PostData['treinamentos_status'] = (!empty($PostData['treinamentos_status']) ? '1' : '0');
        $PostData['treinamentos_data_realizacao'] = (!empty($PostData['treinamentos_data_realizacao']) ? Check::Data($PostData['treinamentos_data_realizacao']) : date('Y-m-d H:i:s'));
    
        $Update->ExeUpdate("escola_treinamentos", $PostData, "WHERE treinamentos_id = :id", "id={$Id}");
        $jSON['success'] = 'Sua edição foi salva com sucesso!';
        $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_treinamentos";
        break;

    case 'TreinamentosAdd':
        if (in_array('', $PostData)) {
            $jSON['error'] = 'Favor, preencha todos os campos!';
        } elseif (Check::Data($PostData['treinamentos_data_realizacao']) != true){
            $jSON['error'] = 'Data é inválida!';
        } else {
            // $PostData['treinamentos_status'] = (!empty($PostData['treinamentos_status']) ? '1' : '0');
            $PostData['treinamentos_date'] = (!empty($PostData['treinamentos_date']) ? Check::Data($PostData['treinamentos_date']) : date('Y-m-d H:i:s'));
            $PostData['treinamentos_data_realizacao'] = (!empty($PostData['treinamentos_data_realizacao']) ? Check::Data($PostData['treinamentos_data_realizacao']) : date('Y-m-d H:i:s'));

            $Create->ExeCreate("escola_treinamentos", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_treinamentos";
        }

        break;

   case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_treinamentos", "WHERE treinamentos_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_treinamentos", "WHERE treinamentos_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_treinamentos";

        endif;
        break;

endswitch;

echo json_encode($jSON);