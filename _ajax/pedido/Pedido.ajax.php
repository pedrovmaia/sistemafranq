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
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

if (isset($PostData['quantidade_centro_custo'])):
    $quantidade_centro_custo = $PostData['quantidade_centro_custo'];
    unset($PostData['quantidade_centro_custo']);
endif;

if (isset($PostData['quantidade_produto_proposta'])):
    $quantidade_produto_proposta = $PostData['quantidade_produto_proposta'];
    unset($PostData['quantidade_produto_proposta']);
endif;

if (isset($PostData['qtd'])):
    $quantidade_produto_pedido = $PostData['qtd'];
    unset($PostData['qtd']);
endif;

switch ($action):

    case 'PedidoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['pedido_id'];
            unset($PostData['pedido_id']);

            $PostData['pedido_status'] = (!empty($PostData['pedido_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_pedidos", $PostData, "WHERE pedido_id = :id", "id={$Id}");
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;

        break;

    case 'add_prod_list':

        $Id = $PostData['produto_id'];
        $Read->ExeRead("sys_produto", "WHERE produto_id = :id AND produto_status = 0", "id={$Id}");
        if($Read->getResult()) {

            $produto = "";
            foreach ($Read->getResult() as $Produto) {

                $produto .= "<div class='itens_pedido' data-prod='{$Produto['produto_id']}'><div class='col-md-9' style='padding-left: 0'>";
                $produto .= "<p style='margin-bottom: 0'>{$Produto['produto_nome']}</p></div>";
                $produto .= "<div class='col-md-3' style='padding-right: 0'>";
                $produto .= "<span><input class='produto_valor_venda' type='hidden' value='{$Produto['produto_valor_venda']}'><input class='produto_id_venda' type='hidden' value='{$Produto['produto_id']}'><small>R$<b>" . number_format($Produto['produto_valor_venda'], 2, ',', '.') . "</b></small></span>";
                $produto .= "<span style='padding: 0' rel='tooltip' callback='{$Produto['produto_id']}' title='Remover' class='btn btn-danger btn-link j_remove_produto_linha'>";
                $produto .= "<i class='material-icons'>delete</i></span></div></div>";

            }

            $jSON['produto'] = $produto;

        } else {
            $jSON['error'] = 'Produto não encontrado!';
        }

        break;

    case 'PedidoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_produto_pedido){
                $valor_total = 0;
                for($i = 0; $i <= $quantidade_produto_pedido; $i++){
                    if(isset($PostData['produto_id_' . $i])){

                        $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$PostData['produto_id_' . $i]}");
                        if($Read->getResult()) {
                            $ProdutoSingle = $Read->getResult()[0];

                            $valor_total = $valor_total + $ProdutoSingle['produto_valor_venda'];
                        }
                    }
                }
            }

            $valorTotal = str_replace(',', '.', str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas_pedido_matricula']));
            $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas_pedido_matricula']));
            //$valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas_pedido_matricula']));
            $valorDesconto = str_replace(',', '.', str_replace('.', '', $PostData['valor_desconto_geral_parcelas_pedido_matricula']));

            if ($valorTotal != $valorPagar) {
                $jSON['error'] = 'Valor total diferente que valor a pagar';
                echo json_encode($jSON);
                die;
            }

            /*if ($valorPagar > $valorTotal) {
                $valorTroco = $valorPagar - $valorTotal;
            }*/

            $PostData['valor_pos_desconto_geral_parcelas_pedido_matricula'] = $valorTotal;
            $PostData['valor_pago_geral_parcelas_pedido_matricula'] = $valorPagar;
            //$PostData['valor_troco_geral_parcelas_pedido_matricula'] = $valorTroco;
            $PostData['valor_desconto_geral_parcelas_pedido_matricula'] = $valorDesconto;

            $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
            if ($Read->getResult()):

                $quantidadeFormasPagamento = 0;
                $ArrFormasPagamento = [];

                foreach ($Read->getResult() as $FormaPagamento):

                    if (!empty($PostData["forma_pagamento_pedido_matricula_" . $FormaPagamento['forma_pagamento_id']]) && $PostData["forma_pagamento_pedido_matricula_" . $FormaPagamento['forma_pagamento_id']] != "0,00") {

                        $ArrFormasPagamento[] = [
                            "forma_id" => $FormaPagamento['forma_pagamento_id'],
                            "valor" => str_replace(',', '.', str_replace('.', '', $PostData["forma_pagamento_pedido_matricula_" . $FormaPagamento['forma_pagamento_id']]))
                        ];

                        $quantidadeFormasPagamento++;

                    }

                endforeach;
            endif;

            $forma_de_pagamentoArray = explode("-", $PostData["forma_parcelamento_entrada_geral_parcelas_pedido_matricula"]);

            $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_id = :id", "id={$forma_de_pagamentoArray[0]}");
            if($Read->getResult()) {
                $FormaPagamento = $Read->getResult()[0];
            } else {
                $jSON['error'] = 'Forma de pagamento inválida!';
                echo json_encode($jSON);
                die;
            }

            /* Criar Pedido */
            $CreateData['pedido_cliente_id'] = $PostData['pedido_cliente_id'];
            $CreateData['pedido_status'] = (!empty($PostData['pedido_status']) ? '1' : '0');
            $CreateData['pedido_data'] = (!empty($PostData['pedido_data']) ? Check::Data($PostData['pedido_data']) : date('Y-m-d H:i:s'));
            $CreateData['pedido_observacao'] = $PostData['pedido_observacao'];
            $CreateData['pedido_funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
            $PostData['pedido_valor_total'] = $valorTotal;
            $CreateData['pedido_valor_total'] = $valorTotal;
            $CreateData['pedido_recorrencia'] = $FormaPagamento['forma_parcelamento_intervalo'];
            $CreateData['pedido_forma_parcelamento_id'] = $FormaPagamento['forma_parcelamento_id'];
            $CreateData['pedido_tipo_parcelamento'] = $FormaPagamento['forma_parcelamento_tipo'];
            $CreateData['pedido_total_parcela'] = $FormaPagamento['forma_parcelamento_parcelas'];
            $CreateData['pedido_valor_entrada'] = $PostData['pedido_valor_entrada'];

            $Create->ExeCreate("sys_pedidos", $CreateData);
            $PedidoCreateID = $Create->getResult();

            // PRODUTO
            if($quantidade_produto_pedido){
                $ArrProduto = [];
                for($i = 0; $i <= $quantidade_produto_pedido; $i++){
                    if(isset($PostData['produto_id_' . $i])){

                        $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$PostData['produto_id_' . $i]}");
                        if($Read->getResult()) {
                           $ProdutoSingle = $Read->getResult()[0];

                            $ArrProduto[] = Array(
                                'pedido_item_produto_id' => $PostData['produto_id_' . $i],
                                'pedido_item_proposta_id' => $PedidoCreateID,
                                'pedido_item_quantidade' => 1,
                                'pedido_item_valor_unitario' => $ProdutoSingle['produto_valor_venda'],
                                'pedido_item_valor_total' => $ProdutoSingle['produto_valor_venda'],
                                'pedido_item_tipo' => $ProdutoSingle['produto_tipo_id'],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }
                $Create->ExeCreateMulti("sys_pedido_item", $ArrProduto);
            }

            if($PostData['pedido_valor_entrada']){
                $CreateMovimenacao['movimentacao_pago_recebido'] = 1;
            } else {
                $CreateMovimenacao['movimentacao_pago_recebido'] = 0;
            }

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateMovimenacao['movimentacao_data'] = date('Y/m/d');
            $CreateMovimenacao['movimentacao_hora'] = date('h:i:s a', time());
            $CreateMovimenacao['movimentacao_pessoa_id'] = $PostData['pedido_cliente_id'];
            $CreateMovimenacao['movimentacao_total_parcela'] = $CreateData['pedido_total_parcela'];
            $CreateMovimenacao['movimentacao_descricao'] = $PostData['pedido_observacao'];
            $CreateMovimenacao['movimentacao_valor_total'] = $PostData['pedido_valor_total'];
            $CreateMovimenacao['movimentacao_tipo_id'] = 2;
            $CreateMovimenacao['movimentacao_forma_parcelamento_id'] = $PostData['pedido_forma_parcelamento_id'];
            $CreateMovimenacao['movimentacao_emissao'] = date('Y/m/d');
            $CreateMovimenacao['movimentacao_tipo'] = "Venda Produtos/Serviços";
            $CreateMovimenacao['movimentacao_recorrencia'] = $CreateData['pedido_recorrencia'];
            $CreateMovimenacao['movimentacao_nome'] = "Venda para " . $PostData['pessoa_nome'];
            $CreateMovimenacao['movimentacao_observacao'] = $PostData['pedido_observacao'];
            $CreateMovimenacao['movimentacao_tipo_parcelamento'] = $CreateData['pedido_tipo_parcelamento'];
            $CreateMovimenacao['movimentacao_status'] = 0;
            $CreateMovimenacao['movimentacao_origem_movimentacao'] = 3;
            $CreateMovimenacao['movimentacao_forma_pagamento_id'] = 6;
            $CreateMovimenacao['movimentacao_proposta_id'] = $PedidoCreateID;
            $CreateMovimenacao['movimentacao_pedido_id'] = $PedidoCreateID;

            $Create->ExeCreate("sys_movimentacao", $CreateMovimenacao);
            $MovimentacaoCreateID = $Create->getResult();

            // RATEIO
            $ArrRateio = [];
            $Read->ExeRead("sys_proposta_rateio", "WHERE proposta_rateio_proposta_id = :id", "id={$PedidoCreateID}");
            if($Read->getResult()) {
                foreach ($Read->getResult() as $Rateio) {
                    $ArrRateio[] = Array(
                        'rateio_conta_id' => $MovimentacaoCreateID,
                        'rateio_centro_custo_id' => $Rateio['proposta_rateio_centro_custo_id'],
                        'rateio_conta_contabil_id' => $Rateio['proposta_rateio_conta_contabil_id'],
                        'rateio_valor' => $Rateio['proposta_rateio_valor'],
                        'rateio_tipo_id' => $Rateio['proposta_rateio_tipo_id'],
                        'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                    );
                }
                $Create->ExeCreateMulti("sys_transacao_rateio", $ArrRateio);
            }

            // GERAÇÃO DE CAIXA
            if($FormaPagamento['forma_parcelamento_id'] == 1) {

                if($quantidadeFormasPagamento){
                    $ArrCaixaAtual = [];
                    foreach($ArrFormasPagamento as $Forma){

                        $ArrCaixaAtual[] = Array(
                            'transacao_caixa_descricao' => $PostData['pedido_observacao'],
                            'transacao_caixa_data' => date('Y/m/d'),
                            'transacao_caixa_hora' => date('h:i:s a', time()),
                            'transacao_caixa_valor' => $Forma['valor'],
                            'transacao_conta_id' => $MovimentacaoCreateID,
                            'transacao_caixa_tipo_id' => 1,
                            'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                            'transacao_caixa_forma' => $Forma['forma_id'],
                            'unidade_id' => $_SESSION['userSYSFranquia']['unidade_padrao'],
                            'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                            'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_movimentacao_conta_id'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                    $Create->ExeCreateMulti("sys_transacao_caixa", $ArrCaixaAtual);
                }

            } else {

                $valor_pago_sem_troco = $PostData['valor_pago_geral_parcelas_pedido_matricula'] - $PostData['valor_troco_geral_parcelas_pedido_matricula'];
                $valor_pos_desconto = $PostData['valor_pos_desconto_geral_parcelas_pedido_matricula'];
                $valor_gerar_parcelas = $valor_pos_desconto - $valor_pago_sem_troco;

                if($FormaPagamento["forma_parcelamento_entrada"] == 1){

                    // CRIAÇÃO DE PARCELAS
                    $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, f.forma_parcelamento_tipo FROM sys_forma_parcelamento AS f WHERE f.forma_parcelamento_id = :id", "id={$FormaPagamento['forma_parcelamento_id']}");
                    if($Read->getResult()){

                        $ArrParcelas = [];

                        foreach ($Read->getResult() as $ItemProposta) {

                            $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
                            $data = date('Y/m/d');

                            for($i = 1; $i <= $parcelas; $i++){

                                $data_pag = null;

                                // localizando valor das parcelas
                                if($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                                {
                                    $valor_parcela = $valor_gerar_parcelas;
                                }

                                if($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                                {
                                    $valor_parcela = $valor_gerar_parcelas / $parcelas;
                                }

                                if($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                                {
                                    $valor_parcela = $valor_gerar_parcelas;
                                }

                                $ArrParcelas[] = Array(
                                    'mov_recebimento_movimento_id' => $MovimentacaoCreateID,
                                    'mov_recebimento_valor' => $valor_parcela,
                                    'mov_recebimento_numero' => 2,
                                    'mov_recebimento_data_vencimento' => $data,
                                    'mov_recebimento_data_recebimento' => $data_pag,
                                    'mov_recebimento_parcela' => $i,
                                    'mov_recebimento_tipo_id' => 0,
                                    'mov_recebimento_status' => 0,
                                    'mov_recebimento_emissao' => date('Y/m/d'),
                                    'mov_recebimento_pessoa_id' => $PostData['pessoa_id'],
                                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                    'data_criacao' => date('Y-m-d H:i:s'),
                                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                                );

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Semanal')
                                {
                                    $data = date('Y/m/d', strtotime("+7 days",strtotime($data)));
                                }

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Quinzenal')
                                {
                                    $data = date('Y/m/d', strtotime("+15 days",strtotime($data)));
                                }

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Mensal')
                                {
                                    $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                                }
                            }
                        }

                        $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);
                    }

                } else {

                    // CRIAÇÃO DE PARCELAS
                    $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, f.forma_parcelamento_tipo FROM sys_forma_parcelamento AS f WHERE f.forma_parcelamento_id = :id", "id={$FormaPagamento['forma_parcelamento_id']}");
                    if($Read->getResult()){

                        $ArrParcelas = [];

                        foreach ($Read->getResult() as $ItemProposta) {

                            $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
                            $data = date('Y/m/d');

                            for($i = 1; $i <= $parcelas; $i++){

                                $data_pag = null;

                                // localizando valor das parcelas
                                if($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                                {
                                    $valor_parcela = $valor_pos_desconto;
                                }

                                if($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                                {
                                    $valor_parcela = $valor_pos_desconto / $parcelas;
                                }

                                if($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                                {
                                    $valor_parcela = $valor_pos_desconto;
                                }

                                $ArrParcelas[] = Array(
                                    'mov_recebimento_movimento_id' => $MovimentacaoCreateID,
                                    'mov_recebimento_valor' => $valor_parcela,
                                    'mov_recebimento_numero' => 2,
                                    'mov_recebimento_data_vencimento' => $data,
                                    'mov_recebimento_data_recebimento' => $data_pag,
                                    'mov_recebimento_parcela' => $i,
                                    'mov_recebimento_tipo_id' => 0,
                                    'mov_recebimento_status' => 0,
                                    'mov_recebimento_emissao' => date('Y/m/d'),
                                    'mov_recebimento_pessoa_id' => $PostData['pessoa_id'],
                                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"]
                                );

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Semanal')
                                {
                                    $data = date('Y/m/d', strtotime("+7 days",strtotime($data)));
                                }

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Quinzenal')
                                {
                                    $data = date('Y/m/d', strtotime("+15 days",strtotime($data)));
                                }

                                if($ItemProposta['forma_parcelamento_intervalo'] == 'Mensal')
                                {
                                    $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                                }
                            }
                        }

                        $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);
                    }
                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedidos/pedido/ver_pedido&id=" . $PedidoCreateID;
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_pedidos", "WHERE pedido_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_pedidos", "WHERE pedido_id = :user", "user={$Id}");
            $jSON['success'] = 'Pedido removido com sucesso!';
            $jSON['redirect'] = "painel.php?exe=pedidos/pedido/filtro_pedido";

        endif;
        break;

endswitch;

echo json_encode($jSON);