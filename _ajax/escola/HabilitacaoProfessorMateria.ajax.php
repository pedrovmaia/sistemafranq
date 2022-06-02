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

    case 'professor_materia':

        $professorId = $PostData["professor"];

        if ($professorId != 0){
            $result = "";
            $Read->FullRead("SELECT p.produto_nome, e.estagio_produto_nome, e.estagio_produto_id FROM sys_produto AS p INNER JOIN sys_estagio_produto AS e ON e.estagio_produto_produto_id = p.produto_id WHERE p.produto_tipo_id = 2 AND p.produto_status = 0");
            if ($Read->getResult()):
                foreach ($Read->getResult() as $Produto):
                    $Read->ExeRead("sys_habilitacao_pessoa", "WHERE habilitacao_pessoa_pessoa_id = :id", "id={$professorId}");
                    if($Read->getResult()){
                        $result .= "<tr class='table_habilitacao'><td><div class='form-check'><label class='form-check-label'><input class='form-check-input' name='estagios[]' checked type='checkbox' value='{$Produto['estagio_produto_id']}'><span class='form-check-sign'><span class='check'></span></span></label></div></td><td>" . $Produto['produto_nome'] . ' - ' . strtoupper($Produto['estagio_produto_nome']) . "</td></tr>";
                    } else {
                        $result .= "<tr class='table_habilitacao'><td><div class='form-check'><label class='form-check-label'><input class='form-check-input' name='estagios[]' type='checkbox' value='{$Produto['estagio_produto_id']}'><span class='form-check-sign'><span class='check'></span></span></label></div></td><td>" . $Produto['produto_nome'] . ' - ' . strtoupper($Produto['estagio_produto_nome']) . "</td></tr>";
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
        elseif (empty($PostData["estagios"])):
            $jSON['error'] = 'Favor, escolha ao menos um estágio!';
        else:
            $list = implode(",", $PostData["estagios"]);

            $ArrEstagios = array();
            foreach ($PostData["estagios"] as $Estagio) {

                $ArrEstagios[] = [
                    "habilitacao_pessoa_pessoa_id" => $PostData["pessoa_principal_id"],
                    "habilitacao_pessoa_estagio_id" => $Estagio,
                    "unidade_id" => $_SESSION['userSYSFranquia']['unidade_padrao'],
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                ];

            }

            $Delete->ExeDelete("sys_habilitacao_pessoa", "WHERE habilitacao_pessoa_pessoa_id = :id", "id={$PostData["pessoa_principal_id"]}");
            $Create->ExeCreateMulti("sys_habilitacao_pessoa", $ArrEstagios);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

endswitch;

echo json_encode($jSON);