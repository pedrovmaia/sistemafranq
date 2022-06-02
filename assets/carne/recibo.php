<?php
require '../../_app/Config.inc.php';

if (!$_POST['nome_empresa']) { $nome_empresa = ""; } else { $nome_empresa = addslashes($_POST['nome_empresa']); }
if (!$_POST['endereco_empresa']) { $endereco_empresa = ""; } else { $endereco_empresa = addslashes($_POST['endereco_empresa']); }
if (!$_POST['cidade_empresa']) { $cidade_empresa = ""; } else { $cidade_empresa = addslashes($_POST['cidade_empresa']); }
if (!$_POST['tel_empresa']) { $tel_empresa = ""; } else { $tel_empresa = addslashes($_POST['tel_empresa']); }
if (!$_POST['cnpj_empresa']) { $cnpj_empresa = ""; } else { $cnpj_empresa = addslashes($_POST['cnpj_empresa']); }
if (!$_POST['logo']) { $logo = ""; } else { $logo = addslashes($_POST['logo']); }
if (!$_POST['descricao']) { $descricao = ""; } else { $descricao = addslashes($_POST['descricao']); }
if (!$_POST['obs']) { $obs = ""; } else { $obs = addslashes($_POST['obs']); }
if (!$_POST['aluno']) { $aluno = ""; } else { $aluno = addslashes($_POST['aluno']); }
if (!isset($_POST['tipo'])) { $tipo = ""; } else { $tipo = addslashes($_POST['tipo']); }
if (!isset($_POST['turma_nome'])) { $turma_nome = ""; } else { $turma_nome = addslashes($_POST['turma_nome']); }
if (!isset($_POST['forma_nome'])) { $forma_nome = "Dinheiro"; } else { $forma_nome = addslashes($_POST['forma_nome']); }
if (!$_POST['mov_recebimento_id']) { $mov_recebimento_id = ""; } else { $mov_recebimento_id = addslashes($_POST['mov_recebimento_id']); }
if (!$_POST['parcela']) { $parcela = ""; } else { $parcela = addslashes($_POST['parcela']); }
if (!$_POST['total_parcela']) { $total_parcela = ""; } else { $total_parcela = addslashes($_POST['total_parcela']); }
if (!$_POST['endereco']) { $endereco = ""; } else { $endereco = addslashes($_POST['endereco']); }
//if (!$_POST['cpf']) { $cpf = ""; } else { $cpf = addslashes($_POST['cpf']); }
if (!$_POST['valor']) { $valor = ""; } else { $valor = addslashes($_POST['valor']); }
if (!$_POST['valorpago']) { $valorpago = ""; } else { $valorpago = addslashes($_POST['valorpago']); }
if (!$_POST['qtd']) { $qtd = ""; } else { $qtd = addslashes($_POST['qtd']); }
if (!$_POST['vencimento']) { $vencimento = ""; } else { $vencimento = addslashes($_POST['vencimento']); }
if (!$_POST['primeiromes']) { $primeiro_mes = ""; } else { $primeiro_mes = addslashes($_POST['primeiromes']); }
if (!$_POST['primeiroano']) { $primeiro_ano = ""; } else { $primeiro_ano = addslashes($_POST['primeiroano']); }
$hoje = date("d/m/Y");
$count_quebra_pg = 0;
if ($qtd > 212) { header("Location: index.php?error=qtd_limite"); }

$nome_tela = "";
$nomes = explode(";", $forma_nome);
foreach ($nomes as $nome) {
    if(!empty($nome)){
        $divide = explode("-", $nome);
        $nome_tela .= "<br>{$divide[0]}: <b>";

        if(isset($divide[1])){
            $nome_tela .= "R$ " . number_format($divide[1], '2', ',', '.') . "</b>";
        } else {
            $nome_tela .= "R$ " . number_format($valorpago, '2', ',', '.') . "</b>";
        }
    }
}
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
    <title>Recibo de Pagamento</title>
    <link href="img/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="css/style_recibo.css" rel="stylesheet" type="text/css">
  </head>
  <body>
      <table width="800">
      <tbody>
      <tr>
      <td colspan="2">
      <table style="width: 800px;">
      <tbody>
      <tr>
      <td style="width: 308px;"><img src="http://www.knnidiomas.gestaoderedes.com.br/web/Styles/KnnIdiomas/logo.png" width="130" height="67" /></td>
     </tr>
     <tr>      
      <td style="width: 233px;"><strong>RECIBO N&ordm;&nbsp;<?php echo $mov_recebimento_id ?></strong></td>
      <td style="width: 340px;"><strong>Vencimento <?php echo $vencimento ?> (parcela: <?php echo $parcela ?>/<?php echo $total_parcela ?>)</strong></td>
      <td style="width: 137px;"><strong>R$ <?= number_format($valorpago, "2", ",", ".") ?></strong></td>
      </tr>
      </tbody>
      </table>
      </td>
      </tr>
      </tbody>
      </table>
      <table width="800" cellspacing="0">
      <tbody>
      <tr>
      <td colspan="2">Recebemos de&nbsp;<strong><?php echo $aluno ?></strong>&nbsp;, Turma&nbsp;<strong><?php echo $turma_nome ?></strong>, em <?php echo $hoje ?> a quantia de&nbsp;<strong><?php echo clsTexto::valorPorExtenso(number_format($valorpago, "2", ",", "."), true, false);?></strong>&nbsp;referente ao <?php if ($tipo == 1) { echo 'curso';} else { echo 'material';}  ?><strong> <?php echo $descricao?></strong></td>
      </tr>
      <tr>
      </tr>
      </tbody>
      </table>
      <table width="800" cellspacing="0">
      <tbody>
      <tr>
      <td colspan="2">
      <div>
      <div><center>
      </center></div>
      </div>
      </td>
      </tr>
      </tbody>
      </table>
      <table width="800">
      <tbody>
      <tr>
      <td>
      <table cellspacing="1" cellpadding="1">
      <tbody>
      <tr>
      <td>Forma de Pagamento</td>
      </tr>
      <tr>
      <td><?php echo $nome_tela ?></td>
       <td style="width: 550px; text-align: right;">&nbsp; _______________________________  <?php echo $cidade_empresa ?>, <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); date_default_timezone_set('America/Sao_Paulo'); echo utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));?></td>
      </tr>
       </tbody>
      </table> 
      </td>
      </tr>
      </tbody>
      </table>
      <table width="700">
      <tbody>
      <tr>
      <td style="text-align: center;"><?php echo $nome_empresa ?> CNPJ:&nbsp;<?php echo $cnpj_empresa ?></td>
      </tr>
      </tbody>
      </table>
      <p>&nbsp;</p>
  </body>
</html>