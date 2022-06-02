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

if (isset($PostData['quantidade_centro_custo'])):
    $quantidade_centro_custo = $PostData['quantidade_centro_custo'];
    unset($PostData['quantidade_centro_custo']);
endif;

if (isset($PostData['quantidade_produto_proposta'])):
    $quantidade_produto_proposta = $PostData['quantidade_produto_proposta'];
    unset($PostData['quantidade_produto_proposta']);
endif;

switch ($action):

    case 'buscarEstagio':

        $Read->FullRead("SELECT e.estagio_produto_id, e.estagio_produto_nome, p.produto_nome, e.estagio_produto_valor, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_estagio_produto AS e INNER JOIN sys_produto AS p ON e.estagio_produto_produto_id = p.produto_id INNER JOIN sys_politica_comercial_estagios AS es ON e.estagio_produto_id = es.politica_comercial_estagio_id WHERE p.produto_id = :id", "id={$PostData['produto_id']}");

        if($Read->getResult()){
            $clone = "";
            $numero = $PostData['numero'] - 1;
            foreach ($Read->getResult() as  $Estagios) {

                $nova_data = date('Y-m-d');
                $de = date('Y-m-d', strtotime($Estagios["politica_comercial_data_inicio"]));
                $ate = date('Y-m-d', strtotime($Estagios["politica_comercial_data_final"]));

                if(($nova_data >= $de) && ($nova_data <= $ate)) {
                    $valor = $Estagios["politica_comercial_valor"];
                } else {
                    $valor = $Estagios["estagio_produto_valor"];
                }

                $clone .= "<tr><td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_" . $numero . "' name='pedido_item_tipo_" . $numero . "' value='2'><input data-tipo='pedido_item_tipo_" . $numero . "' value='" . $Estagios['produto_nome'] . " - " . $Estagios['estagio_produto_nome'] . "' accessKey='" . $Estagios['estagio_produto_id'] . "' readonly data-total='proposta_item_valor_total_".$numero."' data-qtd='proposta_item_quantidade_".$numero."' id='proposta_item_valor_unitario_".$numero."' placeholder='Clique e selecione seu produto' type='text' name='nome_produto_".$numero."' class='form-control j_produto_proposta'></td>";
                $clone .= "<td class='pt-4-half' style='width: 61px;'><input autocomplete='off' min='0' type='number' name='proposta_item_quantidade_".$numero."' data-uni='".$valor."' data-total='proposta_item_valor_total_".$numero."' class='form-control proposta_item_quantidade_".$numero." qtd_itens_list' value='1'></td>";
                $clone .= "<td class='pt-4-half' style='width: 110px;'><div class='form-group'><input readonly autocomplete='off' type='text' name='proposta_item_valor_unitario_".$numero."' class='form-control proposta_item_valor_unitario_".$numero." dinheiro' value='".$valor."'></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_item_parcelamento_id_".$numero."'><option value=''>ESCOLHA A FORMA DE PARCELAMENTO</option>";
                $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
                if ($Read->getResult()):
                    foreach ($Read->getResult() as $Forma):
                        $clone .= "<option value='{$Forma["forma_parcelamento_id"]}'>{$Forma["forma_parcelamento_nome"]}</option>";
                    endforeach;
                endif;
                $clone .= "</select></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_item_vencimento_".$numero."' class='form-control formDate' placeholder='dd/mm/yyyy'></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' type='text' name='proposta_item_valor_total_".$numero."' class='form-control valor_total_tabela proposta_item_valor_total_".$numero." dinheiro' value='".$valor."'></div></td>";
                $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></div></tr>";
                $numero++;
            }
            $jSON['success'] = $clone;
            $jSON['numero'] = $numero;

        } else {
            $jSON['error'] = "true";
        }

        break;

    case 'PropostaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['proposta_id'];
            unset($PostData['proposta_id']);

            $PostData['proposta_valor_total'] = str_replace('R$', '', $PostData['proposta_valor_total']);
            $PostData['proposta_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_valor_total']));
            $PostData['proposta_valor_entrada'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_valor_entrada']));

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['proposta_status'] = (!empty($PostData['proposta_status']) ? '1' : '0');
            //$CreateData['proposta_total_parcela'] = $PostData['proposta_total_parcela'];
            $CreateData['proposta_valor_total'] = $PostData['proposta_valor_total'];
            //$CreateData['proposta_recorrencia'] = $PostData['proposta_recorrencia'];
            $CreateData['proposta_nome'] = $PostData['proposta_nome'];
            //$CreateData['proposta_forma_parcelamento_id'] = $PostData['proposta_forma_parcelamento_id'];
            //$CreateData['proposta_tipo_parcelamento'] = $PostData['proposta_tipo_parcelamento'];
            $CreateData['proposta_valor_entrada'] = $PostData['proposta_valor_entrada'];

            $Update->ExeUpdate("sys_proposta", $CreateData, "WHERE proposta_id = :id", "id={$Id}");

            // RATEIO
            if($quantidade_centro_custo){
                $ArrRateio = [];
                for($i = 0; $i <= $quantidade_centro_custo; $i++){
                    if(isset($PostData['centro_custo_' . $i])){
                        $ArrRateio[] = Array(
                            'proposta_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'proposta_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'proposta_rateio_valor' => $PostData['valor_rateio_' . $i]
                        );
                    }
                    $Update->ExeUpdate("sys_proposta_rateio", $ArrRateio, "WHERE proposta_rateio_id = :id", "id={$PostData['rateio_' . $i]}");
                }
            }

            // PRODUTO
            if($quantidade_produto_proposta){
                $ArrProduto = [];
                for($i = 0; $i <= $quantidade_produto_proposta; $i++){
                    if(isset($PostData['nome_produto_' . $i])){

                        if(isset($PostData['pedido_item_tipo_' . $i])){
                            $tipo = $PostData['pedido_item_tipo_' . $i];
                        } else {
                            $tipo = 1;
                        }

                        $ArrProduto[] = Array(
                            'proposta_item_produto_id' => $PostData['nome_produto_' . $i . '_id'],
                            'proposta_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                            'proposta_item_valor_unitario' => $PostData['proposta_item_valor_unitario_' . $i],
                            'proposta_item_valor_total' => $PostData['proposta_item_valor_total_' . $i],
                            'proposta_item_tipo' => $tipo,
                            'proposta_item_forma_parcelamento_id' => $PostData['proposta_item_parcelamento_id_' . $i],
                            'proposta_item_vencimento' => date('Y-m-d', strtotime($PostData['proposta_item_vencimento_' . $i]))
                        );
                    }
                    $Update->ExeUpdate("sys_proposta_item", $ArrProduto, "WHERE proposta_item_id = :id", "id={$PostData['item_' . $i]}");
                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;
        break;

    case 'PropostaAdd':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['proposta_valor_total'] = str_replace('R$', '', $PostData['proposta_valor_total']);
            $PostData['proposta_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_valor_total']));
            $PostData['proposta_valor_entrada'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_valor_entrada']));

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['proposta_status'] = (!empty($PostData['proposta_status']) ? '1' : '0');
            $CreateData['proposta_emissao'] = (!empty($PostData['proposta_emissao']) ? Check::Data($PostData['proposta_emissao']) : date('Y-m-d H:i:s'));
            //$CreateData['proposta_total_parcela'] = $PostData['proposta_total_parcela'];
            $CreateData['proposta_valor_total'] = $PostData['proposta_valor_total'];
            //$CreateData['proposta_recorrencia'] = $PostData['proposta_recorrencia'];
            $CreateData['proposta_nome'] = $PostData['proposta_nome'];
            //$CreateData['proposta_forma_parcelamento_id'] = $PostData['proposta_forma_parcelamento_id'];
            //$CreateData['proposta_tipo_parcelamento'] = $PostData['proposta_tipo_parcelamento'];
            $CreateData['proposta_valor_entrada'] = $PostData['proposta_valor_entrada'];

            $Create->ExeCreate("sys_proposta", $CreateData);
            $MovimentacaoCreateID = $Create->getResult();

            // RATEIO
            if($quantidade_centro_custo){
                $ArrRateio = [];
                for($i = 0; $i <= $quantidade_centro_custo; $i++){
                    if(isset($PostData['centro_custo_' . $i])){
                        $ArrRateio[] = Array(
                            'proposta_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'proposta_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'proposta_rateio_valor' => $PostData['valor_rateio_' . $i],
                            'proposta_rateio_tipo_id' => 0,
                            'proposta_rateio_proposta_id' => $MovimentacaoCreateID,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_proposta_rateio", $ArrRateio);
            }

            // PRODUTO
            if($quantidade_produto_proposta){
                $ArrProduto = [];
                for($i = 0; $i <= $quantidade_produto_proposta; $i++){
                    if(isset($PostData['nome_produto_' . $i])){

                        if(isset($PostData['pedido_item_tipo_' . $i])){
                            $tipo = $PostData['pedido_item_tipo_' . $i];
                        } else {
                            $tipo = 1;
                        }

                        $ArrProduto[] = Array(
                            'proposta_item_produto_id' => $PostData['nome_produto_' . $i . '_id'],
                            'proposta_item_proposta_id' => $MovimentacaoCreateID,
                            'proposta_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                            'proposta_item_valor_unitario' => $PostData['proposta_item_valor_unitario_' . $i],
                            'proposta_item_valor_total' => $PostData['proposta_item_valor_total_' . $i],
                            'proposta_item_tipo' => $tipo,
                            'proposta_item_forma_parcelamento_id' => $PostData['proposta_item_parcelamento_id_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'proposta_item_vencimento' => date('Y-m-d', strtotime($PostData['proposta_item_vencimento_' . $i])),
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_proposta_item", $ArrProduto);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedidos/proposta/ver_proposta&id=" . $MovimentacaoCreateID;
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=fornecedores/fornecedor/filtro_fornecedores";

        endif;
        break;

    case 'remove_tel':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_proposta_item", "WHERE proposta_item_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_proposta_item", "WHERE proposta_item_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Produto foi removido com sucesso!';

        endif;
        break;

    case 'remove_centro':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_proposta_rateio", "WHERE proposta_rateio_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_proposta_rateio", "WHERE proposta_rateio_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Rateio foi removido com sucesso!';

        endif;
        break;

     case 'infos_centro_custo':

        $Read->ExeRead("sys_centro_custo");
        $CentroCustoOption = "";
        if($Read->getResult()):
            foreach ($Read->getResult() as $CentroCusto):
                $CentroCustoOption .= "<option value='{$CentroCusto['centro_custo_id'] }'>{$CentroCusto['centro_custo_nome'] }</option>";
            endforeach;
        endif;

        $Read->ExeRead("sys_conta_contabil");
        $ContaContabilOption = "";
        if($Read->getResult()):
            foreach ($Read->getResult() as $ContasContabeis):
                $ContaContabilOption .= "<option value='{$ContasContabeis['conta_contabil_id'] }'>{$ContasContabeis['conta_contabil_nome'] }</option>";
            endforeach;
        endif;

        $clone = "<tr><td class='pt-4-half'><select style='margin-top: -3px' name='centro_custo_".$PostData['numero']."' class='form-control jsys_tipo' data-style='btn btn-link' id='exampleFormControlSelect1'><option value='0'>SELECIONE UM CENTRO DE CUSTO</option>".$CentroCustoOption."<?php endforeach; endif;?></select></td>";
        $clone .= "<td class='pt-4-half'><select style='margin-top: -3px' class='form-control' name='conta_contabil_".$PostData['numero']."'><option value='0'>SELECIONE UMA CONTA CONTÁBIL</option>".$ContaContabilOption."<?php endforeach; endif; ?></select></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='text' name='valor_rateio_".$PostData['numero']."' class='form-control dinheiro'></div></td><td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></div></tr>";

        $jSON['success'] = $clone;
        break;

    case 'infos_produto':

        $clone = "<tr><td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_" . $PostData['numero'] . "' name='pedido_item_tipo_" . $PostData['numero'] . "' value='1'><input readonly data-tipo='pedido_item_tipo_" . $PostData['numero'] . "' placeholder='Clique e selecione seu produto' data-total='proposta_item_valor_total_".$PostData['numero']."' data-qtd='proposta_item_quantidade_".$PostData['numero']."' id='proposta_item_valor_unitario_".$PostData['numero']."' type='text' name='nome_produto_".$PostData['numero']."' class='form-control j_produto_proposta'></td>";
        $clone .= "<td class='pt-4-half' style='width: 61px;'><input autocomplete='off' min='0' type='number' data-uni='0' data-total='proposta_item_valor_total_".$PostData['numero']."' name='proposta_item_quantidade_".$PostData['numero']."' class='form-control proposta_item_quantidade_".$PostData['numero']." qtd_itens_list'></td>";
        $clone .= "<td class='pt-4-half' style='width: 110px;'><div class='form-group'><input readonly autocomplete='off' type='text' name='proposta_item_valor_unitario_".$PostData['numero']."' class='form-control dinheiro proposta_item_valor_unitario_".$PostData['numero']."'></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_item_parcelamento_id_".$PostData['numero']."'><option value=''>ESCOLHA A FORMA DE PARCELAMENTO</option>";
        $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st", "st=0");
        if ($Read->getResult()):
            foreach ($Read->getResult() as $Forma):
                $clone .= "<option value='{$Forma["forma_parcelamento_id"]}'>{$Forma["forma_parcelamento_nome"]}</option>";
            endforeach;
        endif;
        $clone .= "</select></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_item_vencimento_".$PostData['numero']."' class='form-control formDate' placeholder='dd/mm/yyyy'></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' type='text' name='proposta_item_valor_total_".$PostData['numero']."' class='form-control valor_total_tabela proposta_item_valor_total_".$PostData['numero']." dinheiro'></div></td>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></div></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);