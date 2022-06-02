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

        $arr = array();
        $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];

        $Read->FullRead("SELECT          
                    DATE_FORMAT(parcela.mov_recebimento_data_recebimento, '%d/%m/%Y') AS mov_recebimento_data_recebimento,
                    DATE_FORMAT(parcela.mov_recebimento_data_vencimento, '%d/%m/%Y') AS 
                    mov_recebimento_data_vencimento,
                    parcela.mov_recebimento_id,
                    parcela.mov_recebimento_movimento_id,
                    parcela.mov_recebimento_numero,
                    parcela.mov_recebimento_parcela,
                    parcela.mov_recebimento_pessoa_id,
                    parcela.mov_recebimento_status,
                    parcela.mov_recebimento_tipo_id,
                    parcela.mov_recebimento_valor,
                    parcela.mov_valor_pago,
                    pessoa.pessoa_nome
                    FROM sys_movimentacao_recebimento parcela
                    LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id
                    WHERE parcela.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                    AND parcela.mov_recebimento_status = 1
                    AND parcela.mov_recebimento_valor > 0
                    AND parcela.mov_recebimento_data_recebimento BETWEEN ('{$dataInicio}') AND ('{$dataFim}')
                    ORDER BY parcela.mov_recebimento_data_recebimento
                ");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            $valor = 0;
            $qtd_alunos = 0;
            $aluno = array();
            $aluno[] = 0;

            foreach ($Read->getResult() as $Result){                               

                if(!array_search($Result['mov_recebimento_pessoa_id'], $aluno)){
                    $qtd_alunos++;                                     
                }

                $aluno[] = $Result['mov_recebimento_pessoa_id'];
                
                if($Result['mov_valor_pago'] == null){
                    $valor_parcela = $Result['mov_recebimento_valor'];
                } else {
                    $valor_parcela = $Result['mov_valor_pago'];
                }

                $valor = $valor + $valor_parcela;

                $cor = '';

                if(number_format($Result['mov_recebimento_valor'], 2, ',', '.') > number_format($valor_parcela, 2, ',', '.')) {

                    $cor = 'blue';

                }

                array_push($arr, array(
                        "id" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_id'],
                        "moviid" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_movimento_id'].'</span/>',
                        "datar" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_data_recebimento'].'</span/>',
                        "datav" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_data_vencimento'].'</span/>',
                        "numero" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_numero'].'</span/>',
                        "parcela" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_parcela'].'</span/>',
                        "pessoa" => '<span style="color:'.$cor.'">'.$Result['pessoa_nome'].'</span/>',
                        "status" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_status'].'</span/>',
                        "tipo" => '<span style="color:'.$cor.'">'.$Result['mov_recebimento_tipo_id'].'</span/>',
                        "valor" => '<span style="color:'.$cor.'">'.number_format($Result['mov_recebimento_valor'], 2, ',', '.').'</span/>',
                        "valor_pago" => '<span style="color:'.$cor.'">'.number_format($valor_parcela, 2, ',', '.').'</span>',
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contasreceber/ver_movimentacao_recebimento&id={$Result["mov_recebimento_movimento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                    )
                );
            }
            $manage['qtd_alunos'] = $qtd_alunos;
            $manage['valor'] = number_format($valor, 2, ',', '.');
            $manage['rows'] = $arr;
            echo json_encode($manage);

        }
        break;
endswitch;