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

        $Read->FullRead("SELECT DATE_FORMAT(parcela.mov_recebimento_data_recebimento, '%d/%m/%Y') AS mov_recebimento_data_recebimento,
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
					pessoa.pessoa_nome,
					telaluno.telefone AS telefone,
					financeiro.pessoa_nome AS financeironome,
					tel.telefone AS financeirotelefone
					FROM sys_movimentacao_recebimento parcela
					LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id
					LEFT OUTER JOIN sys_telefones_pessoas AS telaluno ON telaluno.pessoa_id = pessoa.pessoa_id
					LEFT OUTER JOIN sys_pessoas AS financeiro ON financeiro.pessoa_id = pessoa.pessoa_responsavel_financeiro_id
					LEFT OUTER JOIN sys_telefones_pessoas AS tel ON tel.pessoa_id = financeiro.pessoa_id
					WHERE parcela.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
				    AND parcela.mov_recebimento_status = 0
                    AND parcela.mov_recebimento_valor > 0
				    AND parcela.mov_recebimento_data_vencimento BETWEEN ('{$dataInicio}') AND ('{$dataFim}')
					GROUP BY parcela.mov_recebimento_pessoa_id
					ORDER BY parcela.mov_recebimento_data_vencimento
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

                $valor = $valor + $Result['mov_recebimento_valor'];

                array_push($arr, array(
                	    "id" => $Result['mov_recebimento_id'],
                        "moviid" => $Result['mov_recebimento_movimento_id'],
                        "datar" => $Result['mov_recebimento_data_recebimento'],
                        "datav" => $Result['mov_recebimento_data_vencimento'],
                        "numero" => $Result['mov_recebimento_numero'],
                        "parcela" => $Result['mov_recebimento_parcela'],
                        "pessoa" => $Result['pessoa_nome'],
                        "telefone" => $Result['telefone'],
                        "responsavel" => $Result['financeironome'],
                        "financeirotelefone" => $Result['financeirotelefone'],
                        "status" => $Result['mov_recebimento_status'],
                        "tipo" => $Result['mov_recebimento_tipo_id'],
                        "valor" => number_format($Result['mov_recebimento_valor'], 2, ',', '.'),
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