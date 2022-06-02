<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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

if (isset($PostData['quantidade_telefone'])):
    $quantidade_telefone = $PostData['quantidade_telefone'];
    unset($PostData['quantidade_telefone']);
endif;

switch ($action):

    case 'AlunoEditar':

        $Id = $PostData['pessoa_id'];
        unset($PostData['pessoa_id']);

        if($PostData['pessoa_nascimento'] != "") {

            $data_inicial = $PostData['pessoa_nascimento'];
            $data_final = date('Y-m-d');

            function MaiorIdade($data_nasc) {
                list($dia_nasc, $mes_nasc, $ano_nasc) = explode("/", $data_nasc);
                list($dia_hoje, $mes_hoje, $ano_hoje) = explode("/", date("d/m/Y", time()));
                return mktime(23, 59, 59, $mes_nasc, $dia_nasc, $ano_nasc) <
                    mktime(00, 00, 00, $mes_hoje, $dia_hoje, $ano_hoje - 18);
            }

            if (MaiorIdade($data_inicial) == true) {

                if (Check::CPF($PostData['pessoa_cpf']) != true) {
                    $jSON['error'] = 'CPF informado não é válido!';
                    echo json_encode($jSON);
                    die;
                }

                $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf AND pessoa_id != :id AND pessoa_tipo_id = 4", "cpf={$PostData['pessoa_cpf']}&id={$Id}");
                if($Read->getResult()) {
                    $jSON['error'] = 'CPF informado já foi cadastrado!';
                    echo json_encode($jSON);
                    die;
                }

            } else {

                if(empty($PostData['pessoa_responsavel_financeiro_id']) && empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

            }

        } else {
            $jSON['error'] = 'Data de Nascimento não informada!';
            echo json_encode($jSON);
            die;
        }
        
        if ($PostData['catalogo_cep'] == ""):
            $jSON['error'] = 'Informe um CEP!';
        elseif ($PostData['catalogo_bairro'] != true):
            $jSON['error'] = 'Informe um bairro!';
        elseif ($PostData['catalogo_endereco'] != true):
            $jSON['error'] = 'Informe um endereço!';
        else:

            if($quantidade_telefone){
                for($i = 0; $i <= $quantidade_telefone; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){

                        if(!isset($PostData['telefone_' . $i])){
                            $jSON['error'] = 'Informe um telefone!';
                            echo json_encode($jSON);
                            die;
                        }

                        if(!isset($PostData['ramal_' . $i])){
                            $jSON['error'] = 'Informe uma ramal!';
                            echo json_encode($jSON);
                            die;
                        }


                        if(!isset($PostData['observacao_' . $i])){
                            $jSON['error'] = 'Informe uma observação!';
                            echo json_encode($jSON);
                            die;
                        }

                    }
                }
            }

            $cadastrar_financeiro = 0;
            $cadastrar_financeiro_padagogico = 0;
            $cadastrar_padagogico = 0;

            if(empty($PostData['pessoa_responsavel_financeiro_id']) && MaiorIdade($data_inicial) == false){

                if(empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um nome do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_cpf_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um CPF do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                } else {

                    if (Check::CPF($PostData['pessoa_cpf_responsavel_financeiro']) != true){
                        $jSON['error'] = 'CPF informado não é válido!';
                        echo json_encode($jSON);
                        die;
                    }

                    if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_financeiro']){
                        $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_financeiro']}");
                    if($Read->getResult()) {
                        $jSON['error'] = 'CPF informado já foi cadastrado!';
                        echo json_encode($jSON);
                        die;
                    }

                }

                if(empty($PostData['pessoa_rg_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um RG do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_emissor_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um órgão emissor do rg do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                $cadastrar_financeiro = 1;

            }

            if(empty($PostData['pessoa_responsavel_financeiro_id']) && MaiorIdade($data_inicial) == true && !empty($PostData['pessoa_nome_responsavel_financeiro'])){

                if(empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um nome do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_cpf_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um CPF do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                } else {

                    if (Check::CPF($PostData['pessoa_cpf_responsavel_financeiro']) != true){
                        $jSON['error'] = 'CPF informado não é válido!';
                        echo json_encode($jSON);
                        die;
                    }

                    if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_financeiro']){
                        $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_financeiro']}");
                    if($Read->getResult()) {
                        $jSON['error'] = 'CPF informado já foi cadastrado!';
                        echo json_encode($jSON);
                        die;
                    }

                }

                if(empty($PostData['pessoa_rg_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um RG do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_emissor_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um órgão emissor do rg do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_telefone_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um telefone do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                $cadastrar_financeiro = 1;

            }

            $repetir_responsavel = (!empty($PostData['repetir_responsavel']) ? '1' : '0');

            if($repetir_responsavel == 0) {

                if(empty($PostData['pessoa_responsavel_pedagogico_id']) && MaiorIdade($data_inicial) == false){

                    if(empty($PostData['pessoa_nome_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um nome do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_cpf_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um CPF do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    } else {

                        if (Check::CPF($PostData['pessoa_cpf_responsavel_pedagogico']) != true){
                            $jSON['error'] = 'CPF informado não é válido!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf_responsavel_financeiro'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF dos responsáveis não podem ser iguais!';
                            echo json_encode($jSON);
                            die;
                        }

                        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_pedagogico']}");
                        if($Read->getResult()) {
                            $jSON['error'] = 'CPF informado já foi cadastrado!';
                            echo json_encode($jSON);
                            die;
                        }

                    }

                    if(empty($PostData['pessoa_rg_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um RG do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_emissor_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um órgão emissor do rg do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    $cadastrar_padagogico = 1;

                }

                if(empty($PostData['pessoa_responsavel_pedagogico_id']) && MaiorIdade($data_inicial) == true && !empty($PostData['pessoa_nome_responsavel_pedagogico'])){

                    if(empty($PostData['pessoa_nome_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um nome do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_cpf_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um CPF do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    } else {

                        if (Check::CPF($PostData['pessoa_cpf_responsavel_pedagogico']) != true){
                            $jSON['error'] = 'CPF informado não é válido!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf_responsavel_financeiro'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF dos responsáveis não podem ser iguais!';
                            echo json_encode($jSON);
                            die;
                        }

                        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_pedagogico']}");
                        if($Read->getResult()) {
                            $jSON['error'] = 'CPF informado já foi cadastrado!';
                            echo json_encode($jSON);
                            die;
                        }

                    }

                    if(empty($PostData['pessoa_rg_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um RG do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_emissor_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um órgão emissor do rg do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    $cadastrar_padagogico = 1;

                }

            } else {

                $cadastrar_financeiro_padagogico = 1;

            }

            if($cadastrar_financeiro == 1) {

                $CreatePessoaFinanceiro['pessoa_nome'] = $PostData['pessoa_nome_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_cpf'] = $PostData['pessoa_cpf_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_rg'] = $PostData['pessoa_rg_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_emissor'] = $PostData['pessoa_emissor_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_tipo_id'] = 5;
                $CreatePessoaFinanceiro['pessoa_status'] = 0;

                $Create->ExeCreate("sys_pessoas", $CreatePessoaFinanceiro);
                $responsavel_financeiroid = $Create->getResult();

                $CreatePessoaFinanceiroTelefone['telefone'] = $PostData['pessoa_telefone_responsavel_financeiro'];
                $CreatePessoaFinanceiroTelefone['pessoa_id'] = $responsavel_financeiroid;

                if($cadastrar_financeiro_padagogico == 1) {
                    $responsavel_pedagogicoid = $responsavel_financeiroid;
                }

            }

            if($cadastrar_padagogico == 1 && $cadastrar_financeiro_padagogico == 0) {

                $CreatePessoaPedagogico['pessoa_nome'] = $PostData['pessoa_nome_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_cpf'] = $PostData['pessoa_cpf_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_rg'] = $PostData['pessoa_rg_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_emissor'] = $PostData['pessoa_emissor_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_tipo_id'] = 5;
                $CreatePessoaPedagogico['pessoa_status'] = 0;

                $Create->ExeCreate("sys_pessoas", $CreatePessoaPedagogico);
                $responsavel_pedagogicoid = $Create->getResult();
            }

            if(!isset($responsavel_financeiroid)) {
                $responsavel_financeiroid = $PostData['pessoa_responsavel_financeiro_id'];
            }

            if(!isset($responsavel_pedagogicoid)) {
                $responsavel_pedagogicoid = $PostData['pessoa_responsavel_pedagogico_id'];
            }

            $PostData['pessoa_status'] = (!empty($PostData['pessoa_status']) ? '1' : '0');
            $PostData['pessoa_nascimento'] = (!empty($PostData['pessoa_nascimento']) ? Check::Nascimento($PostData['pessoa_nascimento']) : null);

            $PostData['acesso_sistema'] = (!empty($PostData['acesso_sistema']) ? '1' : '0');
            $PostData['acesso_portal'] = (!empty($PostData['acesso_portal']) ? '1' : '0');
            $UpdateData['pessoa_status'] = $PostData['pessoa_status'];
            $UpdateData['pessoa_nascimento'] = $PostData['pessoa_nascimento'];
            $UpdateData['pessoa_nome'] = $PostData['pessoa_nome'];
            $UpdateData['pessoa_email'] = $PostData['pessoa_email'];
            $UpdateData['pessoa_sexo'] = $PostData['pessoa_sexo'];
            $UpdateData['pessoa_apelido'] = $PostData['pessoa_apelido'];
            $UpdateData['pessoa_cpf'] = $PostData['pessoa_cpf'];
            $UpdateData['pessoa_rg'] = $PostData['pessoa_rg'];
            $UpdateData['pessoa_emissor'] = $PostData['pessoa_emissor'];
            $UpdateData['pessoa_tipo_id'] = $PostData['pessoa_tipo_id'];
            $UpdateData['pessoa_profissao'] = $PostData['pessoa_profissao'];
            $UpdateData['pessoa_observacao'] = $PostData['pessoa_observacao'];
            $UpdateData['pessoa_acesso_sistema'] = $PostData['acesso_sistema'];
            $UpdateData['pessoa_acesso_portal'] = $PostData['acesso_portal'];
            $UpdateData['pessoa_estuda'] = $PostData['pessoa_estuda'];
            $UpdateData['pessoa_trabalha'] = $PostData['pessoa_trabalha'];
            $UpdateData['pessoa_escola_id'] = $PostData['pessoa_escola_id'];
            $UpdateData['pessoa_trabalho_id'] = $PostData['pessoa_trabalho_id'];
            $UpdateData['pessoa_responsavel_financeiro_id'] = $responsavel_financeiroid;
            $UpdateData['pessoa_responsavel_pedagogico_id'] = $responsavel_pedagogicoid;

            $Update->ExeUpdate("sys_pessoas", $UpdateData, "WHERE pessoa_id = :id", "id={$Id}");

            $UpdateDataEndereco['catalogo_cep'] = $PostData['catalogo_cep'];
            $UpdateDataEndereco['catalogo_bairro'] = $PostData['catalogo_bairro'];
            $UpdateDataEndereco['catalogo_observacao'] = $PostData['catalogo_observacao'];
            $UpdateDataEndereco['catalogo_endereco'] = $PostData['catalogo_endereco'];
            $UpdateDataEndereco['catalogo_numero'] = $PostData['catalogo_numero'];
            $UpdateDataEndereco['catalogo_cidade'] = $PostData['catalogo_cidade'];
            $UpdateDataEndereco['catalogo_uf'] = $PostData['catalogo_uf'];
            $UpdateDataEndereco['catalogo_pais'] = $PostData['catalogo_pais'];
            $UpdateDataEndereco['catalogo_complemento'] = $PostData['catalogo_complemento'];
            $UpdateDataEndereco['pessoa_id'] = $Id;
            $Update->ExeUpdate("sys_catalogo_endereco_pessoas", $UpdateDataEndereco, "WHERE pessoa_id = :id", "id={$Id}");

            if($quantidade_telefone){
                $ArrTelefones = [];
                
                for($i = 0; $i <= $quantidade_telefone; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){
                         if(isset($PostData['operadora_' . $i])){
                            $operadora = $PostData['operadora_' . $i];
                        } else {
                            $operadora = null;
                        }
                        if (isset($PostData['telid_' . $i])){
                            $UpdateTelefones['tipo_telefone'] = $PostData['tipo_telefone_' . $i];
                            $UpdateTelefones['telefone'] = $PostData['telefone_' . $i];
                            $UpdateTelefones['ramal'] = $PostData['ramal_' . $i];
                            $UpdateTelefones['operadora'] = $operadora;
                            $UpdateTelefones['observacao'] = $PostData['observacao_' . $i];

                            $Update->ExeUpdate("sys_telefones_pessoas", $UpdateTelefones, "WHERE id = :id", "id={$PostData['telid_' . $i]}");
                            $jSON['redirect'] = "painel.php?exe=escola/alunos/cadastro_alunos&id=" . $Id;
                        } else {
                            $ArrTelefones[] = Array(
                                'pessoa_id' => $Id,
                                'tipo_telefone' => $PostData['tipo_telefone_' . $i],
                                'telefone' => $PostData['telefone_' . $i],
                                'ramal' => $PostData['ramal_' . $i],
                                'operadora' => $operadora,
                                'observacao' => $PostData['observacao_' . $i],
                                'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                                'data_criacao' => date('Y-m-d H:i:s'),
                                'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                            );
                        }
                    }
                }
                if(count($ArrTelefones) > 0){
                    $Create->ExeCreateMulti("sys_telefones_pessoas", $ArrTelefones);
                }
            }


            $jSON['success'] = 'Sua edição foi salva com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_alunos&id=" . $Id;
        endif;
        break;

    case 'AlunoAdd':

        if($PostData['pessoa_nascimento'] != "") {

            $data_inicial = $PostData['pessoa_nascimento'];
            $data_final = date('Y-m-d');

            function MaiorIdade($data_nasc) {
              list($dia_nasc, $mes_nasc, $ano_nasc) = explode("/", $data_nasc); 
              list($dia_hoje, $mes_hoje, $ano_hoje) = explode("/", date("d/m/Y", time()));
              return mktime(23, 59, 59, $mes_nasc, $dia_nasc, $ano_nasc) < 
                     mktime(00, 00, 00, $mes_hoje, $dia_hoje, $ano_hoje - 18);
            }

            if (MaiorIdade($data_inicial) == true) {

                if (Check::CPF($PostData['pessoa_cpf']) != true) {
                    $jSON['error'] = 'CPF informado não é válido!';
                    echo json_encode($jSON);
                    die;
                }

                $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf AND pessoa_tipo_id = 4", "cpf={$PostData['pessoa_cpf']}");
                if($Read->getResult()) {
                    $jSON['error'] = 'CPF informado já foi cadastrado!';
                    echo json_encode($jSON);
                    die;
                }

            } else {

                  if(empty($PostData['pessoa_responsavel_financeiro_id']) && empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                  }

            }

        } else {
            $jSON['error'] = 'Data de Nascimento não informada!';
            echo json_encode($jSON);
            die;
        }

        if ($PostData['catalogo_cep'] == ""):
            $jSON['error'] = 'Informe um CEP!';
        elseif ($PostData['catalogo_bairro'] != true):
            $jSON['error'] = 'Informe um bairro!';
        elseif ($PostData['catalogo_endereco'] != true):
            $jSON['error'] = 'Informe um endereço!';
        else:

            if($quantidade_telefone){
                for($i = 0; $i <= $quantidade_telefone; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){

                        if(!isset($PostData['telefone_' . $i])){
                            $jSON['error'] = 'Informe um telefone!';
                            echo json_encode($jSON);
                            die;
                        }

                        if(!isset($PostData['ramal_' . $i])){
                            $jSON['error'] = 'Informe uma ramal!';
                            echo json_encode($jSON);
                            die;
                        }


                        if(!isset($PostData['observacao_' . $i])){
                            $jSON['error'] = 'Informe uma observação!';
                            echo json_encode($jSON);
                            die;
                        }

                    }
                }
            }

            $cadastrar_financeiro = 0;
            $cadastrar_financeiro_padagogico = 0;
            $cadastrar_padagogico = 0;

            if(empty($PostData['pessoa_responsavel_financeiro_id']) && MaiorIdade($data_inicial) == false){

                if(empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um nome do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_cpf_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um CPF do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                } else {

                    if (Check::CPF($PostData['pessoa_cpf_responsavel_financeiro']) != true){
                        $jSON['error'] = 'CPF informado não é válido!';
                        echo json_encode($jSON);
                        die;
                    }

                    if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_financeiro']){
                        $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_financeiro']}");
                    if($Read->getResult()) {
                        $jSON['error'] = 'CPF informado já foi cadastrado!';
                        echo json_encode($jSON);
                        die;
                    }

                }

                if(empty($PostData['pessoa_rg_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um RG do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_emissor_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um órgão emissor do rg do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_telefone_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um telefone do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                $cadastrar_financeiro = 1;

            }

            if(empty($PostData['pessoa_responsavel_financeiro_id']) && MaiorIdade($data_inicial) == true && !empty($PostData['pessoa_nome_responsavel_financeiro'])){

                if(empty($PostData['pessoa_nome_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um nome do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_cpf_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um CPF do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                } else {

                    if (Check::CPF($PostData['pessoa_cpf_responsavel_financeiro']) != true){
                        $jSON['error'] = 'CPF informado não é válido!';
                        echo json_encode($jSON);
                        die;
                    }

                    if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_financeiro']){
                        $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                        echo json_encode($jSON);
                        die;
                    }

                    $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_financeiro']}");
                    if($Read->getResult()) {
                        $jSON['error'] = 'CPF informado já foi cadastrado!';
                        echo json_encode($jSON);
                        die;
                    }

                }

                if(empty($PostData['pessoa_rg_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um RG do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                if(empty($PostData['pessoa_emissor_responsavel_financeiro'])){
                    $jSON['error'] = 'Informe um órgão emissor do rg do responsável financeiro!';
                    echo json_encode($jSON);
                    die;
                }

                $cadastrar_financeiro = 1;
            }

            $repetir_responsavel = (!empty($PostData['repetir_responsavel']) ? '1' : '0');

            if($repetir_responsavel == 0) {

                if(empty($PostData['pessoa_responsavel_pedagogico_id']) && MaiorIdade($data_inicial) == false){

                    if(empty($PostData['pessoa_nome_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um nome do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_cpf_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um CPF do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    } else {

                        if (Check::CPF($PostData['pessoa_cpf_responsavel_pedagogico']) != true){
                            $jSON['error'] = 'CPF informado não é válido!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf_responsavel_financeiro'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF dos responsáveis não podem ser iguais!';
                            echo json_encode($jSON);
                            die;
                        }

                        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_pedagogico']}");
                        if($Read->getResult()) {
                            $jSON['error'] = 'CPF informado já foi cadastrado!';
                            echo json_encode($jSON);
                            die;
                        }

                    }

                    if(empty($PostData['pessoa_rg_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um RG do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_emissor_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um órgão emissor do rg do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    $cadastrar_padagogico = 1;

                }

                if(empty($PostData['pessoa_responsavel_pedagogico_id']) && MaiorIdade($data_inicial) == true && !empty($PostData['pessoa_nome_responsavel_pedagogico'])){

                    if(empty($PostData['pessoa_nome_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um nome do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_cpf_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um CPF do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    } else {

                        if (Check::CPF($PostData['pessoa_cpf_responsavel_pedagogico']) != true){
                            $jSON['error'] = 'CPF informado não é válido!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF do responsável não pode ser igual ao do aluno!';
                            echo json_encode($jSON);
                            die;
                        }

                        if($PostData['pessoa_cpf_responsavel_financeiro'] == $PostData['pessoa_cpf_responsavel_pedagogico']){
                            $jSON['error'] = 'CPF dos responsáveis não podem ser iguais!';
                            echo json_encode($jSON);
                            die;
                        }

                        $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cpf = :cpf", "cpf={$PostData['pessoa_cpf_responsavel_pedagogico']}");
                        if($Read->getResult()) {
                            $jSON['error'] = 'CPF informado já foi cadastrado!';
                            echo json_encode($jSON);
                            die;
                        }

                    }

                    if(empty($PostData['pessoa_rg_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um RG do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    if(empty($PostData['pessoa_emissor_responsavel_pedagogico'])){
                        $jSON['error'] = 'Informe um órgão emissor do rg do responsável pedagógico!';
                        echo json_encode($jSON);
                        die;
                    }

                    $cadastrar_padagogico = 1;

                }

            } else {

                $cadastrar_financeiro_padagogico = 1;

            }

            if($cadastrar_financeiro == 1) {

                $CreatePessoaFinanceiro['pessoa_nome'] = $PostData['pessoa_nome_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_cpf'] = $PostData['pessoa_cpf_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_rg'] = $PostData['pessoa_rg_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_emissor'] = $PostData['pessoa_emissor_responsavel_financeiro'];
                $CreatePessoaFinanceiro['pessoa_tipo_id'] = 5;
                $CreatePessoaFinanceiro['pessoa_status'] = 0;

                $Create->ExeCreate("sys_pessoas", $CreatePessoaFinanceiro);
                $responsavel_financeiroid = $Create->getResult();

                $CreatePessoaFinanceiroTelefone['telefone'] = $PostData['pessoa_telefone_responsavel_financeiro'];
                $CreatePessoaFinanceiroTelefone['pessoa_id'] = $responsavel_financeiroid;

                $Create->ExeCreate("sys_telefones_pessoas", $CreatePessoaFinanceiroTelefone);

                if($cadastrar_financeiro_padagogico == 1) {
                    $responsavel_pedagogicoid = $responsavel_financeiroid;
                }

            }

            if($cadastrar_padagogico == 1 && $cadastrar_financeiro_padagogico == 0) {

                $CreatePessoaPedagogico['pessoa_nome'] = $PostData['pessoa_nome_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_cpf'] = $PostData['pessoa_cpf_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_rg'] = $PostData['pessoa_rg_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_emissor'] = $PostData['pessoa_emissor_responsavel_pedagogico'];
                $CreatePessoaPedagogico['pessoa_tipo_id'] = 5;
                $CreatePessoaPedagogico['pessoa_status'] = 0;

                $Create->ExeCreate("sys_pessoas", $CreatePessoaPedagogico);
                $responsavel_pedagogicoid = $Create->getResult();
            }

            if(!isset($responsavel_financeiroid)) {
                $responsavel_financeiroid = $PostData['pessoa_responsavel_financeiro_id'];
            }

            if(!isset($responsavel_pedagogicoid)) {
                $responsavel_pedagogicoid = $PostData['pessoa_responsavel_pedagogico_id'];
            }

            $PostData['pessoa_status'] = (!empty($PostData['pessoa_status']) ? '1' : '0');
            $PostData['pessoa_nascimento'] = (!empty($PostData['pessoa_nascimento']) ? Check::Nascimento($PostData['pessoa_nascimento']) : null);
            $PostData['acesso_sistema'] = (!empty($PostData['acesso_sistema']) ? '1' : '0');
            $PostData['acesso_portal'] = (!empty($PostData['acesso_portal']) ? '1' : '0');

            $CreateData['pessoa_status'] = $PostData['pessoa_status'];
            $CreateData['pessoa_estuda'] = $PostData['pessoa_estuda'];
            $CreateData['pessoa_trabalha'] = $PostData['pessoa_trabalha'];
            $CreateData['pessoa_escola_id'] = $PostData['pessoa_escola_id'];
            $CreateData['pessoa_trabalho_id'] = $PostData['pessoa_trabalho_id'];
            $CreateData['pessoa_nascimento'] = $PostData['pessoa_nascimento'];
            $CreateData['pessoa_nome'] = $PostData['pessoa_nome'];
            $CreateData['pessoa_email'] = $PostData['pessoa_email'];
            $CreateData['pessoa_sexo'] = $PostData['pessoa_sexo'];
            $CreateData['pessoa_apelido'] = $PostData['pessoa_apelido'];
            $CreateData['pessoa_cpf'] = $PostData['pessoa_cpf'];
            $CreateData['pessoa_rg'] = $PostData['pessoa_rg'];
            $CreateData['pessoa_emissor'] = $PostData['pessoa_emissor'];
            $CreateData['pessoa_tipo_id'] = $PostData['pessoa_tipo_id'];
            $CreateData['pessoa_profissao'] = $PostData['pessoa_profissao'];
            $CreateData['pessoa_observacao'] = $PostData['pessoa_observacao'];
            $CreateData['pessoa_acesso_sistema'] = $PostData['acesso_sistema'];
            $CreateData['pessoa_acesso_portal'] = $PostData['acesso_portal'];
            $CreateData['pessoa_responsavel_financeiro_id'] = $responsavel_financeiroid;
            $CreateData['pessoa_responsavel_pedagogico_id'] = $responsavel_pedagogicoid;

            $Create->ExeCreate("sys_pessoas", $CreateData);
            $PessoaCreateID = $Create->getResult();

            if($quantidade_telefone){
                $ArrTelefones = [];
                for($i = 0; $i <= $quantidade_telefone; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){

                        if(isset($PostData['operadora_' . $i])){
                            $operadora = $PostData['operadora_' . $i];
                        } else {
                            $operadora = null;
                        }

                        $ArrTelefones[] = Array(
                            'pessoa_id' => $PessoaCreateID,
                            'tipo_telefone' => $PostData['tipo_telefone_' . $i],
                            'telefone' => $PostData['telefone_' . $i],
                            'ramal' => $PostData['ramal_' . $i],
                            'operadora' => $operadora,
                            'observacao' => $PostData['observacao_' . $i],
                            'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                            'data_criacao' => date('Y-m-d H:i:s'),
                            'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                        );
                    }
                }
                $Create->ExeCreateMulti("sys_telefones_pessoas", $ArrTelefones);
            }

            $CreateDataEndereco['catalogo_cep'] = $PostData['catalogo_cep'];
            $CreateDataEndereco['catalogo_bairro'] = $PostData['catalogo_bairro'];
            $CreateDataEndereco['catalogo_observacao'] = $PostData['catalogo_observacao'];
            $CreateDataEndereco['catalogo_endereco'] = $PostData['catalogo_endereco'];
            $CreateDataEndereco['catalogo_numero'] = $PostData['catalogo_numero'];
            $CreateDataEndereco['catalogo_cidade'] = $PostData['catalogo_cidade'];
            $CreateDataEndereco['catalogo_uf'] = $PostData['catalogo_uf'];
            $CreateDataEndereco['catalogo_pais'] = $PostData['catalogo_pais'];
            $CreateDataEndereco['catalogo_complemento'] = $PostData['catalogo_complemento'];
            $CreateDataEndereco['pessoa_id'] = $PessoaCreateID;
            $Create->ExeCreate("sys_catalogo_endereco_pessoas", $CreateDataEndereco);
            $UpdateData['pessoa_catalogo_id'] = $Create->getResult();
            $Update->ExeUpdate("sys_pessoas", $UpdateData, "WHERE pessoa_id = :id", "id={$PessoaCreateID}");


            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_alunos&id=" . $PessoaCreateID;
        endif;

        break;

    /*case 'delete':
        $Id = $PostData['del_id'];

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=escola/alunos/filtro_alunos";

        endif;
        break;*/

    case 'remove_tel':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_telefones_pessoas", "WHERE id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            var_dump($PostData);
            var_dump($Read->getResult()); die;

            $Delete->ExeDelete("sys_telefones_pessoas", "WHERE id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['success'] = 'Telefone foi removido com sucesso!';

        endif;
        break;

    case 'infos_tel':

        $Read->ExeRead("sys_tipo_telefone");
        $TipoOption = "";
        if($Read->getResult()):
            foreach ($Read->getResult() as $Tipo):
                $TipoOption .= "<option value='{$Tipo['tipo_telefone_nome'] }'>{$Tipo['tipo_telefone_nome'] }</option>";
            endforeach;
        endif;

        $Read->ExeRead("sys_operadoras_celular", "WHERE operadora_celular_status = :st", "st=0");
        $OperadoraOption = "";
        if($Read->getResult()):
            foreach ($Read->getResult() as $Operadoras):
                $OperadoraOption .= "<option value='{$Operadoras['operadora_celular_nome'] }'>{$Operadoras['operadora_celular_nome'] }</option>";
            endforeach;
        endif;

        $clone = "<tr><td class='pt-3-half'>";
        $clone .= "<select class='form-control' name='tipo_telefone_".$PostData['numero']."'><option value=''>Selecione um Tipo</option>".$TipoOption."</select>";
        $clone .= "</td><td class='pt-3-half'><input type='tel' name='telefone_".$PostData['numero']."' placeholder='(00) 0000-0000' class='form-control formPhone'></td>";
        $clone .= "<td class='pt-3-half'><input type='number' name='ramal_".$PostData['numero']."' placeholder='Ramal' class='form-control'></td>";
        $clone .= "<td class='pt-3-half'><select name='operadora_".$PostData['numero']."' class='form-control'><option value=''>Selecione uma Operadora</option>".$OperadoraOption."</select></td>";
        $clone .= "<td class='pt-3-half'><input type='text' name='observacao_".$PostData['numero']."' placeholder='Observação' class='form-control'></td>";
        $clone .= "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
        $jSON['success'] = $clone;
        break;

    case 'search':

        $Id = $PostData['id'];
        $dataInicio = $PostData['inicio'];
        $dataFim = $PostData['fim'];

        if($dataInicio == "" || $dataFim == "") {
            $Read->FullRead("SELECT p.projeto_id, ep.estagio_produto_id, ep.estagio_produto_nome, p.projeto_descricao, mo.modalidade_nome, uni.pessoa_nome 
            FROM sys_matriculas AS m 
            INNER JOIN sys_matricula_item AS mi ON m.matricula_id = mi.matricula_item_proposta_id
            LEFT OUTER JOIN sys_projetos AS p ON p.projeto_id = mi.matricula_projeto_id
            LEFT OUTER JOIN sys_estagio_produto AS ep ON mi.matricula_item_produto_id = ep.estagio_produto_id
            LEFT OUTER JOIN sys_modalidades AS mo ON mi.modalidade_id = mo.modalidade_id
            LEFT OUTER JOIN sys_pessoas AS uni ON mi.unidade_id = uni.pessoa_id
            WHERE mi.matricula_item_tipo = 1 AND m.matricula_cliente_id = :id ORDER BY ep.estagio_produto_id", "id={$Id}");
        } else {
            $Read->FullRead("SELECT p.projeto_id, ep.estagio_produto_id, ep.estagio_produto_nome, p.projeto_descricao, mo.modalidade_nome, uni.pessoa_nome 
            FROM sys_matriculas AS m 
            INNER JOIN sys_matricula_item AS mi ON m.matricula_id = mi.matricula_item_proposta_id
            LEFT OUTER JOIN sys_projetos AS p ON p.projeto_id = mi.matricula_projeto_id
            LEFT OUTER JOIN sys_estagio_produto AS ep ON mi.matricula_item_produto_id = ep.estagio_produto_id
            LEFT OUTER JOIN sys_modalidades AS mo ON mi.modalidade_id = mo.modalidade_id
            LEFT OUTER JOIN sys_pessoas AS uni ON mi.unidade_id = uni.pessoa_id
            WHERE mi.matricula_item_tipo = 1 AND m.matricula_cliente_id = :id AND mi.data_criacao BETWEEN ('".$dataInicio."') AND ('".$dataFim."') ORDER BY mi.data_criacao", "id={$Id}");
        }

        $retorno = "";

        if($Read->getResult()) {
            foreach($Read->getResult() as $Resultado) {

                $Read->FullRead("SELECT SUM( case when aula.presenca = 1 then 1 else 0 end ) presente, SUM( case when aula.presenca = 0 then 1 else 0 end ) falta FROM sys_envolvidos_projeto AS ep
                            INNER JOIN sys_projetos AS p ON ep.envolvidos_projeto_projeto_id = p.projeto_id
                            INNER JOIN sys_acompanhamento_aula AS aula ON aula.projeto_id = p.projeto_id
                            WHERE p.projeto_id = :p AND ep.envolvidos_envolvido_id = :id", "p={$Resultado['projeto_id']}&id={$Id}");

                $Presenca = $Read->getResult()[0]['presente'];
                $Falta = $Read->getResult()[0]['falta'];

                $Read->FullRead("SELECT SUM( case when pla.planejamento_status = 2 then 1 else 0 end ) status1,
                            COUNT( pla.planejamento_id ) id FROM sys_planejamento
                            AS pla WHERE pla.planejamento_projeto_id = :projeto", "projeto={$Resultado['projeto_id']}");

                $Realizadas = $Read->getResult()[0]['status1'];
                $Total = $Read->getResult()[0]['id'];

                $total = $Total;
                $parte = $Realizadas;
                if($total != 0){
                    $x = $parte*100/$total;
                } else {
                    $x = 0;
                }
                $x=substr($x,0,strpos($x,'.')+3);

                $retorno .= "<div class='card border_shadow list_retorno_search'><div class='card-body'><div class='row' style='padding: 5px'>";
                $retorno .= "<div class='col-md-6'><label style='color: #422D66'><b>Turma-Curso-Estágio</b></label><br>";
                $retorno .= "<b>{$Resultado['projeto_descricao']} - {$Resultado['estagio_produto_nome']} - {$Resultado['modalidade_nome']}</b></div>";
                $retorno .= "<div class='col-md-6'><label style='color: #422D66'><b>Franquia</b></label><br>";
                $retorno .= "<b>{$Resultado['pessoa_nome']}</b></div></div><div class='row' style='padding: 5px'>";
                $retorno .= "<div class='col-md-3'><label style='color: #422D66'><b>Frequência</b></label><br>";
                $retorno .= "<b>".($Presenca ? $Presenca : 0)."/{$Total}</b></div><div class='col-md-3'><label style='color: #422D66'><b>Faltas</b></label><br>";
                $retorno .= "<b>".($Falta ? $Falta : 0)."</b></div><div class='col-md-6'><label style='color: #422D66'><b>Progresso:</b></label>";
                $retorno .= "<div class='progress md-progress' style='height: 20px'>";
                $retorno .= "<div class='progress-bar' role='progressbar' style='width:" . number_format($x, 0, '.', ',') . "%; height: 20px' aria-valuenow='".number_format($Realizadas, 0, '.', ',') ."' aria-valuemin='0' aria-valuemax='{$Total}'>" . number_format($x, 0, '.', ',');
                $retorno .= "%</div></div></div></div></div></div>";        
            }
            $jSON['success'] = $retorno;
        } else {
            $jSON['error'] = "Sem resultados no período selecionado.";
        }
        break;

endswitch;

echo json_encode($jSON);