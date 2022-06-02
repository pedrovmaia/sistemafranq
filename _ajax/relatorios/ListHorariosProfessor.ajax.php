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
                     DATE_FORMAT(planejamento.planejamento_data,'%d/%m/%Y') AS data_aula ,
                     turma.projeto_descricao,
                     modalidade.modalidade_nome,
                     planejamento.planejamento_hora_inicial as hora_inicial,
                     planejamento.planejamento_hora_final as hora_final,
                     '1:00' as hora
                     FROM sys_planejamento planejamento
                      LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = planejamento.planejamento_projeto_id
                      LEFT OUTER JOIN sys_modalidades modalidade ON modalidade.modalidade_id = turma.projeto_modalidade_id
                      WHERE turma.projeto_gerente_id = 16 AND
                     planejamento.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                      AND
                      planejamento.planejamento_data  BETWEEN ('".$dataInicio."') AND ('".$dataFim."')
                          ");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "data" => $Result['data_aula'],
                            "turma" => $Result['projeto_descricao'],
                            "modalidade" => $Result['modalidade_nome'],
                            "horainicial" => $Result['hora_inicial'],
                            "horafinal" => $Result['hora_final'],
                            "hora" => $Result['hora'],
                            
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        
        break;
endswitch;