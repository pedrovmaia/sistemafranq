<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">CADASTRO DE TESTE DE NÍVEL</h4>
                                <p class="card-category">Cadastro de teste de nível</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RH_TESTE_PESSOAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->FullRead(" SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id AND unidade_id = :unidade", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
    if ($Read->getResult()):
        ?>
        <form class="form_testes_pessoa">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                        <div class="row">
                                    
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">ALUNO</label>
                            <span class="form-control"><?= $Read->getResult()[0]['pessoa_nome'] ?></span>
                        </div>
                    </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DATA PREVISTA</label>
                            <input type="text"  name="testes_pessoa_data" class="form-control formDate">
                        </div>
                    </div>
                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">RESPONSÁVEL</label>
                                            <a data-toggle="modal" data-target="#getCodeModal">
                                                <input readonly type="text" placeholder="Clique e selecione o responsável"  id="txt_pessoa" class="form-control">
                                            </a>
                                            <input  id="txt_id_pessoa" type="hidden" name="testes_pessoa_responsavel_id" class="form-control">
                                        </div>
                                    </div>

                            <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating">TIPO DE TESTE</label>
                                                   
                                                     <select style="margin-top: -3px" name="teste_pessoa_tipo_id" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE UM TIPO</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_tipo_teste_nivel", "WHERE tipo_teste_nivel_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $tipo):
                                                                ?>
                                                                <option value="<?= $tipo['tipo_teste_nivel_id'] ?>"><?= $tipo['tipo_teste_nivel_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                        </div>
                    </div>                
            </div>
                                               
                                            <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">HORÁRIO</label>
                            <input type="text"  name="testes_pessoa_hora" class="form-control ">
                        </div>
                    </div>
                          
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DURAÇÃO</label>
                            <input type="number" placeholder="Em minutos"  name="testes_pessoa_duracao" class="form-control ">
                        </div>
                    </div>
                </div>

             <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating">SITUAÇÃO</label>
                                                   
                                                     <select style="margin-top: -3px" name="teste_pessoa_situacao" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE A SITUAÇÃO</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_situacao_pessoa", "WHERE situacao_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Situacao):
                                                                ?>
                                                                <option value="<?= $Situacao['situacao_id'] ?>"><?= $Situacao['situacao_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                        </div>
                    </div>                          
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TESTE REALIZADO EM</label>
                            <input type="text" name="testes_pessoa_data_realizada" class="form-control formDate">
                        </div>
                    </div>
                </div>
                       
                    <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating">ESTÁGIO DO CURSO</label>                
                              <select style="margin-top: -3px" name="teste_pessoa_produto_id" class="form-control" data-style="btn btn-link">
                                                         <option value="0">SELECIONE UM CURSO-ESTÁGIO</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Estagio):
                                                                ?>
                                                                <option value="<?= $Estagio['estagio_produto_id'] ?>"><?= $Estagio['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                        </div>
                    </div>
                </div>
                        <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="bmd-label-floating">OBSERVAÇÃO</label>
                            <textarea name="testes_pessoa_observacao" class="form-control" rows="4" cols="50"></textarea>
                    </div>
                </div>
            </div>
                
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="TestePessoaAdd"/>
            <input type="hidden" name="testes_pessoa_pessoa_id" value="<?= $Id ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
           
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=rh/cadastro_testes_pessoa');
        exit;
    endif;
    ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= RH_TESTE_PESSOAS ?>
  </div>
</div>
<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_funcionarios"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListFuncionarios.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="cpf" data-filter-control="input"><?= $texto['CRG'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
endif;
?>