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


        $Read->FullRead("SELECT conta.conta_bancaria_id,
                       conta.conta_bancaria_nome,
                       conta.conta_bancaria_agencia,
                       conta.conta_bancaria_digito_agencia,
                       conta.conta_bancaria_conta,
                       conta.conta_bancaria_digito_conta,
                       tipo.tipo_conta_bancaria_nome,
                       instituicao.instituicao_financeira_nome
                    FROM sys_conta_bancaria conta 
                    LEFT OUTER JOIN sys_tipo_conta_bancaria tipo ON tipo.tipo_conta_bancaria_id = conta.conta_bancaria_tipo_id
                    LEFT OUTER JOIN sys_instituicao_financeira  instituicao ON instituicao.instituicao_financeira_id = conta.conta_bancaria_banco_id WHERE conta.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['conta_bancaria_id'],
                        "nome" => $Result['conta_bancaria_nome'],
                        "instituicaofinanceira" => $Result['instituicao_financeira_nome'],
                        "tipo" => $Result['tipo_conta_bancaria_nome'],
                        "agencia" => $Result['conta_bancaria_agencia'],
                        "digitoagencia" => $Result['conta_bancaria_digito_agencia'],
                        "conta" => $Result['conta_bancaria_conta'],
                        "digitoconta" => $Result['conta_bancaria_digito_conta'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/caixas_bancos/ver_conta_bancaria&id={$Result["conta_bancaria_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/caixas_bancos/cadastro_conta_bancaria&id={$Result["conta_bancaria_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='financeiro/ContaBancaria' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["conta_bancaria_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;