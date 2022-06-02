<?php
session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
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
endif;

switch ($action):

    case 'list':

        $Id = $PostData["pessoa_id"];

        $arr = array();

        $Read->FullRead("SELECT 
                parcela.mov_recebimento_data_recebimento,
                parcela.mov_recebimento_data_vencimento,
                parcela.mov_recebimento_id,
                parcela.mov_recebimento_movimento_id,
                parcela.mov_recebimento_numero,
                parcela.mov_recebimento_parcela,
                parcela.mov_recebimento_parcela_tipo,
                parcela.mov_recebimento_pessoa_id,
                parcela.mov_recebimento_status,
                parcela.mov_recebimento_tipo_id,                
                parcela.mov_recebimento_valor,
                parcela.mov_valor_pago,                
                parcela.mov_recebimento_tipo,
                parcela.mov_recebimento_forma_pagamento,                
                parcela.mov_recebimento_desc_identificador,
                pessoa.pessoa_nome

                FROM sys_movimentacao_recebimento parcela

                LEFT OUTER JOIN sys_pessoas AS pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id

                WHERE pessoa.pessoa_id = :id AND parcela.unidade_id = :unidade ORDER BY mov_recebimento_status, parcela.mov_recebimento_data_vencimento ASC", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $multa = "";

                //Convert it into a timestamp.
                $timestamp = strtotime( $Result['mov_recebimento_data_vencimento']);

                //Convert it to DD-MM-YYYY
                $dmy = date("d/m/Y", $timestamp);

                $dataHoje = date('Y-m-d');
                $dataBoleto = $Result['mov_recebimento_data_vencimento'];

                if(strtotime($dataHoje) > strtotime($dataBoleto) && $Result['mov_recebimento_status'] == 0) {
                    $color = "red";
                } else {
                    $color = "#333333";
                }

                $data1 = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
                $data2 = new DateTime($Result['mov_recebimento_data_vencimento'], new DateTimeZone('UTC'));
                $intervalo = date_diff($data1, $data2);
                $DiasAtraso = $intervalo->days;

                $dataHoje = date('Y-m-d');
                $dataBoleto = $Result['mov_recebimento_data_vencimento'];

                if(strtotime($dataHoje) > strtotime($dataBoleto) && $Result['mov_recebimento_status'] == 0) {

                    if($DiasAtraso > 15 && $Result['mov_recebimento_tipo'] == 1) {
                        $TotalMulta = $DiasAtraso * 0.33;
                        $TotalMulta = ($Result['mov_recebimento_valor_sem_desconto'] * $TotalMulta) / 100;
                        $multa = "R$ ".number_format($TotalMulta, 2, ',', '.');
                    }
                }

                array_push($arr, array(
                        "id" => $Result['mov_recebimento_numero'],
                        "produto" => $Result['mov_recebimento_desc_identificador'],
                        "produto1" => "<span style='color: ".$color."'>".$Result['mov_recebimento_desc_identificador']."</span>",
                        "titulo_id" => $Result['mov_recebimento_id'],
                        "tipo" => $Result['mov_recebimento_tipo'],
                        "titulo_id1" => "<span style='color: ".$color."'>".$Result['mov_recebimento_id']."</span>",
                        "pessoa_id" => $Result['mov_recebimento_pessoa_id'],
                        "fornecedor" => $Result['pessoa_nome'],
                        "fornecedor1" => "<span style='color: ".$color."'>".$Result['pessoa_nome']."</span>",
                        "parcela" => $Result['mov_recebimento_parcela'],
                        "parcela1" => "<span style='color: ".$color."'>".$Result['mov_recebimento_parcela']."</span>",
                        "tipoparcela" => "<span style='color: ".$color."'>".($Result['mov_recebimento_parcela_tipo'] == 1 ? 'Parcial' : 'Integral')."</span>",
                        "vencimento" =>  $dmy,
                        "vencimento1" =>  "<span style='color: ".$color."'>".$dmy."</span>",
                        "receb_mov_id" => $Result['mov_recebimento_movimento_id'],
                        "valor" =>  "R$ " . number_format($Result['mov_recebimento_valor'], 2, ',', '.'),
                        "multa" => "<span style='color: ".$color."'>".$multa."</span>",
                        "valor1" =>  "<span style='color: ".$color."'>R$ " . number_format($Result['mov_recebimento_valor'], 2, ',', '.')."</span>",
                        "recebimento" => ($Result['mov_recebimento_data_recebimento'] ? date('d/m/Y', strtotime($Result['mov_recebimento_data_recebimento'])) : ''),
                        "valorpago" => ($Result['mov_valor_pago'] ? "R$ ".number_format($Result['mov_valor_pago'], 2, ',','.') : ''),
                        "status" => ($Result['mov_recebimento_status'] == 0 ? 'Aberto' : ($Result['mov_recebimento_status'] == 1 ? 'Pago' : ($Result['mov_recebimento_status'] == 2 ? 'Cancelado' : ($Result['mov_recebimento_status'] == 3 ? 'Renegociado' : 'Inválido')))),
                        "status1" => "<span style='color: ".$color."'>".($Result['mov_recebimento_status'] == 0 ? 'Aberto' : ($Result['mov_recebimento_status'] == 1 ? 'Pago' : ($Result['mov_recebimento_status'] == 2 ? 'Cancelado' : ($Result['mov_recebimento_status'] == 3 ? 'Renegociado' : 'Inválido'))))."</span>",
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contasreceber/ver_titulo_receber&id={$Result["mov_recebimento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : ''). "</span>"
                    )
                );                
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }

        break;

    case 'list_negociacao':
     
        $Id = $PostData["pessoa_id"];

        $arr = array();

        $Read->FullRead("SELECT 
                parcela.mov_recebimento_data_recebimento,
                parcela.mov_recebimento_data_vencimento,
                parcela.mov_recebimento_id,
                parcela.mov_recebimento_movimento_id,
                parcela.mov_recebimento_numero,
                parcela.mov_recebimento_parcela,
                parcela.mov_recebimento_pessoa_id,
                parcela.mov_recebimento_status,
                parcela.mov_recebimento_tipo_id,
                parcela.mov_recebimento_valor,
                parcela.mov_recebimento_tipo,
                pessoa.pessoa_nome    
                 FROM sys_movimentacao_recebimento parcela
                 LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id 
                 WHERE pessoa.pessoa_id = :id AND parcela.unidade_id = :unidade AND (parcela.mov_recebimento_status = 0 OR parcela.mov_recebimento_status IS NULL) ORDER BY parcela.mov_recebimento_status", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                //Convert it into a timestamp.
                $timestamp = strtotime( $Result['mov_recebimento_data_vencimento']);
                 
                //Convert it to DD-MM-YYYY
                $dmy = date("d/m/Y", $timestamp);

                array_push($arr, array(
                        "id" => $Result['mov_recebimento_movimento_id'],
                        "titulo_id" => $Result['mov_recebimento_id'],
                        "pessoa_id" => $Result['mov_recebimento_pessoa_id'],
                        "tipo" => $Result['mov_recebimento_tipo'],
                        "fornecedor" => $Result['pessoa_nome'],
                        "parcela" => $Result['mov_recebimento_parcela'],
                        "vencimento" =>  $dmy,
                        "receb_mov_id" => $Result['mov_recebimento_movimento_id'],
                        "valor" =>  'R$ ' . number_format($Result['mov_recebimento_valor'], 2, ',', '.') ,
                        "recebimento" => ($Result['mov_recebimento_data_recebimento'] ? date('d/m/Y', strtotime($Result['mov_recebimento_data_recebimento'])) : ''),
                        "status" => ($Result['mov_recebimento_status'] == 0 ? 'Aberto' : ($Result['mov_recebimento_status'] == 1 ? 'Pago' : ($Result['mov_recebimento_status'] == 2 ? 'Cancelado' : 'Inválido'))),
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;