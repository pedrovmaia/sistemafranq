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
    $Email = new Email;
    $trigger = new Trigger;
endif;

if (isset($PostData['quantidade_politica_acrescimo'])):
    $quantidade_politica_acrescimo = $PostData['quantidade_politica_acrescimo'];
    unset($PostData['quantidade_politica_acrescimo']);
endif;

switch ($action):

    case 'AcrescimoEditar':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_politica_acrescimo){
                $ArrAcrescimo = [];

                for($i = 0; $i <= $quantidade_politica_acrescimo; $i++){

                    if(isset($PostData['parcelas_' . $i])){
                        if (isset($PostData['acresc_id_' . $i])){
                            $UpdateAcrescimo['parcelas'] = $PostData['parcelas_' . $i];
                            $UpdateAcrescimo['acrescimo'] = $PostData['acrescimo_' . $i];
                            $UpdateAcrescimo['tipo'] = $PostData['tipo_' . $i];

                            $Update->ExeUpdate("sys_politica_acrescimo", $UpdateAcrescimo, "WHERE id = :id", "id={$PostData['acresc_id_' . $i]}");
                        } else {
                            $ArrAcrescimo[] = Array(
                                'parcelas' => $PostData['parcelas_' . $i],
                                'acrescimo' => $PostData['acrescimo_' . $i],
                                'tipo' => $PostData['tipo_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }
                if(count($ArrAcrescimo) > 0){
                    $Create->ExeCreateMulti("sys_politica_acrescimo", $ArrAcrescimo);
                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/cadastro_politica_acrescimo&id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}";

        endif;
        break;

    case 'AcrescimoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_politica_acrescimo){
                $ArrAcrescimo = [];
                for($i = 0; $i <= $quantidade_politica_acrescimo; $i++){
                    if(isset($PostData['parcelas_' . $i])){
                        $ArrAcrescimo[] = Array(
                            'parcelas' => $PostData['parcelas_' . $i],
                            'acrescimo' => $PostData['acrescimo_' . $i],
                            'tipo' => $PostData['tipo_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_politica_acrescimo", $ArrAcrescimo);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=politica_comercial/cadastro_politica_acrescimo&id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}";
        endif;

        break;

    case 'remove':
        $Id = $PostData['del_id'];
        $Delete->ExeDelete("sys_politica_acrescimo", "WHERE id = :id", "id={$Id}");
        $jSON['success'] = 'Politica foi removida com sucesso!';
        break;

    case 'add_linha':

        $clone = "<tr><td class='pt-3-half'>";
        $clone .= "<input type='text' name='parcelas_".$PostData['numero']."'  class='form-control' value=''>";
        $clone .= "</td><td class='pt-3-half'><input type='number' name='acrescimo_".$PostData['numero']."' placeholder='0' class='form-control'></td>";
        $clone .= "<td class='pt-3-half'><select style='margin-top: -3px' name='tipo_".$PostData['numero']."' class='form-control' data-style='btn btn-link'><option value='0'>SELECIONE UM TIPO</option><option name='tipo_".$PostData['numero']."' value='1'>Percentual</option><option name='tipo_".$PostData['numero']."' value='2'>Valor</option> </select></td>";
        $clone .= "<td class='pt-3-half'><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);