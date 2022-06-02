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

        //EMPRESA
        $Read->FullRead("SELECT p.pessoa_nome, c.catalogo_endereco, c.catalogo_numero, c.catalogo_complemento, c.catalogo_bairro, c.catalogo_cidade, c.catalogo_uf, t.telefone FROM sys_pessoas AS p INNER JOIN sys_catalogo_endereco_pessoas AS c ON p.pessoa_id = c.pessoa_id INNER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id WHERE p.pessoa_tipo_id = 7 AND p.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
        $Empresa = $Read->getResult()[0];

        //CLIENTE
        $Read->FullRead("SELECT p.pessoa_nome, e.catalogo_endereco, e.catalogo_numero, e.catalogo_bairro, e.catalogo_cidade, e.catalogo_uf, p.pessoa_cpf, m.movimentacao_dia_vencimento, m.movimentacao_valor_total, m.movimentacao_total_parcela, m.movimentacao_id, m.movimentacao_emissao FROM sys_movimentacao AS m INNER JOIN sys_pessoas AS p ON m.movimentacao_pessoa_id = p.pessoa_id INNER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id WHERE m.movimentacao_origem_movimentacao = 1 AND m.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Result){

                $botao = "<form target='_blank' class='btn-group' action='" . BASE . "/assets/carne/carne.php' method='POST'>
                <input type='hidden' name='nome_empresa' value='" . $Empresa['pessoa_nome'] . "' />
                <input type='hidden' name='endereco_empresa' value='" . $Empresa['catalogo_endereco'] . ", " . $Empresa['catalogo_numero'] . ", " . $Empresa['catalogo_bairro'] . ", " . $Empresa['catalogo_cidade'] . " - " . $Empresa['catalogo_uf'] . "' />
                <input type='hidden' name='tel_empresa' value='" . $Empresa['telefone'] . "' />
                <input type='hidden' name='logo' value='" . BASE . "/assets/carne/img/logo.svg' />
                <input type='hidden' name='obs' value='Após vencimento cobrar multa de R$ 2,00 e Juros de 1% ao mês' />

                <input type='hidden' name='nome' value='" . $Result['pessoa_nome'] . "' />
                <input type='hidden' name='endereco' value='" . $Result['catalogo_endereco'] . ", " . $Result['catalogo_numero'] . ", " . $Result['catalogo_bairro'] . ", " . $Result['catalogo_cidade'] . " - " . $Result['catalogo_uf'] . "' />
                <input type='hidden' name='cpf' value='" . $Result['pessoa_cpf'] . "' />
                <input type='hidden' name='valor' value='R$" . number_format($Result['movimentacao_valor_total'], 2, ',', '.') . "' />
                <input type='hidden' name='qtd' value='" . $Result['movimentacao_total_parcela'] . "' />
                <input type='hidden' name='vence' value='" . $Result['movimentacao_dia_vencimento'] . "' />
                <input type='hidden' name='primeiromes' value='" . date('m', strtotime($Result["movimentacao_emissao"])) . "' />
                <input type='hidden' name='primeiroano' value='" . date('Y', strtotime($Result["movimentacao_emissao"])) . "' />
                <button class='btn btn-primary btn-lg btn-link'>
                <i class='material-icons'>credit_card</i>
                </button>
                </form>";

                array_push($arr, array(
                        "id" => $Result['movimentacao_id'],
                        "nome" => $Result['pessoa_nome'],
                        "cpf" => $Result['pessoa_cpf'],
                        "data" => date('d/m/Y',strtotime($Result['movimentacao_emissao'])) ,
                        "valor" => 'R$ ' . number_format($Result['movimentacao_valor_total'], 2, ',', '.') ,
                        "acoes" => "<span class='td-actions'>" . $botao . "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;