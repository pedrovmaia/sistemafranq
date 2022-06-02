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

    /*case 'MovimentacaoEditar':
        
        if ($PostData['pessoa_cnpj'] == ""):
            $jSON['error'] = Informe seu CNPJ!';
        else:
            $Id = $PostData['pessoa_id'];
            unset($PostData['pessoa_id']);

            $PostData['pessoa_status'] = (!empty($PostData['pessoa_status']) ? '1' : '0');
            $PostData['pessoa_nascimento'] = (!empty($PostData['pessoa_nascimento']) ? Check::Nascimento($PostData['pessoa_nascimento']) : date('Y-m-d H:i:s'));

           
            $UpdateData['pessoa_status'] = $PostData['pessoa_status'];
            // ATRIBUIR


            $Update->ExeUpdate("sys_pessoas", $UpdateData, "WHERE pessoa_id = :id", "id={$Id}");

            $UpdateDataEndereco['catalogo_cep'] = $PostData['catalogo_cep'];
            $UpdateDataEndereco['catalogo_bairro'] = $PostData['catalogo_bairro'];
            $UpdateDataEndereco['catalogo_observacao'] = $PostData['catalogo_observacao'];
            $UpdateDataEndereco['catalogo_endereco'] = $PostData['catalogo_endereco'];
            $UpdateDataEndereco['catalogo_numero'] = $PostData['catalogo_numero'];
            $UpdateDataEndereco['catalogo_cidade'] = $PostData['catalogo_cidade'];
            $UpdateDataEndereco['catalogo_uf'] = $PostData['catalogo_uf'];
            $UpdateDataEndereco['catalogo_pais'] = $PostData['catalogo_pais'];
            $UpdateDataEndereco['catalogo_complemento'] = $PostData['catalogo_complemento'];
            $UpdateDataEndereco['pessoa_id'] = $Id;
            $Update->ExeUpdate("sys_catalogo_endereco_pessoas", $UpdateDataEndereco, "WHERE pessoa_id = :id", "id={$Id}");

            if($quantidade_parcelas){
                $ArrTelefones = [];
                
                for($i = 0; $i <= $quantidade_parcelas; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){
                        if (isset($PostData['telid_' . $i])){
                            $UpdateTelefones['tipo_telefone'] = $PostData['tipo_telefone_' . $i];
                            $UpdateTelefones['telefone'] = $PostData['telefone_' . $i];
                            $UpdateTelefones['ramal'] = $PostData['ramal_' . $i];
                            $UpdateTelefones['operadora'] = $PostData['operadora_' . $i];
                            $UpdateTelefones['observacao'] = $PostData['observacao_' . $i];

                            $Update->ExeUpdate("sys_telefones_pessoas", $UpdateTelefones, "WHERE id = :id", "id={$PostData['telid_' . $i]}");
                            $jSON['redirect'] = "painel.php?exe=fornecedores/fornecedor/cadastro_fornecedor&id=" . $Id;
                        } else {
                            $ArrTelefones[] = Array(
                                'pessoa_id' => $Id,
                                'tipo_telefone' => $PostData['tipo_telefone_' . $i],
                                'telefone' => $PostData['telefone_' . $i],
                                'ramal' => $PostData['ramal_' . $i],
                                'operadora' => $PostData['operadora_' . $i],
                                'observacao' => $PostData['observacao_' . $i]
                            );
                        }
                    }
                }
                if(count($ArrTelefones) > 0){
                    $Create->ExeCreateMulti("sys_telefones_pessoas", $ArrTelefones);
                }
            }


            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;
        break;
*/
    case 'MovimentacaoAdd':

        if (empty(trim($PostData['movimentacao_numero']))) {
            $jSON['error'] = 'Favor, preencha o número do título!';
        } elseif (empty(trim($PostData['movimentacao_pessoa_nome']))) {
            $jSON['error'] = 'Favor, preencha o fornecedor!';
        } elseif (empty(trim($PostData['movimentacao_valor_total']))) {
            $jSON['error'] = 'Favor, preencha o valor total!';
        } else {

            if ($PostData['movimentacao_pago_recebido'] == 1) {

                $valorTotal = str_replace(',', '.', str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas']));
                $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas']));
                $valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas']));
                $valorDesconto = str_replace(',', '.', str_replace('.', '', $PostData['valor_desconto_geral_parcelas']));

                if ($valorTotal > $valorPagar) {
                    $jSON['error'] = 'Valor total maior que valor a pagar';
                    die;
                }

                if ($valorPagar > $valorTotal) {
                    $valorTroco = $valorPagar - $valorTotal;
                }

                $PostData['valor_pos_desconto_geral_parcelas'] = $valorTotal;
                $PostData['valor_pago_geral_parcelas'] = $valorPagar;
                $PostData['valor_troco_geral_parcelas'] = $valorTroco;
                $PostData['valor_desconto_geral_parcelas'] = $valorDesconto;

                $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                if ($Read->getResult()):

                    $quantidadeFormasPagamento = 0;
                    $ArrFormasPagamento = [];

                    foreach ($Read->getResult() as $FormaPagamento):

                        if (!empty($PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]) && $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']] != "0,00") {

                            $ArrFormasPagamento[] = [
                                "forma_id" => $FormaPagamento['forma_pagamento_id'],
                                "valor" => str_replace(',', '.', str_replace('.', '',
                                    $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]))
                            ];

                            $quantidadeFormasPagamento++;

                        }

                    endforeach;
                endif;
            }

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['movimentacao_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['movimentacao_valor_total']));
            $CreateData['movimentacao_data'] = date('Y-m-d', strtotime($PostData['movimentacao_data']));
            $CreateData['movimentacao_hora'] = date('H:i:s');
            $CreateData['movimentacao_data_fechamento'] = $PostData['movimentacao_data_fechamento'];
            $CreateData['movimentacao_pessoa_id'] = $PostData['movimentacao_pessoa_id'];
            $CreateData['movimentacao_total_parcela'] = $PostData['movimentacao_total_parcela'];
            $CreateData['movimentacao_descricao'] = $PostData['movimentacao_descricao'];

            $CreateData['movimentacao_tipo_id'] = $PostData['movimentacao_tipo_id'];
            $CreateData['movimentacao_numero'] = $PostData['movimentacao_numero'];
            $CreateData['movimentacao_tipo'] = $PostData['movimentacao_tipo'];
            $CreateData['movimentacao_forma_pagamento_id'] = null;
            $CreateData['movimentacao_pago_recebido'] = $PostData['movimentacao_pago_recebido'];
            $CreateData['movimentacao_recorrencia'] = $PostData['movimentacao_recorrencia'];
            $CreateData['movimentacao_emissao'] = date('Y/m/d');
            $CreateData['movimentacao_nome'] = $PostData['movimentacao_nome'];
            $CreateData['movimentacao_observacao'] = $PostData['movimentacao_observacao'];
            $CreateData['movimentacao_forma_parcelamento_id'] = $PostData['movimentacao_forma_parcelamento_id'];
            $CreateData['movimentacao_status'] = 0;
            $CreateData['movimentacao_tipo_parcelamento'] = $PostData['movimentacao_tipo_parcelamento'];

            $Create->ExeCreate("sys_movimentacao", $CreateData);

            // RATEIO
            $MovimentacaoCreateID = $Create->getResult();
            if ($quantidade_centro_custo) {
                $ArrRateio = [];
                for ($i = 0; $i <= $quantidade_centro_custo; $i++) {
                    if (isset($PostData['centro_custo_' . $i])) {
                        $ArrRateio[] = Array(
                            'rateio_conta_id' => $MovimentacaoCreateID,
                            'rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'rateio_valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_rateio_' . $i])),
                            'rateio_tipo_id' => 0,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_transacao_rateio", $ArrRateio);
            }

            // GERAÇÃO DE CAIXA
            if ($PostData['movimentacao_pago_recebido'] == 1) {

                if($quantidadeFormasPagamento){
                    $ArrCaixaAtual = [];
                    foreach($ArrFormasPagamento as $Forma){

                        $ArrCaixaAtual[] = Array(
                            'transacao_caixa_descricao' => $PostData['movimentacao_descricao'],
                            'transacao_caixa_data' => date('Y/m/d'),
                            'transacao_caixa_hora' => date('h:i:s a', time()),
                            'transacao_caixa_valor' => -$Forma['valor'],
                            'transacao_conta_id' => $MovimentacaoCreateID,
                            'transacao_caixa_tipo_id' => 2,
                            'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                            'transacao_caixa_forma' => $Forma['forma_id'],
                            'unidade_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                            'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                            'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_movimentacao_conta_id'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                    $Create->ExeCreateMulti("sys_transacao_caixa", $ArrCaixaAtual);
                }

            }

            // CRIAÇÃO DE PARCELAS
            if ($PostData['movimentacao_total_parcela'] > 1) {

                $ArrParcelas = [];
                $parcelas = $PostData['movimentacao_total_parcela'];
                $data = date('Y/m/d'); //date("Y-m-d", strtotime( $PostData['movimentacao_data']));//    date('Y/m/d');//;

                if ($PostData['movimentacao_recorrencia'] === 'Semanal') {
                    $data = date('Y/m/d', strtotime("+7 days", strtotime($data)));
                }

                if ($PostData['movimentacao_recorrencia'] === 'Quinzenal') {
                    $data = date('Y/m/d', strtotime("+15 days", strtotime($data)));
                }

                if ($PostData['movimentacao_recorrencia'] === 'Mensal') {
                    $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                }

                for ($i = 1; $i <= $parcelas; $i++) {

                    // localizando data de pagamento
                    if ($PostData['movimentacao_pago_recebido'] == 1) {
                        $data_pag = date('Y/m/d');
                    } else {
                        $data_pag = null;
                    }

                    // localizando valor das parcelas

                    if ($CreateData['movimentacao_tipo_parcelamento'] == 0) // se for a vista
                    {
                        $valor_parcela = $CreateData['movimentacao_valor_total'];
                    }

                    if ($CreateData['movimentacao_tipo_parcelamento'] == 1) // se for parcelamwnto
                    {

                        $valor_parcela = $CreateData['movimentacao_valor_total'] / $parcelas;
                        
                    }

                    if ($CreateData['movimentacao_tipo_parcelamento'] == 2) // se for recorrencia
                    {
                        $valor_parcela = $CreateData['movimentacao_valor_total'];
                    }

                    $ArrParcelas[] = Array(
                        'mov_pagamento_movimento_id' => $MovimentacaoCreateID,
                        'mov_pagamento_valor' => $valor_parcela,
                        'mov_pagamento_numero' => $PostData['movimentacao_numero'],
                        'mov_pagamento_data_vencimento' => $data,
                        'mov_pagamento_data_pagamento' => $data_pag,
                        'mov_pagamento_parcela' => $i,
                        'mov_pagamento_tipo_id' => 0,
                        'mov_pagamento_status' => 0,
                        'mov_pagamento_emissao' => date('Y/m/d'),
                        'mov_pagamento_pessoa_id' => $PostData['movimentacao_pessoa_id'],
                        'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                    );

                    if ($PostData['movimentacao_recorrencia'] === 'Semanal') {
                        $data = date('Y/m/d', strtotime("+7 days", strtotime($data)));
                    }

                    if ($PostData['movimentacao_recorrencia'] === 'Quinzenal') {
                        $data = date('Y/m/d', strtotime("+15 days", strtotime($data)));
                    }

                    if ($PostData['movimentacao_recorrencia'] === 'Mensal') {
                        $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                    }


                }

                $Create->ExeCreateMulti("sys_movimentacao_pagamento", $ArrParcelas);


            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=contaspagar/filtro_movimentacao_pagamento";
            // endif;
        }

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
        $Read->ExeRead("sys_telefones_pessoas", "WHERE id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_telefones_pessoas", "WHERE id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Telefone foi removido com sucesso!';

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

   

endswitch;

echo json_encode($jSON);