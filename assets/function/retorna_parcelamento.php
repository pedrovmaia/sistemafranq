<?php
 
     require '../../_app/Config.inc.php';

	/**
	 * função que devolve em formato JSON os dados do cliente
	 */
	function retorna( $id )
	{

		$Read = new Read;

		$id = (int)$id;

		$arr = Array();

		$Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_id=$id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){
            	$arr['parcela'] = $Result['forma_parcelamento_parcelas'];	
            	$arr['intervalo'] = $Result['forma_parcelamento_intervalo'];
            	$arr['tipo'] = $Result['forma_parcelamento_tipo'];

                if( $arr['intervalo'] == null)
                {
                    $arr['intervalo'] = ' ';
                }

            	if( $Result['forma_parcelamento_tipo'] == 0)
            	{
            		$arr['tipo_nome'] = 'A VISTA';		
            	}
            	
            	if( $Result['forma_parcelamento_tipo'] == 1)
            	{
            		$arr['tipo_nome'] = 'PARCELAMENTO';		
            	}

            	if( $Result['forma_parcelamento_tipo'] == 2)
            	{
            		$arr['tipo_nome'] = 'RECORRÊNCIA';		
            	}
            }
        }

        //$arr['endereco'] ="9999";

		return json_encode( $arr );
	}

/* só se for enviado o parâmetro, que devolve o combo */
if( isset($_GET['id']) )
{
	echo retorna( $_GET['id'] );
}
