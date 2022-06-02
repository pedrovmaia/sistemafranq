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
    $Email = new Email;
    $trigger = new Trigger;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;

switch ($action):

    case 'list':

        $arr = array();

        //$Read->ExeRead("sys_projetos", "WHERE 1=1");
        $Read->FullRead("SELECT matricula.matricula_id,
                   DATE_FORMAT(matricula.matricula_data, '%d/%m/%Y') AS matricula_data,
                   matricula.matricula_total_parcela,
                   matricula.matricula_valor_total,
                   matricula.matricula_recorrencia,
                   matricula.matricula_observacao,
                   matricula.matricula_valor_entrada,
                   matricula.matricula_status,
                   forma.forma_parcelamento_nome,
                   cliente.pessoa_nome as cliente_nome,
                   funcionario.pessoa_nome as funcionario_nome,
                   convenio.convenio_nome,
                   unidades.unidade_nome
                   FROM sys_matriculas matricula
                     LEFT OUTER JOIN sys_pessoas cliente ON cliente.pessoa_id = matricula.matricula_cliente_id
                     LEFT OUTER JOIN sys_forma_parcelamento  forma ON forma.forma_parcelamento_id = matricula.matricula_forma_parcelamento_id
                     LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = matricula.matricula_funcionario_id
                     LEFT OUTER JOIN sys_convenio convenio ON convenio.convenio_id = matricula.matricula_convenio_id
                     LEFT OUTER JOIN sys_unidades unidades ON unidades.unidade_id = matricula.unidade_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['matricula_id'],
                        "data" => $Result['matricula_data'],
                        "unidade" => $Result['unidade_nome'],
                        "totalparcela" => $Result['matricula_total_parcela'],
                        "status" => $Result['matricula_status'],
                        "valor" => number_format($Result['matricula_valor_total'], 2, ',', '.'),
                        "recorrencia" => $Result['matricula_recorrencia'],
                        "observacao" => $Result['matricula_observacao'],
                        "valore" => number_format($Result['matricula_valor_entrada'], 2, ',', '.'),
                        "forma" => $Result['forma_parcelamento_nome'],
                        "cliente" => $Result['cliente_nome'],
                        "funcionario" => $Result['funcionario_nome'],
                        "convenio" => $Result['convenio_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/matricula/ver_pedido&id={$Result["matricula_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;