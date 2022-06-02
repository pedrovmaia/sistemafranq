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

	$Read->FullRead("SELECT 
				 log.id,
				 motivo.motivo_estornos_nome,
				 funcionario.pessoa_nome,
				 DATE_FORMAT(log.date,'%d/%m/%Y %h:%m:%s') AS data ,
				 log.observacao,
				 log.id_titulo,
				 pessoa.pessoa_nome AS aluno,
				 mr.mov_recebimento_parcela AS parcela,
				 mr.mov_recebimento_data_vencimento AS data_parcela

				 FROM sys_log_parcelas log

				 LEFT OUTER JOIN sys_motivos_estornos motivo ON motivo.motivo_estornos_id = log.motivo_id

				 LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = log.funcionario_id

				 LEFT OUTER JOIN sys_movimentacao_recebimento mr ON mr.mov_recebimento_id = log.id_titulo

				LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = mr.mov_recebimento_pessoa_id	

				 WHERE log.tipo = 2
				 AND pessoa.pessoa_id = mr.mov_recebimento_pessoa_id
				 AND log.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
	if($Read->getResult()){
		$manage['total'] = $Read->getRowCount();
		foreach ($Read->getResult() as $Result){

			array_push($arr, array(
				"id" => $Result['id'],
				"motivo" => $Result['motivo_estornos_nome'],
				"nome" => $Result['pessoa_nome'],
				"aluno" => $Result['aluno'],
				"parcela" => $Result['parcela'],
				"data_parcela" => date('d/m/Y', strtotime($Result['data_parcela'])),
				"data" => $Result['data'],
				"obs" => $Result['observacao'],
				"titulo" => $Result['id_titulo']

			)
		);
		}
		$manage['rows'] = $arr;
		echo json_encode($manage);
	}


	break;
endswitch;