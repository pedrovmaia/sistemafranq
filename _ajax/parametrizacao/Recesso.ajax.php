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

    case 'RecessoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['recesso_id'];
            unset($PostData['recesso_id']);

            $PostData['recesso_data_inicial'] = (!empty($PostData['recesso_data_inicial']) ? Check::Data($PostData['recesso_data_inicial']) : date('Y-m-d H:i:s'));
             $PostData['recesso_data_final'] = (!empty($PostData['recesso_data_final']) ? Check::Data($PostData['recesso_data_final']) : date('Y-m-d H:i:s'));

            $PostData['recesso_status'] = (!empty($PostData['recesso_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_recesso", $PostData, "WHERE recesso_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_recesso";
        endif;

        break;

    case 'RecessoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['recesso_data_inicial'] = (!empty($PostData['recesso_data_inicial']) ? Check::Data($PostData['recesso_data_inicial']) : date('Y-m-d H:i:s'));
             $PostData['recesso_data_final'] = (!empty($PostData['recesso_data_final']) ? Check::Data($PostData['recesso_data_final']) : date('Y-m-d H:i:s'));
            $PostData['recesso_status'] = (!empty($PostData['recesso_status']) ? '1' : '0');




            $Create->ExeCreate("sys_recesso", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_recesso";
            
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_recesso", "WHERE recesso_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_recesso", "WHERE recesso_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=parametrizacao/filtro_recesso";

        endif;
        break;

endswitch;

echo json_encode($jSON);