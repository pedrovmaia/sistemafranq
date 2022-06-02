<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action'], $_SESSION['dataUltimaParcela']);
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

$PostData['numeroParcela'] = 1;
if (isset($PostData['numeroParcela'])):
    $quantidade_numeroEntrada = $PostData['numeroParcela'];
    unset($PostData['numeroParcela']);
endif;

if (isset($PostData['quantidade_produto_matricula'])):
    $quantidade_produto_proposta = $PostData['quantidade_produto_matricula'];
    unset($PostData['quantidade_produto_matricula']);
endif;

function criarParcelas($id_produto, $tipo_produto, $nome_produto, $pessoa_id, $MovimentacaoCreateID, $proposta_item_parcelamento_id, $pedido_item_valor_total, $pedido_valor_normal, $pedido_item_vencimento, $dia_vencimento, $desconto, $ultimaData){

     
    // CRIAÇÃO DE PARCELAS
    $Read = new Read;
    $Create = new Create;

    $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, f.forma_parcelamento_tipo FROM sys_forma_parcelamento AS f WHERE f.forma_parcelamento_id = :id", "id={$proposta_item_parcelamento_id}");
    if($Read->getResult()){

        $ArrParcelas = [];

        foreach ($Read->getResult() as $ItemProposta) {

            $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
            if(!$ultimaData) {
                $data = date('Y/m/d', strtotime($pedido_item_vencimento));
            } else {
                $data = $_SESSION['dataUltimaParcela'];
            }

            $Read->FullRead("SELECT dias_vencimento_nome FROM sys_dias_vencimento WHERE dias_vencimento_id = :id", "id={$dia_vencimento}");
            if($Read->getResult()) {
                $ResultadoDataVencimento = $Read->getResult()[0];
            } else {
                $ResultadoDataVencimento = date('d', strtotime($data));
            }

            for($i = 1; $i <= $parcelas; $i++){

                if($i > 1){

                    if($ResultadoDataVencimento){

                        $DiaDosVencimentos = $ResultadoDataVencimento["dias_vencimento_nome"];

                        $data = $_SESSION['dataUltimaParcela'];

                        $mes = date('m', strtotime($data));
                        $ano = date("Y", strtotime($data));

                        $ultimo_dia = date("t", mktime(0,0,0, $mes,'01',$ano));

                        if($DiaDosVencimentos == '31')
                        {
                            $DiaDosVencimentos = $ultimo_dia;
                        }

                        $data_fim = mktime(0, 0, 0, $mes, $DiaDosVencimentos, $ano);

                        $data = date('Y/m/d',$data_fim);
                    }
                }

                $pedido_item_valor_total_desconto = $pedido_item_valor_total;

                // localizando valor das parcelas
                if($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                {
                    $valor_parcela = $pedido_item_valor_total_desconto;
                    $valor_parcela_total = $pedido_valor_normal;
                }

                if($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                {
                    $valor_parcela = $pedido_item_valor_total_desconto / $parcelas;
                    $valor_parcela_total = $pedido_valor_normal / $parcelas;
                }

                if($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                {
                    $valor_parcela = $pedido_item_valor_total_desconto;
                    $valor_parcela_total = $pedido_valor_normal;
                }

                $ArrParcelas[] = Array(
                    'mov_recebimento_movimento_id' => $MovimentacaoCreateID,
                    'mov_recebimento_valor' => $valor_parcela,
                    'mov_recebimento_numero' => 2,
                    'mov_recebimento_data_vencimento' => $data,
                    'mov_recebimento_data_recebimento' => null,
                    'mov_recebimento_parcela' => $i,
                    'mov_recebimento_tipo_id' => 0,
                    'mov_recebimento_status' => 0,
                    'mov_recebimento_emissao' => date('Y/m/d'),
                    'mov_recebimento_pessoa_id' => $pessoa_id,
                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                    'mov_recebimento_valor_sem_desconto' => $valor_parcela_total,
                    'mov_recebimento_tipo' => $tipo_produto,
                    'mov_recebimento_identificador' => $id_produto,
                    'mov_recebimento_desc_identificador' => $nome_produto,
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"],
                    'origem_matricula' => 1
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

                    if($i > 1){
                        if($DiaDosVencimentos == '31') {
                            $d = new DateTime($data);
                            $d->modify( 'last day of next month');
                            $data = $d->format( 'Y/m/d' );
                        } else {
                            $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                        }

                    } else {
                        $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                    }

                }

                $_SESSION['dataUltimaParcela'] = $data;
            }
        }

        $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);
    }
}

function criarParcelasMateriais($id_produto, $tipo_produto, $nome_produto, $pessoa_id, $MovimentacaoCreateID, $proposta_item_parcelamento_id, $pedido_item_valor_total, $pedido_valor_normal, $pedido_item_vencimento, $dia_vencimento, $desconto){

    // CRIAÇÃO DE PARCELAS
    $Read = new Read;
    $Create = new Create;

    $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, f.forma_parcelamento_tipo FROM sys_forma_parcelamento AS f WHERE f.forma_parcelamento_id = :id", "id={$proposta_item_parcelamento_id}");
    if($Read->getResult()){

        $ArrParcelas = [];

        foreach ($Read->getResult() as $ItemProposta) {

            $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
            $data = date('Y/m/d', strtotime($pedido_item_vencimento));

            $Read->FullRead("SELECT dias_vencimento_nome FROM sys_dias_vencimento WHERE dias_vencimento_id = :id", "id={$dia_vencimento}");
            if($Read->getResult()) {
                $ResultadoDataVencimento = $Read->getResult()[0];
            } else {
                $ResultadoDataVencimento = date('d', strtotime($data));
            }

            $pedido_item_valor_total_desconto = $pedido_item_valor_total;

            for($i = 1; $i <= $parcelas ; $i++){

                if($i > 1){

                    if($ResultadoDataVencimento){

                        $DiaDosVencimentos = $ResultadoDataVencimento["dias_vencimento_nome"];

                        $mes = date('m', strtotime($data));
                        $ano = date("Y", strtotime($data));

                        $ultimo_dia = date("t", mktime(0,0,0, $mes,'01',$ano));

                        if($DiaDosVencimentos == '31')
                        {
                            $DiaDosVencimentos = $ultimo_dia;
                        }

                        $data_fim = mktime(0, 0, 0, $mes, $DiaDosVencimentos, $ano);

                        $data = date('Y/m/d',$data_fim);
                    }
                }

                // localizando valor das parcelas
                if($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                {
                    $valor_parcela = $pedido_item_valor_total_desconto;
                    $valor_parcela_total = $pedido_valor_normal;
                }

                if($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                {
                    $valor_parcela = $pedido_item_valor_total_desconto / $parcelas;
                    $valor_parcela_total = $pedido_valor_normal / $parcelas;
                }

                if($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                {
                    $valor_parcela = $pedido_item_valor_total_desconto;
                    $valor_parcela_total = $pedido_valor_normal;
                }

                $ArrParcelas[] = Array(
                    'mov_recebimento_movimento_id' => $MovimentacaoCreateID,
                    'mov_recebimento_valor' => $valor_parcela,
                    'mov_recebimento_numero' => 2,
                    'mov_recebimento_data_vencimento' => $data,
                    'mov_recebimento_data_recebimento' => null,
                    'mov_recebimento_parcela' => $i,
                    'mov_recebimento_tipo_id' => 0,
                    'mov_recebimento_status' => 0,
                    'mov_recebimento_emissao' => date('Y/m/d'),
                    'mov_recebimento_pessoa_id' => $pessoa_id,
                    'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                    'mov_recebimento_valor_sem_desconto' => $valor_parcela_total,
                    'mov_recebimento_tipo' => $tipo_produto,
                    'mov_recebimento_identificador' => $id_produto,
                    'mov_recebimento_desc_identificador' => $nome_produto,
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

                    if($i > 1){
                        if($DiaDosVencimentos == '31') {
                            $d = new DateTime($data);
                            $d->modify( 'last day of next month');
                            $data = $d->format( 'Y/m/d' );
                        } else {
                            $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                        }

                    } else {
                        $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                    }

                }

            }
        }

        $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);
    }
}

switch ($action):

    case 'simularParcelasMatricula':

        $Read = new Read;

        $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, f.forma_parcelamento_tipo FROM sys_forma_parcelamento AS f WHERE f.forma_parcelamento_id = :id", "id={$PostData['proposta_item_parcelamento_id']}");
        if($Read->getResult()) {

            $PostData['proposta_item_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_item_valor_total']));

            $retorno = "";

            foreach ($Read->getResult() as $ItemProposta) {

                $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
                $data = date('Y/m/d', strtotime($PostData['proposta_data_primeiro_vencimento']));
                /*if($PostData['seq'] > 1){
                    $data = date('Y/m/d', strtotime("+{$PostData['qtd_parcelas']} month", strtotime($data)));
                }*/

                for ($i = 1; $i <= $parcelas; $i++) {

                    if (!empty($PostData['desconto_matricula'])) {
                        $Read->ExeRead("sys_descontos", "WHERE desconto_status = 0 AND desconto_id = :id",
                            "id={$PostData['desconto_matricula']}");
                        if ($Read->getResult()) {
                            foreach ($Read->getResult() as $Desconto) {

                                $desconto_valor = $Desconto['desconto_valor'];
                                $desconto_tipo = $Desconto['desconto_tipo_valor'];

                                if ($desconto_tipo == 0) {

                                    $pedido_item_valor_total_desconto = $PostData['proposta_item_valor_total'] - (($desconto_valor / 100) * $PostData['proposta_item_valor_total']);

                                } elseif ($desconto_tipo == 1) {

                                    $pedido_item_valor_total_desconto = $PostData['proposta_item_valor_total'] - $desconto_valor;

                                }

                            }
                        }

                    } else {
                        $pedido_item_valor_total_desconto = $PostData['proposta_item_valor_total'];
                    }

                    // localizando valor das parcelas
                    if ($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                    {
                        $valor_parcela = $pedido_item_valor_total_desconto;
                        $valor_parcela_total = $PostData['proposta_item_valor_total'];
                    }

                    if ($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                    {
                        $valor_parcela = $pedido_item_valor_total_desconto / $parcelas;
                        $valor_parcela_total = $PostData['proposta_item_valor_total'] / $parcelas;
                    }

                    if ($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                    {
                        $valor_parcela = $pedido_item_valor_total_desconto;
                        $valor_parcela_total = $PostData['proposta_item_valor_total'];
                    }

                    $retorno .= "<tr><td>{$PostData['nome_produto']}</td><td>{$i}</td><td>".date('d/m/Y', strtotime($data))."</td><td>".number_format($valor_parcela, '2', ',', '.')."</td></tr>";


                    if ($ItemProposta['forma_parcelamento_intervalo'] == 'Semanal') {
                        $data = date('Y/m/d', strtotime("+7 days", strtotime($data)));
                    }

                    if ($ItemProposta['forma_parcelamento_intervalo'] == 'Quinzenal') {
                        $data = date('Y/m/d', strtotime("+15 days", strtotime($data)));
                    }

                    if ($ItemProposta['forma_parcelamento_intervalo'] == 'Mensal') {
                        $data = date('Y/m/d', strtotime("+1 month", strtotime($data)));
                    }
                }
            }
            $jSON['success'] = $retorno;
        }

        break;

    case 'PedidoAdd':

        if(!isset($PostData['curso_id'])){
            $jSON['error'] = 'Favor, escolha um curso para continuar!';
            echo json_encode($jSON);
            die;
        }

        if($quantidade_centro_custo){

            for($i = 0; $i < $quantidade_centro_custo; $i++){

                if(!isset($PostData['centro_custo_' . $i])){
                    $jSON['error'] = 'Favor, preencha o campo de rateio da matrícula!';
                    echo json_encode($jSON);
                    die;
                }

                if(!isset($PostData['valor_rateio_' . $i])) {
                    $jSON['error'] = 'Favor, preencha o campo de rateio da matrícula!';
                    echo json_encode($jSON);
                    die;
                }
            }
        } else {
            $jSON['error'] = 'Favor, preencha o campo de rateio da matrícula!';
            echo json_encode($jSON);
            die;
        }

        if(!$PostData['txt_id_turma']){
            $turma = 1;
            $PostData['txt_id_turma'] = null;
        } else {
            $turma = 2;
            unset($PostData['horario_preferencia'], $PostData['telefone_contato'], $PostData['periodo_preferencia'], $PostData['dia_semana_preferencia']);
        }

        if(!$PostData['txt_id_turma'] && !$PostData['horario_preferencia'] && !$PostData['telefone_contato'] && !isset($PostData['periodo_preferencia']) && !isset($PostData['dia_semana_preferencia'])){
            $jSON['error'] = 'Favor, preencha o campo de turma ou lista de espera!';
            echo json_encode($jSON);
            die;
        }

        if(empty($PostData['pedido_valor_total'])){
            $jSON['error'] = 'Opps... Valor Total está vazio, tente novamente!';
            echo json_encode($jSON);
            die;
        }

        if($quantidade_produto_proposta){

            for($i = 0; $i <= $quantidade_produto_proposta; $i++){

                if(isset($PostData['nome_produto_' . $i])) {

                    if (!empty($PostData['proposta_entrada_' . $i])) {

                        if (empty($PostData['proposta_data_entrada_' . $i])) {
                            $jSON['error'] = 'Favor, preencha a data da entrada!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($quantidade_numeroEntrada <= 0){
                            $jSON['error'] = 'Favor, preencha as formas de pagamento na da entrada!';
                            echo json_encode($jSON);
                            die;
                        }
                    }

                    if (empty($PostData['proposta_dia_vencimento_' . $i])) {
                        $jSON['error'] = 'Favor, preencha o dia de vencimento!';
                        echo json_encode($jSON);
                        die;
                    }

                    if (empty($PostData['proposta_data_primeiro_vencimento_' . $i])) {
                        $jSON['error'] = 'Favor, preencha a data do 1º vencimento dos materiais';
                        echo json_encode($jSON);
                        die;
                    }
                }

            }
        }

        if ($PostData['pedido_cliente_id'] == "" || $PostData['pessoa_nome'] == ""):
            $jSON['error'] = 'Favor, escolha um aluno!';
        else:

            if($turma == 2){

                $matricula_projeto_id = $PostData['txt_id_turma'];

                $Read->FullRead("SELECT p.projeto_produto_id FROM sys_projetos AS p WHERE p.projeto_id = :id", "id={$PostData['txt_id_turma']}");
                if($Read->getResult()) {
                    $projeto_produto_id = $Read->getResult()[0]['projeto_produto_id'];
                }

                $Read->FullRead("SELECT p.pessoa_id, p.pessoa_email FROM sys_envolvidos_projeto AS e 
                    INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id 
                    WHERE e.envolvidos_projeto_projeto_id = :id AND p.pessoa_id = :pessoa
                    AND e.unidade_id = :unidade", "id={$PostData['txt_id_turma']}&pessoa={$PostData['pedido_cliente_id']}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

                if($Read->getResult()){
                    $jSON['error'] = 'Aluno já matriculado nessa turma!';
                    echo json_encode($jSON);
                    die;
                }

            } else {

                $matricula_projeto_id = null;
                $projeto_produto_id = null;

            }

            $quantidadeFormasPagamento = 0;
            if(!empty($PostData['valor_pos_desconto_geral_parcelas'])) {

                $valorTotal = str_replace(',', '.', str_replace('.', '', $PostData['valor_pos_desconto_geral_parcelas']));
                $valorPagar = str_replace(',', '.', str_replace('.', '', $PostData['valor_pago_geral_parcelas']));
                //$valorTroco = str_replace(',', '.', str_replace('.', '', $PostData['valor_troco_geral_parcelas']));
                $valorDesconto = str_replace(',', '.', str_replace('.', '', $PostData['valor_desconto_geral_parcelas']));

                if($valorTotal != $valorPagar){
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

                    $ArrFormasPagamento = [];

                    foreach ($Read->getResult() as $FormaPagamento):

                        if(!empty($PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]) && $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']] != "0,00"){

                            $ArrFormasPagamento[] = [
                                "forma_id" => $FormaPagamento['forma_pagamento_id'],
                                "valor" => str_replace(',', '.', str_replace('.', '', $PostData["forma_pagamento_" . $FormaPagamento['forma_pagamento_id']]))
                            ];

                            $quantidadeFormasPagamento++;

                        }

                    endforeach;
                endif;

            }

            $PostData['pedido_valor_total'] = str_replace(',', '.', str_replace('.', '', $PostData['pedido_valor_total']));
            //$PostData['pedido_valor_entrada'] = str_replace(',', '.', str_replace('.', '', $PostData['pedido_valor_entrada']));

            if(empty($PostData['pedido_valor_total'])){
                $jSON['error'] = 'Opps... Valor Total está vazio, tente novamente!';
                echo json_encode($jSON);
                die;
            }

            if(isset($valorDesconto)){
                $PostData['pedido_valor_total'] = $PostData['pedido_valor_total'] - $valorDesconto;
            }

            if($PostData['tipo_matricula'] == 1){

                $CreateData['matricula_status'] = (!empty($PostData['pedido_status']) ? '1' : '0');
                $CreateData['matricula_data'] = (!empty($PostData['pedido_data']) ? Check::Data($PostData['pedido_data']) : date('Y-m-d H:i:s'));
                $CreateData['matricula_valor_total'] = $PostData['pedido_valor_total'];
                $CreateData['matricula_cliente_id'] = $PostData['pedido_cliente_id'];
                $CreateData['matricula_funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                $CreateData['matricula_observacao'] = $PostData['pedido_observacao'];
                $CreateData['matricula_patrocinador_id'] = $PostData['matricula_patrocinador_id'];
                $CreateData['matricula_curso_id'] = $PostData['curso_id'];
                $CreateData['matricula_turma_id'] = $PostData['txt_id_turma'];

                $Create->ExeCreate("sys_matriculas", $CreateData);
                $PedidoCreateID = $Create->getResult();

                if(!empty($PostData['orcamento_matricula_id'])){
                    $OrcamentoUpdate['orcamento_status'] = 1;
                    $Update->ExeUpdate("sys_orcamento_matricula", $OrcamentoUpdate, "WHERE orcamento_matricula_id = :id", "id={$PostData['orcamento_matricula_id']}");
                }

                // CRIAÇÃO DE MOVIMENTAÇÃO
                $CreateMovimenacao['movimentacao_data'] = date('Y/m/d');
                $CreateMovimenacao['movimentacao_hora'] = date('h:i:s a', time());
                $CreateMovimenacao['movimentacao_pessoa_id'] = $PostData['pedido_cliente_id'];
                $CreateMovimenacao['movimentacao_descricao'] = $PostData['pedido_observacao'];
                $CreateMovimenacao['movimentacao_valor_total'] = $PostData['pedido_valor_total'];
                $CreateMovimenacao['movimentacao_tipo_id'] = 2;
                $CreateMovimenacao['movimentacao_emissao'] = date('Y/m/d');
                $CreateMovimenacao['movimentacao_tipo'] = "Matrícula de Aluno";
                $CreateMovimenacao['movimentacao_nome'] = "Matrícula para " . $PostData['pessoa_nome'];
                $CreateMovimenacao['movimentacao_observacao'] = $PostData['pedido_observacao'];
                $CreateMovimenacao['movimentacao_status'] = 0;
                $CreateMovimenacao['movimentacao_origem_movimentacao'] = 1;
                $CreateMovimenacao['movimentacao_forma_pagamento_id'] = 6;
                $CreateMovimenacao['movimentacao_matricula_id'] = $PedidoCreateID;
                $CreateMovimenacao['movimentacao_projeto_id'] = $PostData['txt_id_turma'];
                $CreateMovimenacao['movimentacao_pago_recebido'] = 0;

                $Create->ExeCreate("sys_movimentacao", $CreateMovimenacao);
                $MovimentacaoCreateID = $Create->getResult();

                // RATEIO
                if($quantidade_centro_custo){
                    $ArrRateio = [];
                    for($i = 0; $i <= $quantidade_centro_custo; $i++){
                        if(isset($PostData['centro_custo_' . $i])){
                            $ArrRateio[] = Array(
                                'pedido_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                                'pedido_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                                'pedido_rateio_valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_rateio_' . $i])),
                                'pedido_rateio_tipo_id' => 0,
                                'pedido_rateio_proposta_id' => $MovimentacaoCreateID,
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                    $Create->ExeCreateMulti("sys_pedido_rateio", $ArrRateio);
                }

                $valor_total_matricula = 0;
                $entrada = 0;

                // PRODUTO
                if($quantidade_produto_proposta){
                    $ArrProduto = [];
                    $ultimaData = false;
                    for($i = 0; $i <= $quantidade_produto_proposta; $i++){

                        //ENTRADA
                        $tem_entrada = 0;
                        $valor_linha_com_entrada = 0;
                        $valores_entrada_itens = 0;

                        //DESCONTO
                        $tem_desconto = 0;
                        $valor_linha_com_desconto = 0;
                        $valores_desconto_itens = 0;

                        if(isset($PostData['nome_produto_' . $i])){

                            $tipo = $PostData['pedido_item_tipo_' . $i];

                            $PostData['proposta_item_valor_total_' . $i] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_item_valor_total_' . $i]));

                            if(!empty($PostData['desconto_matricula_' . $i])){

                                $Read->ExeRead("sys_descontos", "WHERE desconto_id = :id", "id={$PostData['desconto_matricula_' . $i]}");
                                if($Read->getResult()){
                                    $Desconto = $Read->getResult()[0];
                                    $tem_desconto = 1;

                                    if($Desconto['desconto_tipo_valor'] == 0){
                                        $valor_linha_com_desconto = $PostData['proposta_item_valor_total_' . $i] - (($Desconto['desconto_valor']/100)*$PostData['proposta_item_valor_total_' . $i]);
                                        $valores_desconto_itens = (($Desconto['desconto_valor']/100)*$PostData['proposta_item_valor_total_' . $i]);
                                    } elseif ($Desconto['desconto_tipo_valor'] == 1) {
                                        $valor_linha_com_desconto = $PostData['proposta_item_valor_total_' . $i] - $Desconto['desconto_valor'];
                                        $valores_desconto_itens = $Desconto['desconto_valor'];
                                    }

                                }

                                $PostData['matricula_desconto_id'] = $PostData['desconto_matricula_' . $i];

                            } else {
                                $PostData['matricula_desconto_id'] = null;
                            }

                            if(!empty($PostData['proposta_entrada_' . $i])){
                                $tem_entrada = 1;
                                $entrada = 1;
                                $PostData['matricula_item_entrada'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_entrada_' . $i]));
                                $valor_linha_com_entrada = $PostData['proposta_item_valor_total_' . $i] - $PostData['matricula_item_entrada'];
                                $valores_entrada_itens = floatval($PostData['matricula_item_entrada']) + $valores_entrada_itens;
                                $PostData['matricula_data_entrada'] = date('Y-m-d H:i:s', strtotime($PostData['proposta_data_entrada_' . $i]));
                                $PostData['matricula_item_entrada_total'] = $valores_entrada_itens;

                            } else {
                                $PostData['matricula_item_entrada'] = null;
                            }

                            $pedido_item_valor_total = $PostData['proposta_item_valor_total_' . $i];

                            if($tem_entrada == 1 && $tem_desconto == 1) {

                                $pedido_item_valor_total = $valor_linha_com_entrada - $valores_desconto_itens;


                            } elseif ($tem_entrada == 1) {

                                $pedido_item_valor_total = $valor_linha_com_entrada;

                            } elseif ($tem_desconto == 1) {

                                $pedido_item_valor_total = $valor_linha_com_desconto;

                            }

                            if($tipo == 1){
                                criarParcelas($PostData['nome_produto_' . $i . '_id'], $tipo, $PostData['nome_produto_' . $i], $PostData['pedido_cliente_id'], $MovimentacaoCreateID, $PostData['proposta_item_parcelamento_id_' . $i], $pedido_item_valor_total, $PostData['proposta_item_valor_total_' . $i], $PostData['proposta_data_primeiro_vencimento_' . $i], $PostData['proposta_dia_vencimento_' . $i], $PostData['desconto_matricula_' . $i], $ultimaData);
                            }

                            if($tipo == 2){
                                criarParcelasMateriais($PostData['nome_produto_' . $i . '_id'], $tipo, $PostData['nome_produto_' . $i], $PostData['pedido_cliente_id'], $MovimentacaoCreateID, $PostData['proposta_item_parcelamento_id_' . $i], $pedido_item_valor_total, $PostData['proposta_item_valor_total_' . $i], $PostData['proposta_data_primeiro_vencimento_' . $i], $PostData['proposta_dia_vencimento_' . $i], $PostData['desconto_matricula_' . $i]);
                            }

                            $ultimaData = true;

                            if(!$PostData['matricula_item_entrada']) {
                                $PostData['matricula_data_entrada'] = null;
                            }

                            if(!empty($PostData['desconto_matricula_' . $i])){
                                $Read->ExeRead("sys_descontos", "WHERE desconto_status = 0 AND desconto_id = :id", "id={$PostData['desconto_matricula_' . $i]}");
                                if($Read->getResult()){
                                    foreach ($Read->getResult() as $Desconto) {

                                        $desconto_valor = $Desconto['desconto_valor'];
                                        $desconto_tipo = $Desconto['desconto_tipo_valor'];

                                        if($desconto_tipo == 0){

                                            $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i]-(($desconto_valor/100)*$PostData['proposta_item_valor_total_' . $i]);

                                        } elseif ($desconto_tipo == 1) {

                                            $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i] - $desconto_valor;

                                        }

                                    }
                                }

                            } else {
                                $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i];
                            }

                            $valor_total_matricula += $PostData['proposta_item_valor_total_' . $i];

                            if($projeto_produto_id == $PostData['nome_produto_' . $i . '_id']) {
                                $variavel_matricula_projeto_id = $matricula_projeto_id;
                            } else {
                                $variavel_matricula_projeto_id = null;
                            }

                            $ArrProduto[] = Array(
                                'matricula_item_produto_id' => $PostData['nome_produto_' . $i . '_id'],
                                'matricula_item_proposta_id' => $PedidoCreateID,
                                'matricula_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                                'matricula_item_valor_unitario' => str_replace(',', '.', str_replace('.', '', $PostData['proposta_item_valor_unitario_' . $i])),
                                'matricula_item_valor_total' => $valor_total_matricula_desconto,
                                'matricula_item_tipo' => $tipo,
                                'matricula_item_forma_parcelamento_id' => $PostData['proposta_item_parcelamento_id_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'matricula_item_vencimento' => date('Y-m-d', strtotime($PostData['proposta_data_primeiro_vencimento_' . $i])),
                                'matricula_desconto_id' => $PostData['desconto_matricula_' . $i],
                                'matricula_item_entrada' => $PostData['matricula_item_entrada'],
                                'matricula_data_entrada' => $PostData['matricula_data_entrada'],
                                'matricula_dia_vencimento_id' => $PostData['proposta_dia_vencimento_' . $i],
                                'matricula_data_primeiro_vencimento' => $PostData['proposta_data_primeiro_vencimento_' . $i],
                                'modalidade_id' => $PostData['proposta_item_modalidade_' . $i],
                                'matricula_item_valor_total_sem_desconto' => $PostData['proposta_item_valor_total_' . $i],
                                'matricula_projeto_id' => $variavel_matricula_projeto_id,
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }

                    $Create->ExeCreateMulti("sys_matricula_item", $ArrProduto);
                }

                if($turma == 1){

                    $CreateEspera['lista_espera_projeto_pessoa_id'] = $PostData['pedido_cliente_id'];
                    $CreateEspera['lista_espera_projeto_periodo_preferencia'] = $PostData['periodo_preferencia'];
                    $CreateEspera['lista_espera_projeto_dia_preferencia'] = $PostData['dia_semana_preferencia'];
                    $CreateEspera['lista_espera_projeto_horario_preferencia'] = $PostData['horario_preferencia'];
                    $CreateEspera['lista_espera_projeto_telefone_contato'] = $PostData['telefone_contato'];
                    $CreateEspera['lista_espera_projeto_curso_id'] = $PostData['curso_id'];

                    $Create->ExeCreate("sys_lista_espera_projeto", $CreateEspera);
                }

                if($turma == 2){

                    $CreateEnvolvido['envolvidos_projeto_projeto_id'] = $PostData['txt_id_turma'];
                    $CreateEnvolvido['envolvidos_envolvido_id'] = $PostData['pedido_cliente_id'];
                    $CreateEnvolvido['envolvidos_envolvido_tipo_id'] = 1;
                    $CreateEnvolvido['envolvidos_movimentacao_id'] = $MovimentacaoCreateID;
                    $CreateEnvolvido['status'] = 0;

                    $Create->ExeCreate("sys_envolvidos_projeto", $CreateEnvolvido);
                }

                // GERAÇÃO DE CAIXA
                /*if($quantidadeFormasPagamento){
                    $ArrCaixaAtual = [];
                    foreach($ArrFormasPagamento as $Forma){

                        $ArrCaixaAtual[] = Array(
                            'transacao_caixa_descricao' => "Entrada de Matrícula",
                            'transacao_caixa_data' => date('Y/m/d H:i:s'),
                            'transacao_caixa_hora' => date('H:i:s'),
                            'transacao_caixa_valor' => $Forma['valor'],
                            'transacao_conta_id' => $MovimentacaoCreateID,
                            'transacao_caixa_tipo_id' => 1,
                            'transacao_caixa_pessoa_id' => $_SESSION['userSYSFranquia']['pessoa_id'],
                            'transacao_caixa_forma' => $Forma['forma_id'],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'transacao_caixa_caixa_id' => $_SESSION['caixaSYS']['caixa_id'],
                            'transacao_conta_bancaria_id' => $_SESSION['parametrosSYS']['parametro_matricula_conta_id'],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );

                    }

                    $Create->ExeCreateMulti("sys_transacao_caixa", $ArrCaixaAtual);
                }*/

                $DocCreate = [
                    "contrato_nome" => "MATRÍCULA ALUNO " . $PostData['pessoa_nome'],
                    "contrato_tipo_id" => 1,
                    "contrato_estagio_id" => 2,
                    "contrato_data_vencimento" => "",
                    "contrato_modelo_id" => 1,
                    "contrato_status" => 0,
                    "contrato_pessoa_id" => $PostData['pedido_cliente_id'],
                    "movimentacao_id" => $MovimentacaoCreateID,
                    "matricula_id" => $PedidoCreateID
                ];

                $Create->ExeCreate("sys_contratos", $DocCreate);

                $jSON['title'] = "Matricula Realizada!";
                $jSON['success'] = 'Sua matricula foi efetuada com sucesso!';
                $jSON['redirect'] = "painel.php?exe=pedidos/matricula/ver_pedido&id=" . $PedidoCreateID;

            } elseif($PostData['tipo_matricula'] == 2){

                $CreateData['orcamento_matricula_status'] = (!empty($PostData['pedido_status']) ? '1' : '0');
                $CreateData['orcamento_matricula_data'] = (!empty($PostData['pedido_data']) ? Check::Data($PostData['pedido_data']) : date('Y-m-d H:i:s'));
                $CreateData['orcamento_matricula_valor_total'] = $PostData['pedido_valor_total'];
                $CreateData['orcamento_matricula_aluno_id'] = $PostData['pedido_cliente_id'];
                $CreateData['orcamento_matricula_aluno_nome'] = $PostData['pessoa_nome'];
                $CreateData['orcamento_matricula_funcionario_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                $CreateData['orcamento_matricula_observacao'] = $PostData['pedido_observacao'];
                $CreateData['orcamento_matricula_patrocinador_id'] = $PostData['matricula_patrocinador_id'];
                $CreateData['orcamento_matricula_curso_id'] = $PostData['curso_id'];
                $CreateData['orcamento_matricula_turma_id'] = $PostData['txt_id_turma'];
                $CreateData['orcamento_status'] = 0;

                $Create->ExeCreate("sys_orcamento_matricula", $CreateData);
                $OrcamentoMatriculaCreateID = $Create->getResult();

                $valor_total_matricula = 0;
                $entrada = 0;

                // PRODUTO
                if($quantidade_produto_proposta){
                    $ArrProduto = [];
                    $ultimaData = false;
                    for($i = 0; $i <= $quantidade_produto_proposta; $i++){

                        //ENTRADA
                        $tem_entrada = 0;
                        $valor_linha_com_entrada = 0;
                        $valores_entrada_itens = 0;

                        //DESCONTO
                        $tem_desconto = 0;
                        $valor_linha_com_desconto = 0;
                        $valores_desconto_itens = 0;

                        if(isset($PostData['nome_produto_' . $i])){

                            $tipo = $PostData['pedido_item_tipo_' . $i];

                            $PostData['proposta_item_valor_total_' . $i] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_item_valor_total_' . $i]));

                            if(!empty($PostData['desconto_matricula_' . $i])){

                                $Read->ExeRead("sys_descontos", "WHERE desconto_id = :id", "id={$PostData['desconto_matricula_' . $i]}");
                                if($Read->getResult()){
                                    $Desconto = $Read->getResult()[0];
                                    $tem_desconto = 1;

                                    if($Desconto['desconto_tipo_valor'] == 0){
                                        $valor_linha_com_desconto = $PostData['proposta_item_valor_total_' . $i] - (($Desconto['desconto_valor']/100)*$PostData['proposta_item_valor_total_' . $i]);
                                        $valores_desconto_itens = (($Desconto['desconto_valor']/100)*$PostData['proposta_item_valor_total_' . $i]);
                                    } elseif ($Desconto['desconto_tipo_valor'] == 1) {
                                        $valor_linha_com_desconto = $PostData['proposta_item_valor_total_' . $i] - $Desconto['desconto_valor'];
                                        $valores_desconto_itens = $Desconto['desconto_valor'];
                                    }

                                }

                                $PostData['matricula_desconto_id'] = $PostData['desconto_matricula_' . $i];

                            } else {
                                $PostData['matricula_desconto_id'] = null;
                            }

                            if(!empty($PostData['proposta_entrada_' . $i])){
                                $tem_entrada = 1;
                                $entrada = 1;
                                $PostData['matricula_item_entrada'] = str_replace(',', '.', str_replace('.', '', $PostData['proposta_entrada_' . $i]));
                                $valor_linha_com_entrada = $PostData['proposta_item_valor_total_' . $i] - $PostData['matricula_item_entrada'];
                                $valores_entrada_itens = floatval($PostData['matricula_item_entrada']) + $valores_entrada_itens;
                                $PostData['matricula_data_entrada'] = date('Y-m-d H:i:s', strtotime($PostData['proposta_data_entrada_' . $i]));
                                $PostData['matricula_item_entrada_total'] = $valores_entrada_itens;

                            } else {
                                $PostData['matricula_item_entrada'] = null;
                            }

                            $pedido_item_valor_total = $PostData['proposta_item_valor_total_' . $i];

                            if($tem_entrada == 1 && $tem_desconto == 1) {

                                $pedido_item_valor_total = $valor_linha_com_entrada - $valores_desconto_itens;


                            } elseif ($tem_entrada == 1) {

                                $pedido_item_valor_total = $valor_linha_com_entrada;

                            } elseif ($tem_desconto == 1) {

                                $pedido_item_valor_total = $valor_linha_com_desconto;

                            }

                            //criarParcelas($PostData['nome_produto_' . $i . '_id'], $tipo, $PostData['nome_produto_' . $i], $PostData['pedido_cliente_id'], $MovimentacaoCreateID, $PostData['proposta_item_parcelamento_id_' . $i], $pedido_item_valor_total, $PostData['proposta_data_primeiro_vencimento_' . $i], $PostData['desconto_matricula_' . $i], $ultimaData);

                            $ultimaData = true;

                            if(!$PostData['matricula_item_entrada']) {
                                $PostData['matricula_data_entrada'] = null;
                            }

                            if(!empty($PostData['desconto_matricula_' . $i])){
                                $Read->ExeRead("sys_descontos", "WHERE desconto_status = 0 AND desconto_id = :id", "id={$PostData['desconto_matricula_' . $i]}");
                                if($Read->getResult()){
                                    foreach ($Read->getResult() as $Desconto) {

                                        $desconto_valor = $Desconto['desconto_valor'];
                                        $desconto_tipo = $Desconto['desconto_tipo_valor'];

                                        if($desconto_tipo == 0){

                                            $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i]-(($desconto_valor/100)*$PostData['proposta_item_valor_total_' . $i]);

                                        } elseif ($desconto_tipo == 1) {

                                            $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i] - $desconto_valor;

                                        }

                                    }
                                }

                            } else {
                                $valor_total_matricula_desconto = $PostData['proposta_item_valor_total_' . $i];
                            }

                            $valor_total_matricula += $PostData['proposta_item_valor_total_' . $i];

                            $ArrProduto[] = Array(
                                'orcamento_matricula_item_produto_id' => $PostData['nome_produto_' . $i . '_id'],
                                'orcamento_matricula_item_orcamento_id' => $OrcamentoMatriculaCreateID,
                                'orcamento_matricula_item_quantidade' => $PostData['proposta_item_quantidade_' . $i],
                                'orcamento_matricula_item_valor_unitario' => str_replace(',', '.', str_replace('.', '', $PostData['proposta_item_valor_unitario_' . $i])),
                                'orcamento_matricula_item_valor_total' => $valor_total_matricula_desconto,
                                'orcamento_matricula_item_tipo' => $tipo,
                                'orcamento_matricula_item_forma_parcelamento_id' => $PostData['proposta_item_parcelamento_id_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'orcamento_matricula_item_vencimento' => date('Y-m-d', strtotime($PostData['proposta_data_primeiro_vencimento_' . $i])),
                                'orcamento_matricula_item_desconto_id' => $PostData['desconto_matricula_' . $i],
                                'orcamento_matricula_item_entrada' => $PostData['matricula_item_entrada'],
                                'orcamento_matricula_item_data_entrada' => $PostData['matricula_data_entrada'],
                                'orcamento_matricula_item_dia_vencimento_id' => $PostData['proposta_dia_vencimento_' . $i],
                                'orcamento_matricula_item_data_primeiro_vencimento' => $PostData['proposta_data_primeiro_vencimento_' . $i],
                                'modalidade_id' => $PostData['proposta_item_modalidade_' . $i],
                                'orcamento_matricula_item_valor_total_sem_desconto' => $PostData['proposta_item_valor_total_' . $i],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                    $Create->ExeCreateMulti("sys_orcamento_matricula_item", $ArrProduto);
                }

                $CreateEspera['orcamento_matricula_periodo_preferencia'] = (!empty($PostData['periodo_preferencia']) ? $PostData['periodo_preferencia'] : null);
                $CreateEspera['orcamento_matricula_dia_preferencia'] = (!empty($PostData['dia_semana_preferencia']) ? $PostData['dia_semana_preferencia'] : null);
                $CreateEspera['orcamento_matricula_horario_preferencia'] = (!empty($PostData['horario_preferencia']) ? $PostData['horario_preferencia'] : null);
                $CreateEspera['orcamento_matricula_telefone_contato'] = (!empty($PostData['telefone_contato']) ? $PostData['telefone_contato'] : null);
                $CreateEspera['orcamento_matricula_turma_id'] = $PostData['txt_id_turma'];
                $CreateEspera['orcamento_matricula_turma_tipo'] = $turma;

                $Update->ExeUpdate("sys_orcamento_matricula", $CreateEspera, "", "");

                $jSON['title'] = "Orçamento Realizado!";
                $jSON['success'] = 'Orçamento de matricula foi efetuada com sucesso!';
                $jSON['redirect'] = "painel.php?exe=pedidos/matricula/ver_orcamento&id=" . $OrcamentoMatriculaCreateID;

            }
            /*if($entrada == 1) {
                $CreateDataCaixa['transacao_caixa_descricao'] = $PostData['pedido_observacao'];
                $CreateDataCaixa['transacao_caixa_data'] = date('Y/m/d');
                $CreateDataCaixa['transacao_caixa_hora'] = date('h:i:s a', time());
                $CreateDataCaixa['transacao_caixa_valor'] = $PostData['matricula_item_entrada_total'];
                $CreateDataCaixa['transacao_conta_id'] = $MovimentacaoCreateID;
                $CreateDataCaixa['transacao_caixa_tipo_id'] = 1;
                $CreateDataCaixa['transacao_caixa_pessoa_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                $CreateDataCaixa['transacao_caixa_caixa_id'] = $_SESSION['caixaSYS']["caixa_id"];
                $Create->ExeCreate("sys_transacao_caixa", $CreateDataCaixa);
                $IdCreateDataCaixa = $Create->getResult();

                $ArrFormasEntrada = [];
                for($i = 0; $i <= $quantidade_numeroEntrada; $i++) {

                    if(isset($PostData['forma_' . $i])) {
                        $ArrFormasEntrada[] = Array(
                            'forma_pagamento_id' => $PostData['forma_' . $i],
                            'valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_' . $i])),
                            'matricula_id' => $PedidoCreateID,
                            'transacao_caixa_id' => $IdCreateDataCaixa,
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"]
                        );
                    }
                }

                $Create->ExeCreateMulti("sys_forma_pagamento_entrada_matricula", $ArrFormasEntrada);
            }*/
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_pedido", "WHERE pedido_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_pedidos", "WHERE pedido_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedidos/pedido/filtro_pedido";

        endif;
        break;

    case 'buscarTemplateMatricula':

        if(isset($_SESSION['parametrosSYS'])){
            $Retorno = $_SESSION['parametrosSYS'];

            if(!isset($Retorno['parametro_dia_vencimento_id'])){
                $jSON['error'] = "Não existem parâmetros de dia de vencimento cadastrado";
                echo json_encode($jSON);
                die;
            }

            $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_id = :st", "st={$Retorno['parametro_dia_vencimento_id']}");
            if($Read->getResult()){
                $Vencimento = $Read->getResult()[0];

                if (date('d') == $Vencimento['dias_vencimento_nome']) {
                    $Retorno['vencimento_data'] = date('Y-m-d');
                } else {

                    $data = new DateTime('22-01-1990');
                    $data->setDate(date('Y'), date('m', strtotime("+1 month")), $Vencimento['dias_vencimento_nome']);
                    $Retorno['vencimento_data'] = $data->format('Y-m-d');
                }
            }

            $jSON['success'] = $Retorno;
        } else {
            $jSON['error'] = "Não existem parâmetros cadastrados";
        }

        break;

    case 'completarMatricula':

        $valorTotal = 0;

        if(!empty($PostData["forma_parcelamento"])){
            $Read->FullRead("SELECT forma_parcelamento_parcelas FROM sys_forma_parcelamento WHERE forma_parcelamento_id = :id", "id={$PostData["forma_parcelamento"]}");
            if($Read->getResult()){
                $QuantidadeDeParcelas = $Read->getResult()[0]['forma_parcelamento_parcelas'] - 1;
                $QuantidadeDeParcelasSegunda = $Read->getResult()[0]['forma_parcelamento_parcelas'] ;
            } else {
                $QuantidadeDeParcelas = null;
            }
        } else {
            $QuantidadeDeParcelas = null;
        }

        $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_id = :id", "id={$PostData["dia_vencimento"]}");
        if ($Read->getResult()) {
            $dia_vencimento_livro = $Read->getResult()[0]['dias_vencimento_nome'];
        }

        $Read->FullRead("SELECT mo.modalidade_id, e.estagio_produto_id, e.estagio_produto_nome, e.estagio_sequencia, p.produto_nome, e.estagio_produto_valor, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_estagio_produto AS e INNER JOIN sys_produto AS p ON e.estagio_produto_produto_id = p.produto_id LEFT OUTER JOIN sys_politica_comercial_estagios AS es ON e.estagio_produto_id = es.politica_comercial_estagio_id INNER JOIN sys_modalidades AS mo ON mo.modalidade_id = es.modalidade_id WHERE p.produto_id = :id AND es.modalidade_id = :m AND es.unidade_id = :unidade", "id={$PostData['produto_id']}&m={$PostData['modalidade']}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

        if($Read->getResult()){
            $estagios_a_cursar = "";
            $material_didatico = "";
            $jSON['success'] = "true";
            $numero = 0;
            $numeroEstagio = 0;

            $idsEstagios = "";

            $data_vencimento = date('Y-m-d', strtotime($PostData["data_vencimento"]));

            foreach ($Read->getResult() as  $Estagios) {

                $nova_data = date('Y-m-d');
                $de = date('Y-m-d', strtotime($Estagios["politica_comercial_data_inicio"]));
                $ate = date('Y-m-d', strtotime($Estagios["politica_comercial_data_final"]));

                if(($nova_data >= $de) && ($nova_data <= $ate)) {
                    $valor = $Estagios["politica_comercial_valor"];
                } else {
                    $valor = $Estagios["estagio_produto_valor"];
                }

                $valorTotal = $valorTotal + $valor;

                $idsEstagios .= ";" . $Estagios['estagio_produto_id'];

                $estagios_a_cursar .= "<tr class='table_{$numero} listagem_dos_itens lista_de_estagios'>";
                $estagios_a_cursar .= "<td><input type='hidden' class='pedido_item_tipo_{$numero}' name='pedido_item_tipo_{$numero}' value='1'>";
                $estagios_a_cursar .= "<input value='{$Estagios['produto_nome']} - {$Estagios['estagio_produto_nome']}' readonly type='text' name='nome_produto_{$numero}' class='form-control nome_produto_{$numero}'>";
                $estagios_a_cursar .= "<input value='{$Estagios['estagio_produto_id']}' type='hidden' name='nome_produto_{$numero}_id'></td>";
                $estagios_a_cursar .= "<input value='{$Estagios['modalidade_id']}' readonly type='hidden' name='proposta_item_modalidade_{$numero}' class='proposta_item_modalidade_{$numero}'>";
                $estagios_a_cursar .= "<td><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_total_{$numero}' class='form-control proposta_item_valor_total_{$numero} valor_total_tabela formMoney' value='{$valor}'>";
                $estagios_a_cursar .= "<input readonly type='hidden' name='proposta_item_valor_unitario_{$numero}' class='form-control proposta_item_valor_unitario_{$numero} dinheiro' value='{$valor}'>";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_item_quantidade_{$numero}' data-uni='{$valor}' data-total='proposta_item_valor_total_{$numero}' class='form-control proposta_item_quantidade_{$numero} qtd_itens_list' value='1'>";
                $estagios_a_cursar .= "<input type='hidden' class='desconto_matricula_{$numero}' name='desconto_matricula_{$numero}' value='{$PostData["desconto"]}' />";
                $estagios_a_cursar .= "<input type='hidden' id='proposta_estagio_sequencia_{$numero}' accesskey='{$valor}' class='proposta_item_forma_parcelamento proposta_item_parcelamento_id_{$numero}' name='proposta_item_parcelamento_id_{$numero}' value='{$PostData["forma_parcelamento"]}' />";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_entrada_{$numero}' class='proposta_valor_entrada proposta_entrada_{$numero}'>";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_data_entrada_{$numero}' class='proposta_data_entrada_{$numero}'>";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_dia_vencimento_{$numero}' class='proposta_dia_vencimento_{$numero}' value='{$PostData["dia_vencimento"]}' />";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_data_primeiro_vencimento_{$numero}' class='proposta_data_primeiro_vencimento_{$numero}' value='{$PostData["data_vencimento"]}'>";
                $estagios_a_cursar .= "<input type='hidden' name='proposta_estagio_sequencia_{$numero}' class='proposta_estagio_sequencia_{$numero}' value='{$Estagios['estagio_sequencia']}'>";
                $estagios_a_cursar .= "</td>";
                $estagios_a_cursar .= "<td class='td-actions text-right'><button type='button' accesskey='table_{$numero}' rel='tooltip' title='Editar' class='btn btn-warning btn-link btn-sm btn-editar'>";
                $estagios_a_cursar .= "<i class='material-icons'>edit</i></button>";
                $estagios_a_cursar .= "<button type='button' accesskey='table_{$numero}' rel='tooltip' title='Remove' class='btn btn-danger btn-link btn-sm btn_remove'>";
                $estagios_a_cursar .= "<i class='material-icons'>close</i></button>";
                $estagios_a_cursar .= "<button type='button' accesskey='table_{$numero}' rel='tooltip' title='Ver simulação' class='btn btn-primary btn-link btn-sm btn_parcelas_simulacao'>";
                $estagios_a_cursar .= "<i class='material-icons'>visibility</i></button>";
                $estagios_a_cursar .= "</td>";
                $estagios_a_cursar .= "</tr>";

                if($numeroEstagio > 0) {

                    if($numeroEstagio == 1)
                    {
                        $novaDataVencimento = mktime(23, 59, 50, date('m', strtotime($data_vencimento)), $dia_vencimento_livro, date('Y', strtotime($data_vencimento)));
                        $data_vencimento = date('Y-m-d', strtotime("+{$QuantidadeDeParcelas} month ", $novaDataVencimento));    
                    }
                    else
                    {
                        $novaDataVencimento = mktime(23, 59, 50, date('m', strtotime($data_vencimento)), $dia_vencimento_livro, date('Y', strtotime($data_vencimento)));
                        $data_vencimento = date('Y-m-d', strtotime("+{$QuantidadeDeParcelasSegunda} month ", $novaDataVencimento));
                    }

                    
                } else {
                    $data_vencimento = $PostData["data_vencimento"];
                }

                $numero++;
                $numeroEstagio++;

                $Read->FullRead("SELECT mp.produto_id, e.estagio_produto_nome, p.produto_nome, p.produto_valor_venda, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_materiais_estagio_produto AS mp INNER JOIN sys_estagio_produto AS e ON mp.estagio_id = e.estagio_produto_id INNER JOIN sys_produto AS p ON mp.produto_id = p.produto_id INNER JOIN sys_politica_comercial_produtos AS es ON p.produto_id = es.politica_comercial_produto_id WHERE e.estagio_produto_id = :id AND es.unidade_id = :unidade", "id={$Estagios['estagio_produto_id']}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Materiais) {

                        $nova_data = date('Y-m-d');
                        $de = date('Y-m-d', strtotime($Materiais["politica_comercial_data_inicio"]));
                        $ate = date('Y-m-d', strtotime($Materiais["politica_comercial_data_final"]));

                        if(($nova_data >= $de) && ($nova_data <= $ate)) {
                            $valor = $Materiais["politica_comercial_valor"];
                        } else {
                            $valor = $Materiais["produto_valor_venda"];
                        }

                        $valorTotal = $valorTotal + $valor;

                        $material_didatico .= "<tr class='table_{$numero} listagem_dos_itens lista_de_materiais'>";
                        $material_didatico .= "<td><input type='hidden' class='pedido_item_tipo_{$numero}' name='pedido_item_tipo_{$numero}' value='2'>";
                        $material_didatico .= "<input value='{$Materiais['produto_nome']}' readonly type='text' name='nome_produto_{$numero}' class='form-control nome_produto_{$numero}'>";
                        $material_didatico .= "<input value='{$Materiais['produto_id']}' type='hidden' name='nome_produto_{$numero}_id'>";
                        $material_didatico .= "<input type='hidden' name='proposta_item_quantidade_{$numero}' class='form-control proposta_item_quantidade_{$numero} qtd_itens_list' value='1'>";
                        $material_didatico .= "<input type='hidden' name='proposta_item_valor_unitario_{$numero}' class='form-control proposta_item_valor_unitario_{$numero} dinheiro' value='{$valor}'>";
                        $material_didatico .= "<input type='hidden' name='proposta_desconto_{$numero}' value='{$PostData["desconto"]}'/>";
                        $material_didatico .= "<input type='hidden' accesskey='{$valor}' class='proposta_item_forma_parcelamento proposta_item_parcelamento_id_{$numero}' value='{$PostData["forma_parcelamento_material"]}' name='proposta_item_parcelamento_id_{$numero}'/>";
                        $material_didatico .= "<input type='hidden' name='proposta_entrada_{$numero}' class='form-control proposta_valor_entrada proposta_entrada_{$numero}'>";
                        $material_didatico .= "<input type='hidden' name='proposta_data_entrada_{$numero}' class='proposta_data_entrada_{$numero}'>";
                        $material_didatico .= "<input type='hidden' value='{$PostData["dia_vencimento"]}' class='proposta_dia_vencimento_{$numero}' name='proposta_dia_vencimento_{$numero}'>";
                        $material_didatico .= "<input type='hidden' name='proposta_data_primeiro_vencimento_{$numero}' class='proposta_data_primeiro_vencimento_{$numero}' value='{$data_vencimento}'>";
                        $material_didatico .= "<input type='hidden' class='desconto_matricula_{$numero}' name='desconto_matricula_{$numero}' value='' />";
                        $material_didatico .= "</td>";
                        $material_didatico .= "<input value='{$Estagios['modalidade_id']}' readonly type='hidden' name='proposta_item_modalidade_{$numero}' class='proposta_item_modalidade_{$numero}'>";
                        $material_didatico .= "<td><input readonly type='text' name='proposta_item_valor_total_{$numero}' class='form-control proposta_item_valor_total_{$numero} valor_total_tabela formMoney' value='{$valor}'></td>";
                        $material_didatico .= "<td class='td-actions text-right'><button type='button' accesskey='table_{$numero}' rel='tooltip' title='Editar' class='btn btn-warning btn-link btn-sm btn-editar'>";
                        $material_didatico .= "<i class='material-icons'>edit</i></button>";
                        $material_didatico .= "<button type='button' accesskey='table_{$numero}' rel='tooltip' title='Remove' class='btn btn-danger btn-link btn-sm btn_remove'>";
                        $material_didatico .= "<i class='material-icons'>close</i></button>";
                        $material_didatico .= "<button type='button' accesskey='table_{$numero}' rel='tooltip' title='Ver simulação' class='btn btn-primary btn-link btn-sm btn_parcelas_simulacao'>";
                        $material_didatico .= "<i class='material-icons'>visibility</i></button>";
                        $material_didatico .= "</td>";
                        $material_didatico .= "</tr>";

                        $numero++;

                    }
                }
            }

            $jSON['material_dicatico'] = $material_didatico;
            $jSON['estagios_curso'] = $estagios_a_cursar;
            $jSON['numero'] = $numero;
            $jSON['idsEstagios'] = $idsEstagios;
            $jSON['total'] = $valorTotal;

        } else {
            $jSON['error'] = "error";
        }

        break;

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

                $clone .= "<tr class='table_".$numero."'><th class='text-center'>PESQUISE O PRODUTO</th><th class='text-center'>QUANTIDADE</th><th class='text-center'>UNITÁRIO</th><th class='text-center'>DESCONTO</th><th class='text-center'>TOTAL</th>";
                $clone .= "<th class='text-center'><span class='table-remove' accesskey='table_".$numero."'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></th></tr>";
                $clone .= "<tr class='table_".$numero."'><td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_" . $numero . "' name='pedido_item_tipo_" . $numero . "' value='1'>";
                $clone .= "<input data-tipo='pedido_item_tipo_" . $numero . "' value='" . $Estagios['produto_nome'] . " - " . $Estagios['estagio_produto_nome'] . "' accessKey='" . $Estagios['estagio_produto_id'] . "' readonly data-total='proposta_item_valor_total_".$numero."' data-qtd='proposta_item_quantidade_".$numero."' id='proposta_item_valor_unitario_".$numero."' placeholder='Clique e selecione seu produto' type='text' name='nome_produto_".$numero."' class='form-control j_produto_proposta'></td>";
                $clone .= "<td class='pt-4-half'><input autocomplete='off' min='0' type='number' name='proposta_item_quantidade_".$numero."' data-uni='".$valor."' data-total='proposta_item_valor_total_".$numero."' class='form-control proposta_item_quantidade_".$numero." qtd_itens_list' value='1'></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_unitario_".$numero."' class='form-control proposta_item_valor_unitario_".$numero." formMoney' value='".$valor."'></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_desconto_".$numero."'><option value=''>ESCOLHA UM DESCONTO</option>";
                $Read->ExeRead('sys_descontos', 'WHERE desconto_status = :st', 'st=0');
                if ($Read->getResult()):
                    foreach ($Read->getResult() as $Desconto):
                        $clone .= "<option value='{$Desconto['desconto_id']}'>{$Desconto['desconto_nome']}</option>";
                    endforeach;
                endif;
                $clone .= "</select></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_total_".$numero."' class='form-control proposta_item_valor_total_".$numero." valor_total_tabela formMoney' value='".$valor."'></div></td></tr>";
                $clone .= "<tr class='table_".$numero."'><th class='text-center'>PARCELA</th><th class='text-center'>ENTRADA</th><th class='text-center'>DATA ENTRADA</th><th class='text-center'>DIA VENCIMENTO</th><th class='text-center'>DATA 1º VENCIMENTO</th></tr>";
                $clone .= "<tr class='table_".$numero."'><td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_item_parcelamento_id_".$numero."'><option value=''>Escola a forma de parcelamento</option>";
                $Read->ExeRead('sys_forma_parcelamento', 'WHERE forma_parcelamento_status = :st', 'st=0');
                if ($Read->getResult()):
                    foreach ($Read->getResult() as $Forma):
                        $clone .= "<option value='{$Forma['forma_parcelamento_id']}'>{$Forma['forma_parcelamento_nome']}</option>";
                    endforeach;
                endif;
                $clone .= "</select></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' min='0' type='text' name='proposta_entrada_".$numero."' class='form-control proposta_valor_entrada formMoney'></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_entrada_".$numero."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><select class='form-control matricula_dia_vencimento' name='proposta_dia_vencimento_".$numero."'><option value='' selected disabled>Selecione o dia de vencimento</option>";
                $Read->ExeRead('sys_dias_vencimento', 'WHERE dias_vencimento_status = :st', 'st=0');
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Vencimento) {
                        $clone .= "<option value='{$Vencimento['dias_vencimento_id']}'>{$Vencimento['dias_vencimento_nome']}</option>";
                    }
                }
                $clone .= "</select></div></td>";
                $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_primeiro_vencimento_".$numero."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
                $clone .= "</tr><tr class='separar'></tr>";

                $numero++;

                $Read->FullRead("SELECT mp.produto_id, e.estagio_produto_nome, p.produto_nome, p.produto_valor_venda, es.politica_comercial_valor, es.politica_comercial_data_inicio, es.politica_comercial_data_final FROM sys_materiais_estagio_produto AS mp INNER JOIN sys_estagio_produto AS e ON mp.estagio_id = e.estagio_produto_id INNER JOIN sys_produto AS p ON mp.produto_id = p.produto_id INNER JOIN sys_politica_comercial_estagios AS es ON e.estagio_produto_id = es.politica_comercial_estagio_id WHERE e.estagio_produto_id = :id", "id={$Estagios['estagio_produto_id']}");
                if($Read->getResult()){
                    foreach ($Read->getResult() as $Materiais) {

                        $nova_data = date('Y-m-d');
                        $de = date('Y-m-d', strtotime($Materiais["politica_comercial_data_inicio"]));
                        $ate = date('Y-m-d', strtotime($Materiais["politica_comercial_data_final"]));

                        if(($nova_data >= $de) && ($nova_data <= $ate)) {
                            $valor = $Materiais["politica_comercial_valor"];
                        } else {
                            $valor = $Materiais["produto_valor_venda"];
                        }

                        $clone .= "<tr class='table_".$numero."'><th class='text-center'>PESQUISE O PRODUTO</th><th class='text-center'>QUANTIDADE</th><th class='text-center'>UNITÁRIO</th><th class='text-center'>DESCONTO</th><th class='text-center'>TOTAL</th>";
                        $clone .= "<th class='text-center'><span class='table-remove' accesskey='table_".$numero."'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></th></tr>";
                        $clone .= "<tr class='table_".$numero."'><td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_" . $numero . "' name='pedido_item_tipo_" . $numero . "' value='2'>";
                        $clone .= "<input data-tipo='pedido_item_tipo_" . $numero . "' value='" . $Materiais['produto_nome'] . " - " . $Materiais['estagio_produto_nome'] . "' accessKey='" . $Materiais['produto_id'] . "' readonly data-total='proposta_item_valor_total_".$numero."' data-qtd='proposta_item_quantidade_".$numero."' id='proposta_item_valor_unitario_".$numero."' placeholder='Clique e selecione seu produto' type='text' name='nome_produto_".$numero."' class='form-control j_produto_proposta'></td>";
                        $clone .= "<td class='pt-4-half'><input autocomplete='off' min='0' type='number' name='proposta_item_quantidade_".$numero."' data-uni='".$valor."' data-total='proposta_item_valor_total_".$numero."' class='form-control proposta_item_quantidade_".$numero." qtd_itens_list' value='1'></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_unitario_".$numero."' class='form-control proposta_item_valor_unitario_".$numero." formMoney' value='".$valor."'></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_desconto_".$numero."'><option value=''>ESCOLHA UM DESCONTO</option>";
                        $Read->ExeRead('sys_descontos', 'WHERE desconto_status = :st', 'st=0');
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $Desconto):
                                $clone .= "<option value='{$Desconto['desconto_id']}'>{$Desconto['desconto_nome']}</option>";
                            endforeach;
                        endif;
                        $clone .= "</select></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_total_".$numero."' class='form-control proposta_item_valor_total_".$numero." valor_total_tabela formMoney' value='".$valor."'></div></td></tr>";
                        $clone .= "<tr class='table_".$numero."'><th class='text-center'>PARCELA</th><th class='text-center'>ENTRADA</th><th class='text-center'>DATA ENTRADA</th><th class='text-center'>DIA VENCIMENTO</th><th class='text-center'>DATA 1º VENCIMENTO</th></tr>";
                        $clone .= "<tr class='table_".$numero."'><td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_item_parcelamento_id_".$numero."'><option value=''>Escola a forma de parcelamento</option>";
                        $Read->ExeRead('sys_forma_parcelamento', 'WHERE forma_parcelamento_status = :st', 'st=0');
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $Forma):
                                $clone .= "<option value='{$Forma['forma_parcelamento_id']}'>{$Forma['forma_parcelamento_nome']}</option>";
                            endforeach;
                        endif;
                        $clone .= "</select></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' min='0' type='text' name='proposta_entrada_".$numero."' class='form-control proposta_valor_entrada formMoney'></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_entrada_".$numero."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><select class='form-control' name='proposta_dia_vencimento_".$numero."'><option value='' selected disabled>Selecione o dia de vencimento</option>";
                        $Read->ExeRead('sys_dias_vencimento', 'WHERE dias_vencimento_status = :st', 'st=0');
                        if($Read->getResult()){
                            foreach ($Read->getResult() as $Vencimento) {
                                $clone .= "<option value='{$Vencimento['dias_vencimento_id']}'>{$Vencimento['dias_vencimento_nome']}</option>";
                            }
                        }
                        $clone .= "</select></div></td>";
                        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_primeiro_vencimento_".$numero."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
                        $clone .= "</tr><tr class='separar'></tr>";

                        $numero++;

                    }
                }
            }
            $jSON['success'] = $clone;
            $jSON['numero'] = $numero;

        } else {
            $jSON['error'] = "true";
        }

        break;

    case 'infos_parcelas':

        $clone = "<tr><td class='pt-4-half'>";
        $clone .= "<select style='margin-top: -3px' class='form-control forma_pagamento_valor_entrada_".$PostData['numero']."' name='forma_pagamento_valor_entrada_".$PostData['numero']."'>";
        $clone .= "<option value=''>SELECIONE UMA FORMA DE PAGAMENTO</option>";
        $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
        if($Read->getResult()){
            foreach ($Read->getResult() as $FormaPagamento) {
                $clone .= "<option value='{$FormaPagamento['forma_pagamento_id']}'>{$FormaPagamento['forma_pagamento_nome']}</option>";
            }
        }
        $clone .= "</select></td><td class='pt-4-half'><div class='form-group'>";
        $clone .= "<input accessKey='forma_pagamento_valor_entrada_".$PostData['numero']."' autocomplete='off' type='text' name='valor_valor_entrada_".$PostData['numero']."' class='form-control valor_valor_entrada formMoney'></div></td><td>";
        $clone .= "<span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
    break;    

    case 'infos_produto':

        $clone = "";
        $clone .= "<tr class='table_".$PostData['numero']."'><th class='text-center'>PESQUISE O PRODUTO</th><th class='text-center'>QUANTIDADE</th><th class='text-center'>UNITÁRIO</th><th class='text-center'>DESCONTO</th><th class='text-center'>TOTAL</th>";
        $clone .= "<th class='text-center'><span class='table-remove' accesskey='table_".$PostData['numero']."'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></th></tr>";
        $clone .= "<tr class='table_".$PostData['numero']."'><td class='pt-4-half'><input type='hidden' class='pedido_item_tipo_".$PostData['numero']."' name='pedido_item_tipo_".$PostData['numero']."' value='1'>";
        $clone .= "<input readonly placeholder='Clique e selecione seu produto' data-tipo='pedido_item_tipo_".$PostData['numero']."' data-total='proposta_item_valor_total_".$PostData['numero']."' data-qtd='proposta_item_quantidade_".$PostData['numero']."' id='proposta_item_valor_unitario_".$PostData['numero']."' type='text' name='nome_produto_".$PostData['numero']."' class='form-control j_produto_proposta'></td>";
        $clone .= "<td class='pt-4-half'><input autocomplete='off' min='0' type='number' data-uni='0' data-total='proposta_item_valor_total_".$PostData['numero']."' name='proposta_item_quantidade_".$PostData['numero']."' class='form-control proposta_item_quantidade_".$PostData['numero']." qtd_itens_list'></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_unitario_".$PostData['numero']."' class='form-control proposta_item_valor_unitario_".$PostData['numero']." formMoney'></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_desconto_".$PostData['numero']."'><option value=''>ESCOLHA UM DESCONTO</option>";
        $Read->ExeRead('sys_descontos', 'WHERE desconto_status = :st', 'st=0');
        if ($Read->getResult()):
            foreach ($Read->getResult() as $Desconto):
                $clone .= "<option value='{$Desconto['desconto_id']}'>{$Desconto['desconto_nome']}</option>";
            endforeach;
        endif;
        $clone .= "</select></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input readonly autocomplete='off' min='0' type='text' name='proposta_item_valor_total_".$PostData['numero']."' class='form-control proposta_item_valor_total_".$PostData['numero']." valor_total_tabela formMoney'></div></td></tr>";
        $clone .= "<tr class='table_".$PostData['numero']."'><th class='text-center'>PARCELA</th><th class='text-center'>ENTRADA</th><th class='text-center'>DATA ENTRADA</th><th class='text-center'>DIA VENCIMENTO</th><th class='text-center'>DATA 1º VENCIMENTO</th></tr>";
        $clone .= "<tr class='table_".$PostData['numero']."'><td class='pt-4-half'><div class='form-group'><select style='margin-top: -3px' class='form-control' name='proposta_item_parcelamento_id_".$PostData['numero']."'><option value=''>Escola a forma de parcelamento</option>";
        $Read->ExeRead('sys_forma_parcelamento', 'WHERE forma_parcelamento_status = :st', 'st=0');
        if ($Read->getResult()):
            foreach ($Read->getResult() as $Forma):
                $clone .= "<option value='{$Forma['forma_parcelamento_id']}'>{$Forma['forma_parcelamento_nome']}</option>";
            endforeach;
        endif;
        $clone .= "</select></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' min='0' type='text' name='proposta_entrada_".$PostData['numero']."' class='form-control proposta_valor_entrada formMoney'></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_entrada_".$PostData['numero']."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><select class='form-control matricula_dia_vencimento' name='proposta_dia_vencimento_".$PostData['numero']."'><option value='' selected disabled>Selecione o dia de vencimento</option>";
        $Read->ExeRead('sys_dias_vencimento', 'WHERE dias_vencimento_status = :st', 'st=0');
        if($Read->getResult()){
            foreach ($Read->getResult() as $Vencimento) {
                $clone .= "<option value='{$Vencimento['dias_vencimento_id']}'>{$Vencimento['dias_vencimento_nome']}</option>";
            }
        }
        $clone .= "</select></div></td>";
        $clone .= "<td class='pt-4-half'><div class='form-group'><input autocomplete='off' type='date' name='proposta_data_primeiro_vencimento_".$PostData['numero']."' class='form-control' placeholder='dd/mm/yyyy'></div></td>";
        $clone .= "</tr><tr class='separar'></tr>";

        $jSON['success'] = $clone;
        break;

        case 'expirarOrcamento':

            if($PostData['id']){

                $OrcamentoUpdate['orcamento_status'] = 2;
                $Update->ExeUpdate("sys_orcamento_matricula", $OrcamentoUpdate, "WHERE orcamento_matricula_id = :id", "id={$PostData['id']}");
                $jSON['success'] = "Seu orçamento foi expirado com sucesso!";

            } else {
                $jSON['error'] = "Alteração não concluída!";
            }

        break;

endswitch;

echo json_encode($jSON);