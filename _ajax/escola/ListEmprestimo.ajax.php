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

          $Read->FullRead("SELECT emprestimo.emprestimo_id,
            emprestimo.emprestimo_data_reserva,
            emprestimo.emprestimo_data_entrega,
            pessoa.pessoa_nome,
            acervo.acervo_titulo
            FROM sys_emprestimo_acervo emprestimo
            LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = emprestimo.emprestimo_pessoa_id
            LEFT OUTER JOIN sys_acervo acervo ON acervo.acervo_id = emprestimo.emprestimo_acervo_id
            WHERE emprestimo.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
          $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['emprestimo_id'],
                        "acervo" => $Result['acervo_titulo'],
                        "datar" => date('d/m/Y', strtotime($Result['emprestimo_data_reserva'])),
                        "datae" => date('d/m/Y', strtotime($Result['emprestimo_data_entrega'])),  
                        "pessoa" => $Result['pessoa_nome'],       
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=biblioteca/ver_emprestimo_acervo&id={$Result["emprestimo_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=biblioteca/cadastro_emprestimo_acervo&id={$Result["emprestimo_id"]}&idbiblioteca={$Result["emprestimo_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Emprestimo' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["emprestimo_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
         }
        
        break;
endswitch;