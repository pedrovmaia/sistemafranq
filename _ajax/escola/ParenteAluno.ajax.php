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

if (isset($PostData['quantidade_parente_aluno'])):
    $quantidade_parente_aluno = $PostData['quantidade_parente_aluno'];
    unset($PostData['quantidade_parente_aluno']);
endif;

switch ($action):

    case 'ParenteEditar':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['pessoa_id'];

            if($quantidade_parente_aluno){
                $ArrParente = [];

                for($i = 0; $i <= $quantidade_parente_aluno; $i++){

                    if(isset($PostData['pessoas_parentesco_parente_id_' . $i])){
                        if (isset($PostData['pessoas_parentesco_id_' . $i])){
                            $UpdateParente['pessoas_parentesco_parente_id'] = $PostData['pessoas_parentesco_parente_id_' . $i];
                            $UpdateParente['pessoa_parentesco_parente_cpf'] = $PostData['pessoa_parentesco_parente_cpf_' . $i];
                            $UpdateParente['pessoas_parentesco_grau_id'] = $PostData['pessoas_parentesco_grau_id_' . $i];

                            $Update->ExeUpdate("sys_pessoas_parentesco", $UpdateParente, "WHERE pessoas_parentesco_id = :id", "id={$PostData['pessoas_parentesco_id_' . $i]}");

                        } else {
                            $ArrParente[] = Array(
                                'pessoa_id' => $PostData['pessoa_id'],
                                'pessoas_parentesco_parente_id' => $PostData['pessoas_parentesco_parente_id_' . $i],
                                'pessoa_parentesco_parente_cpf' => $PostData['pessoa_parentesco_parente_cpf_' . $i],
                                'pessoas_parentesco_grau_id' => $PostData['pessoas_parentesco_grau_id_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }
                if(count($ArrParente) > 0){
                    $Create->ExeCreateMulti("sys_pessoas_parentesco", $ArrParente);
                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
        endif;
        break;

    case 'ParenteAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_parente_aluno){
                $ArrParente = [];
                for($i = 0; $i <= $quantidade_parente_aluno; $i++){
                    if(isset($PostData['pessoas_parentesco_parente_id_' . $i])){
                        $ArrParente[] = Array(
                            'pessoa_id' => $PostData['pessoa_id'],
                            'pessoas_parentesco_parente_id' => $PostData['pessoas_parentesco_parente_id_' . $i],
                            'pessoa_parentesco_parente_cpf' => $PostData['pessoa_parentesco_parente_cpf_' . $i],
                            'pessoas_parentesco_grau_id' => $PostData['pessoas_parentesco_grau_id_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_pessoas_parentesco", $ArrParente);
            }
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/cadastro_parentes&idAluno={$PostData['pessoa_id']}&id={$PostData['pessoa_id']}";
        endif;

        break;

    case 'remove':
        $Id = $PostData['del_id'];
        $Delete->ExeDelete("sys_pessoas_parentesco", "WHERE id = :id", "id={$Id}");
        $jSON['success'] = 'Parente foi removido com sucesso!';
        break;

    case 'add_linha':

        $clone = "<tr><td class='pt-3-half'>";
        $clone .= "<input readonly type='text' data-cpf='txt_cpf_" .$PostData['numero']. "' data-id='txt_id_pessoa_" .$PostData['numero']. "' placeholder='Clique e selecione a pessoa' name='pessoas_parentesco_parente_id_".$PostData['numero']." id='txt_pessoa_" .$PostData['numero']. "' class='form-control j_grau_parentes'><input  id='txt_id_pessoa_" .$PostData['numero']. "' type='hidden' name='pessoas_parentesco_parente_id_" .$PostData['numero']. "' class='form-control'></td>";
        $clone .= "<td class='pt-3-half'><input readonly type='text' id='txt_cpf_" .$PostData['numero']. "' name='pessoa_parentesco_parente_cpf_" .$PostData['numero']. "' class='form-control' value=''></td>";
        $clone .= "<td class='pt-3-half'><select style='margin-top: -3px' class='form-control' name='pessoas_parentesco_grau_id_".$PostData['numero']."'>";
        $clone .= "<option value=''>SELECIONE O GRAU DE PARENTESCO</option>";
        $Read->ExeRead('sys_grau_parentesco', 'WHERE grau_parentesco_status = :st', 'st=0');
        if ($Read->getResult()):
            foreach ($Read->getResult() as $Grau):
            $clone .= "<option value='{$Grau['grau_parentesco_id']}'>{$Grau['grau_parentesco_nome']}</option>";
            endforeach;
        endif;
        $clone .= "</select></td>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);