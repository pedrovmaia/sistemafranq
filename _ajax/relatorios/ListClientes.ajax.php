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

        $Read->FullRead("SELECT 
                  pessoa.pessoa_id,
                  pessoa.pessoa_nome,
                  CASE
                    WHEN pessoa.pessoa_sexo = '1' THEN 'Masculino'
                    ELSE 'Feminimo'
                    END AS pessoa_sexo,
                  CASE
                    WHEN pessoa.pessoa_status = '0' THEN 'Ativado'
                    ELSE 'Desativado'
                    END AS pessoa_status_descricao,
                  
                   CASE
                    WHEN pessoa.pessoa_estuda = '1' THEN 'Não'
                    ELSE 'Sim'
                    END AS pessoa_estuda,
                  
                  CASE
                    WHEN pessoa.pessoa_trabalha = '1' THEN 'Não'
                    ELSE 'Sim'
                    END AS pessoa_trabalha,
                    
                  pessoa.pessoa_id,  
                  pessoa.pessoa_apelido,
                  pessoa.pessoa_cnpj,
                  pessoa.pessoa_cpf,
                  pessoa.pessoa_email,
                  pessoa.pessoa_rg,
                  pessoa.pessoa_emissor,
                  pessoa.pessoa_profissao,
                  pessoa.pessoa_nascimento,
                  pessoa.pessoa_idioma_ensina,
                  pessoa.pessoa_data,
                  pessoa.pessoa_ie,
                  pessoa.pessoa_im,
                  pessoa.pessoa_observacao,
                  pessoa.pessoa_periodo,
                  pessoa.pessoa_responsavel,
                  pessoa.pessoa_serie,
                  pessoa.pessoa_homepage,
                  pessoa.pessoa_grau_escolaridade,
                  pessoa.pessoa_facebook,
                  pessoa.pessoa_instagram,
                  pessoa.pessoa_linkedin,
                  pessoa.pessoa_twitter,
                  pessoa.pessoa_youtube,
                  cargo.cargo_descricao,
                  endereco.catalogo_endereco,
                  endereco.catalogo_numero,
                  endereco.catalogo_bairro,
                  endereco.catalogo_cep,
                  endereco.catalogo_cidade, 
                  endereco.catalogo_complemento,
                  endereco.catalogo_pais,
                  endereco.catalogo_uf,
                  endereco.catalogo_observacao,
                  tipo.tipo_pessoa_descricao,
                  escola.escola_nome,
                  empresa.empresa_nome
                    FROM sys_pessoas pessoa  
                    LEFT OUTER JOIN sys_cargo  cargo ON cargo.cargo_id = pessoa.pessoa_cargo_id
                    LEFT OUTER JOIN sys_catalogo_endereco_pessoas  endereco ON endereco.pessoa_id = pessoa.pessoa_id
                    LEFT OUTER JOIN sys_tipo_pessoas  tipo ON tipo.tipo_pessoa_id = pessoa.pessoa_tipo_id
                    LEFT OUTER JOIN sys_escola  escola ON escola.escola_id = pessoa.pessoa_escola_id
                    LEFT OUTER JOIN sys_empresas  empresa ON empresa.empresa_id = pessoa.pessoa_trabalho_id
                    
                 WHERE pessoa.pessoa_tipo_id = 1
                 AND pessoa.unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}
                 AND pessoa.pessoa_status = 0");
        if($Read->getResult()){
            $manage['total'] = $Read->getRowCount();
            foreach ($Read->getResult() as $Aluno){

                array_push($arr, array(
                    "id" => $Aluno['pessoa_id'],
                    "nome" => $Aluno['pessoa_nome'],
                    "tipo" => $Aluno['tipo_pessoa_descricao'],
                    "sexo" => $Aluno['pessoa_sexo'],
                    "apelido" => $Aluno['pessoa_apelido'],
                    "nascimento" => date('d/m/Y', strtotime($Aluno['pessoa_nascimento'])),
                    "cpf" => $Aluno['pessoa_cpf'],
                    "e-mail" => $Aluno['pessoa_email'],
                    "rg" => $Aluno['pessoa_rg'],
                    "emissor" => $Aluno['pessoa_emissor'],
                    "profissao" => $Aluno['pessoa_profissao'],
                    "observacao" => $Aluno['pessoa_observacao'],
                    "status" => $Aluno['pessoa_status_descricao'],
                    "responsavel" => $Aluno['pessoa_responsavel'],
                    "data" => $Aluno['pessoa_data'],
                    "ie" => $Aluno['pessoa_ie'],
                    "im" => $Aluno['pessoa_im'],
                    "estuda" => $Aluno['pessoa_estuda'],
                    "escola" => $Aluno['escola_nome'],
                    "grauescolaridade" => $Aluno['pessoa_grau_escolaridade'],
                    "trabalha" => $Aluno['pessoa_trabalha'],
                    "trabalho" => $Aluno['empresa_nome'],
                    "periodo" => $Aluno['pessoa_periodo'],
                    "serie" => $Aluno['pessoa_serie'],
                    "homepage" => $Aluno['pessoa_homepage'],
                    "facebook" => $Aluno['pessoa_facebook'],
                    "instagram" => $Aluno['pessoa_instagram'],
                    "linkedin" => $Aluno['pessoa_linkedin'],
                    "twitter" => $Aluno['pessoa_twitter'],
                    "youtube" => $Aluno['pessoa_youtube'],
                    "cargo" => $Aluno['cargo_descricao'],
                    "endereco" => $Aluno['catalogo_endereco'],
                    "numero" => $Aluno['catalogo_numero'],
                    "bairro" => $Aluno['catalogo_bairro'],
                    "complemento" => $Aluno['catalogo_complemento'],
                    "cep" => $Aluno['catalogo_cep'],
                    "cidade" => $Aluno['catalogo_cidade'],
                    "pais" => $Aluno['catalogo_pais'],
                    "uf" => $Aluno['catalogo_uf'],
                    "catalogoobs" => $Aluno['catalogo_observacao'],
                    "acoes" => "<span class='td-actions'>" . ($_SESSION['permissao']['ler'] == 1 ? "<a rel='tooltip' href='painel.php?exe=escola/alunos/ver_alunos&id={$Aluno["pessoa_id"]}' title='Ver' class='btn btn-primary btn-link mr-1'><i class='material-icons'>visibility</i></a>" : '') . " ". "</span>"
                    )
                );
            }
            $manage['rows'] = $arr;
            echo json_encode($manage);
        }
        break;
endswitch;