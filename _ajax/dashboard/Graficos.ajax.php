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
    $trigger = new Trigger;
endif;

switch ($action):

    case 'dailySalesChart':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Read->FullRead("SET lc_time_names = :id", "id=pt_PT");
            $Read->FullRead("SELECT MONTHNAME(matricula_data) as mes, count(matricula_valor_total) as total FROM sys_matriculas WHERE sys_matriculas.unidade_id = :id AND  matricula_data >= now() - interval 3 month GROUP BY MONTH(matricula_data)", "id={$_SESSION['userSYSFranquia']['unidade_id']}");
            if($Read->getResult()){
                $jSON['success'] = $Read->getResult();
            } else {
                $jSON['error'] = 'Não possui resultados';
            }

        endif;

        break;

    case 'dailySalesChartTurmas':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Read->FullRead("SET lc_time_names = :id", "id=pt_PT");
            $Read->FullRead("SELECT MONTHNAME(projeto_data_inicio) as mes, count(projeto_id) as total FROM sys_projetos WHERE sys_projetos.unidade_id = :id AND  projeto_data_inicio >= now() - interval 3 month GROUP BY MONTH(projeto_data_inicio)", "id={$_SESSION['userSYSFranquia']['unidade_id']}");
            if($Read->getResult()){
                $jSON['success'] = $Read->getResult();
            } else {
                $jSON['error'] = 'Não possui resultados';
            }

        endif;

        break;

endswitch;

echo json_encode($jSON);