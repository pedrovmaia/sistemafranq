<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

usleep(50000);

if ($PostData):
    require '../../_app/Config.inc.php';
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

    $Read->ExeRead("sys_planejamento", "WHERE planejamento_projeto_id = :id", "id={$PostData['txt_id_turma']}");
    if($Read->getResult()){
        $jSON['error'] = 'Turma já possui Planejamento!';
        echo json_encode($jSON);
        die;
    }

    $Read->FullRead("SELECT cp.etapa, cp.aula, cp.materias, cp.atividades, cp.homework, cp.exercicios, p.projeto_produto_id FROM sys_projetos AS p INNER JOIN sys_modalidades AS m ON p.projeto_modalidade_id = m.modalidade_id
                        INNER JOIN sys_carga_horaria_cursos AS c ON m.modalidade_id = c.modalidade_id INNER JOIN sys_conteudo_programatico AS cp ON cp.estagio_id = p.projeto_produto_id
                        WHERE cp.horas = :hora AND p.projeto_id = :id AND m.modalidade_id = :mo AND c.carga_horas = cp.horas AND p.projeto_produto_id = :p
                        ORDER BY cp.aula+0",
    "hora={$_POST['projeto_grade']}&id={$_POST['txt_id_turma']}&mo={$_POST['modalidade_id']}&p={$_POST['produto_id']}");
    if($Read->getResult()){
        $conteudoProgramatico = $Read->getResult();
    } else {
        $jSON['error'] =  'Conteúdo programático não encontrado!';
        echo json_encode($jSON);
        die;
    }

    /* só se for enviado o parâmetro, que devolve o combo */
	if( isset($_POST['primeiro_dia']) ) {

		if(isset( $_POST['segundo_dia'])) {
			planejar( $_POST['primeiro_dia'], $_POST['segundo_dia'], $_POST['txt_id_turma'] , $_POST['pessoa_id'], $_POST['primeiro_dia_hora_inicio'], $_POST['primeiro_dia_hora_final'], $_POST['segundo_dia_hora_inicio'], $_POST['segundo_dia_hora_final'], $conteudoProgramatico, $_POST['modalidade_id'], $_POST['projeto_grade']);
            $jSON['success'] = "Planejamento concluído com sucesso";
		} else {
			planejar( $_POST['primeiro_dia'], '', $_POST['txt_id_turma'], $_POST['pessoa_id'], $_POST['primeiro_dia_hora_inicio'], $_POST['primeiro_dia_hora_final'], '', '', $conteudoProgramatico, $_POST['modalidade_id'], $_POST['projeto_grade'] );
            $jSON['success'] = "Planejamento concluído com sucesso";
		}
	}
  
	function planejar( $primeiro_dia , $segundo_dia, $projetoid, $pessoaid, $primeiro_dia_inicio, $primeiro_dia_final, $segundo_dia_inicio, $segundo_dia_final, $conteudoProgramatico, $modalidade_id, $carga_horaria_grade ) {
		// prevent multiple calls by retrieving time once //
		$now = time();
		$aYearLater = strtotime('+1 Year', $now);

		$quantidade_aulas = $carga_horaria_grade;
		$quantidade_aulas_contador = 0;
		$quantidade_hora_primeiro_dia = 1;
		$quantidade_hora_segundo_dia  = 1;

		// fill this with dates //
		$allDates = Array();

		// init with next friday and saturday //

		if($primeiro_dia !== '') {
			$primeiro_dia = strtotime(NextDia($primeiro_dia), strtotime('-1 Day', $now));
        }

        if($segundo_dia !== '') {
			$segundo_dia  = strtotime(NextDia($segundo_dia), strtotime('-1 Day', $now));
	    }

		// keep adding days untill a year has passed //
		while(1) {

		    if($primeiro_dia != '') {
				// primeiro dia
				if($quantidade_aulas_contador >= $quantidade_aulas)
			    	break 1;


			    if($primeiro_dia > $aYearLater)
			        break 1;

			        if(verificar_atividades_extra_curriculares($primeiro_dia, $conteudoProgramatico[0]['projeto_produto_id']) == false) {

                        if (verificar_informacao_feriado_municipal($primeiro_dia) == false) {

                            if (verificar_informacao_feriado($primeiro_dia) == false) {

                                if (verificar_informacao_ferias($primeiro_dia, $pessoaid) == false) {

                                    if (verificar_informacao_recesso($primeiro_dia) == false) {

                                        $allDates[] = date('d-m-Y', $primeiro_dia);
                                        $quantidade_aulas_contador += $quantidade_hora_primeiro_dia;


                                        $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                                        $PostData['planejamento_status'] = 0;
                                        $PostData['planejamento_descricao'] = 'Aguardando aula';
                                        $PostData['planejamento_projeto_id'] = $projetoid;
                                        $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                                        $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                                        $PostData['modalidade_id'] = $modalidade_id;
                                        inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);
                                    } else {

                                        $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                                        $PostData['planejamento_status'] = 1;
                                        $PostData['planejamento_descricao'] = 'Recesso escolar';
                                        $PostData['planejamento_projeto_id'] = $projetoid;
                                        $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                                        $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                                        $PostData['modalidade_id'] = $modalidade_id;
                                        inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                                    }
                                } else {

                                    $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                                    $PostData['planejamento_status'] = 1;
                                    $PostData['planejamento_descricao'] = 'Férias professor';
                                    $PostData['planejamento_projeto_id'] = $projetoid;
                                    $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                                    $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                                    $PostData['modalidade_id'] = $modalidade_id;
                                    inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                                }


                            } else {


                                $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                                $PostData['planejamento_status'] = 1;
                                $PostData['planejamento_descricao'] = 'Feriado';
                                $PostData['planejamento_projeto_id'] = $projetoid;
                                $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                                $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                                $PostData['modalidade_id'] = $modalidade_id;
                                inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                            }

                        } else {

                            $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                            $PostData['planejamento_status'] = 1;
                            $PostData['planejamento_descricao'] = 'Feriado Municipal';
                            $PostData['planejamento_projeto_id'] = $projetoid;
                            $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                            $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                            $PostData['modalidade_id'] = $modalidade_id;
                            inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                        }

                    } else {

                        $PostData['planejamento_data'] = date('Y/m/d', $primeiro_dia);
                        $PostData['planejamento_status'] = 0;
                        $PostData['planejamento_descricao'] = 'Aguardando aula';
                        $PostData['planejamento_projeto_id'] = $projetoid;
                        $PostData['planejamento_hora_inicial'] = $primeiro_dia_inicio;
                        $PostData['planejamento_hora_final'] = $primeiro_dia_final;
                        $PostData['modalidade_id'] = $modalidade_id;
                        inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                    }
			    
			    $primeiro_dia = strtotime('+1 Week', $primeiro_dia);

            }

            if($segundo_dia != '') {
			    // segundo dia
			    if($quantidade_aulas_contador >= $quantidade_aulas)
			    	break 1;


			    if($segundo_dia > $aYearLater)
			        break 1;

                if(verificar_atividades_extra_curriculares($primeiro_dia, $conteudoProgramatico[0]['projeto_produto_id']) == false) {

                    if (verificar_informacao_feriado_municipal($segundo_dia) == false) {

                        if (verificar_informacao_feriado($segundo_dia) == false) {

                            if (verificar_informacao_ferias($segundo_dia, $pessoaid) == false) {

                                if (verificar_informacao_recesso($segundo_dia) == false) {

                                    $allDates[] = date('d-m-Y', $segundo_dia);
                                    $quantidade_aulas_contador += $quantidade_hora_segundo_dia;


                                    $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                                    $PostData['planejamento_status'] = 0;
                                    $PostData['planejamento_descricao'] = 'Aguardando aula';
                                    $PostData['planejamento_projeto_id'] = $projetoid;
                                    $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                                    $PostData['planejamento_hora_final'] = $segundo_dia_final;
                                    $PostData['modalidade_id'] = $modalidade_id;

                                    inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                                } else {

                                    $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                                    $PostData['planejamento_status'] = 1;
                                    $PostData['planejamento_descricao'] = 'Recesso escolar';
                                    $PostData['planejamento_projeto_id'] = $projetoid;
                                    $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                                    $PostData['planejamento_hora_final'] = $segundo_dia_final;
                                    $PostData['modalidade_id'] = $modalidade_id;

                                    inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);


                                }
                            } else {

                                $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                                $PostData['planejamento_status'] = 1;
                                $PostData['planejamento_descricao'] = 'Férias professor';
                                $PostData['planejamento_projeto_id'] = $projetoid;
                                $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                                $PostData['planejamento_hora_final'] = $segundo_dia_final;
                                $PostData['modalidade_id'] = $modalidade_id;

                                inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);
                            }


                        } else {


                            $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                            $PostData['planejamento_status'] = 1;
                            $PostData['planejamento_descricao'] = 'Feriado';
                            $PostData['planejamento_projeto_id'] = $projetoid;
                            $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                            $PostData['planejamento_hora_final'] = $segundo_dia_final;
                            $PostData['modalidade_id'] = $modalidade_id;

                            inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);
                        }

                    } else {

                        $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                        $PostData['planejamento_status'] = 1;
                        $PostData['planejamento_descricao'] = 'Feriado Municipal';
                        $PostData['planejamento_projeto_id'] = $projetoid;
                        $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                        $PostData['planejamento_hora_final'] = $segundo_dia_final;
                        $PostData['modalidade_id'] = $modalidade_id;

                        inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);
                    }
                } else {

                    $PostData['planejamento_data'] = date('Y/m/d', $segundo_dia);
                    $PostData['planejamento_status'] = 0;
                    $PostData['planejamento_descricao'] = 'Aguardando aula';
                    $PostData['planejamento_projeto_id'] = $projetoid;
                    $PostData['planejamento_hora_inicial'] = $segundo_dia_inicio;
                    $PostData['planejamento_hora_final'] = $segundo_dia_final;
                    $PostData['modalidade_id'] = $modalidade_id;
                    inserir($PostData, $quantidade_aulas_contador, $conteudoProgramatico);

                }

			    $segundo_dia = strtotime('+1 Week', $segundo_dia);
          
            }
		}
    }

	function NextDia($dia) {

        if($dia === 'Monday') {
			 return 'Next Monday';
        }

        if($dia === 'Tuesday') {
			 return 'Next Tuesday';
        }

        if($dia === 'Wednesday') {
			 return 'Next Wednesday';
        }

        if($dia === 'Thursday') {
			 return 'Next Thursday';
        }

        if($dia === 'Friday') {
			 return 'Next Friday';
        }

        if($dia === 'Saturday') {
			 return 'Next Saturday';
        }

        if($dia === 'Sunday') {
			 return 'Next Sunday';
        }

        return '';
    }

    function inserir($PostData, $quantidade, $conteudo) {

        if($PostData["planejamento_status"] == 0) {
            $PostData['materias'] = $conteudo[$quantidade - 1]["materias"];
            $PostData['atividades'] = $conteudo[$quantidade - 1]["atividades"];
            $PostData['homework'] = $conteudo[$quantidade - 1]["homework"];
            $PostData['exercicios'] = $conteudo[$quantidade - 1]["exercicios"];
            $PostData['etapa'] = $conteudo[$quantidade - 1]['etapa'];
        }
        $Create = new Create;

        $Create->ExeCreate("sys_planejamento", $PostData);
    }

    function verificar_informacao_recesso($data) {
       
        $Read = new Read;

        $dataYYMMDD = date('Y/m/d', $data);

        $Read->ExeRead("sys_recesso", "WHERE :data BETWEEN date(recesso_data_inicial) AND date(recesso_data_final)" , "data={$dataYYMMDD}");

        if($Read->getResult()){

            $feriados = $Read->getResult()[0];

            return true;
        
        } else {
            return false;   
        }

        return false;   	 

    }

    function verificar_informacao_ferias($data, $professorid) {
    	
        $Read = new Read;

        $dataYYMMDD = date('Y/m/d', $data);


        $Read->ExeRead("sys_ferias", "WHERE :data BETWEEN date(ferias_data_inicial) AND date(ferias_data_final) AND ferias_pessoa_id =  :professor" , "data={$dataYYMMDD}&&professor={$professorid}");

        if($Read->getResult()){

            $feriados = $Read->getResult()[0];

            return true;
        
        } else {
            return false;   
        }

        return false;
    }


    function verificar_informacao_feriado($data) {
        $Read = new Read;

        $dataYYMMDD = date('Y/m/d', $data);

        $Read->ExeRead("sys_feriado", "WHERE feriado_data = :data ", "data={$dataYYMMDD}");

        if($Read->getResult()) {

            $feriados = $Read->getResult()[0];

            return true;
        
        } else {
            return false;   
        }

    	return false;	
    }

     function verificar_informacao_feriado_municipal($data) {

        $Read = new Read;

        $dataYYMMDD = date('Y/m/d', $data);

        $Read->ExeRead("sys_feriado_municipal", "WHERE feriado_municipal_data = :data ", "data={$dataYYMMDD}");

        if($Read->getResult()) {

            $feriados = $Read->getResult()[0];

            return true;
        
        } else {
            return false;   
        }

        return false;   
    }

    function verificar_atividades_extra_curriculares($data, $estagio_id) {

        $Read = new Read;

        $dataYYMMDD = date('Y/m/d', $data);

        $Read->ExeRead("sys_atividades_extra_curriculares", "WHERE :data BETWEEN date(atividades_extra_data_inicial) AND date(atividades_extra_data_final) AND atividades_extra_estagio_id = :id", "data={$dataYYMMDD}&id={$estagio_id}");

        if($Read->getResult()){

            $extra_curriculares = $Read->getResult()[0];

            return true;

        } else {
            return false;
        }

        return false;
    }

echo json_encode($jSON);