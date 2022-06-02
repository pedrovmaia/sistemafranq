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

        $Read->FullRead("SELECT p.projeto_produto_id, p.projeto_id, p.projeto_descricao, p.projeto_gerente_id, p.projeto_modalidade_id, professor.pessoa_nome FROM sys_projetos AS p LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = p.projeto_gerente_id WHERE projeto_status = 0 and p.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){
                array_push($arr, array(
                        "id" => $Result['projeto_id'],
                        "nome" => $Result['projeto_descricao'],
                        "professor" => $Result['pessoa_nome'],
                        "modalidade_id" => $Result['projeto_modalidade_id'],
                        "produto_id" => $Result['projeto_produto_id']
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;

    case 'list_matricula':

        $arr = array();
        $Id = $PostData['id'];

        if($Id){
            $retorno = [];
            $Ids = explode(";", $Id);
            foreach ($Ids as $es) {
                if($es != ""){
                    $Read->FullRead("SELECT p.projeto_produto_id, p.projeto_id, p.projeto_descricao, p.projeto_gerente_id, p.projeto_modalidade_id, professor.pessoa_nome FROM sys_projetos AS p LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = p.projeto_gerente_id WHERE projeto_status = 0 and p.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']} AND projeto_produto_id = {$es}");
                    if($Read->getResult()){
                        $retorno = array_merge($retorno, $Read->getResult());
                    }
                }
            }

            if(count($retorno) > 0){
                $manage['total'] = count($retorno);
                foreach ($retorno as $Result){
                    array_push($arr, array(
                            "id" => $Result['projeto_id'],
                            "nome" => $Result['projeto_descricao'],
                            "professor" => $Result['pessoa_nome'],
                            "modalidade_id" => $Result['projeto_modalidade_id'],
                            "produto_id" => $Result['projeto_produto_id']
                        )
                    );
                }
                $manage['rows'] = $arr;
                echo json_encode($manage);
            }

        }

        break;
endswitch;