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

    case 'gerente_consultor':

        $gerenteId = $PostData["gerente"];

        if ($gerenteId != 0){
            $result = "";
            $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st", "st=7");
            if ($Read->getResult()):
                foreach ($Read->getResult() as $Consultor):
                    $Read->ExeRead("sys_subordinados", "WHERE pessoa_principal_id = :id AND pessoa_filha_id = :na", "id={$gerenteId}&na={$Consultor['pessoa_id']}");
                    if($Read->getResult()){
                        $result .= "<option selected='selected' value='{$Consultor['pessoa_id']}'>{$Consultor['pessoa_nome']}</option>";
                    } else {
                        $result .= "<option value='{$Consultor['pessoa_id']}'>{$Consultor['pessoa_nome']}</option>";
                    }
                endforeach;
                $jSON['success'] = $result;
            endif;
        } else {
            $jSON['error'] = 'error';
        }

        break;

    case 'manager':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        elseif (empty($PostData["consultores"])):
            $jSON['error'] = 'Favor, escolha ao menos um consultor!';
        else:
            $list = implode(",", $PostData["consultores"]);

            $ArrSubordinados = array();
            foreach ($PostData["consultores"] as $Consultor){

                $ArrSubordinados[] = [
                    "pessoa_principal_id" => $PostData["pessoa_principal_id"],
                    "pessoa_filha_id" => $Consultor,
                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                ];
            }

            $Delete->ExeDelete("sys_subordinados", "WHERE pessoa_principal_id = :id", "id={$PostData["pessoa_principal_id"]}");
            $Create->ExeCreateMulti("sys_subordinados", $ArrSubordinados);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

endswitch;

echo json_encode($jSON);