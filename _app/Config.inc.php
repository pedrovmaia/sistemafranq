<?php
include_once 'ConfigDBURL.inc.php';

// URL BASE PORTAIS ################
if ($_SERVER['HTTP_HOST'] == 'localhost'):
    define('BASE_PORTAIS', 'https://localhost/KnnIdiomas/portal_knn_svn.git/trunk');
else:
    define('BASE_PORTAIS', 'https://www.knnidiomas.com.br/portal'); //Url raiz do site no servidor
endif;

// DEFINE SERVIDOR DE E-MAIL ################
define('MAIL_HOST', 'mail.madeforweb.com.br'); //Servidor de e-mail
define('MAIL_PORT', '465'); //Porta de envio
define('MAIL_USER', 'contato@madeforweb.com.br'); //E-mail de envio
define('MAIL_SMTP', 'contato@madeforweb.com.br'); //E-mail autenticador do envio (Geralmente igual ao MAIL_USER, exceto em serviços como AmazonSES, sendgrid...)
define('MAIL_PASS', '@bl722995'); //Senha do e-mail de envio
define('MAIL_SENDER', 'Bruno Henrique'); //Nome do remetente de e-mail
define('MAIL_MODE', 'ssl'); //Encriptação para envio de e-mail [0 não parametrizar / tls / ssl] (Padrão = tls)
define('MAIL_TESTER', 'brunohrp01@gmail.com'); //E-mail de testes (DEV)


// CONSTANTES DE FUNCIONALIDADES ####################
define('CAD_COLABORADOR', '9'); //RH - Funcionário
define('CAD_FUNCIONALIDADES', '10'); //ADM - Funcionalidades

define('FRANQUEADOR_ATIVIDADES_EXTRAS_PROFESSOR', '13'); //FRANQUEADOR - Atividades Extras Professor
define('ESCOLA_FAQ', '14'); //ESCOLA - FAQ
define('ESCOLA_CATEGORIA_ANEXO', '16'); //ESCOLA - Categoria Anexo
define('ESCOLA_CATEGORIA_TREINAMENTO', '17'); //ESCOLA - Categoria Treinamento
define('ESCOLA_ORIGEM_MATERIA', '18'); //ESCOLA - Origem Matéria
define('ESCOLA_TIPO_PORTAL', '19'); //ESCOLA - Tipo Portal
define('FRANQUEADOR_FUNCOES', '20'); //FRANQUEADOR - Funções
define('FRANQUEADOR_GRAU_ESCOLARIDADE', '21'); //FRANQUEADOR - Grau Escolaridade
define('FRANQUEADOR_GRAU_PARENTESCO', '22'); //FRANQUEADOR - Grau Parentesco
define('FRANQUEADOR_IDIOMA', '23'); //FRANQUEADOR - Idioma
define('FRANQUEADOR_INT_TIPO_CONTRATO', '24'); //FRANQUEADOR - Int Tipo Contrato
define('FRANQUEADOR_MODALIDADES', '25'); //FRANQUEADOR - Modalidades
define('FRANQUEADOR_AUTOR', '26'); //FRANQUEADOR - Autor
define('ESCOLA_SALA', '27'); //ESCOLA - Sala
define('ESCOLA_TURMA', '29'); // ESCOLA - Turmas
define('FRANQUEADOR_MOTIVO_REAT_VENDA', '31'); //FRANQUEADOR - Motivo de Reativação da Venda
define('PRODUTOS_PRODUTO', '43'); // PRODUTOS - Produtos
define('ESCOLA_CURSO', '44'); // PRODUTOS - Produtos
define('FRANQUEADOR_MOTIVO_NAO_FECHAMENTO', '28'); //FRANQUEADOR - Motivo Não Fechamento
define('FRANQUEADOR_MOTIVO_TRANC_MATRICULA', '42'); //FRANQUEADOR - Motivo de Trancamento de Matrícul
define('FRANQUEADOR_MOTIVO_TRANSFERENCIA', '32'); //FRANQUEADOR - Motivo Transferência
define('FRANQUEADOR_MOTIVOS_CANCELAMENTO', '33'); //FRANQUEADOR - Motivos Cancelamento
define('FRANQUEADOR_MOTIVOS_DESISTENCIAS', '34'); //FRANQUEADOR - Motivos Desistência
define('FRANQUEADOR_OCORRENCIAS_NATUREZA', '35'); //FRANQUEADOR - Ocorrências Natureza
define('FRANQUEADOR_OCORRENCIAS_TIPO_ACAO', '36'); //FRANQUEADOR - Ocorrências Tipo de Ação
define('FRANQUEADOR_OCUPACOES', '37'); //FRANQUEADOR - Ocupações
define('FRANQUEADOR_OPERADORAS_CELULAR', '39'); //FRANQUEADOR - Operadoras de Celular
define('FRANQUEADOR_ORIGEM', '40'); //FRANQUEADOR - Origem
define('FRANQUEADOR_PERIODO', '30'); //FRANQUEADOR - Período
define('FRANQUEADOR_PROMOCOES', '45'); //FRANQUEADOR - Promoções
define('FRANQUEADOR_SEGMENTO', '46'); //FRANQUEADOR - Segmento
define('FRANQUEADOR_TIPO_ACRESCIMO_ABATIMENTO', '47'); //FRANQUEADOR - Tipo de Acréscimo para Abatimento
define('FRANQUEADOR_TIPO_CARTA_COBRANCA', '48'); //FRANQUEADOR - Tipo de Carta de Cobrança
define('FRANQUEADOR_TIPO_CARTA_QUITACAO', '49'); //FRANQUEADOR - Tipo de Carta de Quitação
define('FRANQUEADOR_TIPO_DESCONTO', '50'); //FRANQUEADOR - Tipos de Desconto
define('FRANQUEADOR_TIPO_FRANQUIA', '51'); //FRANQUEADOR - Tipo Franquia
define('FRANQUEADOR_TIPO_OBRA', '52'); //FRANQUEADOR - Tipo Obra
define('FRANQUEADOR_TIPO_PRODUTO', '53'); //FRANQUEADOR - Tipo Produto
define('FINANCEIRO_INSTITUICAO_FINANCEIRA', '54'); //FINANCEIRO - Instituições Financeiras
define('FINANCEIRO_TIPO_CONTA_BANCARIA', '55'); //FINANCEIRO - Tipos de Contas Bancárias
define('FINANCEIRO_CONTA_BANCARIA', '56'); //FINANCEIRO - Contas Bancárias
define('CONTASPAGAR_MOVIMENTACAO_PAGAMENTO', '57'); //CONTAS A PAGAR - Movimentação de Pagamento
define('CONTASPAGAR_MOVIMENTACAO_RECEBIMENTO', '58'); //CONTAS A PAGAR - Movimentação de Recebimento
define('DOCUMENTOS_MODELO', '59'); //DOCUMENTOS - Modelo de contratos
define('DOCUMENTOS_CONTRATO', '61'); //DOCUMENTOS - Documentos
define('MOVIMENTACAO_MANUAL_ESTOQUE', '63'); //PRODUTOS - Entrada e saída manual estoque
define('PEDIDOS_PEDIDO', '64'); //PEDIDOS - Pedido
define('DOCUMENTOS_ESTAGIO_CONTRATO', '66'); //DOCUMENTOS - Estágio Contrato
define('DOCUMENTOS_TIPO_CONTRATOS', '67'); //DOCUMENTOS - Tipo Contratos
define('FRANQUEADOR_CONVENIO', '68'); //FRANQUEADOR - Convenio
define('FRANQUEADOR_PROPOSTAS', '69'); //FRANQUEADOR - Propostas
define('FRANQUEADOR_ESTAGIO_PROJETO', '70'); //FRANQUEADOR - Estágio de Turma
define('FRANQUEADOR_TIPO_ENVOLVIDO_PROJETO', '71'); //FRANQUEADOR - Tipo Alunos Turma
define('FRANQUEADOR_TIPO_TELEFONE', '72'); //FRANQUEADOR - Tipos de Telefone
define('ESCOLA_TREINAMENTOS', '73'); //ESCOLA - Treinamentos
define('FORNECEDORES_PRESTADOR', '74'); //FORNECEDORES - Prestadores de Serviços
define('FORNECEDORES_FORNECEDOR', '75'); //FORNECEDORES - Fornecedores
define('ESCOLA_ALUNOS', '76'); //ESCOLA - Alunos
define('FRANQUEADOR_ESCOLA', '77'); //FRANQUEADOR - Escola
define('FRANQUEADOR_CENTRO_CUSTO', '78'); //FRANQUEADOR - Centro de Custo
define('FRANQUEADOR_EMPRESAS', '79'); //FRANQUEADOR - Empresas
define('FINANCEIRO_CONTA_CONTABIL', '80'); //FINANCEIRO - Conta Contábil
define('ESCOLA_LIVROS', '81'); //ESCOLA - Livros
define('ESCOLA_COLECAO_LIVROS', '82'); //ESCOLA - Coleção de Livros
define('FRANQUEADOR_UNIDADES', '83'); //FRANQUEADOR - Unidades
define('FRANQUEADOR_ACERVO', '84'); //FRANQUEADOR - Acervo
define('FRANQUEADOR_EDITORA', '85'); //FRANQUEADOR - Editora
define('FRANQUEADOR_CLASSIFICACAO_LITERARIA', '88'); //FRANQUEADOR - Classificação Literária
define('FRANQUEADOR_FRANQUIA', '86'); //FRANQUEADOR - Franquia 
define('FRANQUEADOR_ETAPA_PRODUTO', '89'); //FRANQUEADOR - Etapa de Cursos
define('ESCOLA_TIPO_AVALIACAO', '90'); //ESCOLA - Tipo de Avaliacao
define('FRANQUEADOR_FORMULACAO_NOTA', '91'); //FRANQUEADOR - Formulação de Notas
define('FRANQUEADOR_FERIADO', '92'); //FRANQUEADOR - Feriados
define('FRANQUEADOR_MENSAGENS', '93'); //FRANQUEADOR - Mensagens de Boletim
define('FRANQUEADOR_COORDENADORIAS', '94'); //FRANQUEADOR - Coordenadorias
define('FRANQUEADOR_GRUPO_ECONOMICO', '95'); //FRANQUEADOR - Grupos Econômicos
define('FRANQUEADOR_GRUPO_MARKETING', '96'); //FRANQUEADOR - Grupos Marketing
define('FRANQUEADOR_GRUPO_PEDAGOGICO', '97'); //FRANQUEADOR - Grupos Pedagógicos
define('FRANQUEADOR_ITINERARIO', '98'); //FRANQUEADOR - Itinerário
define('FRANQUEADOR_FORMA_PAGAMENTO', '99'); //FRANQUEADOR - Forma de Pagamento
define('ESCOLA_AVALIACOES', '100'); //ESCOLA - Avaliações

define('FRANQUEADOR_TIPOS_DOC_LIQUIDACAO', '103'); //FRANQUEADOR - Tipos de Documento de Liquidação
define('FRANQUEADOR_PLANO_CONTAS', '104'); //FRANQUEADOR - Plano de Contas 
define('ESCOLA_ESTAGIO_CURSO', '105'); //ESCOLA - Estágio do curso
define('RH_CARGO', '108'); //RH - Cargos
define('FINANCEIRO_FORMA_PARCELAMENTO', '109'); //FINANCEIRO - Forma de Parcelamento
define('CRM_ORIGEM_INTERESSE', '110'); //CRM - Origem do Interesse
define('CRM_MOTIVO_INTERESSE', '111'); //CRM - Motivo do Interesse
define('CRM_TIPO_ATENDIMENTO', '112'); //CRM - Tipo de Atendimento
define('RH_TIPO_TESTE_PESSOA', '113'); //RH - Tipo de Teste
define('ADMIN_MENU', '114'); //ADMIN - Menus
define('ADMIN_SUBMENU', '115'); //ADMIN - Submenus
define('CRM_RESPOSTA', '116'); //CRM - Resposta do Tipo de Atendimento
define('CRM_ACOES', '117'); //CRM - Próximas Ações do Tipo de Atendimento
define('POLITICA_DIAS_VENCIMENTO', '119'); //POLITICA COMERCIAL - Dias de Vencimento
define('POLITICA_DESCONTOS', '120'); //POLITICA COMERCIAL - Descontos
define('POLITICA_JUROS_MULTA', '121'); //POLITICA COMERCIAL - Multa e Juros de Mora 
define('CONTASPAGAR_TITULOS', '118'); // CONTAS A PAGAR - TITULOS
define('CONTASRECEBER_RECEBIMENTO', '122'); // CONTAS A PAGAR - TITULOS
define('CONTASRECEBER_TITULOS', '123'); // CONTAS A PAGAR - TITULOS
define('ESCOLA_PROFESSOR', '124'); //ESCOLA - Professor
define('CRM_PROSPECCAO', '125'); //CRM - Prospecção
define('ESCOLA_MATERIAS_AULA', '126'); //ESCOLA - Matéria Aula
define('ADM_ACESSO_MENUS', '127'); // ADM - Acesso Menus
define('CRM_OCORRENCIA', '128'); // CRM - Ocorrência
define('RH_TESTE_PESSOAS', '129'); //RH - Teste de Pessoa
define('FINANCEIRO_TRANSACAO_CAIXA', '131'); //FINANCEIRO - Transações Caixa
define('ESCOLA_PLANEJAMENTO', '130'); //ESCOLA - Planejamento de aulas
define('PEDAGOGICO_QUIZ', '132'); //PEDAGÓGICO - Quiz
define('PEDAGOGICO_QUIZ_RESPOSTAS', '133'); //PEDAGÓGICO - Quiz Respostas
define('PEDAGOGICO_QUIZ_PERGUNTAS', '134'); //PEDAGÓGICO - Quiz Perguntas
define('PEDAGOGICO_LIVRO_DICA', '135'); //PEDAGÓGICO - Livro Dicas
define('PEDAGOGICO_LIVRO_DOWNLOAD', '136'); //PEDAGÓGICO - Livro Download
define('PEDAGOGICO_DOWNLOADS', '137'); //PEDAGÓGICO - Downloads
define('FRANQUEADOR_RECESSO', '138'); //FRANQUEADOR - Recesso
define('RH_FERIAS', '139'); //RH - Férias
define('CRM_PESSOAS', '140'); //CRM - Pessoas
define('RESTAURANTES_MESAS', '141'); //RESTAURANTE - Mesas
define('CRM_INDICACAO', '142'); //CRM - Indicações
define('PEDAGOGICO_RESPOSTAS_QUIZ', '143'); //PEDAGOGICO - Respostas Quiz
define('FRANQUEADOR_PRECO_PRODUTO', '144'); //FRANQUEADOR - Preço Produto
define('ESCOLA_LISTA_ESPERA', '145'); //ESCOLA - Lista de espera
define('CRM_INTERESSE', '146'); //CRM - Interesse
define('POLITICA_POLITICA_ACRESCIMO', '147'); //POLITICA COMERCIAL - Politica de Acréscimo
define('ESCOLA_ETAPA_AVALIACAO', '148'); //ESCOLA - Etapa de Avaliação
define('RH_RELACAO_COORDENADOR_PROFESSOR', '151'); //RH - Relação Coordenador / Professor
define('RH_RELACAO_GERENTE_CONSULTOR', '152'); //RH - Relação Gerente / Consultor
define('ESCOLA_HABILITACAO_PROFESSOR_MATERIA', '153'); //ESCOLA - Habilitação Professor Matéria
define('FINANCEIRO_IMPRESSAO_CARNES', '155'); //FINANCEIRO - Impressão de Carnês
define('MARKETING_TIPO_EVENTO', '156'); //MARKETING - Tipo de Evento
define('MARKETING_TIPO_CAMPANHA', '157'); //MARKETING - Tipo de Campanha
define('POLITICA_COMERCIAL_PRODUTO', '158'); //POLITICA_COMERCIAL - Politica Comercial de Produtos/Serviços
define('MARKETING_EVENTO', '159'); //MARKETING - Eventos
define('MARKETING_CAMPANHA', '160'); //MARKETING - Campanhas
define('CRM_ATENDIMENTOS', '161'); //CRM - Atendimentos
define('ESCOLA_ACOMPANHAMENTO_AULAS', '163'); //ESCOLA - Acompanhamento de Aulas
define('ESCOLA_AVALIACAO_ALUNOS', '164'); //ESCOLA - Acompanhamento de Aulas
define('ESCOLA_LISTA_ASSINATURA', '165'); //ESCOLA - Lista de assinatura
define('RELATORIOS_ALUNOS', '166'); //RELATÓRIOS - Pesquisa de Alunos
define('RELATORIOS_EMPRESAS', '167'); //RELATÓRIOS - Pesquisa de Empresas
define('RELATORIOS_OCORRENCIAS', '168'); //RELATÓRIOS - Pesquisa de Empresas
define('RELATORIOS_TURMAS', '169'); //RELATÓRIOS - Pesquisa de Turmas
define('RELATORIOS_PROSPECCAO', '170'); //RELATÓRIOS - Pesquisa de Proespecções
define('RELATORIOS_FERIADOS', '171'); //RELATÓRIOS - Feriados
define('RELATORIOS_CLIENTES', '172'); //RELATÓRIOS - Pesquisa de Clientes
define('RELATORIOS_AULAS_REALIZADAS', '174'); //RELATÓRIOS - Total de Aulas Realizadas
define('RELATORIOS_SALDO_ESTOQUE', '175'); //RELATÓRIOS - Saldo de Estoque
define('RELATORIOS_ATENDIMENTOS', '176'); //RELATÓRIOS - Atendimentos
define('RELATORIOS_ANIVERSARIANTES', '177'); //RELATÓRIOS - Aniversariantes
define('CONTASRECEBER_ENVIO_SCPC', '178'); //CONTAS RECEBER - Inclusão SCPC
define('RELATORIOS_ALUNOS_MATRICULADOS', '179'); //RELATÓRIOS - Alunos Matriculados
define('FRANQUEADOR_PAISES', '180'); //FRANQUEADOR - Países
define('FRANQUEADOR_ESTADOS', '181'); //FRANQUEADOR - Estados
define('FRANQUEADOR_CIDADES', '182'); //FRANQUEADOR - Cidades
define('FRANQUEADOR_CONSULTOR', '183'); //FRANQUEADOR - Consultor de Campo
define('RH_RELACAO_GERENTE_CAMPO_CONSULTO_CAMPO', '184'); //RH - Relação Gerente Campo / Consultor Campo
define('RELATORIOS_ENVIO_SCPC', '185'); //RELATÓRIOS - Envios SCPC
define('RELATORIOS_VENDAS_REALIZADAS', '186'); //RELATÓRIOS - Vendas Realizadas
define('FRANQUEADOR_ESCOLA_FRANQUIAS', '187'); //FRANQUEADOR - Escola Franquias
define('RH_TIPO_HISTORICO_FUNCIONARIO', '188'); //RH - Tipo de Histórico de FuncionáriO
define('RH_HISTORICO_FUNCIONARIO', '189'); //RH - Histórico de Funcionário
define('RELATORIOS_ALUNOS_FALTOSOS', '190'); //RELATÓRIOS - Alunos Faltosos
define('RELATORIOS_FREQUENCIA_GERAL', '191'); //RELATÓRIOS - Frequência Geral
define('RELATORIOS_HORARIOS_PROFESSOR', '192'); //RELATÓRIOS - Registro de Horários por Professor
define('RELATORIOS_ALUNOS_TURMA', '195'); //RELATÓRIOS - Alunos Matriculados com Turma
define('ESCOLA_PARENTES', '197'); //ESCOLA - Parentes
define('SUPRIMENTOS_PEDIDO_COMPRA', '198'); //SUPRIMENTOS - Pedido de Compra
define('FINANCEIRO_CONTROLE_CHEQUE', '199'); //FINANCEIRO - Controle de Cheque
define('FINANCEIRO_SITUACAO_CHEQUE', '200'); //FINANCEIRO - Situação de Cheque
define('PEDAGOGICO_EMPRESTIMO_ACERVO', '202'); //PEDAGÓGICO - Empréstimo Acervo
define('ESCOLA_REPOSICAO_AULA', '204'); //ESCOLA - Reposição de Aula
define('ESCOLA_MATERIAIS_ESTAGIO', '205'); //ESCOLA - Materiais Estagio
define('PARAMETRIZACAO_FERIADOS_MUNICIPAIS', '206'); //PARAMETRIZAÇÃO - Feriados Municipais
define('RELATORIOS_TRANSACAO_CAIXA', '207'); //RELATÓRIOS - Transação Caixa
define('RELATORIOS_ALUNOS_TRANCADOS', '208'); //RELATÓRIOS - Alunos Trancados
define('RELATORIOS_ALUNOS_CANCELADOS', '209'); //RELATÓRIOS - Alunos Cancelados
define('RELATORIOS_TITULOS_ATRASO', '210'); //RELATÓRIOS - Títulos em Atraso
define('FINANCEIRO_TITULOS_ATRASO', '211'); //FINANCEIRO - Títulos em Atraso
define('FINANCEIRO_CONFERIR_CAIXA', '212'); //FINANCEIRO - Conferir Caixa
define('PEDIDOS_CLIENTES', '213'); //PEDIDOS - Clientes
define('FRANQUEADOR_ANO_LETIVO', '214'); //FRANQUEADOR - aNO Letivos
define('FRANQUEADOR_PERIODO_LETIVO', '215'); //FRANQUEADOR - Período Letivo
define('CRM_PATROCINADORES', '216'); //CRM - Patrocinadores
define('FRANQUEADOR_NIVEIS_EMPRESA', '217'); //FRANQUEADOR - Níveis Empresa
define('ESCOLA_HOMEWROK', '218'); //ESCOLA - Homework
define('ESCOLA_EXERCICIO', '219'); //ESCOLA - Exercícios
define('ESCOLA_HISTORICO_MATRICULA', '220'); //ESCOLA - Histórico de Matrículas
define('ESCOLA_HISTORICO_PEDIDO', '221'); //ESCOLA - Histórico de Pedidos
define('POLITICA_COMERCIAL_ESTAGIO', '222'); //POLITICA COMERCIAL - Estágio
define('FINANCEIRO_NEGOCIACOES', '223'); //POLITICA COMERCIAL - Estágio
define('ESCOLA_HISTORICO_PEDAGOGICO', '224'); //ESCOLA - Histórico Pedagógico
define('SEDE_FRANQUIAS', '225'); //SEDE - Franquias
define('SEDE_CURSOS', '226'); //SEDE - Cursos
define('SEDE_MATERIAIS_DIDATICOS', '227'); //SEDE - Materiais Didáticos
define('SEDE_TURMAS', '228'); //SEDE - Turmas
define('SEDE_ALUNOS', '229'); //SEDE - Aunos
define('SEDE_MATRICULAS', '230'); //SEDE - Matrículas
define('SEDE_PEDIDOS_LIVROS', '231'); //SEDE - Pedidos de Livros
define('SEDE_RENEGOCIACAO', '232'); //SEDE - Renegociação
define('FINANCEIRO_MOTIVO_NEGOCIACAO', '233'); //FINANCEIRO - Motivo Negociação 
define('RETENCAO_PARCELA_ATRASO', '235'); //RETENÇÃO - Alunos com Parcelas em Atraso
define('FINANCEIRO_RECEBIMENTO_DETALHADO', '236'); //FINANCEIRO - Recebimento Detalhado 
define('PARAMETRIZACAO_PARAMETRIZACAO_MATRICULA', '237'); //PARAMETRIZAÇÃO - Parametrização da Matrícula
define('CONTABIL_RELATORIO_CENTRO_CURSO', '237'); //CONTÁBIL - Relatório Rateio de Centro de Custo
define('FRANQUEADOR_MOTIVO_ESTORNO', '239'); //FRANQUEADOR - Motivos de Estorno
define('FRANQUEADOR_MOTIVO_ALTERAR_VENCIMENTO', '240'); //FRANQUEADOR - Motivos de Alterar Data de Vencimento
define('FINANCEIRO_LOG_CANCELAMENTO_PARCELA', '241');//FINANCEIRO - Log de Cancelamento de Parcela
define('FINANCEIRO_LOG_ESTORNO_PARCELA', '242');//FINANCEIRO - Log de Estorno de Parcelas
define('FINANCEIRO_LOG_ALTERACAO_VENCIMENTO', '243');//FINANCEIRO - Log de Alteração de Data de Vencimento
define('PARAMETRIZACAO_SISTEMA', '244');//PARAMETRIZAÇÃO - Parametrização do Sistema
define('RETENCAO_OCORRENCIA_RETENCAO_ALUNO', '245');//RETENÇÃO - Ocorrência Retenção Aluno
define('RELATORIOS_MATRICULAS_MES', '249');//RELATÓRIOS - Matrículas por Mês  
define('FINANCEIRO_HISTORICO_RENEGOCIACAO', '250');//FINANCEIRO - Histórico de Renegociação
define('PARAMETRIZAÇÃO_OPERADORES_FINANCEIRO', '251');//PARAMETRIZAÇÃO - Operadores Financeiro
define('ESCOLA_TRANSFERENCIA_ENVOLVIDOS', '252');//ESCOLA - Transferência de Turma Envolvidos 
define('FINANCEIRO_LIST_LANCAMENTO_CONTA', '253');//FINANCEIRO - List Lançamento Conta
define('PARAMETRIZACAO_ATIVIDADE_EXTRA', '254');//PARAMETRIZAÇÃO - Atividades Extras
define('FINANCEIRO_LIST_PARCELAS_RECEBIDAS', '255');//FINANCEIRO - List Parcelas Recebidas
define('PARAMETRIZACAO_MATRIZ_PERDA_DESCONTO', '256');//PARAMETRIZAÇÃO - Matriz Perda de Desconto

define('RELATORIOS_TURMAS_SALAS', '257');//RELATÓRIOS - Turmas por Salas
define('RELATORIOS_TURMAS_PROFESSOR', '258');//RELATÓRIOS - Turmas por Salas

// DEFINE OS MENUS DO SITE ####################
define('MENU_PEDAGOGICO', '3'); // Menu Pedagógico
define('MENU_DASHBOARD', '4'); // Menu Dashboard
define('MENU_FRANQUEADOR', '5'); // Menu Franqueador
define('MENU_FAVORITOS', '6'); // Menu Favoritos
define('MENU_ESCOLA', '7'); // Menu Escola
define('MENU_PEDIDOS', '8'); // Menu Pedidos/Serviços
define('MENU_FINANCEIRO', '9'); // Menu Financeiro
define('MENU_CONTAS_PAGAR', '10'); // Menu Contas/Pagar
define('MENU_CONTAS_RECEBER', '11'); // Menu Contas/Receber
define('MENU_RH', '12'); // Menu Recursos Humanos
define('MENU_FORNECEDORES', '13'); // Menu Fornecedores
define('MENU_GESTAO_CONTRATOS', '14'); // Menu Gestão de Contratos
define('MENU_PARAMETRIZACAO', '15'); // Menu Parametrização
define('MENU_ALERTAS_PENDENCIAS', '16'); // Menu Alertas/Pendências
define('MENU_PRODUTOS', '17'); // Menu Produtos
define('MENU_RELATORIOS', '18'); // Menu Relatórios
define('MENU_INTELIGENCIA_ARTIFICIAL', '19'); // Menu Inteligência Artificial
define('MENU_POLITICA_COMERCIAL', '20'); // Menu Politica Comercial
define('MENU_CRM', '21'); // Menu CRM
define('MENU_TRANSPORTE', '22'); // Menu Transporte Escolar
define('MENU_ADMINISTRACAO', '23'); // Menu Administração
define('MENU_RESTAURANTES', '24'); // Menu Restaurantes
define('MENU_MARKETING', '26'); // Menu Marketing
define('MENU_SUPRIMENTOS', '27'); // Menu Suprimentos
define('MENU_BIBLIOTECA', '28'); // Menu Biblioteca
define('MENU_SEDE', '29'); // Menu Sede
define('MENU_RETENCAO', '30'); // Menu Retenção
define('MENU_CONTABIL', '31'); // Menu Contabil



// DEFINE OS SUBMENUS DO SITE ####################
define('SUBMENU_PORTAISWEB_FAQ', '1'); // SubMenu Portais Web FAQ
define('SUBMENU_PORTAISWEB_CATEGORIA_DOWNLOADS', '2'); //
define('SUBMENU_PORTAISWEB_CATEGORIA_TREINAMENTOS', '3'); //
define('SUBMENU_PORTAISWEB_ORIGEM_MATERIA', '4'); //
define('SUBMENU_PORTAISWEB_TIPOS_PORTAIS', '5'); //
define('SUBMENU_PORTAISWEB_TREINAMENTOS', '6'); //
define('SUBMENU_PORTAISWEB_LIVROS', '7'); //
define('SUBMENU_PORTAISWEB_TIPO_TESTE_NIVEL', '8'); //
define('SUBMENU_PORTAISWEB_MATERIAS_AULA', '9'); //
define('SUBMENU_PORTAISWEB_QUIZZES', '10'); //
define('SUBMENU_PORTAISWEB_DOWNLOADS', '11'); // 
define('SUBMENU_PORTAISWEB_COLECAO_LIVROS', '12'); //
define('SUBMENU_PORTAISWEB_CONSULTOR_CAMPO', '16'); //
define('SUBMENU_PORTAISWEB_BIBLIOTECA', '17'); //
define('SUBMENU_FRANQUIAS_COORDENADORIA', '18'); //Franquias / Administração Coordenadoria
define('SUBMENU_FRANQUIAS_GRUPOS_MARKETING', '19'); //Franquias / Administração Grupos de Marketing
define('SUBMENU_FRANQUIAS_GRUPOS_ECONOMICO', '20'); //Franquias / Administração Grupos Econômicos
define('SUBMENU_FRANQUIAS_GRUPOS_PEDAGOGICO', '21'); //	Franquias / Administração Grupos Pedagógicos
define('SUBMENU_FRANQUIAS_FRANQUIA', '22'); //Franquias / Administração Franquia
define('SUBMENU_DOMINIOS_ATIVIDADE_EXTRA_PROFESSOR', '23'); //Domínios Atividades Extra Professor
define('SUBMENU_DOMINIOS_CENTRO_CUSTO', '24'); //Domínios Centro de Custo
define('SUBMENU_DOMINIOS_FUNCOES', '25'); //Domínios Funções
define('SUBMENU_DOMINIOS_GRAU_ESCOLARIDADE', '26'); //	Domínios Graus de Escolaridade
define('SUBMENU_DOMINIOS_GRAU_PARENTESCO', '27'); //Domínios Graus de Parentesco
define('SUBMENU_DOMINIOS_INT_TIPO_CONTRATO', '28'); //Domínios Interesse Tipo de Contrato
define('SUBMENU_DOMINIOS_MODALIDADES', '29'); //Domínios Modalidades
define('SUBMENU_DOMINIOS_MOTIVOS_CANCELAMENTO', '30'); //Domínios Motivos de Cancelamento
define('SUBMENU_DOMINIOS_MOTIVOS_DESISTENCIA', '31'); //Domínios Motivos de Desistência
define('SUBMENU_DOMINIOS_MOTIVOS_NAO_FECHAMENTO', '32'); //Domínios Motivos de Não Fechamento
define('SUBMENU_DOMINIOS_MOTIVO_REAT_VENDA', '33'); //	Domínios Motivos de Reativação de Venda
define('SUBMENU_DOMINIOS_MOTIVOS_TRANC_MATRICULA', '34'); //	Domínios Motivos de Trancamento de Matrícula
define('SUBMENU_DOMINIOS_MOTIVOS_TRANSFERENCIA', '35'); //Domínios Motivos de Transferência
define('SUBMENU_DOMINIOS_OCUPACOES', '36'); //Domínios Ocupações
define('SUBMENU_DOMINIOS_OPERADORAS_CELULAR', '37'); //Domínios Operadoras de Celular
define('SUBMENU_DOMINIOS_ORIGENS', '38'); //Domínios Origens
define('SUBMENU_DOMINIOS_AUTORES', '39'); //Domínios Autores
define('SUBMENU_DOMINIOS_CLASSIFICACOES_LITERARIAS', '40'); //Domínios Classificações Literárias
define('SUBMENU_DOMINIOS_IDIOMAS', '41'); //Domínios Idiomas
define('SUBMENU_DOMINIOS_PERIODOS', '42'); //Domínios Períodos
define('SUBMENU_DOMINIOS_PROMOCOES', '43'); //Domínios Promoções
define('SUBMENU_DOMINIOS_SEGMENTOS', '44'); //Domínios Segmentos
define('SUBMENU_DOMINIOS_SALAS', '45'); //Domínios Salas
define('SUBMENU_DOMINIOS_TIPO_ACRESCIMO_ABATIMENTO', '46'); //Domínios Tipos de Acréscimo para Abatimento
define('SUBMENU_DOMINIOS_TIPO_CARTA_COBRANCA', '47'); //Domínios Tipos de Carta de Cobrança
define('SUBMENU_DOMINIOS_TIPO_CARTA_QUITACAO', '48'); //Domínios Tipos de Carta de Quitação
define('SUBMENU_DOMINIOS_TIPOS_DESCONTOS', '49'); //	Domínios Tipos de Desconto
define('SUBMENU_DOMINIOS_TIPOS_FRANQUIAS', '50'); //Domínios Tipos de Franquias
define('SUBMENU_DOMINIOS_TIPOS_OBRAS', '51'); //Domínios Tipos de Obras
define('SUBMENU_DOMINIOS_ESTAGIO_TURMAS', '52'); //Domínios Estágios de Turmas
define('SUBMENU_DOMINIOS_TIPO_ALUNOS_TURMA', '53'); //	Domínios Tipo Alunos Turma
define('SUBMENU_DOMINIOS_CONVENIO', '54'); //Domínios Convênio
define('SUBMENU_DOMINIOS_PROPOSTAS', '55'); //Domínios Propostas
define('SUBMENU_DOMINIOS_EMPRESAS', '57'); //Domínios Empresas
define('SUBMENU_DOMINIOS_UNIDADES', '58'); //Domínios Unidades 
define('SUBMENU_DOMINIOS_FORMULACAO_NOTA', '63'); //Domínios Formulação de Notas
define('SUBMENU_DOMINIOS_FERIADOS', '64'); //Domínios Feriados
define('SUBMENU_DOMINIOS_MENSAGEM_BOLETIM', '65'); //Domínios Mensagens de Boletim
define('SUBMENU_DOMINIOS_ITINERARIO', '66'); //Domínios Itinerário
define('SUBMENU_DOMINIOS_FORMA_PAGAMENTO', '67'); //Domínios Formas de Pagamento
define('SUBMENU_DOMINIOS_PLANO_CONTA', '68'); //Domínios Plano de Conta
define('SUBMENU_DOMINIOS_TIPO_DOCUMENTO_LIQUIDACAO', '69'); //Domínios Tipos de Documentação de Liquidação
define('SUBMENU_DOMINIOS_RECESSO', '70'); //Domínios Recesso
define('SUBMENU_DOMINIOS_PRECO_PRODUTOS', '71'); //Domínios Preço de Produtos
define('SUBMENU_DOMINIOS_ANO_LETIVO', '72'); //Domínios Ano Letivo
define('SUBMENU_DOMINIOS_PERIODO_LETIVO', '73'); //Domínios Período Letivo 
define('SUBMENU_DOMINIOS_TIPOS_TELEFONE', '119'); //Domínios Tipos de Telefone
define('SUBMENU_LOCALIZACAO_PAISES', '74'); //Localização Países
define('SUBMENU_LOCALIZACAO_ESTADOS', '75'); //Localização Estados
define('SUBMENU_LOCALIZACAO_CIDADES', '76'); //Localização Cidades
define('SUBMENU_GERENCIAMENTO_MATRICULA_ALUNOS', '100'); //Gerenciamento de Matrículas / Alunos Gerencimento de Alunos
define('SUBMENU_GERENCIAMENTO_MATRICULA_MATRICULA', '101'); //Gerenciamento de Matrículas / Alunos Realizar Matrículas
define('SUBMENU_GERENCIAMENTO_MATRICULA_RECEBIMENTO', '102'); //Gerenciamento de Matrículas / Alunos Recebimento
define('SUBMENU_CONTROLE_TURMA_SALAS', '103'); //Controle de Turmas Salas
define('SUBMENU_CONTROLE_TURMA_TURMAS', '104'); //Controle de Turmas Turmas
define('SUBMENU_CONTROLE_TURMA_LISTA_ESPERA', '105'); //Controle de Turmas Lista de Espera
define('SUBMENU_CONTROLE_TURMA_CALENDARIO_MENSAL', '106'); //Controle de Turmas Calendário Mensal
define('SUBMENU_CONTROLE_TURMA_LISTA_ASSINATURA', '107'); //Controle de Turmas Lista de Assinaturas
define('SUBMENU_CONTROLE_TURMA_DIARIO_CLASSE', '108'); //Controle de Turmas Diário de Classes
define('SUBMENU_CONTROLE_TURMA_LISTA_CHAMADA', '109'); //Controle de Turmas Lista de Chamada
define('SUBMENU_CONTROLE_TURMA_MAPA_HORARIO', '110'); //Controle de Turmas Mapa de Horários
define('SUBMENU_CONTROLE_TURMA_PLANEJAMENTO', '111'); //Controle de Turmas Planejamento
define('SUBMENU_CONTROLE_TURMA_ACOMPANHAMENTO_AULA', '112'); //	Controle de Turmas Acompanhamento da Aula
define('SUBMENU_ADM_AVALIACOES_AVALIACOES', '113'); //Administração de Avaliações Avaliações
define('SUBMENU_ADM_AVALIACOES_TIPO_AVALIACOES', '114'); //Administração de Avaliações Tipos de Avaliações
define('SUBMENU_ADM_ESCOLA_GERENCIAMENTO_CURSO', '115'); //Administração da Escola Gerenciamento de Cursos
define('SUBMENU_ADM_ESCOLA_PROFESSORES', '116'); //Administração da Escola Professores
define('SUBMENU_ADM_ESCOLA_ACERVO', '117'); //Administração da Escola Acervo da Biblioteca
define('SUBMENU_ADM_ESCOLA_HAB_PROFESSOR_MATERIA', '118'); //Administração da Escola Habilitação de Professores a Matérias
define('SUBMENU_GERENCIAMENTO_PEDIDOS_PEDIDOS', '120'); //Gerenciamento de Pedidos e Serviços Pedidos
define('SUBMENU_GERENCIAMENTO_PEDIDOS_CLIENTES', '121'); //	Gerenciamento de Pedidos e Serviços Clientes
define('SUBMENU_GERENCIAMENTO_SUPRIMENTOS_PEDIDOS', '122'); //Gerenciamento de Suprimentos Pedidos de Compra
define('SUBMENU_GERENCIAMENTO_SUPRIMENTOS_PEDIDOS_ELETRONICO_LIVRO', '123'); //Gerenciamento de Suprimentos Pedido Eletrônico de Compra de Livro
define('SUBMENU_GESTAO_FINANCEIRA_IMPRESSAO_CARNE', '124'); //Gestão Financeira Impressão de Carnes
define('SUBMENU_GESTAO_FINANCEIRA_TRANSACOES_MANUAIS', '125'); //Gestão Financeira Transações Manuais Caixa
define('SUBMENU_GESTAO_FINANCEIRA_TITULOS_ATRASO', '126'); //Gestão Financeira Títulos em Atraso
define('SUBMENU_GESTAO_FINANCEIRA_NEGOCIACOES', '127'); //Gestão Financeira Negociações
define('SUBMENU_GESTAO_FINANCEIRA_RECEBIMENTO_DETALHADO', '128'); //Gestão Financeira Recebimento Detalhado
define('SUBMENU_GESTAO_FINANCEIRA_RECEBIMENTO_SIMPLIFICADO', '129'); //Gestão Financeira Recebimento Simplificado
define('SUBMENU_GESTAO_FINANCEIRA_FORMA_PARCELAMENTO', '130'); //Gestão Financeira Formas de Parcelamento
define('SUBMENU_CAIXA_BANCOS_REMESSA', '131'); //Caixas e Bancos Remessa
define('SUBMENU_CAIXA_BANCOS_RETORNO', '132'); //Caixas e Bancos Retorno
define('SUBMENU_CAIXA_BANCOS_CONFERIR_CAIXA', '133'); //Caixas e Bancos Conferir Caixa
define('SUBMENU_CAIXA_BANCOS_CONFIGURAÇÃO_BOLETOS', '135'); //Caixas e Bancos Configuração de Boletos
define('SUBMENU_CAIXA_BANCOS_CREDITO_CLIENTES', '136'); //Caixas e Bancos Crédito de Clientes
define('SUBMENU_CAIXA_BANCOS_TIPO_DOCUMENTO', '137'); //Caixas e Bancos Tipo de Documento
define('SUBMENU_CAIXA_BANCOS_LANCAMENTO', '138'); //Caixas e Bancos Lançamento
define('SUBMENU_CAIXA_BANCOS_TRANSFERIR', '139'); //Caixas e Bancos Transferir
define('SUBMENU_CAIXA_BANCOS_CONTAS', '140'); //Caixas e Bancos Contas
define('SUBMENU_CAIXA_BANCOS_INSTITUICAOS_FINANCEIRAS', '141'); //Caixas e Bancos Instituição Financeiras
define('SUBMENU_CAIXA_BANCOS_TIPOS_CONTAS', '142'); //Caixas e Bancos Tipos de Contas
define('SUBMENU_CAIXA_BANCOS_CONTAS_CONTABEIS', '143'); //Caixas e Bancos Contas Contábeis	
define('SUBMENU_CAIXA_BANCOS_CONTROLE_CHEQUES', '144'); //Caixas e Bancos Controle de Cheques
define('SUBMENU_CAIXA_BANCOS_SITUACAO_CHEQUES', '145'); //Caixas e Bancos Situaçâo de Cheques
define('SUBMENU_CONTAS_PAGAR_MOVIMENTACAO_PAGAMENTOS', '146'); //Contas a Pagar Movimentação de Pagamentos
define('SUBMENU_CONTAS_PAGAR_TITULOS_PAGAR', '147'); //Contas a Pagar Títulos a Pagar
define('SUBMENU_CONTAS_RECEBER_MOVIMENTACAO_RECEBIMENTOS', '148'); //Contas a Receber Movimentação de Recebimentos
define('SUBMENU_CONTAS_RECEBER_TITULOS_RECEBER', '149'); //Contas a Receber Títulos a Receber
define('SUBMENU_COLABORADOR_FUNCIONARIO', '13'); //Colaboradores Funcionário
define('SUBMENU_COLABORADOR_CARGO', '14'); //Colaboradores Cargo
define('SUBMENU_COLABORADOR_TIPO_TESTE', '15'); //Colaboradores Tipo de teste
define('SUBMENU_COLABORADOR_RELACAO_COORDENADOR_PROFESSOR', '150'); //Colaboradores Relação Coordenador / Professor
define('SUBMENU_COLABORADOR_RELACAO_GERENTE_CONSULTOR', '151'); //Colaboradores Gerente / Consultor
define('SUBMENU_COLABORADOR_GERENTE_CAMPO_CONSULTO_CAMPO', '152'); //Colaboradores Relação Gerente Campo / Consultor Campo
define('SUBMENU_BIBLIOTECA_EMPRESTIMO_ACERVO', '153'); //Biblioteca Empréstimo Acervo
define('SUBMENU_BIBLIOTECA_ACERVO', '154'); //Biblioteca  Acervo
define('SUBMENU_BIBLIOTECA_CLASSIFICACAO_LITERARIA', '155'); //Biblioteca Classificação Literária
define('SUBMENU_BIBLIOTECA_EDITORA', '156'); //Biblioteca Editora
define('SUBMENU_BIBLIOTECA_TIPOS_OBRAS', '157'); //Biblioteca Tipos de Obras
define('SUBMENU_EMPRESA_EMPRESA_FORNECEDOR', '158'); //Empresa / Fornecedores - Empresa / Fornecedor
define('SUBMENU_EMPRESA_PRESTADOR_SERVICO', '159'); //Empresa / Fornecedores Prestador de Serviço
define('SUBMENU_GESTAO_CONTRATO_CONTRATOS_DOCUMENTOS', '160'); //Gestão de Contrato e Documento Contratos e Documentos
define('SUBMENU_GESTAO_CONTRATO_TIPOS_DOCUMENTOS', '161'); //Gestão de Contrato e Documento Tipos de Documentos
define('SUBMENU_GESTAO_CONTRATO_ESTAGIOS_CONTRATO', '162'); //Gestão de Contrato e Documento Estágios de Contrato
define('SUBMENU_GESTAO_CONTRATO_MODELOS_CONTRATO', '163'); //Gestão de Contrato e Documento Modelos de Contrato
define('SUBMENU_GERENCIAMENTO_ESCOLAS', '164'); //Gerenciamento Escolas
define('SUBMENU_GERENCIAMENTO_RECESSO', '165'); //Gerenciamento Recesso
define('SUBMENU_GERENCIAMENTO_FERIADO_MUNICIPAL', '166'); //Gerenciamento Feriado Municipal
define('SUBMENU_GERENCIAMENTO_RATEIO_MATRICULA', '195'); //Gerenciamento Feriado Municipal
define('SUBMENU_GERENCIAMENTO_RATEIO_PEDIDO', '197'); //Gerenciamento Feriado Municipal
define('SUBMENU_ALERTAS_ALUNOS_SEM_TURMA', '167'); //Alertas Alunos sem Turma
define('SUBMENU_ALERTAS_PLANEJAMENTO_DESAT', '168'); //Alertas Planejamento Desatualizado
define('SUBMENU_ALERTAS_TURMAS_INICIAR', '169'); //Alertas Turmas Iniciar
define('SUBMENU_ALERTAS_TURMAS_TERMINAR', '170'); //Alertas Turmas Terminar
define('SUBMENU_PRODUTOS_PRODUTOS', '171'); //Produtos - Produtos
define('SUBMENU_PRODUTOS_TIPO_PRODUTO', '172'); //Produtos Tipo de Produto
define('SUBMENU_PRODUTOS_MOVIMENTACAO_MANUAL', '173'); //Produtos Movimentação Manual de Estoque
define('SUBMENU_POLITICA_COMERCIAL_DESCONTOS', '174'); //Politica Comercial Descontos
define('SUBMENU_POLITICA_COMERCIAL_DIAS_VENCIMENTO', '175'); //Politica Comercial Dias de Vencimento
define('SUBMENU_POLITICA_COMERCIAL_JUROS_MULTA', '176'); //Politica Comercial Multa e Juros de Multa
define('SUBMENU_POLITICA_COMERCIAL_ACRESCIMO', '177'); //Politica Comercial Política de Acréscimo
define('SUBMENU_POLITICA_COMERCIAL_PRODUTOS_SERVICOS', '178'); //Politica Comercial Política Comercial de Produtos/Serviços
define('SUBMENU_CRM_ATENDIMENTOS', '179'); //CRM Atendimentos
define('SUBMENU_CRM_PROSPECCAO', '180'); //CRM Prospecção
define('SUBMENU_CRM_PESSOAS', '181'); //CRM Pessoas
define('SUBMENU_CRM_ORIGEM_INTERESSE', '182'); //CRM Origem de Interesse
define('SUBMENU_CRM_MOTIVO_INTERESSE', '183'); //CRM Motivo do Interesse
define('SUBMENU_CRM_TIPO_ATENDIMENTO', '184'); //CRM Tipo de Atendimento
define('SUBMENU_CRM_OCORRENCIAS_NATUREZA', '185'); //CRM Ocorrências Natureza
define('SUBMENU_CRM_OCORRENCIAS_TIPO_ACAO', '186'); //CRM Ocorrências Tipo de Ação
define('SUBMENU_TRANSPORTE_ESCOLA_ITINERARIO', '187'); //Transporte Escolar Itinerários
define('SUBMENU_ACESSO_SISTEMA_NIVEIS_USUARIO', '188'); //Acesso do Sistema Níveis de Usuário
define('SUBMENU_ACESSO_SISTEMA_FUNCIONALIDADES', '189'); //Acesso do Sistema Funcionalidades
define('SUBMENU_ACESSO_SISTEMA_ACESSOS', '190'); //Acesso do Sistema Acessos
define('SUBMENU_ACESSO_SISTEMA_RELACAO_USUARIOS', '191'); //Acesso do Sistema Relação Usuários / Unidades
define('SUBMENU_MENUS_MENUS', '192'); //Menus - Menus
define('SUBMENU_MENUS_ACESSO_MENUS', '193'); //Menus Acesso ao Menus
define('SUBMENU_MENUS_ACESSO_SUBMENUS', '194'); //Menus Acesso ao SubMenus
define('SUBMENU_POLITICA_COMERCIAL_ESTAGIO', '195'); //Politica Comercial Política Comercial de Estágio
define('SUBMENU_RATEIO_RELATORIO_CENTRO_CURSO', '202'); //Politica Comercial Política Comercial de Estágio
define('SUBMENU_DOMINIOS_MOTIVOS_ESTORNO', '203');//Domínios Motivos de Estorno
define('SUBMENU_DOMINIOS_MOTIVOS_ALTERAR_VENCIMENTO', '204');//Domínios Motivo Alterar Vencimento
define('SUBMENU_LOG_CANCELAMENTO_PARCELA', '205');//Log Cancelamento Parcela
define('SUBMENU_LOG_ESTORNO_PARCELA', '206');//Log Estorno Parcela
define('SUBMENU_LOG_ALTERACAO_VENCIMENTO', '207');//Log de Alteração de Data de Vencimento
define('SUBMENU_PARAMETRIZACAO_MATRICULA', '208');//Parametrização de Matrícula
define('SUBMENU_PARAMETRIZACAO_SISTEMA', '209');//Parametrização do Sistema
define('SUBMENU_OPERADORES_FINANCEIRO', '210');//Parametrização Operadores Fincaneiro
define('SUBMENU_CONTROLE_TURMA_TRANSFERENCIA_ENVOLVIDOS', '211');//Controle de Turmas Transferência de Aluno 
define('SUBMENU_CAIXA_BANCO_LIST_LANCAMENTO_CONTA', '212');//List Lançamento Conta
define('SUBMENU_PARAMETRIZACAO_ATIVIDADE_EXTRA', '213');//Gerenciamento Atividades Extra Curriculares
define('SUBMENU_FINANCEIRO_MATRIZ_DESCONTOS', '214');//Gestão Financeira Matriz de Descontos de Parcelas


/*
 * MEDIA CONFIG
 */
define('IMAGE_W', 1600); //Tamanho da imagem (WIDTH)
define('IMAGE_H', 800); //Tamanho da imagem (HEIGHT)
define('THUMB_W', 800); //Tamanho da miniatura (WIDTH) PDTS
define('THUMB_H', 1000); //Tamanho da minuatura (HEIGHT) PDTS
define('AVATAR_W', 500); //Tamanho da miniatura (WIDTH) USERS
define('AVATAR_H', 500); //Tamanho da minuatura (HEIGHT) USERS
define('SLIDE_W', 1920); //Tamanho da miniatura (WIDTH) SLIDE
define('SLIDE_H', 600); //Tamanho da minuatura (HEIGHT) SLIDE


// TRATAMENTO DE ERROS #####################

//CSS constantes :: Mensagens de Erro

define('WS_ACCEPT', 'accept');

define('WS_INFOR', 'infor');

define('WS_ALERT', 'alert');

define('WS_ERROR', 'error');

/*
  AUTO LOAD DE CLASSES
 */

function MyAutoLoad($Class)
{
    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php') && !is_dir(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php')):
            include_once(__DIR__ . '/' . $dirName . '/' . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;
}

spl_autoload_register("MyAutoLoad");



//WSErro :: Exibe erros lançados :: Front

function WSErro($ErrMsg, $ErrNo, $ErrDie = null) {

    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));

    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";



    if ($ErrDie):

        die;

    endif;

}



//PHPErro :: personaliza o gatilho do PHP

function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {

    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));

    echo "<p class=\"trigger {$CssClass}\">";

    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";

    echo "<small>{$ErrFile}</small>";

    echo "<span class=\"ajax_close\"></span></p>";



    if ($ErrNo == E_USER_ERROR):

        die;

    endif;

}

function getDiaSemana($Dia = null)
{
    $OrderStatus = [
        '0' => 'Domingo',
        '1' => 'Segunda-feira',
        '2' => 'Terça-feira',
        '3' => 'Quarta-feira',
        '4' => 'Quinta-feira',
        '5' => 'Sexta-feira',
        '6' => 'Sábado'
    ];
    if (!empty($Dia)):
        return $OrderStatus[$Dia];
    else:
        return $OrderStatus;
    endif;
}

function getDiaSemanaIngles($Dia = null)
{
    $OrderStatus = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday'
    ];
    if (!empty($Dia)):
        return $OrderStatus[$Dia];
    else:
        return $OrderStatus;
    endif;
}

function getPeriodo($Dia = null)
{
    $OrderStatus = [
        '1' => 'Manhã',
        '2' => 'Tarde',
        '3' => 'Noite'
    ];
    if (!empty($Dia)):
        return $OrderStatus[$Dia];
    else:
        return $OrderStatus;
    endif;
}

function getOrderStatus($Status = null)
{
    $OrderStatus = [
        '0' => 'Aguardando atualização de status',
        '1' => 'Pagamento Autorizado',
        '2' => 'Pagamento confirmado e finalizado',
        '3' => 'Pagamento negado por Autorizador',
        '10' => 'Pagamento cancelado',
        '11' => 'Pagamento cancelado após 23:59 do dia de autorização',
        '12' => 'Aguardando Status de instituição financeira',
        '13' => 'Pagamento cancelado por falha no processamento ou por ação do AF'
    ];
    if (!empty($Status)):
        return $OrderStatus[$Status];
    else:
        return $OrderStatus;
    endif;
}

set_error_handler('PHPErro');