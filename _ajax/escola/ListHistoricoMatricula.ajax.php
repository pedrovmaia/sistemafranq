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
    $Id = $PostData["id"];
        if($Id){

        $arr = array();

        $Read->FullRead("SELECT 
                 matricula.matricula_id,
                 DATE_FORMAT( matricula.matricula_data,'%d/%m/%Y') AS data_matricula ,
                 matricula.matricula_valor_total,
                 funcionario.pessoa_nome as consultor_vendas,
                 patrocinador.patrocionador_nome,
                  CASE
                    WHEN matricula.matricula_status = 0 THEN 'Concluída'
                    ELSE 'Cancelada'
                    END AS matricula_status
                 FROM sys_matriculas matricula
                 LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = matricula.matricula_funcionario_id
                 LEFT OUTER JOIN sys_patrocinadores patrocinador ON patrocinador.patrocionador_id = matricula.matricula_patrocinador_id
                 WHERE matricula.matricula_cliente_id = :id", "id={$Id}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['matricula_id'],
                        "data" => $Result['data_matricula'],
                        "valor" => number_format($Result['matricula_valor_total'], 2, ',', '.'),
                        "funcionario" => $Result['consultor_vendas'],
                        "status" => $Result['matricula_status'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=pedidos/matricula/ver_pedido&id={$Result["matricula_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;