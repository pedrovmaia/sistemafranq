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

        $Read->FullRead("SELECT tipo_acrescimo.tipo_acrescimo_abatimento_id,
            tipo_acrescimo.tipo_acrescimo_abatimento_nome,
            CASE
             WHEN tipo_acrescimo.tipo_acrescimo_abatimento_tipo = '1' THEN 'Abatimento'
                    ELSE 'Acréscimo'
                    END AS tipo
                    FROM sys_tipo_acrescimo_abatimento tipo_acrescimo
                    WHERE tipo_acrescimo.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['tipo_acrescimo_abatimento_id'],
                        "nome" => $Result['tipo_acrescimo_abatimento_nome'],
                        "tipo" => $Result['tipo'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/dominios/ver_tipo_acrescimo_abatimento&id={$Result["tipo_acrescimo_abatimento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=franqueador/dominios/cadastro_tipo_acrescimo_abatimento&id={$Result["tipo_acrescimo_abatimento_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='franqueador/TipoAcrescimoAbatimento' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["tipo_acrescimo_abatimento_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;