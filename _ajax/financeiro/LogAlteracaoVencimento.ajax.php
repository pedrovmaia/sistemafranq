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
					 motivo.motivo_alterar_vencimento_nome,
					 funcionario.pessoa_nome,
					 DATE_FORMAT(log.date,'%d/%m/%Y %h:%m:%s') AS data ,
					 log.observacao,
					 log.id_titulo
					 FROM sys_log_parcelas log
					 LEFT OUTER JOIN sys_motivos_alterar_vencimento motivo ON motivo.motivo_alterar_vencimento_id = log.motivo_id
					 LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = log.funcionario_id
					 WHERE log.tipo = 3
				 AND log.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
	if($Read->getResult()){
		$manage['total'] = $Read->getRowCount();
		foreach ($Read->getResult() as $Result){

			array_push($arr, array(
				"id" => $Result['id'],
				"motivo" => $Result['motivo_alterar_vencimento_nome'],
				"nome" => $Result['pessoa_nome'],
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