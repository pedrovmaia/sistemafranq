<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
    $Email = new Email;
    $trigger = new Trigger;
endif;

if (isset($PostData['quantidade_telefone'])):
    $quantidade_telefone = $PostData['quantidade_telefone'];
    unset($PostData['quantidade_telefone']);
endif;

switch ($action):

    case 'FranquiaEditar':

        if (Check::Email($PostData['pessoa_email']) != true):
            $jSON['error'] = 'E-mail informado não é válido!';
        elseif ($PostData['pessoa_cnpj'] == ''):
            $jSON['error'] = 'CPF informado não é válido!';
        elseif ($PostData['catalogo_cep'] == ""):
            $jSON['error'] = 'Informe um CEP!';
        elseif ($PostData['catalogo_bairro'] != true):
            $jSON['error'] = 'Informe um bairro!';
        elseif ($PostData['catalogo_endereco'] != true):
            $jSON['error'] = 'Informe um endereço!';
        else:
            $Id = $PostData['pessoa_id'];
            unset($PostData['pessoa_id']);

            $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cnpj = :cpf AND pessoa_id != :id", "cpf={$PostData['pessoa_cnpj']}&id={$Id}");
            if($Read->getResult()) {
                $jSON['error'] = 'CPF informado já foi cadastrado!';
                echo json_encode($jSON);
                die;
            }

            $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_email = :email AND pessoa_id != :id", "email={$PostData['pessoa_email']}&id={$Id}");
            if($Read->getResult()) {
                $jSON['error'] = 'E-mail informado já está em uso!';
                echo json_encode($jSON);
                die;
            }

            $Read->FullRead("SELECT acesso_pessoa_id FROM sys_acesso_pessoas WHERE acesso_email = :email AND acesso_pessoa_id != :id", "email={$PostData['pessoa_email']}&id={$Id}");
            if($Read->getResult()) {
                $jSON['error'] = 'E-mail informado já está em uso!';
                echo json_encode($jSON);
                die;
            }

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

                        if(!isset($PostData['operadora_' . $i])){
                            $jSON['error'] = 'Informe uma operadora!';
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

            $PostData['pessoa_status'] = (!empty($PostData['pessoa_status']) ? '1' : '0');
            $PostData['pessoa_nascimento'] = (!empty($PostData['pessoa_nascimento']) ? Check::Nascimento($PostData['pessoa_nascimento']) : date('Y-m-d H:i:s'));

           
            $UpdateData['pessoa_status'] = $PostData['pessoa_status'];
            $UpdateData['pessoa_nascimento'] = $PostData['pessoa_nascimento'];
            $UpdateData['pessoa_nome'] = $PostData['pessoa_nome'];
            $UpdateData['pessoa_email'] = $PostData['pessoa_email'];
           
            $UpdateData['pessoa_apelido'] = $PostData['pessoa_apelido'];
            $UpdateData['pessoa_cnpj'] = $PostData['pessoa_cnpj'];
            $UpdateData['pessoa_ie'] = $PostData['pessoa_ie'];
            $UpdateData['pessoa_im'] = $PostData['pessoa_im'];
            $UpdateData['pessoa_tipo_id'] = $PostData['pessoa_tipo_id'];
            $UpdateData['pessoa_observacao'] = $PostData['pessoa_observacao'];
        
            $UpdateData['pessoa_homepage'] = $PostData['pessoa_homepage'];
            $UpdateData['pessoa_responsavel'] = $PostData['pessoa_responsavel'];


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
                        if (isset($PostData['telid_' . $i])){
                            $UpdateTelefones['tipo_telefone'] = $PostData['tipo_telefone_' . $i];
                            $UpdateTelefones['telefone'] = $PostData['telefone_' . $i];
                            $UpdateTelefones['ramal'] = $PostData['ramal_' . $i];
                            $UpdateTelefones['operadora'] = $PostData['operadora_' . $i];
                            $UpdateTelefones['observacao'] = $PostData['observacao_' . $i];

                            $Update->ExeUpdate("sys_telefones_pessoas", $UpdateTelefones, "WHERE id = :id", "id={$PostData['telid_' . $i]}");
                            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/cadastro_franquia&id=" . $Id;
                        } else {
                            $ArrTelefones[] = Array(
                                'pessoa_id' => $Id,
                                'tipo_telefone' => $PostData['tipo_telefone_' . $i],
                                'telefone' => $PostData['telefone_' . $i],
                                'ramal' => $PostData['ramal_' . $i],
                                'operadora' => $PostData['operadora_' . $i],
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


            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_franquia";
        endif;
        break;

    case 'FranquiaAdd':

        if (Check::Email($PostData['pessoa_email']) != true):
            $jSON['error'] = 'E-mail informado não é válido!';
        elseif ($PostData['pessoa_cnpj'] == ""):
            $jSON['error'] = 'CPF informado não é válido!';
        elseif ($PostData['catalogo_cep'] == ""):
            $jSON['error'] = 'Informe um CEP!';
        elseif ($PostData['catalogo_bairro'] != true):
            $jSON['error'] = 'Informe um bairro!';
        elseif ($PostData['catalogo_endereco'] != true):
            $jSON['error'] = 'Informe um endereço!';
       
        else:

            $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cnpj = :cpf", "cpf={$PostData['pessoa_cnpj']}");
            if($Read->getResult()) {
                $jSON['error'] = 'CPF informado já foi cadastrado!';
                echo json_encode($jSON);
                die;
            }

            $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_email = :email", "email={$PostData['pessoa_email']}");
            if($Read->getResult()) {
                $jSON['error'] = 'E-mail informado já foi cadastrado!';
                echo json_encode($jSON);
                die;
            }

            $Read->FullRead("SELECT acesso_pessoa_id FROM sys_acesso_pessoas WHERE acesso_email = :email", "email={$PostData['pessoa_email']}");
            if($Read->getResult()) {
                $jSON['error'] = 'E-mail informado já foi cadastrado!';
                echo json_encode($jSON);
                die;
            }

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

                        if(!isset($PostData['operadora_' . $i])){
                            $jSON['error'] = 'Informe uma operadora!';
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

            $PostData['pessoa_status'] = (!empty($PostData['pessoa_status']) ? '1' : '0');
            $PostData['pessoa_nascimento'] = (!empty($PostData['pessoa_nascimento']) ? Check::Nascimento($PostData['pessoa_nascimento']) : date('Y-m-d H:i:s'));

            $PostData['pessoa_data'] = (!empty($PostData['pessoa_data']) ? Check::Nascimento($PostData['pessoa_data']) : date('Y-m-d H:i:s'));

            $CreateData['pessoa_status'] = $PostData['pessoa_status'];
            $CreateData['pessoa_nascimento'] = $PostData['pessoa_nascimento'];
            $CreateData['pessoa_nome'] = $PostData['pessoa_nome'];
            $CreateData['pessoa_email'] = $PostData['pessoa_email'];
            $CreateData['pessoa_apelido'] = $PostData['pessoa_apelido'];
            $CreateData['pessoa_cnpj'] = $PostData['pessoa_cnpj'];
            $CreateData['pessoa_ie'] = $PostData['pessoa_ie'];
            $CreateData['pessoa_im'] = $PostData['pessoa_im'];
            $CreateData['pessoa_tipo_id'] = $PostData['pessoa_tipo_id'];
            $CreateData['pessoa_observacao'] = $PostData['pessoa_observacao'];
            $CreateData['pessoa_homepage'] = $PostData['pessoa_homepage'];
            $CreateData['pessoa_responsavel'] = $PostData['pessoa_responsavel'];


            $Create->ExeCreate("sys_pessoas", $CreateData);
            $PessoaCreateID = $Create->getResult();

            if($quantidade_telefone){
                $ArrTelefones = [];
                for($i = 0; $i <= $quantidade_telefone; $i++){
                    if(isset($PostData['tipo_telefone_' . $i])){
                        $ArrTelefones[] = Array(
                            'pessoa_id' => $PessoaCreateID,
                            'tipo_telefone' => $PostData['tipo_telefone_' . $i],
                            'telefone' => $PostData['telefone_' . $i],
                            'ramal' => $PostData['ramal_' . $i],
                            'operadora' => $PostData['operadora_' . $i],
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
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_franquia";
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];

        $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

            $Delete->ExeDelete("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=franqueador/franquias/filtro_franquia";

        endif;
        break;

    case 'remove_tel':
        $Id = $PostData['del_id'];
        $Read->ExeRead("sys_telefones_pessoas", "WHERE id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);

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

endswitch;

echo json_encode($jSON);