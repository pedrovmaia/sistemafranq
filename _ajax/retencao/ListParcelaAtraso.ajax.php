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

        $Read->FullRead("SELECT     
            DISTINCT parcela.mov_recebimento_pessoa_id,
            (SELECT          
            COUNT(parcela_count.mov_recebimento_id)
            FROM sys_movimentacao_recebimento parcela_count
            WHERE parcela_count.unidade_id = :unidade
            AND parcela_count.mov_recebimento_status = 0
            AND parcela_count.mov_recebimento_valor > 0
            AND parcela_count.mov_recebimento_data_vencimento < now()
            AND parcela_count.mov_recebimento_pessoa_id = parcela.mov_recebimento_pessoa_id) AS qtd_parcelas,
            (SELECT          
            SUM(parcela_count.mov_recebimento_valor)
            FROM sys_movimentacao_recebimento parcela_count
            WHERE parcela_count.unidade_id = :unidade
            AND parcela_count.mov_recebimento_status = 0
            AND parcela_count.mov_recebimento_valor > 0
            AND parcela_count.mov_recebimento_data_vencimento < now()
            AND parcela_count.mov_recebimento_pessoa_id = parcela.mov_recebimento_pessoa_id) AS valor_total,
            pessoa.pessoa_nome,
            telefones.telefone,
            parcela.mov_recebimento_valor,
            parcela.mov_recebimento_pessoa_id,
						financeiro.pessoa_nome AS responsavelfi,
						telefones_fi.telefone AS responsavelfitel
            FROM sys_movimentacao_recebimento parcela
            LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id
            LEFT OUTER JOIN sys_telefones_pessoas telefones ON telefones.pessoa_id = parcela.mov_recebimento_pessoa_id
						LEFT OUTER JOIN sys_pessoas AS financeiro ON financeiro.pessoa_id = pessoa.pessoa_responsavel_financeiro_id
            LEFT OUTER JOIN sys_telefones_pessoas telefones_fi ON telefones_fi.pessoa_id = financeiro.pessoa_id
            WHERE parcela.unidade_id = :unidade
            AND parcela.mov_recebimento_status = 0
            AND parcela.mov_recebimento_valor > 0
            AND parcela.mov_recebimento_data_vencimento < now()", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            $valor_total = 0;
            $aluno = 0;
            foreach ($Read->getResult() as $Result){

                if($Result['mov_recebimento_pessoa_id'] != $aluno) {         
                
                    array_push($arr, array(
                            "qtd" => $Result['qtd_parcelas'],
                            "valor_total" => "R$ ".number_format($Result['valor_total'], 2, ',','.'),
                            "nome" => $Result['pessoa_nome'],
                            "telefone" => $Result['telefone'],
                            "nome_res" => $Result['responsavelfi'],
                            "telefone_res" => $Result['responsavelfitel'],
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Result["mov_recebimento_pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                        )
                    );

                }

                $aluno = $Result['mov_recebimento_pessoa_id'];
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'listParcelas':

        $arr = array();
        $parcela_inicial = $PostData['inicio'];
        $parcela_final = $PostData['fim'];

        $Read->FullRead("SELECT     
            DISTINCT parcela.mov_recebimento_pessoa_id,
            (SELECT          
            COUNT(parcela_count.mov_recebimento_id)
            FROM sys_movimentacao_recebimento parcela_count
            WHERE parcela_count.unidade_id = :unidade
            AND parcela_count.mov_recebimento_status = 0
            AND parcela_count.mov_recebimento_valor > 0
            AND parcela_count.mov_recebimento_data_vencimento < now()
            AND parcela_count.mov_recebimento_pessoa_id = parcela.mov_recebimento_pessoa_id) AS qtd_parcelas,
            (SELECT          
            SUM(parcela_count.mov_recebimento_valor)
            FROM sys_movimentacao_recebimento parcela_count
            WHERE parcela_count.unidade_id = :unidade
            AND parcela_count.mov_recebimento_status = 0
            AND parcela_count.mov_recebimento_valor > 0
            AND parcela_count.mov_recebimento_data_vencimento < now()
            AND parcela_count.mov_recebimento_pessoa_id = parcela.mov_recebimento_pessoa_id) AS valor_total,
            pessoa.pessoa_nome,
            telefones.telefone,
            parcela.mov_recebimento_valor,            
            parcela.mov_recebimento_pessoa_id,
                        financeiro.pessoa_nome AS responsavelfi,
                        telefones_fi.telefone AS responsavelfitel
            FROM sys_movimentacao_recebimento parcela
            LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id
            LEFT OUTER JOIN sys_telefones_pessoas telefones ON telefones.pessoa_id = parcela.mov_recebimento_pessoa_id
                        LEFT OUTER JOIN sys_pessoas AS financeiro ON financeiro.pessoa_id = pessoa.pessoa_responsavel_financeiro_id
            LEFT OUTER JOIN sys_telefones_pessoas telefones_fi ON telefones_fi.pessoa_id = financeiro.pessoa_id
            WHERE parcela.unidade_id = :unidade
            AND parcela.mov_recebimento_status = 0
            AND parcela.mov_recebimento_valor > 0
            AND parcela.mov_recebimento_data_vencimento < now()", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            $valor_total = 0;
            $aluno = 0;
            foreach ($Read->getResult() as $Result){

                if($Result['qtd_parcelas'] >= $parcela_inicial && $Result['qtd_parcelas'] <= $parcela_final){

                    if($Result['mov_recebimento_pessoa_id'] != $aluno) {

                        array_push($arr, array(
                                "qtd" => $Result['qtd_parcelas'],
                                "valor_total" => "R$ ".number_format($Result['valor_total'], 2, ',','.'),
                                "nome" => $Result['pessoa_nome'],
                                "telefone" => $Result['telefone'],
                                "nome_res" => $Result['responsavelfi'],
                                "telefone_res" => $Result['responsavelfitel'],
                                "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Result["mov_recebimento_pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                            )
                        ); 

                    }

                    $aluno = $Result['mov_recebimento_pessoa_id']; 

                }              
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;