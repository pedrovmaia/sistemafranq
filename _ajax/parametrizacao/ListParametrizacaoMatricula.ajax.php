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

        $Read->FullRead("SELECT parametro.parametro_id,
            forma.forma_parcelamento_nome,
            dia.dias_vencimento_nome,
            modalidade.modalidade_nome
            FROM sys_parametros parametro
            LEFT OUTER JOIN sys_forma_parcelamento forma on forma.forma_parcelamento_id = parametro.parametro_forma_parcelamento_id
            LEFT OUTER JOIN sys_dias_vencimento dia on dia.dias_vencimento_id = parametro.parametro_dia_vencimento_id
            LEFT OUTER JOIN sys_modalidades modalidade on modalidade.modalidade_id = parametro.parametro_modalidade_id WHERE parametro.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['parametro_id'],
                        "forma" => $Result['forma_parcelamento_nome'],
                        "dia" => $Result['dias_vencimento_nome'],
                        "moda" => $Result['modalidade_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=parametrizacao/ver_parametrizacao_matricula&id={$Result["parametro_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=parametrizacao/cadastro_parametrizacao_matricula&id={$Result["parametro_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='parametrizacao/ParametrizacaoMatricula' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["parametro_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>")
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;