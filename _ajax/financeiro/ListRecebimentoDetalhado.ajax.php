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
                DATE_FORMAT(parcela.mov_recebimento_data_recebimento, '%d/%m/%Y') AS mov_recebimento_data_recebimento,
                DATE_FORMAT(parcela.mov_recebimento_data_vencimento, '%d/%m/%Y') AS 
                    datav,
                parcela.mov_recebimento_data_vencimento,
                parcela.mov_recebimento_id,
                parcela.mov_recebimento_movimento_id,
                parcela.mov_recebimento_numero,
                parcela.mov_recebimento_parcela,
                parcela.mov_recebimento_pessoa_id,
                parcela.mov_recebimento_status,
                parcela.mov_recebimento_tipo_id,
                parcela.mov_recebimento_valor,
                pessoa.pessoa_nome
                 FROM sys_movimentacao_recebimento parcela
                 LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id
                 WHERE parcela.mov_recebimento_status = 1
                 AND parcela.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['mov_recebimento_id'],
                        "datar" => $Result['mov_recebimento_data_recebimento'],
                        "datav" => $Result['datav'],
                        "movimento" => $Result['mov_recebimento_movimento_id'],
                        "numero" => $Result['mov_recebimento_numero'],
                        "parcela" => $Result['mov_recebimento_parcela'],
                        "pessoa" => $Result['pessoa_nome'],
                        "tipo" => $Result['mov_recebimento_tipo_id'],
                        "valor" => number_format($Result['mov_recebimento_valor'], 2, ',', '.'),
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=contasreceber/ver_movimentacao_recebimento&id={$Result["mov_recebimento_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') ."</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;