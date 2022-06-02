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
                                <h4 class="card-title"><?= $texto['CadEMPACV'] ?></h4>
                                <p class="card-category"><?= $texto['CadEMPACVi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_EMPRESTIMO_ACERVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_emprestimo_acervo", "WHERE emprestimo_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_emprestimo_acervo">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                     <label class="bmd-label-floating"><?= $Texto['ACRV'] ?></label>
                                             <select style="margin-top: -3px" name="emprestimo_acervo_id" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                <option value="0"><?= $texto['SelACRV'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_acervo");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Acervo):
                                                          ?>
                                                           <option value="<?= $Acervo['acervo_id'] ?>" <?php if ($FormData['emprestimo_acervo_id']  == $Acervo['acervo_id'] ) { echo "selected";}  ?>  ><?php echo $Acervo['acervo_titulo']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>
                          
                          </div>
                      </div>

                                          <div class="col-md-6">
                        <div class="form-group">
                                        <label><?= $texto['LOCALP'] ?></label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_pessoa" type="text" name="emprestimo_pessoa_id"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_pessoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_pessoa" type="hidden" name="emprestimo_pessoa_id" class="form-control">

                        </div>
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTRESRVi'] ?></label>
                            <input type="text" name="emprestimo_data_reserva"  value="<?= date('d/m/Y', strtotime($emprestimo_data_reserva)) ?>" class="form-control formDate">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                      <label class="bmd-label-floating"><?= $texto['DTENTREGi'] ?></label>
                            <input type="text" name="emprestimo_data_entrega" value="<?= date('d/m/Y', strtotime($emprestimo_data_entrega)) ?>" class="form-control formDate">
                          
                          </div>
                      </div>
                  </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" name="emprestimo_status" value="1" <?= ($emprestimo_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                        </div>
                    </div>
                
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="EmprestimoEditar"/>
            <input type="hidden" name="emprestimo_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='escola/Emprestimo' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=pedagogico/cadastro_sys_emprestimo_acervo');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_EMPRESTIMO_ACERVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    ?>
    <form class="form_emprestimo_acervo">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
           
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $Texto['ACRV'] ?></label>
                                             <select style="margin-top: -3px" name="emprestimo_acervo_id" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                <option value="0"><?= $texto['SelACRV'] ?></option>
                                               <?php
                                                  $Read->ExeRead("sys_acervo");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Acervo):
                                                          ?>
                                                          <<option value="<?= $Acervo['acervo_id'] ?>"><?= $Acervo['acervo_titulo'] ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>
                          </div>
                      </div>

                                          <div class="col-md-6">
                        <div class="form-group">
                                        <label><?= $texto['LOCALP'] ?></label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e seleciona a pessoa" id="txt_pessoa" type="text" class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_pessoa" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_pessoa" type="hidden" name="emprestimo_pessoa_id" class="form-control">

                        </div>
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTRESRVi'] ?></label>
                            <input type="text" name="emprestimo_data_reserva"class="form-control formDate">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                      <label class="bmd-label-floating"><?= $texto['DTENTREGi'] ?></label>
                            <input type="text" name="emprestimo_data_entrega" class="form-control formDate">
                          
                          </div>
                      </div>
                  </div>
            <br/>
        </div>
        <br/>
        <input type="hidden" name="action" value="EmprestimoAdd"/>
        <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
        <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
        <div class="clearfix"></div>
    </form>
    <?php
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDAGOGICO_EMPRESTIMO_ACERVO ?>
  </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_pessoas"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListPessoas.ajax.php?action=list"
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
                            <th  data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>