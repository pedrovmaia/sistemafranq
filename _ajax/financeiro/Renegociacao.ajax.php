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

switch ($action):

    case 'renegociacao':

        $qtd = $PostData['qtd'];
        $parcelaqtd = $PostData['parcelaqtd'];
        $valor_total = $PostData['total'];
        $ArrParcelas = [];
        $porparcela = round($valor_total/$parcelaqtd, 2);

        $CreateDataNegociacao['negociacoes_pessoa_id'] = $PostData['pessoa_id'];
        $CreateDataNegociacao['negociacoes_data'] = date('Y/m/d');
        $CreateDataNegociacao['negociacoes_descricao'] = $PostData['obs'];
        $CreateDataNegociacao['negociacoes_hora'] = date('H:i:s');
        $CreateDataNegociacao['negociacoes_funcionario_id'] = $_SESSION["userSYSFranquia"]["pessoa_id"];
        $CreateDataNegociacao['negociacoes_motivo_id'] = $PostData['motivo'];

        $Create->ExeCreate("sys_negociacoes", $CreateDataNegociacao);
        $NegociacaoId = $Create->getResult();

        for($i = 0; $i < $qtd; $i++){

            $Read->ExeRead("sys_movimentacao_recebimento", "WHERE mov_recebimento_id = :id", "id={$PostData['parcela_' . $i]}");
            if($Read->getResult()){

                $ArrUpdate['mov_recebimento_status'] = 3;
                $ArrUpdate['negociacao_id'] = $NegociacaoId;

                $Update->ExeUpdate("sys_movimentacao_recebimento", $ArrUpdate, "WHERE mov_recebimento_id = :id", "id={$PostData['parcela_' . $i]}");

                $mov_recebimento_numero = $Read->getResult()[0]['mov_recebimento_numero'];
                $mov_recebimento_movimento_id = $Read->getResult()[0]['mov_recebimento_movimento_id'];
                $mov_recebimento_data_vencimento = $Read->getResult()[0]['mov_recebimento_data_vencimento'];

            }
        }

        for($i = 0; $i < $parcelaqtd; $i++){

            $data = date('Y-m-d', strtotime("+{$i} month", strtotime($mov_recebimento_data_vencimento)));

            $ArrParcelas[] = Array(
                'mov_recebimento_movimento_id' => $mov_recebimento_movimento_id,
                'mov_recebimento_valor' => $porparcela,
                'mov_recebimento_valor_sem_desconto' => $porparcela,
                'mov_recebimento_numero' => $mov_recebimento_numero,
                'mov_recebimento_data_vencimento' => $data,
                'mov_recebimento_data_recebimento' => null,
                'mov_recebimento_parcela' => ($i+1),
                'mov_recebimento_tipo_id' => 0,
                'mov_recebimento_status' => 0,
                'mov_recebimento_emissao' => date('Y/m/d'),
                'mov_recebimento_pessoa_id' => $PostData['pessoa_id'],
                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                "negociacao_id" => $NegociacaoId,
                'data_criacao' => date('Y-m-d H:i:s'),
                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
            );
        }

        $Create->ExeCreateMulti("sys_movimentacao_recebimento", $ArrParcelas);

        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        $jSON['redirect'] = "painel.php?exe=contasreceber/filtro_titulos_receber_por_pessoa&id={$PostData['pessoa_id']}";

    break;

endswitch;

echo json_encode($jSON);