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

        //$Read->ExeRead("sys_projetos", "WHERE 1=1");
        $Read->FullRead("SELECT projeto.projeto_codigo,
                   projeto.projeto_data_inicio,
                   projeto.projeto_data_termino,
                   projeto.projeto_descricao,
                   projeto.projeto_id,
                   projeto.projeto_observacao,
                   projeto.projeto_qtd_participantes,
                   projeto.projeto_status,
                   sala.sala_nome,
                   modalidade.modalidade_nome,
                   estagio_prod.estagio_produto_nome,
                   professor.pessoa_nome,
                   situacao.situacao_projeto_nome,
                   tipo.tipo_projeto_nome
                   FROM sys_projetos projeto
                     LEFT OUTER JOIN sys_sala  sala ON sala.sala_id = projeto.projeto_sala_id
                     LEFT OUTER JOIN sys_modalidades  modalidade ON modalidade.modalidade_id = projeto.projeto_modalidade_id
                     LEFT OUTER JOIN sys_estagio_produto estagio_prod ON estagio_prod.estagio_produto_id = projeto.projeto_produto_id
                     LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = projeto.projeto_gerente_id
                     LEFT OUTER JOIN sys_situacao_projeto situacao ON situacao.situacao_projeto_id = projeto.projeto_situacao_id
                     LEFT OUTER JOIN sys_tipo_projeto tipo ON tipo.tipo_projeto_id = projeto.projeto_tipo_id
                       WHERE projeto.projeto_status = 0
                       AND projeto.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['projeto_id'],
                        "nome" => $Result['projeto_descricao'],
                        "codigo" => $Result['projeto_codigo'],
                        "status" => $Result['projeto_status'],
                        "produto" => $Result['estagio_produto_nome'],
                        "modalidade" => $Result['modalidade_nome'],
                        "professor" => $Result['pessoa_nome'],
                        "vagas" => $Result['projeto_qtd_participantes'],
                        "sala" => $Result['sala_nome'],
                        "tipo" => $Result['tipo_projeto_nome'],
                        "situacao" => $Result['situacao_projeto_nome'],
                        "datainicio" => date('d/m/Y', strtotime($Result['projeto_data_inicio'])), 
                        "datafinal" => date('d/m/Y', strtotime($Result['projeto_data_termino'])),
                        "observacao" => $Result['projeto_observacao'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/ver_turma&id={$Result["projeto_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;