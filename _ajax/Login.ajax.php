<?php

session_start();
require '../_app/Config.inc.php';

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Login';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):
    //PREPARA OS DADOS
    $Case = $PostData['callback_action'];
    unset($PostData['callback'], $PostData['callback_action']);

    //ELIMINA CÓDIGOS
    $PostData = array_map('strip_tags', $PostData);
    $trigger = new Trigger;

    //SELECIONA AÇÃO
    switch ($Case):
        //LOGIN
        case 'admin_login':
            if (in_array('', $PostData)):
                $jSON['trigger'] = $trigger->notify('<b>OPPSSS:</b> Informe seu e-mail e senha para logar!', 'orange', 'icon-bullhorn', 4000);
            else:
                if (!Check::Email($PostData['funcionario_email']) || !filter_var($PostData['funcionario_email'], FILTER_VALIDATE_EMAIL)):
                    $jSON['trigger'] = $trigger->notify('<b>OPPSSS:</b> E-mail informado não é válido!', 'orange', 'icon-bullhorn', 4000);
                elseif (strlen($PostData['funcionario_senha']) < 4):
                    $jSON['trigger'] = $trigger->notify('<b>OPPSSS:</b> Senha informada não é compatível!', 'orange', 'icon-bullhorn', 4000);
                else:
                    $Read = new Read;
                    //CRIPTIGRAFA A SENHA
                    $PostData['funcionario_senha'] = hash('sha512', $PostData['funcionario_senha']);
                    $Read->FullRead("SELECT * FROM sys_acesso_pessoas WHERE acesso_email = :email AND acesso_senha = :pass", "email={$PostData['funcionario_email']}&pass={$PostData['funcionario_senha']}");
                    if (!$Read->getResult()):
                        $jSON['trigger'] = $trigger->notify('<b>ERRO:</b> E-mail informado é inválido!', 'red', 'icon-bullhorn', 4000);
                    else:
                        $Read->FullRead("SELECT * FROM sys_pessoas WHERE pessoa_email = :email", "email={$PostData['funcionario_email']}");
                        if (!$Read->getResult()):
                            $jSON['trigger'] = $trigger->notify('<b>ERRO:</b> E-mail e senha não conferem!', 'red', 'icon-bullhorn', 4000);
                        else:
                            $_SESSION['userSYSFranquia'] = $Read->getResult()[0];

                        $jSON['trigger'] = $trigger->notify("<b>Olá " . $Read->getResult()[0]['pessoa_nome'] . ",</b> Seja bem-vindo(a)!", 'green', 'icon-bullhorn', 4000);

                            $Read->FullRead("SELECT * FROM sys_caixa WHERE sys_caixa.caixa_status = 1 AND sys_caixa.caixa_pessoa_id = :id AND sys_caixa.unidade_id = :usuario", "id={$_SESSION['userSYSFranquia']['pessoa_id']}&usuario={$_SESSION['userSYSFranquia']['unidade_id']}");
                        if ($Read->getResult()) {
                            $_SESSION['caixaSYS'] = $Read->getResult()[0];
                            $caixaSYS = $_SESSION['caixaSYS'];
                        }

                        $Read->FullRead("SELECT * FROM sys_parametros WHERE unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_id"]}");
                        if ($Read->getResult()) {
                            $_SESSION['parametrosSYS'] = $Read->getResult()[0];
                        } else {
                            $_SESSION['parametrosSYS'] = [];
                        }

                        $Read->FullRead("SELECT p.pessoa_nome AS razao, p.pessoa_apelido AS fantasia, p.pessoa_email, p.pessoa_cnpj, e.catalogo_cep, CONCAT('Rua ',e.catalogo_endereco, ', ', e.catalogo_numero, ' - ', e.catalogo_bairro) AS endereco, e.catalogo_cidade AS cidade, e.catalogo_uf AS uf, t.telefone, e.catalogo_bairro AS bairro 
                        FROM sys_pessoas AS p LEFT OUTER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id
                        LEFT OUTER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id
                        WHERE p.pessoa_tipo_id = 7 AND p.pessoa_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_id"]}");
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

                        $jSON['redirect'] = 'painel.php';
                        endif;
                    endif;
                endif;
            endif;
            break;

        case 'logout':
            unset($_SESSION['userSYSFranquia']);
            unset($_SESSION['caixaSYS']);
            unset($_SESSION['parametrosSYS']);
            $jSON['trigger'] = $trigger->notify("<b>TUDO CERTO:</b> Você saiu do sistema com sucesso!", 'green', 'icon-bullhorn', 4000);
            $jSON['redirect'] = 'index.php';
            break;

    endswitch;

    //RETORNA O CALLBACK
    if ($jSON):
        echo json_encode($jSON);
    else:
        $jSON['Trigger.class'] = '<b class="icon-warning">OPSS:</b> Desculpe. Mas uma ação do sistema não respondeu corretamente. Ao persistir, contate o desenvolvedor!';
        echo json_encode($jSON);
    endif;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;
