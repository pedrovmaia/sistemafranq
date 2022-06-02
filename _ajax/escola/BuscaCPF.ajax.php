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
    $Email = new Email;
    $trigger = new Trigger;
endif;

switch ($action):

    case 'buscaralunoscpf':

        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf AND pessoa_tipo_id = 4", "cpf={$PostData['cpf']}");
        if($Read->getResult()) {
            $jSON['success'] = true;
            $jSON['id'] = $Read->getResult()[0]['pessoa_id'];
            $jSON['nome'] = $Read->getResult()[0]['pessoa_nome'];
        } else {
            $jSON['error'] = true;
        }
        break;

endswitch;

echo json_encode($jSON);