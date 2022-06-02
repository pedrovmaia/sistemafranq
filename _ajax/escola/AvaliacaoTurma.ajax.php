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

    case 'manager':

        $quantidade_etapas = $PostData['qtdetapas'];
        //var_dump($PostData); die;

        if($quantidade_etapas){
            $ArrEtapas = [];
            
            for($i = 0; $i <= $quantidade_etapas; $i++){
                if(isset($PostData['etapa_produto_id_' . $i])){
                    if (isset($PostData['avaliacao_turma_id_' . $i])){

                        $UpdateHorario['avaliacao_turma_etapa_id'] = $PostData['etapa_produto_id_' . $i];
                        $UpdateHorario['avaliacao_turma_materia_inicial_id'] = $PostData['materia_inicio_' . $i];
                        $UpdateHorario['avaliacao_turma_materia_final_id'] = $PostData['materia_fim_' . $i];
                        $UpdateHorario['avaliacao_turma_data_inicial'] = date('Y-m-d', strtotime($PostData['hora_inical_' . $i]));
                        $UpdateHorario['avaliacao_turma_data_final'] = date('Y-m-d', strtotime($PostData['hora_final_' . $i]));

                        $Update->ExeUpdate("sys_avaliacao_turma", $UpdateHorario, "WHERE avaliacao_turma_id = :id", "id={$PostData['avaliacao_turma_id_' . $i]}");

                    } else {

                        $ArrEtapas[] = Array(
                            'avaliacao_turma_turma_id' => $PostData['turma_id'],
                            'avaliacao_turma_etapa_id' => $PostData['etapa_produto_id_' . $i],
                            'avaliacao_turma_materia_inicial_id' =>  $PostData['materia_inicio_' . $i],
                            'avaliacao_turma_materia_final_id' => $PostData['materia_fim_' . $i],
                            'avaliacao_turma_data_inicial' => date('Y-m-d', strtotime($PostData['hora_inical_' . $i])),
                            'avaliacao_turma_data_final' => date('Y-m-d', strtotime($PostData['hora_final_' . $i])),
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
            }
            if(count($ArrEtapas) > 0){
                $Create->ExeCreateMulti("sys_avaliacao_turma", $ArrEtapas);
            }
        }

        $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        $jSON['redirect'] = "escola/turma/avaliacao_turma&id=" . $PostData['turma_id'];

        break;

endswitch;

echo json_encode($jSON);