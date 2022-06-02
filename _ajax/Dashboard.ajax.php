<?php

session_start();
require '../_app/Config.inc.php';
usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Dashboard';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):
    //PREPARA OS DADOS
    $Case = $PostData['callback_action'];
    unset($PostData['callback'], $PostData['callback_action']);

    // AUTO INSTANCE OBJECT READ
    if (empty($Read)):
        $Read = new Read;
    endif;

    // AUTO INSTANCE OBJECT CREATE
    if (empty($Create)):
        $Create = new Create;
    endif;

    // AUTO INSTANCE OBJECT UPDATE
    if (empty($Update)):
        $Update = new Update;
    endif;

    // AUTO INSTANCE OBJECT DELETE
    if (empty($Delete)):
        $Delete = new Delete;
    endif;

    //SELECIONA AÇÃO
    switch ($Case):

        case 'mensagens':
            $Read->FullRead("SELECT o.*, count(o.ocorrencia_id) as total, n.ocorrencias_natureza_nome FROM sys_ocorrencia AS o INNER JOIN sys_ocorrencias_natureza AS n  ON n.ocorrencia_natureza_id = o.ocorrencia_natureza_id WHERE o.ocorrencia_encaminha_id = :id AND o.ocorrencia_status = 0", "id={$_SESSION['userSYSFranquia']["pessoa_id"]}");
            $jSON['num_mensagens'] = $Read->getResult()[0]['total'];

            $mensagem_real = '<div class="list_notificacoes_msg_novas">';
            if ($Read->getResult()):
                foreach($Read->getResult() as $MensagensHeader) {
                    $mensagem_real .= '<a class="dropdown-item j_abrir_modal_ocorrencia" rel="'.$MensagensHeader['ocorrencia_id'].'" href="#"><div>';
                    $mensagem_real .= "<div class='text-truncate2'>Natureza: " . Check::Words($MensagensHeader["ocorrencias_natureza_nome"], 15) . "<br>Descrição: " . Check::Words($MensagensHeader["ocorrencia_descricao"], 15) . "</div>";
                    $mensagem_real .= "<div class='small text-gray-500'>" . date('d-m-Y', strtotime($MensagensHeader['ocorrencia_data'])) . "</div>";
                    $mensagem_real .= "</div></a>";
                }
            else:
                $mensagem_real .= "Sem mensagens a ser exibidas!!!";
            endif;

            $jSON['novas_mensagens'] = $mensagem_real . "</div>";

            break;

        case 'listmensagens':

            $Read->FullRead("SELECT M.escola_mensagem_date, M.escola_mensagem_conteudo, M.escola_mensagem_titulo FROM escola_mensagem_leitura AS L INNER JOIN escola_mensagem AS M ON L.escola_mensagem_leitura_mensagem_id = M.escola_mensagem_id WHERE escola_mensagem_leitura_lido != 1 AND escola_mensagem_leitura_funcionario_id = :id", "id={$_SESSION['userPortalKNN']["pessoa_id"]}");
            $mensagem_list = '<div class="list_notificacoes_msg_novas">';
            if ($Read->getResult()):
                foreach($Read->getResult() as $MensagensHeader) {
                    $mensagem_list .= '<a class="dropdown-item d-flex align-items-center msg_list_single" href="painel.php?exe=mensagens/home"><div>';
                    $mensagem_list .= "<div class='text-truncate2'>" . Check::Words($MensagensHeader["escola_mensagem_conteudo"], 15) . "</div>";
                    $mensagem_list .= "<div class='small text-gray-500'>" . date('d-m-Y H:i:s', strtotime($MensagensHeader['escola_mensagem_date'])) . "</div>";
                    $mensagem_list .= "</div></a>";
                }
                $mensagem_list .= "<a class='dropdown-item text-center small text-gray-500' href='painel.php?exe=mensagens/home'>Ler mensagens</a>";
            else:
                $mensagem_list .= "Sem mensagens a ser exibidas!!!";
            endif;

            $jSON['novas_mensagens'] = $mensagem_list . "</div>";

            break;
    endswitch;

    //RETORNA O CALLBACK
    if ($jSON):
        echo json_encode($jSON);
    else:
        $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Desculpe. Mas uma ação do sistema não respondeu corretamente. Ao persistir, contate o desenvolvedor!', E_USER_ERROR);
        echo json_encode($jSON);
    endif;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;