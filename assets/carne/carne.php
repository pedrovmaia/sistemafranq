<?php
require '../../_app/Config.inc.php';

if (!$_POST['nome_empresa']) { $nome_empresa = ""; } else { $nome_empresa = addslashes($_POST['nome_empresa']); }
if (!$_POST['endereco_empresa']) { $endereco_empresa = ""; } else { $endereco_empresa = addslashes($_POST['endereco_empresa']); }
if (!$_POST['tel_empresa']) { $tel_empresa = ""; } else { $tel_empresa = addslashes($_POST['tel_empresa']); }
if (!$_POST['logo']) { $logo = ""; } else { $logo = addslashes($_POST['logo']); }
if (!$_POST['obs']) { $obs = ""; } else { $obs = addslashes($_POST['obs']); }
if (!$_POST['qtd']) { $qtd = ""; } else { $qtd = addslashes($_POST['qtd']); }

$hoje = date("d/m/Y");

$count_quebra_pg = 0;

if ($qtd > 212) { header("Location: index.php?error=qtd_limite"); }
if ($qtd == "") { header("Location: index.php?error=qtd_limite"); }
?>
<!DOCTYPE HTML>
<!-- SPACES 2 -->
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="Resource-type" content="document">
    <meta name="Robots" content="all">
    <meta name="Rating" content="general">
    <meta name="author" content="Gabriel Masson">
    <title>Carnê</title>
    <link href="img/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div class="bto">
    Ao Imprimir o carnê certifique-se se a impressão está ajustada à página
    <br>
    <br>
    <button class="btn-impress" onclick="window.print()">Imprimir</button>
    &nbsp;
    <?php echo "<a href=\"capa.php?endereco={$endereco_empresa}&tel={$tel_empresa}&logo={$logo}\" class=\"btn\" target=\"_blank\">
      Capa do carnê
    </a>"; ?>
    &nbsp;
    <button class="btn" onclick="window.history.back()">Voltar ao formulário</button>
  </div>

<?php

$Read = new Read;

for($i = 0; $i < $qtd; $i++){

    $Read->FullRead("SELECT mr.mov_recebimento_parcela as num_parcela, mr.mov_recebimento_id, MONTH(mr.mov_recebimento_data_vencimento) AS primeiromes, YEAR(mr.mov_recebimento_data_vencimento) AS primeiroano, mr.mov_recebimento_parcela, mr.mov_recebimento_valor AS valor, p.pessoa_nome AS nome, CONCAT(e.catalogo_endereco,', ',e.catalogo_numero, ', ', e.catalogo_bairro, ', ', e.catalogo_cidade, ' - ', e.catalogo_uf) AS endereco, p.pessoa_cpf AS cpf, mr.mov_recebimento_data_vencimento AS vence FROM sys_movimentacao AS m INNER JOIN sys_pessoas AS p ON m.movimentacao_pessoa_id = p.pessoa_id INNER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id INNER JOIN sys_movimentacao_recebimento AS mr ON m.movimentacao_id = mr.mov_recebimento_movimento_id WHERE m.movimentacao_origem_movimentacao = 1 AND mr.mov_recebimento_id = :id ORDER BY mr.mov_recebimento_parcela", "id={$_POST["parcela{$i}"]}");

    $nome = $Read->getResult()[0]['nome'];
    $endereco = $Read->getResult()[0]['endereco'];
    $cpf = $Read->getResult()[0]['cpf'];
    $valor = $Read->getResult()[0]['valor'];
    $vence = $Read->getResult()[0]['vence'];
    $primeiro_mes = $Read->getResult()[0]['primeiromes'];
    $primeiro_ano = $Read->getResult()[0]['primeiroano'];
    $num_parcela = $Read->getResult()[0]['num_parcela'];


    $ano_vence = $primeiro_ano;
    $mes_vence = $primeiro_mes - 1;
    $vence = date('d', strtotime($vence));

    if ($mes_vence == 12) {
        $ano_vence = $ano_vence + 1;
        $mes_vence = 1;
    } else {
        $mes_vence++;
    }

    echo "<!-- PARCELA -->
  <div class=\"parcela\">
    <div class=\"grid\">
      <div class=\"col4\">
        <div class=\"destaca\">
          <table width=\"100%\">
            <tr>
              <td>
                <small>Parcela</small>
                <br>{$num_parcela}
              </td>
            <td>
              <small>Valor</small>
              <br>".number_format($valor, "2", ",", ".")."
            </td>
            </tr>
            <tr>
              <td colspan=\"2\">
                <small>Vencimento</small>
                <br>{$vence}/{$mes_vence}/{$ano_vence}
              </td>
            </tr>
            <tr>
              <td colspan=\"2\">
                <small>Observações</small>
                <br><br><br><br>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class=\"col8\">
        <table width=\"100%\">
          <tr>
            <td colspan=\"2\">
              <small>Nome do cedente</small>
              <br>{$nome_empresa}
            </td>
            <td>
              <small>Parcela</small>
              <br>{$num_parcela}
            </td>
            <td>
              <small>Valor</small>
              <br>".number_format($valor, "2", ",", ".")."
            </td>
          </tr>
          <tr>
            <td>
              <small>Data do Documento</small>
              <br>{$hoje}
            </td>
            <td>
              <small>Tipo de Documento</small>
              <br>Carnê
            </td>
            <td colspan=\"2\">
              <small>Vencimento</small>
              <br>{$vence}/{$mes_vence}/{$ano_vence}
            </td>
          </tr>
          <tr>
            <td colspan=\"4\">
              <small>Todas as informações deste carnê são de responsabilidade do cedente</small>
              <br>{$obs}
            </td>
          </tr>
        </table>
        <div class=\"nome\">{$nome}, {$cpf}, {$endereco}</div>
      </div>
    </div>
  </div>";

    if (!$count_quebra_pg) { $count_quebra_pg = 0; } // Preenche Variavel
    $count_quebra_pg++; // contagem de loop
    if ($count_quebra_pg == 4) { // Adiciona quebra a cada 4 loops e zera a variavel
        echo "<div class=\"quebra-pagina\"></div>";
        $count_quebra_pg = 0;
    }

}
die;
/*if (!$_POST['nome']) { $nome = ""; } else { $nome = addslashes($_POST['nome']); }
if (!$_POST['endereco']) { $endereco = ""; } else { $endereco = addslashes($_POST['endereco']); }
if (!$_POST['cpf']) { $cpf = ""; } else { $cpf = addslashes($_POST['cpf']); }
if (!$_POST['valor']) { $valor = ""; } else { $valor = addslashes($_POST['valor']); }
if (!$_POST['vence']) { $vence = ""; } else { $vence = addslashes($_POST['vence']); }
if (!$_POST['primeiromes']) { $primeiro_mes = ""; } else { $primeiro_mes = addslashes($_POST['primeiromes']); }
if (!$_POST['primeiroano']) { $primeiro_ano = ""; } else { $primeiro_ano = addslashes($_POST['primeiroano']); }
$count = 1;*/


/*while ($count <= $qtd) {



  $count++;
}*/

?>

  </body>
</html>