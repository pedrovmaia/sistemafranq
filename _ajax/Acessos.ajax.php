<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'funcionalidaderead':

        $funcionalidaId = $PostData["funcionalidade"];
        $nivelAcessoId = $PostData["nivelacesso"];
        if ($nivelAcessoId != 0 && $funcionalidaId != 0){
            $result = "";
            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :id AND nivel_acesso_id = :na", "id={$funcionalidaId}&na={$nivelAcessoId}");
            if($Read->getResult()){
                $permissoes = $Read->getResult()[0];
                $jSON['success'] = $permissoes;
            } else {
                $jSON['error'] = 'error';
            }

        } else {
            $jSON['error'] = 'error';
        }

        break;

    case 'manager':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        elseif ($PostData["funcionalidade"] == 0):
            $jSON['error'] = 'Favor, escolha uma funcionalidade!';
        elseif (empty($PostData["permissoes"])):
            $jSON['error'] = 'Favor, escolha ao menos um nível de acesso!';
        else:

            $PostData["inserir"] = 0;
            $PostData["alterar"] = 0;
            $PostData["ler"] = 0;
            $PostData["deletar"] = 0;

            $funcionalidaId = $PostData["funcionalidade"];
            $nivelAcessoId = $PostData["nivel_acesso"];
            unset($PostData["funcionalidade"], $PostData["nivel_acesso"]);

            foreach ($PostData["permissoes"] as $Permissao){

                if ($Permissao == "insert"){
                    $PostData["inserir"] = 1;
                } elseif ($Permissao == "update"){
                    $PostData["alterar"] = 1;
                } elseif ($Permissao == "read"){
                    $PostData["ler"] = 1;
                } elseif ($Permissao == "delete"){
                    $PostData["deletar"] = 1;
                }
            }
            unset($PostData["permissoes"]);
            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :id AND nivel_acesso_id = :nivel", "id={$funcionalidaId}&nivel={$nivelAcessoId}");
            if($Read->getResult()){
                $Update->ExeUpdate("sys_relacao_funcionalidade_nivel_acesso", $PostData, "WHERE funcionalidade_id = :id AND nivel_acesso_id = :nivel", "id={$funcionalidaId}&nivel={$nivelAcessoId}");
            } else {
                $PostData["funcionalidade_id"] = $funcionalidaId;
                $PostData["nivel_acesso_id"] = $nivelAcessoId;
                $Create->ExeCreate("sys_relacao_funcionalidade_nivel_acesso", $PostData);
            }
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'search':
        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE niveis_acesso_nome LIKE '%{$PostData["termo"]}%'");
        $result = "";

        if($Read->getResult()){
            $result .= "<div class='card-header card-header-primary'><h4 class='card-title'>Todas os niveis de acesso</h4><p class='card-category'>Relação de niveis de acesso</p></div><div class='card-body table-responsive'><table class='table table-hover'><thead class='text-warning'><th>ID</th><th>Nome</th><th>Ações</th></thead><tbody>";
            foreach ($Read->getResult() as $Niveisacesso) {
                $result .= "
                    <tr>
                        <td>{$Niveisacesso['niveis_acesso_id']}</td>
                        <td>{$Niveisacesso['niveis_acesso_nome']}</td>
                        <td class='td-actions'>
                            <a rel='tooltip' href='painel.php?exe=admin/acesso/cadastro_niveis_acesso&id={$Niveisacesso["niveis_acesso_id"]}' title='Editar' class='btn btn-warning'><i class='material-icons'>mode_edit</i></a>
                            <span rel='tooltip' title='Deletar' rel='single_user_addr' callback='NiveisAcesso' action='delete' class='j_delete_action_confirm icon-warning btn btn-danger' id='{$Niveisacesso['niveis_acesso_id']}'><i class='material-icons''>delete</i></span>
                        </td>
                    </tr>
                ";
            }
            $result .= "</tbody></table></div>";
        }
        $jSON['content'] = $result;
        break;

    case 'pass':
        $PostData['senha_atual'] = hash('sha512', $PostData['senha_atual']);
        $Read->FullRead("SELECT acesso_pessoa_id, acesso_tipo FROM sys_acesso_pessoas WHERE acesso_email = :email AND acesso_senha = :pass", "email={$_SESSION['userSYSFranquia']['pessoa_email']}&pass={$PostData['senha_atual']}");
        if (!$Read->getResult()):
            $jSON['error'] = '<b>ERRO:</b> Senha atual não confere!';
        else:

            if(strlen($PostData['usuario_senha']) < 4){
                $jSON['error'] = '<b>OPPSSS:</b> Senha informada não é compatível!';;
            }elseif($PostData['usuario_senha'] != $PostData['usuario_senha1']){

                $jSON['error'] = '<b>ERRO:</b> Senhas não conferem!';

            } else {

                unset($PostData['usuario_senha1']);
                unset($PostData['senha_atual']);

                $PostData['acesso_senha'] = hash('sha512', $PostData['usuario_senha']);
                unset($PostData['usuario_senha']);
                $Update->ExeUpdate("sys_acesso_pessoas", $PostData, "WHERE acesso_pessoa_id = :id", "id={$_SESSION['userSYSFranquia']['pessoa_id']}");

                unset($_SESSION['userSYSFranquia']);
                unset($_SESSION['caixaSYS']);
                unset($_SESSION['parametrosSYS']);
                $jSON['success'] = "<b>TUDO CERTO: </b> Sua senha foi atualizada com sucesso!";
                $jSON['redirect'] = 'index.php';
            }

        endif;

        break;

endswitch;

echo json_encode($jSON);