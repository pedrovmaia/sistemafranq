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
                                <h4 class="card-title">VER TESTE</h4>
                                <p class="card-category">Exibição teste</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RH_TESTE_PESSOAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_testes_pessoa", "WHERE testes_pessoa_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_tipo_teste_pessoa">
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
                            <input type="text" disabled value="<?= $testes_pessoa_data ?>" name="testes_pessoa_data" class="form-control formDate">
                        </div>
                    </div>
                     <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label  class="bmd-label-floating">RESPONSÁVEL</label>
                                                   
                                                     <select style="margin-top: -3px" disabled name="testes_pessoa_responsavel_id" value="<?= $testes_pessoa_responsavel_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE O RESPONSÁVEL</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 6");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Pessoa):
                                                                ?>
                                                                <option value="<?= $Pessoa['pessoa_id'] ?>"><?= $Pessoa['pessoa_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                     
                    </div>
                </div>

                            <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating">TIPO DE TESTE</label>
                                                   
                                                     <select style="margin-top: -3px" disabled name="teste_pessoa_tipo_id" value="<?= $teste_pessoa_tipo_id ?>" class="form-control" data-style="btn btn-link">

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
                            <input type="text" disabled name="testes_pessoa_hora" value="<?= $testes_pessoa_hora ?>" class="form-control formDate">
                        </div>
                    </div>
                </div>
                          
                          <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DURAÇÃO</label>
                            <input type="text" disabled value="<?= $testes_pessoa_duracao ?>" name="testes_pessoa_duracao" class="form-control formDate">
                        </div>
                    </div>

                     <div class="col-md-6">
                       <div class="form-group">
                                                    <label class="bmd-label-floating">SITUAÇÃO</label>
                                                    <input type="text" disabled name="teste_pessoa_situacao" value="<?= $teste_pessoa_situacao ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TESTE REALIZADO EM</label>
                            <input type="text" disabled value="<?= $testes_pessoa_data_realizada ?>" name="testes_pessoa_data_realizada" class="form-control formDate">
                        </div>
                    </div>



                     <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating">CURSO-ESTÁGIO</label>
                                                   
                                                     <select style="margin-top: -3px" disabled name="teste_pessoa_produto_id" value="<?= $teste_pessoa_produto_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0">SELECIONE UM CURSO-ESTÁGIO</option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Produto):
                                                                ?>
                                                                <option value="<?= $Estagio['estagio_produto_id'] ?>" <?= ($Estagio['estagio_produto_id'] == $FormData['teste_pessoa_produto_id'] ? 'selected="selected"' : ''); ?>><?= $Estagio['estagio_produto_nome'] ?></option>
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
                            <textarea name="testes_pessoa_observacao" disabled value="<?= $testes_pessoa_observacao ?>" class="form-control" rows="4" cols="50"></textarea>
                    </div>
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
        header('Location: painel.php?exe=rh/cadastro_teste_pessoa');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= RH_TESTE_PESSOAS ?>
  </div>
</div>
