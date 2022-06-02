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

    case 'UnidadeEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['unidade_id'];
            unset($PostData['unidade_id']);
            unset($PostData['pessoa_nome']);

           // $PostData['unidade_status'] = (!empty($PostData['unidade_status']) ? '1' : '0');
            die;
            $Update->ExeUpdate("sys_unidades", $PostData, "WHERE unidade_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_unidades";
        endif;

        break;

    case 'UnidadeAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            unset($PostData['pessoa_nome']);
           $ArrUnidade[] = Array(
                'franquia_id' => $PostData['franquia_id'],
                'unidade_nome' => $PostData['unidade_nome'],
                'data_criacao' => date('Y-m-d H:i:s'),
                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
            );

            $Create->ExeCreateMulti("sys_unidades", $ArrUnidade);

            $UpdateArr = [
                "unidade_id" => $Create->getResult()
            ];

            $Update->ExeUpdate("sys_pessoas", $UpdateArr, "WHERE pessoa_id = :id", "id={$PostData['franquia_id']}");

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_unidades";
        endif;
        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_unidades", "WHERE unidade_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_unidades", "WHERE unidade_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/dominios/filtro_unidades";

        endif;
        break;

endswitch;

echo json_encode($jSON);