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

        $nivelacessoId = $PostData["nivelacesso"];
        $menuId = $PostData["menu"];

        if ($nivelacessoId != 0 && $menuId != 0){
            $result = "";
            $Read->FullRead("SELECT submenu_nome, submenu_id FROM sys_submenus WHERE submenu_status = :st AND submenu_menu_id = :id", "st=0&id={$menuId}");
            if ($Read->getResult()):
                foreach ($Read->getResult() as $SubMenu):
                    $Read->ExeRead("sys_relacao_submenu_nivel_acesso", "WHERE submenu_nivel_acesso_id = :id AND submenu_submenu_id = :na", "id={$nivelacessoId}&na={$SubMenu['submenu_id']}");
                    if($Read->getResult()){
                        $result .= "<option selected='selected' value='{$SubMenu['submenu_id']}'>{$SubMenu['submenu_nome']}</option>";
                    } else {
                        $result .= "<option value='{$SubMenu['submenu_id']}'>{$SubMenu['submenu_nome']}</option>";
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
        elseif ($PostData["submenu_menu_id"] == 0):
            $jSON['error'] = 'Favor, escolha um menu!';
        elseif (empty($PostData["submenus"])):
            $jSON['error'] = 'Favor, escolha ao menos um submenu!';
        else:

            $menu_sistemaId = $PostData["submenu_menu_id"];
            $nivelAcessoId = $PostData["submenu_nivel_acesso_id"];
            $list = implode(",", $PostData["submenus"]);

            $ArrRelacao = array();
            foreach ($PostData["submenus"] as $SubMenuId){

                $ArrRelacao[] = [
                    "submenu_menu_id" => $menu_sistemaId,
                    "submenu_submenu_id" => $SubMenuId,
                    "submenu_nivel_acesso_id" => $nivelAcessoId,
                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                ];
            }

            $Delete->ExeDelete("sys_relacao_submenu_nivel_acesso", "WHERE submenu_menu_id = :id AND submenu_nivel_acesso_id = :p", "id={$menu_sistemaId}&p={$nivelAcessoId}");
            if(count($ArrRelacao) > 0){
                $Create->ExeCreateMulti("sys_relacao_submenu_nivel_acesso", $ArrRelacao);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'SubMenuEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['submenu_id'];
            unset($PostData['submenu_id']);

            $PostData['submenu_status'] = (!empty($PostData['submenu_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_submenus", $PostData, "WHERE submenu_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'SubMenuAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $PostData['submenu_status'] = (!empty($PostData['submenu_status']) ? '1' : '0');
            $Create->ExeCreate("sys_submenus", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=admin/cadastro_submenu&id=" . $Create->getResult();
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_submenus", "WHERE submenu_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_submenus", "WHERE submenu_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=admin/filtro_submenu";

        endif;
        break;

endswitch;

echo json_encode($jSON);