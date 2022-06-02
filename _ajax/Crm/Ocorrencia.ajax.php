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

switch ($action):
 
 case 'OcorrenciaEditar':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $PostData['ocorrencia_data'] = (!empty($PostData['ocorrencia_data']) ? Check::Data($PostData['ocorrencia_data']) : date('Y-m-d'));
            $Id = $PostData['ocorrencia_id'];
            unset($PostData['ocorrencia_id']);

        
            $Update->ExeUpdate("sys_ocorrencia", $PostData, "WHERE ocorrencia_id = :id", "id={$Id}");
            $jSON['success'] = 'Sua edição foi salva com sucesso!';
             $jSON['redirect'] = "painel.php?exe=crm/ver_ocorrencia&id=" . $Id;
        endif;

        break;

    case 'OcorrenciaAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            unset($PostData['pessoa_nome']);

            $PostData['ocorrencia_atendente_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];

            $PostData['ocorrencia_data'] = (!empty($PostData['ocorrencia_data']) ? Check::Data($PostData['ocorrencia_data']) : date('Y-m-d'));
            $Create->ExeCreate("sys_ocorrencia", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_ocorrencia&id=" . $PostData['ocorrencia_pessoa_id'];
        endif;

        break;

    case 'alteraStatusOcorrencia':

        $Id = $PostData['ocorrencia_id'];
        $status = $PostData['status'];

        $ArrUpdate = [
            'ocorrencia_status' => $status
        ];

        $Update->ExeUpdate("sys_ocorrencia", $ArrUpdate, "WHERE ocorrencia_id = :id", "id={$Id}");
        $jSON['success'] = "Status da ocorrência alterado com sucesso!";

        break;

    case 'buscarOcorrencia':

        $Id = $PostData['ocorrencia_id'];

        $resultado = "";

        $Read->FullRead("SELECT o.*, n.ocorrencias_natureza_nome, p.pessoa_nome FROM sys_ocorrencia AS o INNER JOIN sys_ocorrencias_natureza AS n ON n.ocorrencia_natureza_id = o.ocorrencia_natureza_id INNER JOIN sys_pessoas AS p ON p.pessoa_id = o.ocorrencia_pessoa_id WHERE o.ocorrencia_id = :id", "id={$Id}");
        if($Read->getResult()){
            $Ocorrencia = $Read->getResult()[0];

            $resultado .= '<div class="row list_ocorrencia_remover">';
            $resultado .= '<div class="col-md-6"><div class="form-group"><label class="bmd-label-floating">Data</label><input disabled class="form-control" value="'.date('d/m/Y', strtotime($Ocorrencia['ocorrencia_data'])).'"/></div></div>';
            $resultado .= '<div class="col-md-6"><div class="form-group"><label class="bmd-label-floating">Status</label><input disabled class="form-control" value="'.($Ocorrencia['ocorrencia_status'] == 0 ? 'Novo' : ($Ocorrencia['ocorrencia_status'] == 1 ? 'Resolvido' : ($Ocorrencia['ocorrencia_status'] == 2 ? 'Cancelado' : 'Novo'))).'"/></div></div>';
            $resultado .= '<div class="col-md-12"><div class="form-group"><label class="bmd-label-floating">Cliente/Aluno</label><input disabled class="form-control" value="'.$Ocorrencia['pessoa_nome'].'"/></div></div>';
            $resultado .= '<div class="col-md-12"><div class="form-group"><label class="bmd-label-floating">Natureza</label><input disabled class="form-control" value="'.$Ocorrencia['ocorrencias_natureza_nome'].'"/></div></div>';
            $resultado .= '<div class="col-md-12"><div class="form-group"><label class="bmd-label-floating">Descrição</label><textarea disabled rows="3" class="form-control">'.$Ocorrencia['ocorrencia_descricao'].'</textarea></div></div>';
            $resultado .= '</div>';
            $resultado .= '<div class="row list_ocorrencia_remover"><div class="col-md-12"><div class="form-group"><button type="button" data-status="1" rel="'.$Ocorrencia['ocorrencia_id'].'" class="btn btn-primary j_altera_status_ocorrencia">MARCAR COMO RESOLVIDO</button><button type="button" data-status="2" rel="'.$Ocorrencia['ocorrencia_id'].'" class="btn btn-primary j_altera_status_ocorrencia">MARCAR COMO CANCELADO</button></div></div></div>';

            $jSON['success'] = $resultado;

        } else {
            $jSON['error'] = "Ocorrência não existe!";
        }

        break;

    case 'buscarResponsavel':

        $Id = $PostData['id'];

        $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencia_natureza_id = :id", "id={$Id}");
        if($Read->getResult()){
            $OcorrenciaNatureza = $Read->getResult()[0];

            $Read->FullRead("SELECT pessoa_id, pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$OcorrenciaNatureza['responsavel_id']}");
            if($Read->getResult()){
                $jSON['success'] = $Read->getResult()[0];
            } else {
                $jSON['error'] = "Responsável não existe!";
            }

        } else {
            $jSON['error'] = "Natureza não existe!";
        }

        break;

    case 'OcorrenciaGeralAdd':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            unset($PostData['pessoa_nome']);

            $PostData['ocorrencia_atendente_id'] = $_SESSION['userSYSFranquia']['pessoa_id'];
            $PostData['ocorrencia_status'] = 0;
            $PostData['ocorrencia_data'] = (!empty($PostData['ocorrencia_data']) ? $PostData['ocorrencia_data'] : date('Y-m-d H:i:s'));
            $Create->ExeCreate("sys_ocorrencia", $PostData);
            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=crm/filtro_ocorrencia&id=" . $PostData['ocorrencia_pessoa_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_ocorrencia", "WHERE ocorrencia_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("sys_ocorrencia", "WHERE ocorrencia_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=crm/filtro_ocorrencia&id=" . $Read->getResult()[0]['ocorrencia_pessoa_id'];

        endif;
        break;

endswitch;

echo json_encode($jSON);