<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'FeriasEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['ferias_data_inicial'] = (!empty($PostData['ferias_data_inicial']) ? Check::Data($PostData['ferias_data_inicial']) : date('Y-m-d H:i:s'));
             $PostData['ferias_data_final'] = (!empty($PostData['ferias_data_final']) ? Check::Data($PostData['ferias_data_final']) : date('Y-m-d H:i:s'));
            $Id = $PostData['ferias_id'];
            unset($PostData['ferias_id']);

            $PostData['ferias_status'] = (!empty($PostData['ferias_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_ferias", $PostData, "WHERE ferias_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/filtro_ferias&id=" . $Id;
        endif;

        break;

    case 'FeriasAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
              $PostData['ferias_data_inicial'] = (!empty($PostData['ferias_data_inicial']) ? Check::Data($PostData['ferias_data_inicial']) : date('Y-m-d H:i:s'));
             $PostData['ferias_data_final'] = (!empty($PostData['ferias_data_final']) ? Check::Data($PostData['ferias_data_final']) : date('Y-m-d H:i:s'));
            $PostData['ferias_status'] = (!empty($PostData['ferias_status']) ? '1' : '0');
            $Create->ExeCreate("sys_ferias", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=rh/filtro_ferias";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_ferias", "WHERE ferias_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_ferias", "WHERE ferias_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=rh/filtro_ferias";

        endif;
        break;

endswitch;

echo json_encode($jSON);