<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-1">
                               <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                            </div>
                            <div class="col-md-10 text-center">
                                <h4 class="card-title"><?= $texto['PREVCONT'] ?></h4>
                                <p class="card-category"><?= $texto['VerCONTRACi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".DOCUMENTOS_CONTRATO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->FullRead("SELECT mc.modelo_contrato_texto FROM sys_contratos AS c INNER JOIN sys_modelo_contrato AS mc ON c.contrato_modelo_id = mc.modelo_contrato_id WHERE c.contrato_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    extract($Read->getResult()[0]);
                    $Read->FullRead("SELECT c.contrato_id, aluno.pessoa_responsavel_financeiro_id, aluno.pessoa_id, aluno.pessoa_nome, aluno.pessoa_nascimento, aluno.pessoa_cpf, aluno.pessoa_rg, aluno.pessoa_email, endereco_aluno.catalogo_uf,
endereco_aluno.catalogo_endereco, endereco_aluno.catalogo_bairro, endereco_aluno.catalogo_cidade, endereco_aluno.catalogo_cep,
unidade.pessoa_nome AS escola, aluno_financeiro.pessoa_nome AS financeiro_nome, aluno_financeiro.pessoa_nascimento AS financeiro_nascimento,
aluno_financeiro.pessoa_cpf AS financeiro_cpf, aluno_financeiro.pessoa_rg AS financeiro_rg, aluno_financeiro.pessoa_email AS financeiro_email,
aluno_financeiro.pessoa_profissao AS financeiro_profissao, aluno.pessoa_profissao, endereco_financeiro.catalogo_endereco AS financeiro_endereco,
endereco_financeiro.catalogo_bairro AS financeiro_bairro, endereco_financeiro.catalogo_cep AS financeiro_cep, endereco_financeiro.catalogo_cidade AS financeiro_cidade,
endereco_financeiro.catalogo_uf AS financeiro_uf,
produto.produto_nome AS curso_nome,
periodo.periodo_letivo_descricao AS periodo_letivo,
modalidade.modalidade_nome AS modalidade,
m.matricula_data AS data_matricula
FROM sys_matriculas AS m 
INNER JOIN sys_contratos AS c ON m.matricula_id = c.matricula_id
INNER JOIN sys_pessoas AS aluno ON m.matricula_cliente_id = aluno.pessoa_id
INNER JOIN sys_catalogo_endereco_pessoas AS endereco_aluno ON aluno.pessoa_id = endereco_aluno.pessoa_id
INNER JOIN sys_pessoas AS unidade ON aluno.unidade_id = unidade.pessoa_id
LEFT OUTER JOIN sys_pessoas AS aluno_financeiro ON aluno.pessoa_responsavel_financeiro_id = aluno_financeiro.pessoa_id
LEFT OUTER JOIN sys_catalogo_endereco_pessoas AS endereco_financeiro ON aluno_financeiro.pessoa_id = endereco_financeiro.pessoa_id
INNER JOIN sys_produto AS produto ON produto.produto_id = m.matricula_curso_id
INNER JOIN sys_projetos AS turma ON turma.projeto_id = m.matricula_turma_id
INNER JOIN sys_periodo_letivo AS periodo ON periodo.periodo_letivo_id = turma.projeto_periodo_id
INNER JOIN sys_modalidades AS modalidade ON modalidade.modalidade_id = turma.projeto_modalidade_id
WHERE c.contrato_id = :id", "id={$Id}");
                    if($Read->getResult()){
                        $ResultadoContrato = $Read->getResult()[0];
                    } else {
                        die("<br><br>Não existe!!!!");
                    }
                    ?>
                     <form class="form_contrato">
                          <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                              <div class="row">
                                  <div class="col-md-12">
                                    <?php

                                    $TelefoneCelularAluno = "";
                                    $TelefoneComercialAluno = "";
                                    $TelefoneResidencialAluno = "";

                                    $Read->FullRead("SELECT tipo_telefone, telefone FROM sys_telefones_pessoas WHERE pessoa_id = :id", "id={$ResultadoContrato["pessoa_id"]}");
                                    if($Read->getResult()) {

                                        foreach($Read->getResult() as $Telefone) {

                                            if($Telefone['tipo_telefone'] == "Fixo"){

                                                $TelefoneResidencialAluno = $Telefone['telefone'];

                                            } elseif($Telefone['tipo_telefone'] == "Celular"){

                                                $TelefoneCelularAluno = $Telefone['telefone'];

                                            } elseif($Telefone['tipo_telefone'] == "Comercial"){

                                                $TelefoneComercialAluno = $Telefone['telefone'];

                                            }

                                        }

                                    }

                                    if(!empty($ResultadoContrato["financeiro_nome"])){
                                        $NomeResponsavelFinanceiro = $ResultadoContrato["financeiro_nome"];
                                    } else {
                                        $NomeResponsavelFinanceiro = $ResultadoContrato["pessoa_nome"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_nascimento"])){
                                        $DataNascimentoResponsávelFinanceiro = date('d/m/Y', strtotime($ResultadoContrato["financeiro_nascimento"]));
                                    } else {
                                        $DataNascimentoResponsávelFinanceiro = date('d/m/Y', strtotime($ResultadoContrato["pessoa_nascimento"]));
                                    }

                                    if(!empty($ResultadoContrato["financeiro_cpf"])){
                                        $CPFRNEResponsávelFinanceiro = $ResultadoContrato["financeiro_cpf"];
                                    } else {
                                        $CPFRNEResponsávelFinanceiro = $ResultadoContrato["pessoa_cpf"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_rg"])){
                                        $RGResponsávelFinanceiro = $ResultadoContrato["financeiro_rg"];
                                    } else {
                                        $RGResponsávelFinanceiro = $ResultadoContrato["pessoa_rg"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_email"])){
                                        $EmailResponsávelFinanceiro = $ResultadoContrato["financeiro_email"];
                                    } else {
                                        $EmailResponsávelFinanceiro = $ResultadoContrato["pessoa_email"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_profissao"])){
                                        $ProfissaoResponsavelFinanceiro = $ResultadoContrato["financeiro_profissao"];
                                    } else {
                                        $ProfissaoResponsavelFinanceiro = $ResultadoContrato["pessoa_profissao"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_endereco"])){
                                        $EnderecoResponsavelFinanceiro = $ResultadoContrato["financeiro_endereco"];
                                    } else {
                                        $EnderecoResponsavelFinanceiro = $ResultadoContrato["catalogo_endereco"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_bairro"])){
                                        $BairroResponsavelFinanceiro = $ResultadoContrato["financeiro_bairro"];
                                    } else {
                                        $BairroResponsavelFinanceiro = $ResultadoContrato["catalogo_bairro"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_cep"])){
                                        $CEPResponsavelFinanceiro = $ResultadoContrato["financeiro_cep"];
                                    } else {
                                        $CEPResponsavelFinanceiro = $ResultadoContrato["catalogo_cep"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_cidade"])){
                                        $CidadeResponsavelFinanceiro = $ResultadoContrato["financeiro_cidade"];
                                    } else {
                                        $CidadeResponsavelFinanceiro = $ResultadoContrato["catalogo_cidade"];
                                    }

                                    if(!empty($ResultadoContrato["financeiro_uf"])){
                                        $EstadoResponsavelFinanceiro = $ResultadoContrato["financeiro_uf"];
                                    } else {
                                        $EstadoResponsavelFinanceiro = $ResultadoContrato["catalogo_uf"];
                                    }

                                    $TelefoneResidencialResponsavelFinanceiro = "";
                                    $TelefoneCelularResponsavelFinanceiro = "";
                                    $TelefoneComercialResponsavelFinanceiro = "";

                                    $Read->FullRead("SELECT tipo_telefone, telefone FROM sys_telefones_pessoas WHERE pessoa_id = :id", "id={$ResultadoContrato["pessoa_responsavel_financeiro_id"]}");
                                    if($Read->getResult()) {

                                        foreach($Read->getResult() as $Telefone) {

                                            if($Telefone['tipo_telefone'] == "Fixo"){

                                                $TelefoneResidencialResponsavelFinanceiro = $Telefone['telefone'];

                                            } elseif($Telefone['tipo_telefone'] == "Celular"){

                                                $TelefoneCelularResponsavelFinanceiro = $Telefone['telefone'];

                                            } elseif($Telefone['tipo_telefone'] == "Comercial"){

                                                $TelefoneComercialResponsavelFinanceiro = $Telefone['telefone'];

                                            }

                                        }

                                    } else {

                                        $TelefoneCelularResponsavelFinanceiro = $TelefoneCelularAluno;
                                        $TelefoneComercialResponsavelFinanceiro = $TelefoneComercialAluno;
                                        $TelefoneResidencialResponsavelFinanceiro = $TelefoneResidencialAluno;

                                    }

                                    $DataVenda = date('d/m/Y', strtotime($ResultadoContrato['data_matricula']));
                                    $NumeroVenda = "";
                                    $NumeroContrato = "CONTRATO nº " . str_pad($ResultadoContrato["contrato_id"], 5, 0, STR_PAD_LEFT);
                                    $NomeFantasiaUnidade = $_SESSION['NOME_FANTASIA_EMPRESA'];
                                    $RazãoSocialUnidade = $_SESSION['NOME_EMPRESA'];
                                    $CNPJUnidade = $_SESSION['CNPJ_EMPRESA'];
                                    $EndereçoUnidade = $_SESSION['ENDERECO_EMPRESA'];
                                    $BairroUnidade = $_SESSION['BAIRRO_EMPRESA'];
                                    $CEPUnidade = $_SESSION['CEP_EMPRESA'];
                                    $CidadeUnidade = $_SESSION['CIDADE_EMPRESA'];
                                    $EstadoUnidade = $_SESSION['UF_EMPRESA'];
                                    $TelefoneCelularUnidade = "";
                                    $TelefoneComercialUnidade = "";
                                    $NomeAluno = $ResultadoContrato["pessoa_nome"];
                                    $DataNascimentoAluno = $ResultadoContrato["pessoa_nascimento"];
                                    $RGAluno = $ResultadoContrato["pessoa_rg"];
                                    $CPFRNEAluno = $ResultadoContrato["pessoa_cpf"];
                                    $EmailAluno = $ResultadoContrato["pessoa_email"];
                                    $EnderecoAluno = $ResultadoContrato["catalogo_endereco"];
                                    $BairroAluno = $ResultadoContrato["catalogo_bairro"];
                                    $CEPAluno = $ResultadoContrato["catalogo_cep"];
                                    $CidadeAluno = $ResultadoContrato["catalogo_cidade"];
                                    $EstadoAluno = $ResultadoContrato["catalogo_uf"];
                                    $EscolaEstudaAluno = "";
                                    $EmpresaTrabalhaAluno = "";
                                    $CursoContratado = $ResultadoContrato["curso_nome"];
                                    $ValordoMaterialDidatico = "";
                                    $PeriodoLetivo = $ResultadoContrato["periodo_letivo"];
                                    $Modalidade = $ResultadoContrato["modalidade"];
                                    $NomedaTurma = "";
                                    $ValordasParcelas = "";
                                    $ValorMensal = "";
                                    $ValorPrimeiraParcela = "";
                                    $ValorTotaldaVenda = "";
                                    $ValorTotaldaVendaLiquido = "";
                                    $BonusVencimento = "";
                                    $DescontoTotaldaVenda = "";
                                    $DescontosConcedidos = "";
                                    $DiaVencimentoPrimeiraParcela = "";
                                    $DiaVencimentoParcelas = "";
                                    $DataVencimentoPrimeiraParcela = "";
                                    $NumerodeParcelas = "";
                                    $ValordasParcelasmaisDatadeVencimento = "";
                                    $FormadePagamento = "";
                                    $PercentualMultadeAtraso = "";
                                    $PercentualMora = "";
                                    $Idioma = "";
                                    $CódigodaTurma = "";
                                    $DatadeIniciodaTurma = "";
                                    $HorariodaTurma = "";
                                    $DatadeIníciodoAlunonaTurma = "";
                                    $NomedoProfessor = "";
                                    $DadosdoCurso = "";
                                    $CargaHoráriadoCurso = "";
                                    $EtapasdeAvaliacao = "";
                                    $TaxaCancelamentoAntesInicio = "";
                                    $PorcentagemMultadeCancelamentoAntesInicio = "";
                                    $TaxaCancelamentoAposInicio = "";
                                    $PorcentagemMultadeCancelamentoAposInicio = "";
                                    $Quebradepagina = "";


                                    $Contrato = str_replace("&lt;&lt;&lt;*Número do Contrato*&gt;&gt;&gt;", $NumeroContrato, $modelo_contrato_texto);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Nome Aluno*&gt;&gt;&gt;", $NomeAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*CPF/RNE Aluno*&gt;&gt;&gt;", $CPFRNEAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*RG Aluno*&gt;&gt;&gt;", $RGAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*E-mail Aluno*&gt;&gt;&gt;", $EmailAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Endereço Aluno*&gt;&gt;&gt;", $EnderecoAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Bairro Aluno*&gt;&gt;&gt;", $BairroAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Cidade Aluno*&gt;&gt;&gt;", $CidadeAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*CEP Aluno*&gt;&gt;&gt;", $CEPAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Curso Contratado*&gt;&gt;&gt;", $CursoContratado, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Período Letivo*&gt;&gt;&gt;", $PeriodoLetivo, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Modalidade*&gt;&gt;&gt;", $Modalidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Residencial Aluno*&gt;&gt;&gt;", $TelefoneResidencialAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Celular Aluno*&gt;&gt;&gt;", $TelefoneCelularAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Comercial Aluno*&gt;&gt;&gt;", $TelefoneComercialAluno, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Nome Responsável Financeiro*&gt;&gt;&gt;", $NomeResponsavelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Data Nascimento Responsável Financeiro*&gt;&gt;&gt;", $DataNascimentoResponsávelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*CPF/RNE Responsável Financeiro*&gt;&gt;&gt;", $CPFRNEResponsávelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*RG Responsável Financeiro*&gt;&gt;&gt;", $RGResponsávelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*E-mail Responsável Financeiro*&gt;&gt;&gt;", $EmailResponsávelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Profissão Responsável Financeiro*&gt;&gt;&gt;", $ProfissaoResponsavelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Celular Responsável Financeiro*&gt;&gt;&gt;", $TelefoneCelularResponsavelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Residencial Responsável Financeiro*&gt;&gt;&gt;", $TelefoneResidencialResponsavelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Telefone Comercial Responsável Financeiro*&gt;&gt;&gt;", $TelefoneComercialResponsavelFinanceiro, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Cidade Unidade*&gt;&gt;&gt;", $CidadeUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Estado Unidade*&gt;&gt;&gt;", $EstadoUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*CNPJ Unidade*&gt;&gt;&gt;", $CNPJUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Nome Fantasia Unidade*&gt;&gt;&gt;", $NomeFantasiaUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Razão Social Unidade*&gt;&gt;&gt;", $RazãoSocialUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Endereço Unidade*&gt;&gt;&gt;", $EndereçoUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Bairro Unidade*&gt;&gt;&gt;", $BairroUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*CEP Unidade*&gt;&gt;&gt;", $CEPUnidade, $Contrato);
                                    $Contrato = str_replace("&lt;&lt;&lt;*Data da venda*&gt;&gt;&gt;", $DataVenda, $Contrato);

                                    //echo $Contrato;
                                    ?>
                                    <textarea rows="100" class="contrato" name="modelo_contrato_texto"><?= $Contrato ?></textarea>
                                  </div>
                              </div>
                              <br/>
                          </div>
                          <br/>
                          
                          <div class="clearfix"></div>
                      </form>
                    <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=documentos/cadastro_contrato');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= DOCUMENTOS_CONTRATO ?>
  </div>
</div>
