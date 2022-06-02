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

if (isset($PostData['quantidade_centro_custo'])):
    $quantidade_centro_custo = $PostData['quantidade_centro_custo'];
    unset($PostData['quantidade_centro_custo']);
endif;

switch ($action):

    case 'TransacaoCaixaAdd':

        unset($PostData['false']);
        if (!$PostData['transacao_caixa_descricao'] || !$PostData['transacao_caixa_data'] || !$PostData['transacao_caixa_valor']){
            $jSON['error'] = 'Favor, preencha todos os campos!';
        } else {

            if($PostData['transacao_caixa_tipo_id'] == 1) {

                $valorTotal = str_replace(',', '.',
                    str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas']));
                $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas']));
                //$valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas']));
                $valorDesconto = str_replace(',', '.',
                    str_replace('.', '', $PostData['valor_desconto_geral_parcelas']));

                if ($valorTotal != $valorPagar) {
                    $jSON['error'] = 'Valor total diferente que valor a pagar';
                    echo json_encode($jSON);
                    die;
                }

                /*if($valorPagar > $valorTotal){
                    $valorTroco = $valorPagar - $valorTotal;
                }*/

                $PostData['valor_pos_desconto_geral_parcelas'] = $valorTotal;
                $PostData['valor_pago_geral_parcelas'] = $valorPagar;
                //$PostData['valor_troco_geral_parcelas'] = $valorTroco;
                $PostData['valor_desconto_geral_parcelas'] = $valorDesconto;

                $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");

                if ($Read->getResult()):

                    $quantidadeFormasPagamento = 0;
                    $ArrFormasPagamento = [];

                    foreach ($Read->getResult() as $FormaPagamento):

                        if (!empty($PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]) && $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']] != "0,00") {

                            if ($PostData['transacao_caixa_tipo_id'] == 1) {

                                $ArrFormasPagamento[] = [
                                    "forma_id" => $FormaPagamento['forma_pagamento_id'],
                                    "valor" => str_replace(',', '.', str_replace('.', '',
                                        $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]))
                                ];
                            }

                            if ($PostData['transacao_caixa_tipo_id'] == 2) {

                                $ArrFormasPagamento[] = [
                                    "forma_id" => $FormaPagamento['forma_pagamento_id'],
                                    "valor" => (-1) * str_replace(',', '.', str_replace('.', '',
                                            $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]))
                                ];
                            }

                            $quantidadeFormasPagamento++;

                        }

                    endforeach;
                endif;
            }

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['movimentacao_data'] = $PostData['transacao_caixa_data'];
            $CreateData['movimentacao_data_fechamento'] = null;
            $CreateData['movimentacao_pessoa_id'] = null;
            $CreateData['movimentacao_total_parcela'] = str_replace(',', '.', str_replace('.', '', $PostData["transacao_caixa_valor"]));
            $CreateData['movimentacao_descricao'] = $PostData['transacao_caixa_descricao'];
            $CreateData['movimentacao_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData["transacao_caixa_valor"]));

            if ($PostData['transacao_caixa_tipo_id'] == 1) {
                $CreateData['movimentacao_tipo_id'] = 2;
                $CreateData['movimentacao_tipo'] = "Entrada manual de caixa";
                $CreateData['movimentacao_pago_recebido'] = $PostData['transacao_caixa_data'];
                $CreateData['movimentacao_nome'] = "Entrada manual de caixa";
            }

            if ($PostData['transacao_caixa_tipo_id'] == 2) {
                $CreateData['movimentacao_tipo_id'] = 1;
                $CreateData['movimentacao_tipo'] = "Saída manual de caixa";
                $CreateData['movimentacao_nome'] = "Saída manual de caixa";
            }

            $CreateData['movimentacao_numero'] = null;

            $CreateData['movimentacao_forma_pagamento_id'] = null;
            $CreateData['movimentacao_emissao'] = date('Y/m/d');
            $CreateData['movimentacao_observacao'] = null;
            $CreateData['movimentacao_status'] = 0;

            $Create->ExeCreate("sys_movimentacao", $CreateData);
            $MovimentacaoCreateID = $Create->getResult();

            if($PostData['pedido_cliente_id']) {

                $cliente_id = $PostData['pedido_cliente_id'];

            } else {

                $cliente_id = null;
            }

            if ($PostData['transacao_caixa_tipo_id'] == 1) {
                if ($quantidadeFormasPagamento) {
                    $ArrCaixaAtual = [];
                    foreach ($ArrFormasPagamento as $Forma) {

                        $ArrCaixaAtual[] = Array(
                            'transacao_caixa_descricao' => $PostData['transacao_caixa_descricao'],
                            'transacao_caixa_data' => date('Y/m/d'),
                            'transacao_caixa_hora' => date('h:i:s a', time()),
                            'transacao_caixa_valor' => $Forma['valor'],
                            'transacao_conta_id' => $MovimentacaoCreateID,
                            'transacao_caixa_tipo_id' => $PostData['transacao_caixa_tipo_id'],
                            'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                            'transacao_caixa_forma' => $Forma['forma_id'],
                            'unidade_id' => $_SESSION['userSYSFranquia']['unidade_padrao'],
                            'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                            'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_caixa_conta_id'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"],
                            'transacao_caixa_aluno_id' => $cliente_id
                        );
                    }

                    $Create->ExeCreateMulti("sys_transacao_caixa", $ArrCaixaAtual);
                }
            }

            if ($PostData['transacao_caixa_tipo_id'] == 2) {

                $ArrCaixaAtual = [
                    'transacao_caixa_descricao' => $PostData['transacao_caixa_descricao'],
                    'transacao_caixa_data' => date('Y/m/d'),
                    'transacao_caixa_hora' => date('h:i:s a', time()),
                    'transacao_caixa_valor' => $CreateData['movimentacao_valor_total'] * -1,
                    'transacao_conta_id' => $MovimentacaoCreateID,
                    'transacao_caixa_tipo_id' => $PostData['transacao_caixa_tipo_id'],
                    'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                    'transacao_caixa_forma' => 1,
                    'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                    'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_caixa_conta_id'],
                    'transacao_caixa_aluno_id' =>  $cliente_id
                ];

                $Create->ExeCreate("sys_transacao_caixa", $ArrCaixaAtual);

            }

            // RATEIO
            if ($quantidade_centro_custo) {
                $ArrRateio = [];
                for ($i = 0; $i <= $quantidade_centro_custo; $i++) {
                    if (isset($PostData['centro_custo_' . $i])) {
                        $ArrRateio[] = Array(
                            'rateio_conta_id' => $MovimentacaoCreateID,
                            'rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'rateio_valor' => $PostData['valor_rateio_' . $i],
                            'rateio_tipo_id' => 0,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_transacao_rateio", $ArrRateio);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=financeiro/filtro_transacao_caixa";
        }

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

endswitch;

echo json_encode($jSON);