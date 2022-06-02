<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

if (isset($PostData['quantidade_centro_custo'])):
    $quantidade_centro_custo = $PostData['quantidade_centro_custo'];
    unset($PostData['quantidade_centro_custo']);
endif;

switch ($action):

    case 'CentroCustoEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['centro_custo_id'];
            unset($PostData['centro_custo_id']);

            $PostData['centro_custo_status'] = (!empty($PostData['centro_custo_status']) ? '1' : '0');
        
            $Update->ExeUpdate("sys_centro_custo", $PostData, "WHERE centro_custo_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=contabil/filtro_centro_custo";
        endif;

        break;

    case 'RateioMatriculaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            // RATEIO
            if($quantidade_centro_custo){
                $ArrRateio = [];
                for($i = 0; $i <= $quantidade_centro_custo; $i++){
                    if(isset($PostData['centro_custo_' . $i])){
                        $ArrRateio[] = Array(
                            'parametros_matricula_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'parametros_matricula_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'parametros_matricula_rateio_valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_rateio_' . $i])),
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }

                $Create->ExeCreateMulti("sys_parametros_matricula_rateio", $ArrRateio);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/cadastro_rateio_matricula";
        endif;
        break;

    case 'RateioMatriculaEdit':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            // RATEIO
            if($quantidade_centro_custo){
                $ArrRateio = [];
                for($i = 0; $i <= $quantidade_centro_custo; $i++){

                    if(isset($PostData['rateio_' . $i])){

                        $ArrRateioUpdate = [];

                        $ArrRateioUpdate = Array(
                            'parametros_matricula_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                            'parametros_matricula_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                            'parametros_matricula_rateio_valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_rateio_' . $i]))
                        );

                        $Update->ExeUpdate("sys_parametros_matricula_rateio", $ArrRateioUpdate, "WHERE parametros_matricula_rateio_id = :id", "id={$PostData['rateio_' . $i]}");

                    } else {
                        if(isset($PostData['centro_custo_' . $i])){
                            $ArrRateio[] = Array(
                                'parametros_matricula_rateio_centro_custo_id' => $PostData['centro_custo_' . $i],
                                'parametros_matricula_rateio_conta_contabil_id' => $PostData['conta_contabil_' . $i],
                                'parametros_matricula_rateio_valor' => str_replace(',', '.', str_replace('.', '', $PostData['valor_rateio_' . $i])),
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }

                if(count($ArrRateio) > 0){
                    $Create->ExeCreateMulti("sys_parametros_matricula_rateio", $ArrRateio);
                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=parametrizacao/cadastro_rateio_matricula";
        endif;
        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_centro_custo", "WHERE centro_custo_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_centro_custo", "WHERE centro_custo_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=contabil/filtro_centro_custo";

        endif;
        break;

        case 'remove_centro':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_parametros_matricula_rateio", "WHERE parametros_matricula_rateio_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_parametros_matricula_rateio", "WHERE parametros_matricula_rateio_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Rateio foi removido com sucesso!';

        endif;
        break;

endswitch;

echo json_encode($jSON);