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
                      caixa.transacao_caixa_id,
                      caixa.transacao_caixa_descricao,
                      DATE_FORMAT( caixa.transacao_caixa_data,'%d/%m/%Y') AS transacao_caixa_data ,
                      caixa.transacao_caixa_hora,
                      caixa.transacao_caixa_valor,
                      caixa.transacao_conta_id,
                      caixa.transacao_caixa_tipo_id,
                      caixa.transacao_caixa_tipo_parcela AS tipo_parcela,
                      CASE
                        WHEN caixa.transacao_caixa_tipo_id = 1 THEN 'Entrada'
                        ELSE 'Saida'
                        END AS tipo,
                                            
                      pessoa.pessoa_nome,
                      forma.forma_pagamento_nome,
                      caixa.transacao_caixa_caixa_id,
                      caixa.unidade_id
                      FROM sys_transacao_caixa caixa
                      LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = caixa.transacao_caixa_aluno_id
                      LEFT OUTER JOIN sys_forma_pagamento forma  ON forma.forma_pagamento_id = caixa.transacao_caixa_forma
                      WHERE caixa.unidade_id  = {$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

              $color = '';

              if($Result['tipo'] == "Saida") {

                  $color = 'red';

              }

              $tipo_parcela = '';

              if($Result['tipo_parcela'] == 1) {                
                $tipo_parcela = 'Parcial';
              }else if($Result['tipo_parcela'] == 2 || $Result['tipo'] == 'Entrada'){
                 $tipo_parcela = 'Integral';
              }

                array_push($arr, array(
                        "id" => "<span style='color: ".$color."'>".$Result['transacao_caixa_id']."</span",
                        "descricao" => "<span style='color: ".$color."'>".$Result['transacao_caixa_descricao']."</span>",
                        "tipoParcela" => "<span style='color: ".$color."'>".$tipo_parcela."</span>",
                        "data" => "<span style='color: ".$color."'>".$Result['transacao_caixa_data']."</span>",
                        "hora" => "<span style='color: ".$color."'>".$Result['transacao_caixa_hora']."</span>",
                        "valor" => "<span style='color: ".$color."'>".'R$ ' . number_format($Result['transacao_caixa_valor'], 2, ',', '.')."</span>",
                        "conta" => "<span style='color: ".$color."'>".$Result['transacao_conta_id']."</span>",
                        "tipo" => "<span style='color: ".$color."'>".$Result['tipo']."</span>",
                        "pessoa" => "<span style='color: ".$color."'>".$Result['pessoa_nome']."</span>",
                        "forma" => "<span style='color: ".$color."'>".$Result['forma_pagamento_nome']."</span>",
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=financeiro/ver_transacao_caixa&id={$Result["transacao_caixa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') ."</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;