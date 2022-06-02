<?php
if (empty($Read)):
  $Read = new Read;
endif;

$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id) {
    //EMPRESA
    $Read->FullRead("SELECT p.pessoa_nome, c.catalogo_endereco, c.catalogo_numero, c.catalogo_complemento, c.catalogo_bairro, c.catalogo_cidade, c.catalogo_uf, t.telefone FROM sys_pessoas AS p INNER JOIN sys_catalogo_endereco_pessoas AS c ON p.pessoa_id = c.pessoa_id INNER JOIN sys_telefones_pessoas AS t ON p.pessoa_id = t.pessoa_id WHERE p.pessoa_tipo_id = 7 AND p.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
    $Empresa = $Read->getResult()[0];

    //CLIENTE
    $Read->FullRead("SELECT p.pessoa_nome, e.catalogo_endereco, e.catalogo_numero, e.catalogo_bairro, e.catalogo_cidade, e.catalogo_uf, p.pessoa_cpf, m.movimentacao_emissao, m.movimentacao_dia_vencimento, m.movimentacao_valor_total, m.movimentacao_total_parcela FROM sys_movimentacao AS m INNER JOIN sys_pessoas AS p ON m.movimentacao_pessoa_id = p.pessoa_id INNER JOIN sys_catalogo_endereco_pessoas AS e ON p.pessoa_id = e.pessoa_id WHERE m.movimentacao_origem_movimentacao = 1 AND m.movimentacao_id = :id", "id={$Id}");
    $Cliente = $Read->getResult()[0];

} else {
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
}
?>
<div class="content">
  
     <div id="informacoes_basicas" class="border_shadow" style="padding: 15px; background-color: #fff">

    <div class="site-index">
        <div class="body-content">

            <div class="row">
                <div class="col-lg-12">
                    SUCESSO AO REALIZAR MATRÍCULA
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg"><i class="far fa-newspaper"></i> GERAR CONTRATO</button>

                        <form target="_blank" class="btn-group" action="<?= BASE ?>/assets/carne/carne.php" method="POST">
                            <input type="hidden" name="nome_empresa" value="<?= addslashes($Empresa['pessoa_nome']) ?>" />
                            <input type="hidden" name="endereco_empresa" value="<?= addslashes($Empresa['catalogo_endereco'] . ", " . $Empresa['catalogo_numero'] . ", " . $Empresa['catalogo_bairro'] . ", " . $Empresa['catalogo_cidade'] . " - " . $Empresa['catalogo_uf']) ?>" />
                            <input type="hidden" name="tel_empresa" value="<?= addslashes($Empresa['telefone']) ?>" />
                            <input type="hidden" name="logo" value="<?= BASE ?>/assets/carne/img/logo.svg" />
                            <input type="hidden" name="obs" value="Após vencimento cobrar multa de R$ 2,00 e Juros de 1% ao mês" />

                            <input type="hidden" name="nome" value="<?= $Cliente["pessoa_nome"] ?>" />
                            <input type="hidden" name="endereco" value="<?= addslashes($Cliente['catalogo_endereco'] . ", " . $Cliente['catalogo_numero'] . ", " . $Cliente['catalogo_bairro'] . ", " . $Cliente['catalogo_cidade'] . " - " . $Cliente['catalogo_uf']) ?>" />
                            <input type="hidden" name="cpf" value="<?= $Cliente["pessoa_cpf"] ?>" />
                            <input type="hidden" name="valor" value="R$<?= number_format($Cliente["movimentacao_valor_total"] / $Cliente["movimentacao_total_parcela"], 2, ",", ".") ?>" />
                            <input type="hidden" name="qtd" value="<?= $Cliente["movimentacao_total_parcela"] ?>" />
                            <input type="hidden" name="vence" value="<?= $Cliente["movimentacao_dia_vencimento"] ?>" />
                            <input type="hidden" name="primeiromes" value="<?= date('m', strtotime($Cliente["movimentacao_emissao"])) ?>" />
                            <input type="hidden" name="primeiroano" value="<?= date('Y', strtotime($Cliente["movimentacao_emissao"])) ?>" />

                            <button class="btn btn-primary btn-lg">
                                <i class="fas fa-file-invoice-dollar"></i> GERAR CARNÊ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    </div>

    ID FUNCIONALIDADE: <?= ESCOLA_CURSO ?>
</div>
