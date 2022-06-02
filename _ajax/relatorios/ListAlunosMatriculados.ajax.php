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

        $Read->FullRead("SELECT
           DATE_FORMAT(movimentacao.movimentacao_data,'%d/%m/%Y') AS data_inscricao ,
           aluno.pessoa_nome as aluno,
           aluno.pessoa_id,
           turma.projeto_descricao,
           professor.pessoa_nome as professor,
           estagio.estagio_produto_nome,
           modalidades.modalidade_nome,
           movimentacao.movimentacao_id as numero_inscricao
           from sys_movimentacao movimentacao
          LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = movimentacao.movimentacao_pessoa_id
          LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = movimentacao.movimentacao_projeto_id
          LEFT OUTER JOIN sys_modalidades modalidades ON modalidades.modalidade_id = turma.projeto_modalidade_id
          LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
          LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = turma.projeto_produto_id
          WHERE movimentacao.movimentacao_data BETWEEN ('".$dataInicio."') AND ('".$dataFim."')
                          ", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                    "data" => $Result['data_inscricao'],
                    "aluno" => $Result['aluno'],
                    "professor" => $Result['professor'],
                    "turma" => $Result['projeto_descricao'],
                    "estagio" => $Result['estagio_produto_nome'],
                    "modalidade" => $Result['modalidade_nome'],
                    "numero" => $Result['numero_inscricao'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Result["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;