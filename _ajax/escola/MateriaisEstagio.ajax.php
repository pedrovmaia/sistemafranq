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

if (isset($PostData['quantidade_material_estagio'])):
    $quantidade_material_estagio = $PostData['quantidade_material_estagio'];
    unset($PostData['quantidade_material_estagio']);
endif;

switch ($action):

    case 'MaterialEditar':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['estagio_id'];

            if($quantidade_material_estagio){
                $ArrMaterial = [];

                for($i = 0; $i <= $quantidade_material_estagio; $i++){

                    if(isset($PostData['produto_id_' . $i])){
                        if (isset($PostData['indic_id_' . $i])){
                            $UpdateMaterial['produto_id'] = $PostData['produto_id_' . $i];

                            $Update->ExeUpdate("sys_materiais_estagio_produto", $UpdateMaterial, "WHERE id = :id", "id={$PostData['indic_id_' . $i]}");
                        } else {
                            $ArrMaterial[] = Array(
                                'estagio_id' => $PostData['estagio_id'],
                                'produto_id' => $PostData['produto_id_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }

                if(count($ArrMaterial) > 0){
                    $Create->ExeCreateMulti("sys_materiais_estagio_produto", $ArrMaterial);
                }
            }

            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/cadastro_materiais_estagio&idEstagio=" . $Id . "&id=" . $Id;
        endif;
        break;

    case 'MaterialAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_material_estagio){
                $ArrMaterial = [];
                for($i = 0; $i <= $quantidade_material_estagio; $i++){
                    if(isset($PostData['produto_id_' . $i])){
                        $ArrMaterial[] = Array(
                            'estagio_id' => $PostData['estagio_id'],
                            'produto_id' => $PostData['produto_id_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_materiais_estagio_produto", $ArrMaterial);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/cadastro_materiais_estagio&idEstagio=" . $PostData['estagio_id'] . "&id=" . $PostData['estagio_id'];
        endif;

        break;

    case 'remove':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_materiais_estagio_produto", "WHERE id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
        extract($Read->getResult()[0]);
        $Delete->ExeDelete("sys_materiais_estagio_produto", "WHERE id = :id", "id={$Id}");
        $jSON['success'] = 'Material foi removido com sucesso!';
        $jSON['redirect'] = "painel.php?exe=escola/admin/cadastro_materiais_estagio&idEstagio=" . $Read->getResult()[0]['estagio_id'] . "&id=" . $Read->getResult()[0]['estagio_id'];
    endif;
        break;

    case 'add_linha':

        $clone = "<tr><td class='pt-3-half'>";
        $clone .= "<input autocomplete='off' id='txt_produto_id_".$PostData['numero']."' type='hidden' name='produto_id_".$PostData['numero']."' class='form-control'><input autocomplete='off' data-id='txt_produto_id_".$PostData['numero']."' readonly placeholder='Clique e selecione o produto' id='produto_id_".$PostData['numero']."' type='text' name='produto_nome_".$PostData['numero']."' class='form-control j_produto_materias_estagio'>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);