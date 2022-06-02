<?php

session_start();
$PostData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData && $PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'list':
        $arr = array();

        /*$Read->FullRead("SELECT projeto.projeto_id,
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
                LEFT OUTER JOIN sys_tipo_projeto tipo_projeto ON tipo_projeto.tipo_projeto_id = projeto.projeto_tipo_id");*/
        $Read->FullRead("SELECT p.pessoa_id, p.pessoa_nome, l.* FROM sys_lista_espera_projeto AS l INNER JOIN sys_pessoas AS p ON p.pessoa_id = l.lista_espera_projeto_pessoa_id WHERE l.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['pessoa_id'],
                        "nome" => $Result['pessoa_nome'],
                        "periodo" => getPeriodo($Result['lista_espera_projeto_periodo_preferencia']),
                        "dia" => getDiaSemana($Result['lista_espera_projeto_dia_preferencia']),
                        "hora" => $Result['lista_espera_projeto_horario_preferencia'],
                        "telefone" => $Result['lista_espera_projeto_telefone_contato'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['alterar'] == 1 ? "<span rel='{$Result["lista_espera_projeto_id"]}' title='Selecionar Turma' class='btn btn-warning btn-link mr-1 j_sys_selecionar_turma_espera'><i class='material-icons'>book</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;