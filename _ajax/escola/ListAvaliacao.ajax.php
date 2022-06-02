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

        $Read->FullRead("SELECT avaliacao.avaliacao_formula,
                       avaliacao.avaliacao_nome,
                       avaliacao.avaliacao_id,
                       avaliacao.avaliacao_codigo,
                       etapa.etapa_produto_nome,
                       tipo.tipo_avaliacao_nome,
                       nota.formulacao_nota_nome
                 FROM sys_avaliacoes avaliacao
                 LEFT OUTER JOIN sys_etapa_produto  etapa ON etapa.etapa_produto_id = avaliacao.avaliacao_etapa_id
                 LEFT OUTER JOIN sys_tipos_avaliacao  tipo ON tipo.tipo_avaliacao_id = avaliacao.avaliacao_tipo_avaliacao_id
                 LEFT OUTER JOIN sys_formulacao_nota  nota ON nota.formulacao_nota_id = avaliacao.avaliacao_tipo_nota_id  WHERE avaliacao.unidade_id = :unidade AND avaliacao.estagio_id = :id GROUP BY avaliacao.avaliacao_id", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                array_push($arr, array(
                        "id" => $Result['avaliacao_id'],
                        "nome" => $Result['avaliacao_nome'],
                        "codigo" => $Result['avaliacao_codigo'],
                        "etapa" => $Result['etapa_produto_nome'],
                        "tipo" => $Result['tipo_avaliacao_nome'],
                        "tiponota" => $Result['formulacao_nota_nome'],
                        "formula" => $Result['avaliacao_formula'],
                        "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/ver_avaliacao&id={$Result["avaliacao_id"]}' title='Ver' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>visibility</i></a>" : '') . " " . ($_SESSION['permissao']['alterar'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/admin/cadastro_avaliacao&id={$Result["avaliacao_id"]}' title='Editar' class='btn btn-primary btn-link mr-1 '><i class='material-icons'>mode_edit</i></a>" : '') . " " . ($_SESSION['permissao']['deletar'] == 1 ? "<span rel='tooltip' title='Deletar' rel='single_user_addr' callback='escola/Avaliacao' action='delete' class='j_delete_action_confirm btn btn-primary btn-link' id='{$Result["avaliacao_id"]}'><i class='material-icons''>delete</i></span>" : '') . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
    }
        break;
endswitch;