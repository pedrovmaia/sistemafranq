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

    case 'JurosMultaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['juros_multa_id'];
            unset($PostData['juros_multa_id']);

            $PostData['data_inicial'] = (!empty($PostData['data_inicial']) ? Check::Data($PostData['data_inicial']) : date('Y-m-d'));
            $PostData['data_final'] = (!empty($PostData['data_final']) ? Check::Data($PostData['data_final']) : date('Y-m-d'));

            $PostData['multa']  = str_replace(',', '.', str_replace('.', '', $PostData['multa']));
            $PostData['juros']  = str_replace(',', '.', str_replace('.', '', $PostData['juros']));

        
            $Update->ExeUpdate("sys_juros_multa", $PostData, "WHERE juros_multa_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_juros_multa";
        endif;

        break;

    case 'JurosMultaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
           $PostData['data_inicial'] = (!empty($PostData['data_inicial']) ? Check::Data($PostData['data_inicial']) : date('Y-m-d'));
            $PostData['data_final'] = (!empty($PostData['data_final']) ? Check::Data($PostData['data_final']) : date('Y-m-d'));

            $PostData['multa']  = str_replace(',', '.', str_replace('.', '', $PostData['multa']));
            $PostData['juros']  = str_replace(',', '.', str_replace('.', '', $PostData['juros']));
            
            $Create->ExeCreate("sys_juros_multa", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_juros_multa";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_juros_multa", "WHERE juros_multa_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_juros_multa", "WHERE juros_multa_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_juros_multa";

        endif;
        break;

endswitch;

echo json_encode($jSON);