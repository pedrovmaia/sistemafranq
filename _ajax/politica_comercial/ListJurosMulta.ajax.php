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

        $Read->FullRead("SELECT jurosmulta.juros_multa_id,
            jurosmulta.juros,
            jurosmulta.multa,
             DATE_FORMAT(jurosmulta.data_inicial,'%d/%m/%Y') AS datai,
            DATE_FORMAT(jurosmulta.data_final,'%d/%m/%Y') AS dataf
            FROM sys_juros_multa jurosmulta
            WHERE jurosmulta.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['juros_multa_id'],
                        "juros" => number_format($Result['juros'], 2, ',', '.'),
                        "multa" => number_format($Result['multa'], 2, ',', '.'),
                        "datainicial" => $Result['datai'],
                        "datafinal" => $Result['dataf'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/ver_juros_multa&id={$Result["juros_multa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=politica_comercial/cadastro_juros_multa&id={$Result["juros_multa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='politica_comercial/JurosMulta' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["juros_multa_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;