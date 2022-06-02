<?php

class AddDate {

	public function addMonths(DateTime $date, int $months)
	{
		// Clona o objeto $date para mantê-lo inalterado
	    $future = clone $date;

	    // Define o modificador
	    $modifier = "{$months} months";

	    // Modifica a data $future
	    $future->modify($modifier);

	    // Clona o objeto $future para corrigir o limite dos dias
	    $pass = clone $future;
	    $pass->modify("-{$modifier}");

	    // Enquanto o mês atual for diferente do mês do passado do futuro
	    while ($date->format('m') != $pass->format('m'))
	    {
	        // Modifica as datas em -1 dia
	        $future->modify("-1 day");
	        $pass->modify("-1 day");
	    }

	    // Retorna a data desejada
	    return $future;
	}
	
}