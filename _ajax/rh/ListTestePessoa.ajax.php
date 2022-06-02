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

        $Read->FullRead("SELECT teste.testes_pessoa_id ,
             DATE_FORMAT(teste.testes_pessoa_data,'%d/%m/%Y') AS data ,
                       teste.testes_pessoa_hora,
                       teste.testes_pessoa_duracao,
             DATE_FORMAT(teste.testes_pessoa_data_realizada,'%d/%m/%Y') AS data_realizada,                       
                       teste.testes_pessoa_observacao,
                       teste.teste_pessoa_situacao,
                       produto.produto_nome,
                       tipo.tipo_teste_nivel_nome,
                       situacao.situacao_nome,
                       funcionario.pessoa_nome AS funcionario
                 FROM sys_testes_pessoa teste
                 LEFT OUTER JOIN sys_tipo_teste_nivel tipo ON tipo.tipo_teste_nivel_id = teste.teste_pessoa_tipo_id
                 LEFT OUTER JOIN sys_situacao_pessoa situacao ON situacao.situacao_id = teste.teste_pessoa_situacao
                 LEFT OUTER JOIN sys_produto produto ON produto.produto_id = teste.teste_pessoa_produto_id
                 LEFT OUTER JOIN sys_pessoas funcionario ON funcionario.pessoa_id = teste.testes_pessoa_responsavel_id");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['testes_pessoa_id'],
                        "responsavel" => $Result['funcionario'],
                        "tipo" => $Result['tipo_teste_nivel_nome'],
                        "data" => $Result['data'],
                        "datar" => $Result['data_realizada'],
                        "horario" => $Result['testes_pessoa_hora'],
                        "duracao" => $Result['testes_pessoa_duracao'],
                        "situacao" => $Result['situacao_nome'],
                        "observacao" => $Result['testes_pessoa_observacao'],
                        "curso" => $Result['produto_nome'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=rh/ver_teste_pessoa&id={$Result["testes_pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " " .  "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;