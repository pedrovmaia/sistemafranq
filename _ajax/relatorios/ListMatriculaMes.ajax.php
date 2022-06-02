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
        $Read->FullRead("SET lc_time_names = :id", "id=pt_PT");
        $Read->FullRead("
                SELECT
                  YEAR(matricula_data) as ano,
                  MONTHNAME(matricula_data) as mes,
                   count(matricula_valor_total) as total
                FROM sys_matriculas 
                WHERE sys_matriculas.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                AND  matricula_data >= now() - interval 12 month
                GROUP BY MONTH(matricula_data)");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "ano" => $Result['ano'],
                        "mes" => $Result['mes'],
                        "total" => number_format($Result['total'], 2, ',', '.')
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;