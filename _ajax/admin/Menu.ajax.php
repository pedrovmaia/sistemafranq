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

    case 'list_menus_nivel':
        $nivel = $PostData['id'];
        unset($PostData['id']);
        $list_menus = "<tbody class='list_menus'>";

        $Read->FullRead("SELECT m.menu_nome, m.menu_id FROM sys_menus AS m INNER JOIN sys_relacao_menu_nivel_acesso AS n ON m.menu_id = n.menu_id WHERE n.nivel_acesso_id = :nivel", "nivel={$nivel}");
        if($Read->getResult()){

            foreach ($Read->getResult() as $Menu){
                $list_menus .= "<tr><td>" . $Menu['menu_nome'] . "</td></tr>";
            }
            $jSON['success'] = $list_menus . "</tbody>";

        } else {
            $jSON['error'] = $list_menus . "<tr><td>Não existem resultados</td></tr></tbody>";
        }

        break;

    case 'manager':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        elseif ($PostData["menu_sistema"] == 0):
            $jSON['error'] = 'Favor, escolha um menu!';
        elseif (empty($PostData["permissao"])):
            $jSON['error'] = 'Favor, escolha uma permissão!';
        else:

            $menu_sistemaId = $PostData["menu_sistema"];
            $nivelAcessoId = $PostData["nivel_acesso"];
            unset($PostData["menu_sistema"], $PostData["nivel_acesso"]);

            $Read->ExeRead("sys_relacao_menu_nivel_acesso", "WHERE menu_id = :id AND nivel_acesso_id = :nivel", "id={$menu_sistemaId}&nivel={$nivelAcessoId}");
            if($Read->getResult()){
                $Update->ExeUpdate("sys_relacao_menu_nivel_acesso", $PostData, "WHERE menu_id = :id AND nivel_acesso_id = :nivel", "id={$menu_sistemaId}&nivel={$nivelAcessoId}");
            } else {
                $PostData["menu_id"] = $menu_sistemaId;
                $PostData["nivel_acesso_id"] = $nivelAcessoId;
                $Create->ExeCreate("sys_relacao_menu_nivel_acesso", $PostData);
            }
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'MenuEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['menu_id'];
            unset($PostData['menu_id']);

            $PostData['menu_status'] = (!empty($PostData['menu_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_menus", $PostData, "WHERE menu_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'MenuAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['menu_status'] = (!empty($PostData['menu_status']) ? '1' : '0');
            $Create->ExeCreate("sys_menus", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=admin/cadastro_menu&id=" . $Create->getResult();
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_menus", "WHERE menu_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_menus", "WHERE menu_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=admin/filtro_menu";

        endif;
        break;

endswitch;

echo json_encode($jSON);