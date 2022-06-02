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

    case 'EmprestimoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['emprestimo_data_reserva'] = (!empty($PostData['emprestimo_data_reserva']) ? Check::Data($PostData['emprestimo_data_reserva']) : date('Y-m-d H:i:s'));

            $PostData['emprestimo_data_entrega'] = (!empty($PostData['emprestimo_data_entrega']) ? Check::Data($PostData['emprestimo_data_entrega']) : date('Y-m-d H:i:s'));
            $Id = $PostData['emprestimo_id'];
            unset($PostData['emprestimo_id']);

            $PostData['emprestimo_status'] = (!empty($PostData['emprestimo_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_emprestimo_acervo", $PostData, "WHERE emprestimo_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=biblioteca/filtro_emprestimo_acervo";
        endif;

        break;

    case 'EmprestimoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
           
           else:
            $PostData['emprestimo_data_reserva'] = (!empty($PostData['emprestimo_data_reserva']) ? Check::Data($PostData['emprestimo_data_reserva']) : date('Y-m-d H:i:s'));

            $PostData['emprestimo_data_entrega'] = (!empty($PostData['emprestimo_data_entrega']) ? Check::Data($PostData['emprestimo_data_entrega']) : date('Y-m-d H:i:s'));
            
            $PostData['emprestimo_status'] = (!empty($PostData['emprestimo_status']) ? '1' : '0');
            $Create->ExeCreate("sys_emprestimo_acervo", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=biblioteca/filtro_emprestimo_acervo";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_emprestimo_acervo", "WHERE emprestimo_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_emprestimo_acervo", "WHERE emprestimo_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=biblioteca/filtro_emprestimo_acervo";

        endif;
        break;

endswitch;

echo json_encode($jSON);