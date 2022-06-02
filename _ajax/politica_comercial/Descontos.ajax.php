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

    case 'DescontosEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['desconto_id'];
            unset($PostData['desconto_id']);

            $PostData['desconto_data_inicial'] = (!empty($PostData['desconto_data_inicial']) ? Check::Data($PostData['desconto_data_inicial']) : date('Y-m-d'));
            $PostData['desconto_data_final'] = (!empty($PostData['desconto_data_final']) ? Check::Data($PostData['desconto_data_final']) : date('Y-m-d'));

            $PostData['desconto_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['desconto_valor']));

            $PostData['desconto_status'] = (!empty($PostData['desconto_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_descontos", $PostData, "WHERE desconto_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_descontos";
        endif;

        break;

    case 'DescontosAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['desconto_data_inicial'] = (!empty($PostData['desconto_data_inicial']) ? Check::Data($PostData['desconto_data_inicial']) : date('Y-m-d'));
            $PostData['desconto_data_final'] = (!empty($PostData['desconto_data_final']) ? Check::Data($PostData['desconto_data_final']) : date('Y-m-d'));

            $PostData['desconto_valor']  = str_replace(',', '.', str_replace('.', '', $PostData['desconto_valor']));

            $PostData['desconto_status'] = (!empty($PostData['desconto_status']) ? '1' : '0');
            $Create->ExeCreate("sys_descontos", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_descontos";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_descontos", "WHERE desconto_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_descontos", "WHERE desconto_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=politica_comercial/filtro_descontos";

        endif;
        break;

endswitch;

echo json_encode($jSON);