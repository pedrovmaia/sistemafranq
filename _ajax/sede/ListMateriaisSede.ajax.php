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

            $Read->FullRead("SELECT produto.produto_id,
                       produto.produto_nome,
                       produto.produto_valor_venda,
                       produto.produto_valor_custo,
                       unidade.unidade_nome
                 FROM sys_produto produto
                 LEFT OUTER JOIN sys_unidades unidade ON unidade.unidade_id = produto.unidade_id
                 WHERE produto.produto_categoria_id = 4
                 AND produto.produto_status = 0");
            if($Read->getResult()){
                $manage['total'] = $Read->getRowCount();
                foreach ($Read->getResult() as $Result){

                    array_push($arr, array(
                            "id" => $Result['produto_id'],
                            "nome" => $Result['produto_nome'],
                            "unidade" => $Result['unidade_nome'],
                            "custo" => number_format($Result['produto_valor_venda'], 2, ',', '.'),
                            "venda" => number_format($Result['produto_valor_venda'], 2, ',', '.'),
                            "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=produtos/produto/ver_produto&id={$Result["produto_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " ."</span>"
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }
        
        break;
endswitch;