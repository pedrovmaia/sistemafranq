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
    $addDate = new AddDate;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

if (isset($PostData['quantidade_centro_custo'])):
    $quantidade_centro_custo = $PostData['quantidade_centro_custo'];
    unset($PostData['quantidade_centro_custo']);
endif;

switch ($action):

    case 'CarnetTitulos':

        $qtd = $PostData["qtd"];

        $Read->FullRead("SELECT p.pessoa_nome AS nome_empresa, CONCAT(c.catalogo_endereco,', ',c.catalogo_numero, ', ', c.catalogo_bairro, ', ', c.catalogo_cidade, ' - ', c.catalogo_uf) AS endereco_empresa, t.telefone AS tel_empresa FROM sys_pessoas AS p INNER JOIN sys_catalogo_endereco_pessoas AS c ON p.pessoa_id = c.pessoa_id INNER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id WHERE p.pessoa_tipo_id = 7 AND p.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
        $jSON['empresa'] = $Read->getResult()[0];

        for($i = 0; $i < $qtd; $i++){

            $jSON['cliente']["parcela{$i}"] = $PostData["titulo_parcela_id_{$i}"];

        }

        //$Read->FullRead("SELECT mr.mov_recebimento_id, MONTH(mr.mov_recebimento_data_vencimento) AS primeiromes, YEAR(mr.mov_recebimento_data_vencimento) AS primeiroano, mr.mov_recebimento_parcela, mr.mov_recebimento_valor AS valor, p.pessoa_nome AS nome, CONCAT(e.catalogo_endereco,', ',e.catalogo_numero, ', ', e.catalogo_bairro, ', ', e.catalogo_cidade, ' - ', e.catalogo_uf) AS endereco, p.pessoa_cpf AS cpf, mr.mov_recebimento_data_vencimento AS vence FROM sys_movimentacao AS m INNER JOIN sys_pessoas AS p ON m.movimentacao_pessoa_id = p.pessoa_id INNER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id INNER JOIN sys_movimentacao_recebimento AS mr ON m.movimentacao_id = mr.mov_recebimento_movimento_id WHERE m.movimentacao_origem_movimentacao = 1 AND mr.mov_recebimento_id = :id ORDER BY mr.mov_recebimento_parcela", "id={$PostData["titulo_parcela_id_0"]}");
        //$jSON['cliente'] = $Read->getResult()[0];
        break;

    case 'RecibotTitulos':

        $qtd = $PostData["qtd"];

        $Read->FullRead("SELECT p.pessoa_nome AS nome_empresa, CONCAT(c.catalogo_endereco,', ',c.catalogo_numero, ', ', c.catalogo_bairro, ', ', c.catalogo_cidade, ' - ', c.catalogo_uf) AS endereco_empresa, c.catalogo_cidade AS cidade_empresa,  t.telefone AS tel_empresa, p.pessoa_cnpj as cnpj_empresa FROM sys_pessoas AS p INNER JOIN sys_catalogo_endereco_pessoas AS c ON p.pessoa_id = c.pessoa_id INNER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id WHERE p.pessoa_tipo_id = 7 AND p.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

            $jSON['empresa'] = $Read->getResult()[0];

        $Read->FullRead("SELECT m.movimentacao_id, mr.mov_recebimento_id, MONTH(mr.mov_recebimento_emissao) AS primeiromes, YEAR(mr.mov_recebimento_emissao) AS primeiroano, 
            mr.mov_recebimento_parcela, mr.mov_recebimento_valor AS valor, p.pessoa_nome AS aluno, mr.mov_recebimento_desc_identificador AS descricao, mr.mov_recebimento_tipo AS tipo, mr.mov_valor_pago AS valorpago,
            CONCAT(e.catalogo_endereco,', ',e.catalogo_numero, ', ', e.catalogo_bairro, ', ', e.catalogo_cidade, ' - ', e.catalogo_uf) AS endereco, 
            p.pessoa_cpf AS cpf, m.movimentacao_dia_vencimento AS vence, turma.projeto_descricao AS turma_nome, 
            forma_pagamento.forma_pagamento_nome AS forma_nome, mr.mov_recebimento_parcela AS parcela, 
            forma_parcela.forma_parcelamento_parcelas AS total_parcela,
            DATE_FORMAT(mr.mov_recebimento_data_vencimento,'%d/%m/%Y') AS vencimento 

            FROM sys_movimentacao AS m

            INNER JOIN sys_pessoas AS p

            LEFT OUTER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id 

            LEFT OUTER JOIN sys_movimentacao_recebimento AS mr ON m.movimentacao_id = mr.mov_recebimento_movimento_id 

            LEFT OUTER JOIN sys_projetos AS turma ON turma.projeto_id = m.movimentacao_projeto_id 

            LEFT OUTER JOIN sys_forma_pagamento AS forma_pagamento ON forma_pagamento.forma_pagamento_id = mr.mov_recebimento_forma_pagamento 

            INNER JOIN sys_matriculas AS matriculas ON matriculas.matricula_id = m.movimentacao_matricula_id

            INNER JOIN sys_matricula_item AS mat_item ON mat_item.matricula_item_proposta_id = matriculas.matricula_id

            INNER JOIN sys_forma_parcelamento AS forma_parcela ON forma_parcela.forma_parcelamento_id = mat_item.matricula_item_forma_parcelamento_id

            WHERE mr.mov_recebimento_id = :id
            AND mr.mov_recebimento_pessoa_id = p.pessoa_id
            GROUP BY m.movimentacao_id ORDER BY mr.mov_recebimento_parcela", "id={$PostData["titulo_parcela_id_0"]}");

        $jSON['cliente'] = $Read->getResult()[0];
        break;

    case 'NegativarTitulos':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $qtd = $PostData["qtd"];
            $ArrUpdate = [];
            $titulos = "";

            for($i = 0; $i < $qtd; $i++){

                $Read->ExeRead("sys_envio_scpc", "WHERE envio_movimentacao_recebimento_id = :id", "id={$PostData["titulo_parcela_id_".$i]}");
                if($Read->getResult()){
                    $jSON['error'] = "Título {$PostData['titulo_parcela_id_'.$i]} já foi enviado ao SCPC";
                    echo json_encode($jSON);
                    die;
                }

                $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id", "id={$PostData["titulo_parcela_id_".$i]}");

                if($Read->getResult()){
                    $Resultado = $Read->getResult()[0];

                    $data1 = date('Y-m-d');
                    $data2 = $Resultado['mov_recebimento_data_vencimento'];

                    if(strtotime($data1) > strtotime($data2)) {

                        $ArrUpdate[] = [
                            'envio_pessoa_id' => $Resultado['mov_recebimento_pessoa_id'],
                            'envio_data_inclusao' => date('Y-m-d'),
                            'envio_observacao' => "Inclusão SCPC",
                            'envio_movimentacao_recebimento_id' => $Resultado['mov_recebimento_id'],
                            'unidade_id' => $_SESSION['userSYSFranquia']['unidade_padrao'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'envio_status' => 0,
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        ];

                    } else {
                        $titulos .= "Parcela " . $PostData['parcela_pagamento_'.$i] . " não pode ser negativada, está dentro do prazo de vencimento.\n";
                    }

                }

            }

            if($titulos != "") {
                $jSON['error'] = $titulos;
                echo json_encode($jSON);
                die;
            }

            $Create->ExeCreateMulti("sys_envio_scpc", $ArrUpdate);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = 'painel.php?exe=contasreceber/ver_titulo_receber&id=' . $PostData["titulo_parcela_id_0"];

        endif;
        break;

    case 'CancelarTitulos':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $qtd = $PostData["qtd"];
            $titulos = "";

            for($i = 0; $i < $qtd; $i++){
                $ArrUpdate = [
                    'mov_recebimento_status' => 2
                ];

                $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id AND mov_recebimento_status = 0", "id={$PostData["titulo_parcela_id_".$i]}");
                if($Read->getResult()){

                    $Resultado = $Read->getResult()[0];

                    $Update->ExeUpdate("sys_movimentacao_recebimento", $ArrUpdate, "WHERE mov_recebimento_id = :id", "id={$PostData["titulo_parcela_id_".$i]}");

                    $CreateDataCaixa['tipo'] = 1;
                    $CreateDataCaixa['motivo_id'] = $PostData['motivo_cancelamento_parcela'];
                    $CreateDataCaixa['observacao'] = $PostData['observacoes_cancelamento_parcelas'];
                    $CreateDataCaixa['date'] = date('Y-m-d H:i:s');
                    $CreateDataCaixa['funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                    $CreateDataCaixa['id_titulo'] = $PostData['titulo_parcela_id_'.$i];

                    $Create->ExeCreate("sys_log_parcelas", $CreateDataCaixa);
                    $jSON['pessoa'] = $Resultado['mov_recebimento_pessoa_id'];
                    $jSON['success'] = 'Seu registro foi salvo com sucesso!';

                } else {
                    $titulos .= "<br>Parcela " . $PostData['parcela_pagamento_'.$i] . " não pode ser cancelada.<br>";
                }

            }
            if($titulos != "") {
                $jSON['error'] = $titulos;
            }
        endif;
        break;

    case 'DarBaixaParcelas':

        $valorTotal = str_replace(',', '.', str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas']));
        $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas']));
        //$valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas']));
        $valorDesconto = str_replace(',', '.', str_replace('.', '', $PostData['valor_desconto_geral_parcelas']));

        if($valorTotal < $valorPagar){
            $jSON['error'] = 'Valor total menor que valor a pagar';
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
        if ($Read->getResult()) {

            $quantidadeFormasPagamento = 0;
            $ArrFormasPagamento = [];
            $FormasPagamentoNome = "";

            foreach ($Read->getResult() as $FormaPagamento):

                if (!empty($PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]) && $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']] != "0,00") {

                    $ArrFormasPagamento[] = [
                        "forma_id" => $FormaPagamento['forma_pagamento_id'],
                        "valor" => str_replace(',', '.',
                            str_replace('.', '', $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]))
                    ];

                    $FormasPagamentoNome .= $FormaPagamento['forma_pagamento_nome'] . '-' . str_replace(',', '.',
                            str_replace('.', '',
                                $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']])) . ';';

                    $formaPagamentoId = $FormaPagamento['forma_pagamento_id'];

                    $quantidadeFormasPagamento++;

                }

            endforeach;
        } else {
            $jSON['error'] = 'Nenhuma forma de pagamento encontrada!';
            echo json_encode($jSON);
            die;
        }

        $qtd = $PostData["qtd"];
        $titulos = "";
        $jSON['qtd'] = $qtd;
        $Clientes = [];

        $ArrUpdateSCPC = [
            'envio_status' => 1,
            'envio_observacao' => "Baixado do SCPC"
        ];

        for($i = 0; $i < $qtd; $i++){

            $ArrUpdate = [
                'mov_recebimento_status' => 1,
                'mov_recebimento_data_recebimento' => date('Y-m-d'),
                'mov_recebimento_forma_pagamento' => $formaPagamentoId
            ];

            if($qtd == 1) {
                if($valorTotal >= $valorPagar) {
                    $ArrUpdate['mov_valor_pago'] = $valorPagar;
                }
            }

            if(isset($PostData["titulo_parcela_id_".$i])) {

                $Read->ExeRead("sys_movimentacao_recebimento",
                    "WHERE mov_recebimento_id = :id AND (mov_recebimento_status = 0 OR mov_recebimento_status IS NULL)",
                    "id={$PostData["titulo_parcela_id_".$i]}");

                if ($Read->getResult()) {

                    $Resultado = $Read->getResult()[0];

                    $Update->ExeUpdate("sys_movimentacao_recebimento", $ArrUpdate, "WHERE mov_recebimento_id = :id",
                        "id={$PostData["titulo_parcela_id_".$i]}");

                    $Read->ExeRead("sys_envio_scpc", "WHERE envio_movimentacao_recebimento_id = :id",
                        "id={$PostData["titulo_parcela_id_".$i]}");
                    if ($Read->getResult()) {
                        $Update->ExeUpdate("sys_envio_scpc", $ArrUpdateSCPC,
                            "WHERE envio_movimentacao_recebimento_id = :id", "id={$PostData["titulo_parcela_id_".$i]}");
                    }

                    $Read->FullRead("SELECT m.movimentacao_id, mr.mov_recebimento_id, MONTH(mr.mov_recebimento_emissao) AS primeiromes, YEAR(mr.mov_recebimento_emissao) AS primeiroano, 
                        mr.mov_recebimento_parcela, mr.mov_recebimento_valor AS valor, p.pessoa_nome AS aluno, mr.mov_recebimento_desc_identificador AS descricao, mr.mov_recebimento_tipo AS tipo, mr.mov_valor_pago AS valorpago,
                        CONCAT(e.catalogo_endereco,', ',e.catalogo_numero, ', ', e.catalogo_bairro, ', ', e.catalogo_cidade, ' - ', e.catalogo_uf) AS endereco, 
                        p.pessoa_cpf AS cpf, m.movimentacao_dia_vencimento AS vence, turma.projeto_descricao AS turma_nome, 
                        forma_pagamento.forma_pagamento_nome AS forma_nome, mr.mov_recebimento_parcela AS parcela, 
                        forma_parcela.forma_parcelamento_parcelas AS total_parcela,
                        DATE_FORMAT(mr.mov_recebimento_data_vencimento,'%d/%m/%Y') AS vencimento 

                        FROM sys_movimentacao AS m

                        INNER JOIN sys_pessoas AS p

                        LEFT OUTER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id 

                        LEFT OUTER JOIN sys_movimentacao_recebimento AS mr ON m.movimentacao_id = mr.mov_recebimento_movimento_id 

                        LEFT OUTER JOIN sys_projetos AS turma ON turma.projeto_id = m.movimentacao_projeto_id 

                        LEFT OUTER JOIN sys_forma_pagamento AS forma_pagamento ON forma_pagamento.forma_pagamento_id = mr.mov_recebimento_forma_pagamento

                        INNER JOIN sys_matriculas AS matriculas ON matriculas.matricula_id = m.movimentacao_matricula_id

                        INNER JOIN sys_matricula_item AS mat_item ON mat_item.matricula_item_proposta_id = matriculas.matricula_id

                        INNER JOIN sys_forma_parcelamento AS forma_parcela ON forma_parcela.forma_parcelamento_id = mat_item.matricula_item_forma_parcelamento_id

                        WHERE mr.mov_recebimento_id = :id
                        AND mr.mov_recebimento_pessoa_id = p.pessoa_id
                        GROUP BY m.movimentacao_id ORDER BY mr.mov_recebimento_parcela", "id={$PostData["titulo_parcela_id_".$i]}");

                    $Clientes[] = Array(
                        'mov_recebimento_id' => $Read->getResult()[0]['mov_recebimento_id'],
                        'primeiromes' => $Read->getResult()[0]['primeiromes'],
                        'primeiroano' => $Read->getResult()[0]['primeiroano'],
                        'mov_recebimento_parcela' => $Read->getResult()[0]['mov_recebimento_parcela'],
                        'descricao' => $Read->getResult()[0]['descricao'],
                        'valor' => $Read->getResult()[0]['valor'],
                        'valorpago' => $Read->getResult()[0]['valorpago'],
                        'aluno' => $Read->getResult()[0]['aluno'],
                        'tipo' => $Read->getResult()[0]['tipo'],
                        'endereco' => $Read->getResult()[0]['endereco'],
                        'cpf' => $Read->getResult()[0]['cpf'],
                        'vence' => $Read->getResult()[0]['vence'],
                        'turma_nome' => $Read->getResult()[0]['turma_nome'],
                        'forma_nome' => $Read->getResult()[0]['forma_nome'],
                        'parcela' => $Read->getResult()[0]['parcela'],
                        'total_parcela' => $Read->getResult()[0]['total_parcela'],
                        'vencimento' => $Read->getResult()[0]['vencimento']
                    );

                    $jSON['pessoa'] = $Resultado['mov_recebimento_pessoa_id'];
                    $jSON['success'] = 'Baixa do(s) título(s) realizada com sucesso!';

                } else {
                    $titulos .= "<br>Parcela " . $PostData['parcela_pagamento_' . $i] . " não está em aberto.<br>";
                }
            }

        }

        if($Resultado) {

            if ($quantidadeFormasPagamento) {
                $ArrCaixaAtual = [];
                foreach ($ArrFormasPagamento as $Forma) {

                    $ArrCaixaAtual[] = Array(
                        'transacao_caixa_descricao' => "Baixa de título - ".$Resultado['mov_recebimento_desc_identificador'],
                        'transacao_caixa_data' => date('Y/m/d'),
                        'transacao_caixa_hora' => date('h:i:s', time()),
                        'transacao_caixa_valor' => $Forma['valor'],
                        'transacao_conta_id' => $Resultado['mov_recebimento_movimento_id'],
                        'transacao_caixa_tipo_id' => 1,
                        'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                        'transacao_caixa_forma' => $Forma['forma_id'],
                        'unidade_id' => $_SESSION['userSYSFranquia']['unidade_padrao'],
                        'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                        'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_baixa_parcela_conta_id'],
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"],
                        'transacao_caixa_aluno_id' => $Resultado['mov_recebimento_pessoa_id'],
                        'transacao_caixa_tipo_parcela' => $Resultado['mov_recebimento_parcela_tipo']
                    );

                }

                $Create->ExeCreateMulti("sys_transacao_caixa", $ArrCaixaAtual);

                if ($valorTotal > $valorPagar && $qtd == 1) {

                    $diferenca = $valorTotal - $valorPagar;

                    $ArrParcelas = [
                        'mov_recebimento_movimento_id' => $Resultado['mov_recebimento_movimento_id'],
                        'mov_recebimento_valor' => $diferenca,
                        'mov_recebimento_numero' => 2,
                        'mov_recebimento_data_vencimento' => date('Y/m/d'),
                        'mov_recebimento_data_recebimento' => null,
                        'mov_recebimento_parcela' => 1,
                        'mov_recebimento_tipo_id' => 0,
                        'mov_recebimento_status' => 0,
                        'mov_recebimento_emissao' => date('Y/m/d'),
                        'mov_recebimento_pessoa_id' => $PostData["cliente_id_geral_parcelas"],
                        'mov_recebimento_valor_sem_desconto' => $diferenca,
                        'mov_recebimento_desc_identificador' => $Read->getResult()[0]['descricao']." - Valor restante de pagamento",
                        'mov_recebimento_parcela_tipo' => 1
                    ];

                    $Create->ExeCreate("sys_movimentacao_recebimento", $ArrParcelas);

                }

            }
        }

        if($titulos != "") {
            $jSON['error'] = 'OPPSSS: ' . $titulos;
        }

        if(!empty($jSON['success'])){

            $Read->FullRead("SELECT p.pessoa_nome AS nome_empresa, CONCAT(c.catalogo_endereco,', ',c.catalogo_numero, ', ', c.catalogo_bairro, ', ', c.catalogo_cidade, ' - ', c.catalogo_uf) AS endereco_empresa, c.catalogo_cidade AS cidade_empresa,  t.telefone AS tel_empresa, p.pessoa_cnpj as cnpj_empresa FROM sys_pessoas AS p INNER JOIN sys_catalogo_endereco_pessoas AS c ON p.pessoa_id = c.pessoa_id INNER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id WHERE p.pessoa_tipo_id = 7 AND p.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
            $jSON['empresa'] = $Read->getResult()[0];

            $jSON['cliente'] = $Clientes;
            $jSON['nomeFormasPagamento'] = $FormasPagamentoNome;

        }
        break;

    case 'EstornarParcelas':

        if (in_array('', $PostData)):
            $jSON['error'] = 'OPPSSS: Favor, preencha todos os campos!';
        else:

            $qtd = $PostData["qtd"];
            $titulos = "";

            for($i = 0; $i < $qtd; $i++) {

                $ArrUpdate = [
                    'mov_recebimento_status' => 0,
                    'mov_recebimento_data_recebimento' => null
                ];

                $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id AND mov_recebimento_status = 1", "id={$PostData["titulo_parcela_id_".$i]}");
                if($Read->getResult()){

                    $Resultado = $Read->getResult()[0];

                    $Update->ExeUpdate("sys_movimentacao_recebimento", $ArrUpdate, "WHERE mov_recebimento_id = :id", "id={$PostData["titulo_parcela_id_".$i]}");

                    $CreateData['tipo'] = 2;
                    $CreateData['motivo_id'] = $PostData['motivo_estorno_parcela'];
                    $CreateData['observacao'] = $PostData['observacoes_estorno_parcelas'];
                    $CreateData['date'] = date('Y-m-d H:i:s');
                    $CreateData['funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                    $CreateData['id_titulo'] = $PostData['titulo_parcela_id_'.$i];

                    $Create->ExeCreate("sys_log_parcelas", $CreateData);

                    $CreateDataCaixa['transacao_caixa_descricao'] = "Estorno de título";
                    $CreateDataCaixa['transacao_caixa_data'] = date('Y/m/d');
                    $CreateDataCaixa['transacao_caixa_hora'] = date('h:i:s a', time());
                    $CreateDataCaixa['transacao_caixa_valor'] = -$Resultado['mov_recebimento_valor'];
                    $CreateDataCaixa['transacao_conta_id'] = $Resultado['mov_recebimento_movimento_id'];
                    $CreateDataCaixa['transacao_caixa_tipo_id'] = 2;
                    $CreateDataCaixa['transacao_caixa_pessoa_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                    $CreateDataCaixa['transacao_caixa_forma'] = null;

                    $Create->ExeCreate("sys_transacao_caixa", $CreateDataCaixa);

                    $jSON['pessoa'] = $Resultado['mov_recebimento_pessoa_id'];
                    $jSON['success'] = 'Seu registro foi salvo com sucesso!';

                } else {
                    $titulos .= "<br>Parcela " . $PostData['parcela_pagamento_'.$i] . " não pode ser estornada.<br>";
                }

            }
            if($titulos != "") {
                $jSON['error'] = 'OPPSSS: ' . $titulos;
            }
        endif;

        break;

    case 'buscaMotivoEstornarParcela':

        $Read->ExeRead("sys_motivos_estornos", "WHERE motivo_estornos_status = :st", "st=0");
        if($Read->getResult()){
            $motivos = "<div class='row list_remove_estornar_baixa_parcela'><div class='col-md-12'><div class='form-group'><label>Motivos Estorno</label><select class='form-control' name='motivo_estorno_parcela'><option value=''>Selecione o motivo</option>";
            foreach ($Read->getResult() as $Motivos) {
                $motivos .= "<option value='{$Motivos['motivo_estornos_id']}'>{$Motivos['motivo_estornos_nome']}</option>";
            }

            $motivos .= "</select></div></div><div class='col-md-12'><div class='form-group'><label>Observações</label><textarea class='form-control' name='observacoes_estorno_parcelas'></textarea></div></div></div>";

            $jSON['success'] = $motivos;

        } else {
            $jSON['error'] = 'OPPSSS: Não existem motivos de estorno de baixa de títulos cadastrados!';
        }

        break;

    case 'buscarParametrosMultaJurosBaixaParcelas':

        $itens = "";
        $quantidade = $PostData["qtd"];
        $carenciaParametro = $_SESSION['parametrosSYS']['parametro_dias_carencia'];
        $multaParametro = $_SESSION['parametrosSYS']['parametro_multa_atraso'];
        $tipoParametro = $_SESSION['parametrosSYS']['parametro_tipo_calculo_atraso']; //0 - Porcentagem ; 1 - Valor
        $formaCalcJurosParametro = $_SESSION['parametrosSYS']['parametro_forma_calculo_juros']; //0- Juros e multa, 1- Perda desconto, 3 - Ambos
        $TotalJuros     = 0;
        $TotalMulta     = 0;
        $DiasAtraso     = 0;
        $Juros          = 0;

        if($quantidade > 0){
            for($i = 0; $i < $quantidade; $i++){

                $titulo_id = $PostData["id_{$i}"];
                $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id", "id={$titulo_id}");
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Parcela) {
                        extract($Parcela);

                        if($formaCalcJurosParametro == 0) {

                            $dataHoje = date('Y-m-d');
                            $dataBoleto = $mov_recebimento_data_vencimento;
                            if(strtotime($dataHoje) > strtotime($dataBoleto)) {

                                $data1 = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
                                $data2 = new DateTime($mov_recebimento_data_vencimento, new DateTimeZone('UTC'));
                                $intervalo = date_diff($data1, $data2);
                                $PercJuros      = $_SESSION['parametrosSYS']['parametro_juros_atraso'];
                                $DataVencimento = date("", strtotime($mov_recebimento_data_vencimento));
                                $DiasAtraso     = $intervalo->days;
                                $DiasCarencia   = $carenciaParametro;

                                if ($DiasAtraso > 0){

                                    $DiasAtraso = $DiasAtraso - $DiasCarencia;

                                    if ($DiasAtraso > 0) {
                                        $JurosDiario  = ($PercJuros / 30) / 100;
                                        $Juros = $mov_recebimento_valor * ($JurosDiario * $DiasAtraso);
                                        $TotalJuros = $TotalJuros + $Juros;
                                        $TotalMulta = $mov_recebimento_valor * ($multaParametro) / 100;

                                        if($DiasAtraso > 15 && $mov_recebimento_tipo == 1) {
                                            $TotalMulta = $DiasAtraso * 0.33;
                                            $TotalMulta = ($mov_recebimento_valor * $TotalMulta) / 100;
                                        }

                                    } else {
                                        $DiasAtraso = $intervalo; // apenas calcula juros sem cobrar
                                    }
                                }

                                $totalFinal = $mov_recebimento_valor + $TotalJuros + $TotalMulta;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;

                            } else {
                                $totalFinal = $mov_recebimento_valor;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                            }

                        } elseif($formaCalcJurosParametro == 1) {

                            $dataHoje = date('Y-m-d');
                            $dataBoleto = $mov_recebimento_data_vencimento;

                            if(strtotime($dataHoje) > strtotime($dataBoleto)) {

                                if ($origem_matricula == 1) {

                                    if ($mov_recebimento_tipo == 1 && $mov_recebimento_valor != $mov_recebimento_valor_sem_desconto) {

                                        $data1 = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
                                        $data2 = new DateTime($mov_recebimento_data_vencimento, new DateTimeZone('UTC'));
                                        $intervalo = date_diff($data1, $data2);
                                        $DiasAtraso = $intervalo->days;

                                        $Read->FullRead("SELECT porcentagem_desconto, dias FROM sys_matriz_desconto where dias = (select max(dias) from sys_matriz_desconto aux where aux.dias <= :d ) AND unidade_id = :id",
                                            "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}&d={$DiasAtraso}");
                                        if ($Read->getResult()) {

                                            $resultado = $Read->getResult()[0];

                                            if($resultado['porcentagem_desconto'] != 100){

                                                $total = $mov_recebimento_valor_sem_desconto;
                                                $parte = $mov_recebimento_valor;
                                                $porcentagemDoDesconto = $parte*100/$total;

                                                $diferenca = $porcentagemDoDesconto - $resultado['porcentagem_desconto'];

                                                $novoValorFinal = $mov_recebimento_valor_sem_desconto - (($diferenca / 100) * $mov_recebimento_valor_sem_desconto);

                                            } else {

                                                $novoValorFinal = $mov_recebimento_valor_sem_desconto;
                                            }

                                            $totalFinal = $novoValorFinal;
                                            $totalAnterior = $mov_recebimento_valor;
                                            $totalOriginal = $mov_recebimento_valor_sem_desconto;

                                        } else {

                                            $dataHoje = date('Y-m-d');
                                            $dataBoleto = $mov_recebimento_data_vencimento;
                                            if (strtotime($dataHoje) > strtotime($dataBoleto)) {

                                                $totalFinal = $mov_recebimento_valor_sem_desconto;
                                                $totalAnterior = $mov_recebimento_valor;
                                                $totalOriginal = $mov_recebimento_valor_sem_desconto;

                                            } else {
                                                $totalFinal = $mov_recebimento_valor;
                                                $totalAnterior = $mov_recebimento_valor;
                                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                                            }
                                        }

                                    } else {

                                        $dataHoje = date('Y-m-d');
                                        $dataBoleto = $mov_recebimento_data_vencimento;
                                        if (strtotime($dataHoje) > strtotime($dataBoleto)) {

                                            $totalFinal = $mov_recebimento_valor_sem_desconto;
                                            $totalAnterior = $mov_recebimento_valor;
                                            $totalOriginal = $mov_recebimento_valor_sem_desconto;

                                        } else {
                                            $totalFinal = $mov_recebimento_valor;
                                            $totalAnterior = $mov_recebimento_valor;
                                            $totalOriginal = $mov_recebimento_valor_sem_desconto;
                                        }
                                    }

                                } else {

                                    $dataHoje = date('Y-m-d');
                                    $dataBoleto = $mov_recebimento_data_vencimento;
                                    if (strtotime($dataHoje) > strtotime($dataBoleto)) {

                                        $totalFinal = $mov_recebimento_valor_sem_desconto;
                                        $totalAnterior = $mov_recebimento_valor;
                                        $totalOriginal = $mov_recebimento_valor_sem_desconto;

                                    } else {
                                        $totalFinal = $mov_recebimento_valor;
                                        $totalAnterior = $mov_recebimento_valor;
                                        $totalOriginal = $mov_recebimento_valor_sem_desconto;
                                    }
                                }
                            } else {
                                $totalFinal = $mov_recebimento_valor;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                            }

                        } elseif($formaCalcJurosParametro == 2) {

                            $dataHoje = date('Y-m-d');
                            $dataBoleto = $mov_recebimento_data_vencimento;
                            if(strtotime($dataHoje) > strtotime($dataBoleto)) {

                                $data1 = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
                                $data2 = new DateTime($mov_recebimento_data_vencimento, new DateTimeZone('UTC'));
                                $intervalo = date_diff($data1, $data2);
                                $PercJuros      = $_SESSION['parametrosSYS']['parametro_juros_atraso'];
                                $DataVencimento = date("", strtotime($mov_recebimento_data_vencimento));
                                $DiasAtraso     = $intervalo->days;
                                $DiasCarencia   = $carenciaParametro;

                                if ($DiasAtraso > 0){

                                    $DiasAtraso = $DiasAtraso - $DiasCarencia;

                                    if ($DiasAtraso > 0) {
                                        $JurosDiario  = ($PercJuros / 30) / 100;
                                        $Juros = $mov_recebimento_valor * ($JurosDiario * $DiasAtraso);
                                        $TotalJuros = $TotalJuros + $Juros;
                                        $TotalMulta = $mov_recebimento_valor * ($multaParametro) / 100;

                                        if($DiasAtraso > 15 && $mov_recebimento_tipo == 1) {
                                            $TotalMulta = $DiasAtraso * 0.33;
                                            $TotalMulta = ($mov_recebimento_valor_sem_desconto * $TotalMulta) / 100;
                                        }

                                    } else {
                                        $DiasAtraso = $intervalo; // apenas calcula juros sem cobrar
                                    }
                                }

                                $totalFinal = $mov_recebimento_valor_sem_desconto + $TotalJuros + $TotalMulta;

                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;

                            } else {
                                $totalFinal = $mov_recebimento_valor_sem_desconto;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                            }

                        }

                        $itens .= "<div class='row list_remove'>";
                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Parcela</label>";
                        $itens .= "<input type='hidden' name='titulo_parcela_id_{$i}' value='{$mov_recebimento_id}'/>";
                        $itens .= "<input type='hidden' class='j_pessoa_id' value='{$mov_recebimento_pessoa_id}'/>";
                        $itens .= "<input type='hidden' name='qtd' value='{$quantidade}'/>";
                        $itens .= "<input readonly type='text' name='parcela_pagamento_{$i}' value='{$mov_recebimento_parcela}' class='form-control'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='".date('d/m/Y', strtotime($mov_recebimento_data_vencimento))."'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Valor</label>";
                        $itens .= "<input readonly type='text' value='".number_format($totalAnterior, '2', ',', '.')."' class='form-control formMoney'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Valor Original</label>";
                        $itens .= "<input readonly type='text' value='".number_format($totalOriginal, '2', ',', '.')."' class='form-control formMoney'></div></div>";

                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Atraso</label><input readonly class='form-control' type='text' value='".$DiasAtraso." dias'></div></div>";

                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Multa</label><input readonly class='form-control' type='text' value='".number_format($TotalMulta, '2', ',', '.')."'></div></div>";
                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Juros</label><input readonly class='form-control' type='text' value='".number_format($TotalJuros, '2', ',', '.')."'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Total a Pagar</label>";
                        $itens .= "<input readonly type='text' name='valor_a_pagar_pagamento_{$i}' value='".number_format($totalFinal, '2', ',', '.')."' class='form-control valor_a_pagar_pagamento_{$i} formMoney'></div></div>";
                        $itens .= "</div>";
                    }
                }
            }
            $jSON['success'] = $itens;
        }
        break;

    case 'buscarParametrosCalculoDebitosParcelas':

        $itens = "";
        $quantidade = $PostData["qtd"];
        $carenciaParametro = $_SESSION['parametrosSYS']['parametro_dias_carencia'];
        $multaParametro = $_SESSION['parametrosSYS']['parametro_multa_atraso'];
        $tipoParametro = $_SESSION['parametrosSYS']['parametro_tipo_calculo_atraso']; //0 - Porcentagem ; 1 - Valor
        $formaCalcJurosParametro = $_SESSION['parametrosSYS']['parametro_forma_calculo_juros']; //0- Juros e multa, 1- Perda desconto, 3 - Ambos
        $TotalJuros     = 0;
        $TotalMulta     = 0;
        $DiasAtraso     = 0;
        $Juros          = 0;
        $totalDebitos   = 0;

        if($quantidade > 0){
            for($i = 0; $i < $quantidade; $i++){

                $titulo_id = $PostData["id_{$i}"];
                $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id", "id={$titulo_id}");
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Parcela) {
                        extract($Parcela);

                        if($formaCalcJurosParametro == 0) {

                            $dataHoje = date('Y-m-d');
                            $dataBoleto = $mov_recebimento_data_vencimento;
                            if(strtotime($dataHoje) > strtotime($dataBoleto)) {

                                $data1 = new DateTime(date('Y-m-d'));
                                $data2 = new DateTime($mov_recebimento_data_vencimento);
                                $intervalo = $data1->diff( $data2 );
                                $PercJuros      = $_SESSION['parametrosSYS']['parametro_juros_atraso'];
                                $DataVencimento = date("", strtotime($mov_recebimento_data_vencimento));
                                $DiasAtraso     = $intervalo->d;
                                $DiasCarencia   = $carenciaParametro;

                                if ($DiasAtraso > 0){

                                    $DiasAtraso = $DiasAtraso - $DiasCarencia;

                                    if ($DiasAtraso > 0) {
                                        $JurosDiario  = ($PercJuros / 30) / 100;
                                        $Juros = $mov_recebimento_valor * ($JurosDiario * $DiasAtraso);
                                        $TotalJuros = $TotalJuros + $Juros;
                                        $TotalMulta = $mov_recebimento_valor * ($multaParametro) / 100;
                                    } else {
                                        $DiasAtraso = $intervalo; // apenas calcula juros sem cobrar
                                    }
                                }

                                $totalFinal = $mov_recebimento_valor + $TotalJuros + $TotalMulta;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;

                            } else {
                                $totalFinal = $mov_recebimento_valor;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                            }

                        } elseif($formaCalcJurosParametro == 1) {

                            $totalFinal = $mov_recebimento_valor_sem_desconto;
                            $totalAnterior = $mov_recebimento_valor;
                            $totalOriginal = $mov_recebimento_valor_sem_desconto;

                        } elseif($formaCalcJurosParametro == 2) {

                            $dataHoje = date('Y-m-d');
                            $dataBoleto = $mov_recebimento_data_vencimento;
                            if(strtotime($dataHoje) > strtotime($dataBoleto)) {

                                $data1 = new DateTime(date('Y-m-d'));
                                $data2 = new DateTime($mov_recebimento_data_vencimento);
                                $intervalo = $data1->diff( $data2 );
                                $PercJuros      = $_SESSION['parametrosSYS']['parametro_juros_atraso'];
                                $DataVencimento = date("", strtotime($mov_recebimento_data_vencimento));
                                $DiasAtraso     = $intervalo->d;
                                $DiasCarencia   = $carenciaParametro;

                                if ($DiasAtraso > 0){

                                    $DiasAtraso = $DiasAtraso - $DiasCarencia;

                                    if ($DiasAtraso > 0) {
                                        $JurosDiario  = ($PercJuros / 30) / 100;
                                        $Juros = $mov_recebimento_valor * ($JurosDiario * $DiasAtraso);
                                        $TotalJuros = $TotalJuros + $Juros;
                                        $TotalMulta = $mov_recebimento_valor * ($multaParametro) / 100;
                                    } else {
                                        $DiasAtraso = $intervalo; // apenas calcula juros sem cobrar
                                    }
                                }

                                $totalFinal = $mov_recebimento_valor_sem_desconto + $TotalJuros + $TotalMulta;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;

                            } else {
                                $totalFinal = $mov_recebimento_valor_sem_desconto;
                                $totalAnterior = $mov_recebimento_valor;
                                $totalOriginal = $mov_recebimento_valor_sem_desconto;
                            }

                        }

                        $itens .= "<div class='row list_remove_item_calculo'>";
                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Parcela</label>";
                        $itens .= "<input type='hidden' name='titulo_parcela_id_{$i}' value='{$mov_recebimento_id}'/>";
                        $itens .= "<input type='hidden' class='j_pessoa_id' value='{$mov_recebimento_pessoa_id}'/>";
                        $itens .= "<input type='hidden' name='qtd' value='{$quantidade}'/>";
                        $itens .= "<input readonly type='text' name='parcela_pagamento_{$i}' value='{$mov_recebimento_parcela}' class='form-control'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='".date('d/m/Y', strtotime($mov_recebimento_data_vencimento))."'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Valor</label>";
                        $itens .= "<input readonly type='text' value='".number_format($totalAnterior, '2', ',', '.')."' class='form-control formMoney'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Valor Original</label>";
                        $itens .= "<input readonly type='text' value='".number_format($totalOriginal, '2', ',', '.')."' class='form-control formMoney'></div></div>";
                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Multa</label><input readonly class='form-control' type='text' value='".number_format($TotalMulta, '2', ',', '.')."'></div></div>";
                        $itens .= "<div class='col-md-1'><div class='form-group'><label>Juros</label><input readonly class='form-control' type='text' value='".number_format($TotalJuros, '2', ',', '.')."'></div></div>";
                        $itens .= "<div class='col-md-2'><div class='form-group'><label>Total a Pagar</label>";
                        $itens .= "<input readonly type='text' name='valor_a_pagar_pagamento_{$i}' value='".number_format($totalFinal, '2', ',', '.')."' class='form-control valor_a_pagar_pagamento_{$i} formMoney'></div></div>";
                        $itens .= "</div>";

                        $totalDebitos += $totalFinal;
                    }
                }
            }
            $itens .= "<div class='row list_remove_item_calculo'>";
            $itens .= "<div class='col-md-9'></div><div class='col-md-2'><div class='form-group'><label>Total de Débitos</label>";
            $itens .= "<input readonly type='text' value='".number_format($totalDebitos, '2', ',', '.')."' class='form-control valor_a_pagar_pagamento_{$i} formMoney'></div>";
            $itens .= "</div>";
            $itens .= "</div>";
            $jSON['success'] = $itens;
        }
        break;

    case 'buscaMotivoCancelamento':

        $Read->ExeRead("sys_motivos_cancelamento", "WHERE motivo_cancelamento_status = :st", "st=0");
        if($Read->getResult()){
            $motivos = "<div class='row list_remove_cancelar'><div class='col-md-12'><div class='form-group'><label>Motivos Cancelamento</label><select class='form-control' name='motivo_cancelamento_parcela'><option value=''>Selecione o motivo</option>";
            foreach ($Read->getResult() as $Motivos) {
                $motivos .= "<option value='{$Motivos['motivo_cancelamento_id']}'>{$Motivos['motivo_cancelamento_nome']}</option>";
            }

            $motivos .= "</select></div></div><div class='col-md-12'><div class='form-group'><label>Observações</label><textarea class='form-control' name='observacoes_cancelamento_parcelas'></textarea></div></div></div>";

            $jSON['success'] = $motivos;

        } else {
            $jSON['error'] = 'OPPSSS: Não existem motivos de cancelamento cadastrados!';
        }

        break;

    case 'buscaMotivoDataVencimento':

        $Read->ExeRead("sys_motivos_alterar_vencimento", "WHERE motivo_alterar_vencimento_status = :st", "st=0");
        if($Read->getResult()){
            $motivos = "<div class='row list_alterar_data_vencimento'><div class='col-md-12'><div class='form-group'><label>Motivos Alteração de Vencimento</label><select class='form-control' name='motivo_alterar_vencimento_parcela'><option value=''>Selecione o motivo</option>";
            foreach ($Read->getResult() as $Motivos) {
                $motivos .= "<option value='{$Motivos['motivo_alterar_vencimento_id']}'>{$Motivos['motivo_alterar_vencimento_nome']}</option>";
            }

            $motivos .= "</select></div></div><div class='col-md-12'><div class='form-group'><label>Observações</label><textarea class='form-control' name='observacoes_alterar_vencimento_parcelas'></textarea></div></div></div>";

            $jSON['success'] = $motivos;

        } else {
            $jSON['error'] = 'OPPSSS: Não existem motivos para alterar vencimento cadastrados!';
        }

        break;

    case 'AlterarDataVencimento':

        if (in_array('', $PostData)):
            $jSON['error'] = 'OPPSSS: Favor, preencha todos os campos!';
        else:
            $date = str_replace('/', '-', $PostData['data_vencimento'] );
            $newDate = date("Y-m-d", strtotime($date));
            $UpdateData = [
                "mov_recebimento_data_vencimento" => $newDate
            ];

            $Update->ExeUpdate("sys_movimentacao_recebimento", $UpdateData, "WHERE mov_recebimento_id = :id", "id={$PostData['titulo_id']}");

            $CreateDataCaixa['tipo'] = 3;
            $CreateDataCaixa['motivo_id'] = $PostData['motivo_alterar_vencimento_parcela'];
            $CreateDataCaixa['observacao'] = $PostData['observacoes_alterar_vencimento_parcelas'];
            $CreateDataCaixa['date'] = date('Y-m-d H:i:s');
            $CreateDataCaixa['funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
            $CreateDataCaixa['id_titulo'] = $PostData['titulo_id'];

            $Create->ExeCreate("sys_log_parcelas", $CreateDataCaixa);
            $jSON['pessoa'] = $PostData['pessoa_id'];
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;
        break;

    case 'AlterarDataVencimentoMassa':

        if (in_array('', $PostData)):
            $jSON['error'] = 'OPPSSS: Favor, preencha todos os campos!';
        else:

        $data = str_replace('/', '-', $PostData['data_vencimento'] );

        $parte = explode('-', $data);
        $dia = $parte[0];
        $mes = $parte[1];
        $ano = $parte[2];

        // Define a data inicial
        $date = new DateTime();
        $date->setDate($ano, $mes, $dia);

        $CreateDataCaixa['tipo'] = 3;
        $CreateDataCaixa['motivo_id'] = $PostData['motivo_alterar_vencimento_parcela'];
        $CreateDataCaixa['observacao'] = $PostData['observacoes_alterar_vencimento_parcelas'];
        $CreateDataCaixa['date'] = date('Y-m-d H:i:s');
        $CreateDataCaixa['funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];

       $Read->FullRead("SELECT * FROM sys_movimentacao_recebimento WHERE mov_recebimento_status = :s AND mov_recebimento_pessoa_id = :id AND mov_recebimento_tipo = :tipo AND mov_recebimento_desc_identificador = :identificador ORDER BY mov_recebimento_parcela, mov_recebimento_movimento_id", "s={0}&id={$PostData['pessoa_id']}&tipo={$PostData['tipo_id']}&identificador={$PostData['produto']}");

        if($Read->getResult()) {

            $i = 0;
            $parcela = 0;

            foreach ($Read->getResult() as $r) {               

                if($i == 0) {              
                 
                    $newDate = date('Y-m-d', strtotime($data));
                  
                } else {

                    
                    if($r['mov_recebimento_parcela'] == $parcela) {

                        $i--;

                    }                    

                    $newDate = $addDate->addMonths($date, $i)->format("Y-m-d");
                      
                }

                $UpdateData = [
                    "mov_recebimento_data_vencimento" => $newDate
                ];
                    
                $Update->ExeUpdate("sys_movimentacao_recebimento", $UpdateData, "WHERE mov_recebimento_pessoa_id = :id AND mov_recebimento_tipo = :tipo AND mov_recebimento_status = :status AND mov_recebimento_parcela = :parcela AND mov_recebimento_desc_identificador = :identificador", "id={$PostData['pessoa_id']}&tipo={$PostData['tipo_id']}&status={0}&parcela={$r['mov_recebimento_parcela']}&identificador={$r['mov_recebimento_desc_identificador']}");

                $CreateDataCaixa['id_titulo'] = $r['mov_recebimento_id'];

                $Create->ExeCreate("sys_log_parcelas", $CreateDataCaixa);

                $i++;
                $parcela = $r['mov_recebimento_parcela'];
                
            }     
            
        }

        $jSON['pessoa'] = $PostData['pessoa_id'];
        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        
        endif;
        break;

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
            $jSON['error'] = 'OPPSSS: Favor, preencha o número do título!';
        } elseif (empty(trim($PostData['movimentacao_pessoa_nome']))) {
            $jSON['error'] = 'OPPSSS: Favor, preencha o fornecedor!';
        } elseif (empty(trim($PostData['movimentacao_valor_total']))) {
            $jSON['error'] = 'OPPSSS: Favor, preencha o valor total!';
        } else {

            if ($PostData['movimentacao_pago_recebido'] == 1) {
                $valorTotal = str_replace(',', '.', str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas']));
                $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas']));
                //$valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas']));
                $valorDesconto = str_replace(',', '.', str_replace('.', '', $PostData['valor_desconto_geral_parcelas']));

                if ($valorTotal != $valorPagar) {
                    $jSON['error'] = 'OPPSSS: Valor total diferente que valor a pagar';
                    echo json_encode($jSON);
                    die;
                }

                /*if ($valorPagar > $valorTotal) {
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
            $CreateData['movimentacao_data'] = $PostData['movimentacao_data'];
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

            // GERAÇÃO DE CAIXA
            if ($PostData['movimentacao_pago_recebido'] == 1) {

                if($quantidadeFormasPagamento){
                    $ArrCaixaAtual = [];
                    foreach($ArrFormasPagamento as $Forma){

                        $ArrCaixaAtual[] = Array(
                            'transacao_caixa_descricao' => $PostData['movimentacao_descricao'],
                            'transacao_caixa_data' => date('Y/m/d'),
                            'transacao_caixa_hora' => date('h:i:s a', time()),
                            'transacao_caixa_valor' => $Forma['valor'],
                            'transacao_conta_id' => $MovimentacaoCreateID,
                            'transacao_caixa_tipo_id' => 1,
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

                    if ($CreateData['movimentacao_tipo_parcelamento'] == 0) // se for recorrencia
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
                        'mov_recebimento_movimento_id' => $MovimentacaoCreateID,
                        'mov_recebimento_valor' => $valor_parcela,
                        'mov_recebimento_numero' => $PostData['movimentacao_numero'],
                        'mov_recebimento_data_vencimento' => $data,
                        'mov_recebimento_data_recebimento' => $data_pag,
                        'mov_recebimento_parcela' => $i,
                        'mov_recebimento_tipo_id' => 0,
                        'mov_recebimento_status' => 0,
                        'mov_recebimento_emissao' => date('Y/m/d'),
                        'mov_recebimento_pessoa_id' => $PostData['movimentacao_pessoa_id'],
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

                $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);

            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=contasreceber/filtro_movimentacao_recebimento";
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

    case 'LoginOperadorFinanceiro':
            $senha = hash('sha512', $PostData['senha']);
            $Id = $PostData['pessoa_id'];
            $Read->FullRead("SELECT pessoa_id FROM sys_operadores_financeiro WHERE pessoa_id = :id AND senha = :pass AND unidade_id = :unidade", "id={$Id}&pass={$senha}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
            if (!$Read->getResult()):
                $jSON['error'] = "Senha informada não confere com o operador selecionado";
            else:
                $jSON['success'] = $PostData['tipo'];
            endif;
        break;

endswitch;

echo json_encode($jSON);