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
        $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];

        $data_fim = mktime(23, 59, 59, date('m', strtotime($dataFim)), date("d", strtotime($dataFim)), date('Y', strtotime($dataFim)));
        $dataFim = date('Y-m-d H:i:s',$data_fim);

        $Read->FullRead("SELECT m.matricula_id, p.pessoa_nome, m.matricula_data, m.matricula_valor_total, c.projeto_descricao
        FROM sys_matriculas AS m 
        INNER JOIN sys_pessoas AS p ON m.matricula_cliente_id = p.pessoa_id
        LEFT OUTER JOIN sys_projetos AS c ON m.matricula_curso_id  = c.projeto_id
        WHERE m.unidade_id = :id AND m.matricula_data BETWEEN ('".$dataInicio."') AND ('".$dataFim."')", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $Read->FullRead("SELECT SUM(I.matricula_item_valor_total) AS total FROM sys_matricula_item AS I WHERE I.matricula_item_proposta_id = :id", "id={$Result["matricula_id"]}");
                $TotalDesconto = number_format($Read->getResult()[0]['total'], 2, ',', '.');


                array_push($arr, array(
                        "id" => $Result['matricula_id'],
                        "curso" => (isset($Result['projeto_descricao']) ? $Result['projeto_descricao'] : 'Lista de espera'),
                        "nome" => $Result['pessoa_nome'],
                        "data" => date('d/m/Y H:i:s' , strtotime($Result['matricula_data'])),
                        "valor" => number_format($Result['matricula_valor_total'], 2, ',', '.'),
                        "valor_desconto" => $TotalDesconto,
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/matricula/ver_pedido&id={$Result["matricula_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'list_orcamento':

        $arr = array();

        $Read->FullRead("SELECT m.orcamento_matricula_id, m.orcamento_matricula_aluno_nome, m.orcamento_matricula_data, m.orcamento_matricula_valor_total FROM sys_orcamento_matricula AS m WHERE m.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['orcamento_matricula_id'],
                        "nome" => $Result['orcamento_matricula_aluno_nome'],
                        "data" => date('d/m/Y H:i:s' , strtotime($Result['orcamento_matricula_data'])),
                        "valor" => number_format($Result['orcamento_matricula_valor_total'], 2, ',', '.'),
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/matricula/ver_orcamento&id={$Result["orcamento_matricula_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;