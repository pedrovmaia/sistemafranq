<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
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

if (isset($PostData['quantidade_produto_proposta'])):
    $quantidade_produto_proposta = $PostData['quantidade_produto_proposta'];
    unset($PostData['quantidade_produto_proposta']);
endif;

switch ($action):

    case 'PropostaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['proposta_id'];
            unset($PostData['proposta_id']);

            $PostData['pedido_compra_valor_total'] = str_replace('R$', '', $PostData['pedido_compra_valor_total']);
            $PostData['pedido_compra_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['pedido_compra_valor_total']));

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['pedido_compra_status'] = (!empty($PostData['pedido_compra_status']) ? '1' : '0');
            $CreateData['pedido_compra_data'] = (!empty($PostData['pedido_compra_data']) ? Check::Data($PostData['pedido_compra_data']) : date('Y-m-d H:i:s'));
            $CreateData['pedido_compra_valor_total'] = $PostData['pedido_compra_valor_total'];
            $CreateData['pedido_compra_cliente_id'] = $PostData['pedido_cliente_id'];
            $CreateData['pedido_compra_observacao'] = $PostData['pedido_observacao'];

            $Update->ExeUpdate("sys_pedido_compra", $CreateData, "WHERE pedido_compra_id = :id", "id={$Id}");

            // PRODUTO
            if($quantidade_produto_proposta){
                $ArrProduto = [];
                for($i = 0; $i <= $quantidade_produto_proposta; $i++){
                    if(isset($PostData['nome_produto_' . $i])){

                        $ArrProduto[] = Array(
                            'pedido_item_produto_id' => $PostData['nome_produto_' . $i . '_id'],
                            'pedido_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                            'pedido_item_valor_total' => $PostData['proposta_item_valor_total_' . $i],
                            'pedido_item_fornecedor_id' => $PostData['nome_fornecedor_' . $i . '_id']
                        );
                    }
                    $Update->ExeUpdate("sys_pedido_compra_item", $ArrProduto, "WHERE pedido_item_id = :id", "id={$PostData['item_' . $i]}");
                }
            }

            $jSON['success'] = 'Sau edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=suprimentos/compras/ver_pedido&id=" . $MovimentacaoCreateID;
        endif;
        break;

    case 'PedidoAdd':
        if(empty($PostData['nome_fornecedor'])):
            $jSON['error'] = 'Favor, escolha um fornecedor!';
        elseif (empty($PostData['pedido_compra_valor_total'])):
            $jSON['error'] = 'Favor, escolha ao menos um produto!';
        else:

            $PostData['pedido_compra_valor_total'] = str_replace('R$', '', $PostData['pedido_compra_valor_total']);
            $PostData['pedido_compra_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['pedido_compra_valor_total']));

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['pedido_compra_status'] = (!empty($PostData['pedido_compra_status']) ? '1' : '0');
            $CreateData['pedido_compra_data'] = (!empty($PostData['pedido_compra_data']) ? Check::Data($PostData['pedido_compra_data']) : date('Y-m-d H:i:s'));
            $CreateData['pedido_compra_valor_total'] = $PostData['pedido_compra_valor_total'];
            $CreateData['pedido_compra_funcionario_id'] = $_SESSION["userSYSFranquia"]["pessoa_id"];
            $CreateData['pedido_compra_observacao'] = $PostData['pedido_observacao'];
            $CreateData['pedido_fornecedor_id'] = $PostData['txt_id_fornecedor'];

            $Create->ExeCreate("sys_pedido_compra", $CreateData);
            $MovimentacaoCreateID = $Create->getResult();

            // PRODUTO
            if($quantidade_produto_proposta){
                $ArrProduto = [];
                for($i = 0; $i <= $quantidade_produto_proposta; $i++){
                    if(isset($PostData['nome_produto_' . $i])){

                        $ArrProduto[] = Array(
                            'pedido_item_produto_id' => $PostData['nome_produto_' . $i ],
                            'pedido_item_pedido_id' => $MovimentacaoCreateID,
                            'pedido_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                            'pedido_item_valor_total' => $PostData['proposta_item_valor_total_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'pedido_item_cliente_id' => $PostData['nome_cliente_' . $i],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_pedido_compra_item", $ArrProduto);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=suprimentos/compras/filtro_pedido";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];

        $Read->ExeRead("sys_pedido_compra", "WHERE pedido_compra_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_pedido_compra", "WHERE pedido_compra_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=suprimentos/compras/filtro_pedido";

        endif;
        break;

    case 'remove_tel':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_pedido_compra_item", "WHERE pedido_item_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_pedido_compra_item", "WHERE pedido_item_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Produto foi removido com sucesso!';

        endif;
        break;

    case 'infos_produto':

        $clone = "<tr><td class='pt-4-half'><div class='form-group'><input readonly placeholder='Clique e selecione o cliente / aluno' id='proposta_item_cliente_" . $PostData['numero'] . "' type='text' name='nome_cliente_" . $PostData['numero'] . "' class='form-control j_cliente_pedido_compra'></div></td>";
        $clone .= "<td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_" . $PostData['numero'] . "' name='pedido_item_tipo_" . $PostData['numero'] . "' value='1'><input readonly data-tipo='pedido_item_tipo_" . $PostData['numero'] . "' placeholder='Clique e selecione seu produto' data-total='proposta_item_valor_total_".$PostData['numero']."' data-qtd='proposta_item_quantidade_".$PostData['numero']."' id='proposta_item_valor_unitario_".$PostData['numero']."' type='text' name='nome_produto_".$PostData['numero']."' class='form-control j_produto_proposta'></td>";
        $clone .= "<td class='pt-4-half' style='width: 61px;'><input autocomplete='off' min='0' type='number' data-uni='0' data-total='proposta_item_valor_total_".$PostData['numero']."' name='proposta_item_quantidade_".$PostData['numero']."' class='form-control proposta_item_quantidade_".$PostData['numero']." qtd_itens_list'></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' type='text' name='proposta_item_valor_total_".$PostData['numero']."' class='form-control valor_total_tabela proposta_item_valor_total_".$PostData['numero']." dinheiro'></div></td>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></div></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);