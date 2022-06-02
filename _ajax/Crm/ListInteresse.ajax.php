
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

        $Id = $PostData["id"];
        if($Id){
        $arr = array();

        $Read->FullRead("SELECT 
                   interesse.interesse_id,
                    DATE_FORMAT(interesse.interesse_data,'%d/%m/%Y') AS data, 
                   interesse.interesse_observacao,
                   interesse.interesse_pessoa_id,
                   atendente.pessoa_nome                  
                   FROM sys_crm_interesse interesse
                   LEFT OUTER JOIN sys_pessoas atendente ON atendente.pessoa_id = interesse.interesse_atendente_id
                   WHERE interesse.interesse_pessoa_id = $Id
                   AND interesse.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['interesse_id'],
                        "data" => $Result['data'],
                        "atendente" => $Result['pessoa_nome'],
                        "observacao" => $Result['interesse_observacao'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/ver_interesse&id={$Result["interesse_id"]}&idpessoa={$Result["interesse_pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/cadastro_interesse&id={$Result["interesse_id"]}&idpessoa={$Result["interesse_pessoa_id"]}' title='Editar' class='btn btn-primary btn-link mr-1'><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='Crm/Interesse' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["interesse_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;