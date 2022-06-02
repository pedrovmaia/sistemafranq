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
        $Read->FullRead("SELECT projeto.projeto_id,
                projeto.projeto_descricao,
                projeto.projeto_codigo,
                projeto.projeto_data_inicio,
                projeto.projeto_data_termino,
                projeto.projeto_observacao,
                projeto.projeto_qtd_participantes,
                modalidades.modalidade_nome,
                sala.sala_nome,
                pessoas.pessoa_nome,
                situacao.situacao_projeto_nome,
                produto.produto_nome,
                tipo_projeto.tipo_projeto_nome
                FROM sys_projetos projeto
                LEFT OUTER JOIN sys_sala sala ON projeto.projeto_sala_id = sala.sala_id 
                LEFT OUTER JOIN sys_modalidades modalidades ON projeto.projeto_modalidade_id = modalidades.modalidade_id 
                LEFT OUTER JOIN sys_pessoas pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_situacao_projeto situacao ON projeto.projeto_situacao_id = situacao.situacao_projeto_id
                LEFT OUTER JOIN sys_produto produto ON produto.produto_id = projeto.projeto_produto_id 
                LEFT OUTER JOIN sys_tipo_projeto tipo_projeto ON tipo_projeto.tipo_projeto_id = projeto.projeto_tipo_id WHERE projeto.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['projeto_id'],
                        "nome" => $Result['projeto_descricao'],
                        "codigo" => $Result['projeto_codigo'],
                        "curso" => $Result['produto_nome'],
                        "modalidade" => $Result['modalidade_nome'],
                        "professor" => $Result['pessoa_nome'],
                        "vagas" => $Result['projeto_qtd_participantes'],
                        "sala" => $Result['sala_nome'],
                        "tipo" => $Result['tipo_projeto_nome'],
                        "situacao" => $Result['situacao_projeto_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/turma/diario_classe_impressao&id={$Result["projeto_id"]}' title='Ver Diário de Classe' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;