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

if (isset($PostData['quantidade_indicacao_aluno'])):
    $quantidade_indicacao_aluno = $PostData['quantidade_indicacao_aluno'];
    unset($PostData['quantidade_indicacao_aluno']);
endif;

switch ($action):

    case 'IndicacaoEditar':
        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['pessoa_id'];

            if($quantidade_indicacao_aluno){
                $ArrIndicacao = [];

                for($i = 0; $i <= $quantidade_indicacao_aluno; $i++){

                    if(isset($PostData['nome_' . $i])){
                        if (isset($PostData['indic_id_' . $i])){
                            $UpdateIndicacao['nome'] = $PostData['nome_' . $i];
                            $UpdateIndicacao['telefone'] = $PostData['telefone_' . $i];
                            $UpdateIndicacao['email'] = $PostData['email_' . $i];

                            $Update->ExeUpdate("sys_indicacao", $UpdateIndicacao, "WHERE id = :id", "id={$PostData['indic_id_' . $i]}");
                        } else {
                            $ArrIndicacao[] = Array(
                                'pessoa_id' => $PostData['pessoa_id'],
                                'nome' => $PostData['nome_' . $i],
                                'telefone' => $PostData['telefone_' . $i],
                                'email' => $PostData['email_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }
                if(count($ArrIndicacao) > 0){
                    $Create->ExeCreateMulti("sys_indicacao", $ArrIndicacao);
                }
            }

            $jSON['success'] = 'Sua edição foi salva com sucesso!';
        endif;
        break;

    case 'IndicacaoAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            if($quantidade_indicacao_aluno){
                $ArrIndicacao = [];
                for($i = 0; $i <= $quantidade_indicacao_aluno; $i++){
                    if(isset($PostData['nome_' . $i])){
                        $ArrIndicacao[] = Array(
                            'pessoa_id' => $PostData['pessoa_id'],
                            'nome' => $PostData['nome_' . $i],
                            'telefone' => $PostData['telefone_' . $i],
                            'email' => $PostData['email_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_indicacao", $ArrIndicacao);
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/cadastro_indicacao&idAluno=" . $PostData['pessoa_id'] . "&id=" . $PostData['pessoa_id'];
        endif;

        break;

    case 'remove':
        $Id = $PostData['del_id'];
        $Delete->ExeDelete("sys_indicacao", "WHERE id = :id", "id={$Id}");
        $jSON['success'] = 'Indicação foi removida com sucesso!';
        break;

    case 'add_linha':

        $clone = "<tr><td class='pt-3-half'>";
        $clone .= "<input type='text' name='nome_".$PostData['numero']."' placeholder='Digite o nome' class='form-control' value=''>";
        $clone .= "</td><td class='pt-3-half'><input type='tel' name='telefone_".$PostData['numero']."' placeholder='(00) 0000-0000' class='form-control formPhone'></td>";
        $clone .= "<td class='pt-3-half'><input type='email' name='email_".$PostData['numero']."' placeholder='E-mail' class='form-control'></td>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;

endswitch;

echo json_encode($jSON);