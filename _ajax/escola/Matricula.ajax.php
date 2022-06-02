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

switch ($action):

    case 'MatriculaAdd':

        if(!$PostData['txt_id_turma']){
            $turma = 1;
            unset($PostData['txt_id_turma']);
        } else {
            $turma = 2;
            unset($PostData['horario_preferencia'], $PostData['telefone_contato'], $PostData['periodo_preferencia'], $PostData['dia_semana_preferencia']);
        }

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos necessários!';
        else:

        if($turma == 2){

            $Read->FullRead("SELECT p.pessoa_id, p.pessoa_email FROM sys_envolvidos_projeto AS e 
                    INNER JOIN sys_pessoas AS p ON p.pessoa_id = e.envolvidos_envolvido_id 
                    WHERE e.envolvidos_projeto_projeto_id = :id AND p.pessoa_id = :pessoa
                    AND e.unidade_id = :unidade", "id={$PostData['txt_id_turma']}&pessoa={$PostData['pessoa_id']}&unidade={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");

            if($Read->getResult()){
                $jSON['error'] = 'Aluno já matriculado nessa turma!';
                echo json_encode($jSON);
                die;
            }
        }

        $Read->FullRead("SELECT * FROM sys_proposta as p WHERE p.proposta_id = :id", "id={$PostData['proposta_id']}");

        if($Read->getResult()) {
            $Proposta = $Read->getResult()[0];

            if($Proposta['proposta_valor_entrada']){
                $CreateData['movimentacao_pago_recebido'] = 1;
            } else {
                $CreateData['movimentacao_pago_recebido'] = 0;
            }

            // CRIAÇÃO DE MOVIMENTAÇÃO
            $CreateData['movimentacao_data'] = date('Y/m/d');
            $CreateData['movimentacao_hora'] = date('h:i:s a', time());
            $CreateData['movimentacao_pessoa_id'] = $PostData['pessoa_id'];
            //$CreateData['movimentacao_total_parcela'] = $Proposta['proposta_total_parcela'];
            $CreateData['movimentacao_descricao'] = $PostData['descricao'];
            $CreateData['movimentacao_valor_total'] = $Proposta['proposta_valor_total'];
            $CreateData['movimentacao_tipo_id'] = 2;
            //$CreateData['movimentacao_forma_parcelamento_id'] = $Proposta['proposta_forma_parcelamento_id'];
            $CreateData['movimentacao_emissao'] = date('Y/m/d');
            $CreateData['movimentacao_tipo'] = "Matrícula de Aluno";
            //$CreateData['movimentacao_recorrencia'] = $Proposta['proposta_recorrencia'];
            $CreateData['movimentacao_nome'] = $Proposta['proposta_nome'];
            $CreateData['movimentacao_observacao'] = $PostData['observacao'];
            //$CreateData['movimentacao_tipo_parcelamento'] = $Proposta['proposta_tipo_parcelamento'];
            $CreateData['movimentacao_status'] = 0;
            $CreateData['movimentacao_origem_movimentacao'] = 1;
            $CreateData['movimentacao_forma_pagamento_id'] = 6;
            $CreateData['movimentacao_proposta_id'] = $PostData['proposta_id'];
            $CreateData['movimentacao_dia_vencimento'] = $PostData['dia_vencimento'];
            $CreateData['movimentacao_projeto_id'] = $PostData['txt_id_turma']; 

            $Create->ExeCreate("sys_movimentacao", $CreateData);
            $MovimentacaoCreateID = $Create->getResult();

            if($turma == 1){

                $CreateEspera['lista_espera_projeto_pessoa_id'] = $PostData['pessoa_id'];
                $CreateEspera['lista_espera_projeto_periodo_preferencia'] = $PostData['periodo_preferencia'];
                $CreateEspera['lista_espera_projeto_dia_preferencia'] = $PostData['dia_semana_preferencia'];
                $CreateEspera['lista_espera_projeto_horario_preferencia'] = $PostData['horario_preferencia'];
                $CreateEspera['lista_espera_projeto_telefone_contato'] = $PostData['telefone_contato'];

                $Create->ExeCreate("sys_lista_espera_projeto", $CreateEspera);
            }

            if($turma == 2){

                $CreateEnvolvido['envolvidos_projeto_projeto_id'] = $PostData['txt_id_turma'];
                $CreateEnvolvido['envolvidos_envolvido_id'] = $PostData['pessoa_id'];
                $CreateEnvolvido['envolvidos_envolvido_tipo_id'] = 1;
                $CreateEnvolvido['status'] = 0;

                $Create->ExeCreate("sys_envolvidos_projeto", $CreateEnvolvido);
            }

            // RATEIO
            $ArrRateio = [];
            $Read->ExeRead("sys_proposta_rateio", "WHERE proposta_rateio_proposta_id = :id", "id={$PostData['proposta_id']}");
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
            if($Proposta['proposta_valor_entrada']) {
                $CreateDataCaixa['transacao_caixa_descricao'] = $PostData['descricao'];
                $CreateDataCaixa['transacao_caixa_data'] = date('Y/m/d H:i:s');
                $CreateDataCaixa['transacao_caixa_hora'] = date('H:i:s');
                $CreateDataCaixa['transacao_caixa_valor'] = $Proposta['proposta_valor_entrada'];
                $CreateDataCaixa['transacao_conta_id'] = $MovimentacaoCreateID;
                $CreateDataCaixa['transacao_caixa_tipo_id'] = 0;
                $CreateDataCaixa['transacao_caixa_pessoa_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
                $CreateDataCaixa['data_criacao'] = date('Y/m/d');

                $Create->ExeCreate("sys_transacao_caixa", $CreateDataCaixa);
            }

            // CRIAÇÃO DE PARCELAS
            $Read->FullRead("SELECT f.forma_parcelamento_parcelas, f.forma_parcelamento_intervalo, p.proposta_item_valor_total, p.proposta_item_vencimento, f.forma_parcelamento_tipo FROM sys_proposta_item AS p INNER JOIN sys_forma_parcelamento AS f ON f.forma_parcelamento_id = p.proposta_item_forma_parcelamento_id WHERE p.proposta_item_proposta_id = :id", "id={$PostData['proposta_id']}");
            if($Read->getResult()){

                $ArrParcelas = [];

                foreach ($Read->getResult() as $ItemProposta) {

                    $parcelas = $ItemProposta['forma_parcelamento_parcelas'];
                    $data = date('Y/m/d', strtotime($ItemProposta['proposta_item_vencimento']));

                    for($i = 1; $i <= $parcelas; $i++){

                        $data_pag = null;

                        // localizando valor das parcelas
                        if($ItemProposta['forma_parcelamento_tipo'] == 0) // se for recorrencia
                        {
                            $valor_parcela = $ItemProposta['proposta_item_valor_total'];
                        }

                        if($ItemProposta['forma_parcelamento_tipo'] == 1) // se for parcelamwnto
                        {
                            $valor_parcela = $ItemProposta['proposta_item_valor_total'] / $parcelas;
                        }

                        if($ItemProposta['forma_parcelamento_tipo'] == 2) // se for recorrencia
                        {
                            $valor_parcela = $ItemProposta['proposta_item_valor_total'];
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

            $DocCreate = [
                "contrato_nome" => "MATRÍCULA ALUNO " . $PostData['pessoa_nome'],
                "contrato_tipo_id" => 1,
                "contrato_estagio_id" => 2,
                "contrato_data_vencimento" => "",
                "contrato_modelo_id" => 1,
                "contrato_status" => 0,
                "contrato_pessoa_id" => $PostData['pessoa_id'],
                "movimentacao_id" => $MovimentacaoCreateID
            ];

            $Create->ExeCreate("sys_contratos", $DocCreate);

            $jSON['success'] = 'Matricula criada com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/matricula/sucesso_matricula&id=" . $MovimentacaoCreateID;

        } else {
            $jSON['error'] = 'Favor, preencha todos os campos!';
            echo json_encode($jSON);
            die;
        }
      endif;
    break;

endswitch;

echo json_encode($jSON);