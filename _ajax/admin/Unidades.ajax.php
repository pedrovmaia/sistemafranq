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

    case 'unidade':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Erro ao selecionar unidade, atualize e tente novamente';
        elseif ($PostData["unidade"] == 0):
            $jSON['error'] = 'Erro ao selecionar unidade, atualize e tente novamente';
        else:
            $_SESSION["userSYSFranquia"]["unidade_padrao"] = $PostData["unidade"];

            unset($_SESSION['caixaSYS']);

            $Read->FullRead("SELECT * FROM sys_caixa WHERE sys_caixa.caixa_status = 1 AND sys_caixa.caixa_pessoa_id = :id AND sys_caixa.unidade_id = :usuario", "id={$_SESSION['userSYSFranquia']['pessoa_id']}&usuario={$_SESSION['userSYSFranquia']['unidade_padrao']}");
            if ($Read->getResult()) {
                $_SESSION['caixaSYS'] = $Read->getResult()[0];
                $caixaSYS = $_SESSION['caixaSYS'];
            }

            $Read->ExeRead("sys_parametros", "WHERE unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
            if ($Read->getResult()) {
                $_SESSION['parametrosSYS'] = $Read->getResult()[0];
            } else {
                $_SESSION['parametrosSYS'] = [];
            }

            $Read->FullRead("SELECT p.pessoa_nome AS razao, p.pessoa_apelido AS fantasia, p.pessoa_email, p.pessoa_cnpj, e.catalogo_cep, CONCAT('Rua ',e.catalogo_endereco, ', ', e.catalogo_numero, ' - ', e.catalogo_bairro) AS endereco, e.catalogo_cidade AS cidade, e.catalogo_uf AS uf, t.telefone, e.catalogo_bairro AS bairro 
                            FROM sys_pessoas AS p LEFT OUTER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id
                            LEFT OUTER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id
                            WHERE p.pessoa_tipo_id = 7 AND p.pessoa_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
            if($Read->getResult()){
                $_SESSION['NOME_EMPRESA']           = $Read->getResult()[0]['razao'];
                $_SESSION['NOME_FANTASIA_EMPRESA']  = $Read->getResult()[0]['fantasia'];
                $_SESSION['ENDERECO_EMPRESA']       = $Read->getResult()[0]['endereco'];
                $_SESSION['BAIRRO_EMPRESA']         = $Read->getResult()[0]['bairro'];
                $_SESSION['CIDADE_EMPRESA']         = $Read->getResult()[0]['cidade'] . ' - ' . $Read->getResult()[0]['uf'];
                $_SESSION['UF_EMPRESA']             = $Read->getResult()[0]['uf'];
                $_SESSION['CNPJ_EMPRESA']           = $Read->getResult()[0]['pessoa_cnpj'];
                $_SESSION['CEP_EMPRESA']            = $Read->getResult()[0]['catalogo_cep'];
                $_SESSION['TELEFONE_EMAIL_EMPRESA'] = "Fone: {$Read->getResult()[0]['telefone']}  E-mail: {$Read->getResult()[0]['pessoa_email']}";
            }

            $jSON['success'] = 'Unidade foi alterada com sucesso, aguarde o recarregamento do sistema!';
        endif;
        break;

    case 'pessoa_unidade':

        $pessoaId = $PostData["pessoa_id"];

        if ($pessoaId != 0){
            $result = "";
            $Read->FullRead("SELECT u.unidade_nome, u.unidade_id FROM sys_unidades AS u");
            if ($Read->getResult()):
                foreach ($Read->getResult() as $Unidades):
                    $Read->ExeRead("sys_relacao_pessoas_unidades", "WHERE pessoa_unidade_pessoa_id = :id AND pessoa_unidade_unidade_id = :u", "id={$pessoaId}&u={$Unidades['unidade_id']}");
                    if($Read->getResult()){
                        $result .= "<option selected='selected' value='{$Unidades['unidade_id']}'>{$Unidades['unidade_nome']}</option>";
                    } else {
                        $result .= "<option value='{$Unidades['unidade_id']}'>{$Unidades['unidade_nome']}</option>";
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
        elseif (empty($PostData["unidades"])):
            $jSON['error'] = 'Favor, escolha ao menos uma unidade!';
        else:
            $list = implode(",", $PostData["unidades"]);

            $ArrUnidades = array();
            foreach ($PostData["unidades"] as $Unidade){

                $ArrUnidades[] = [
                    "pessoa_unidade_pessoa_id" => $PostData["pessoa_id"],
                    "pessoa_unidade_unidade_id" => $Unidade,
                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                ];
            }

            $Delete->ExeDelete("sys_relacao_pessoas_unidades", "WHERE pessoa_unidade_pessoa_id = :id", "id={$PostData["pessoa_id"]}");
            $Create->ExeCreateMulti("sys_relacao_pessoas_unidades", $ArrUnidades);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

endswitch;

echo json_encode($jSON);