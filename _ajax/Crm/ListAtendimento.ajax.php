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

        $Read->FullRead("SELECT a.atendimento_id, a.atendimento_observacao, p.pessoa_nome AS atendente, pe.pessoa_nome AS cliente, res.resposta_nome, pro.acoes_nome, a.atendimento_date, ti.tipo_contato_nome, a.atendimento_agendamento, a.atendimento_agenda_data, a.atendimento_observacao_agenda, tp.tipo_atendimento_nome FROM sys_atendimentos AS a 
                            INNER JOIN sys_pessoas AS p ON p.pessoa_id = a.atendimento_atendente_id
                            INNER JOIN sys_pessoas AS pe ON pe.pessoa_id = a.atendimento_pessoa_id
                            INNER JOIN sys_crm_resposta_tipo_atendimento AS res ON res.resposta_id = a.atendimento_resposta_id
                            INNER JOIN sys_crm_proximas_acoes_tipo_atendimento AS pro ON pro.acoes_id = a.atendimento_proxima_acao_id
                            LEFT OUTER JOIN sys_tipos_contato_atendimento AS ti ON ti.tipo_contato_id = a.atendimento_tipo_contato_id
                            INNER JOIN sys_crm_tipo_atendimento AS tp ON tp.tipo_atendimento_id = a.tipo_atendimento_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['atendimento_id'],
                        "nome" => $Result['tipo_atendimento_nome'],
                        "atendente" => $Result['atendente'],
                        "cliente" =>  $Result['cliente'],
                        "resposta" => $Result['resposta_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=crm/ver_atendimento&id={$Result["atendimento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;