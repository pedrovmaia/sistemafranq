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
                                <h4 class="card-title"><?= $texto['VerEMPACV'] ?></h4>
                                <p class="card-category"><?= $texto['VerEMPACVi'] ?></p>
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
    if($permissao["ler"] != 1){
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
                     <label class="bmd-label-floating"><?= $texto['PEOPLEi'] ?></label>
                                             <select disabled style="margin-top: -3px" name="emprestimo_pessoa_id" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                               <?php
                                                  $Read->ExeRead("sys_pessoas");
                                                  if ($Read->getResult()):
                                                      foreach ($Read->getResult() as $Pessoa):
                                                          ?>
                                                           <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['emprestimo_pessoa_id']  == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>
                                                      <?php
                                                      endforeach;
                                                  endif;
                                                  ?>
                                                </select>
                          
                          </div>
                      </div>

                                          <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $Texto['ACRV'] ?></label>
                                             <select disabled style="margin-top: -3px" name="emprestimo_acervo_id" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
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
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTRESRVi'] ?></label>
                            <input disabled type="text" name="emprestimo_data_reserva"  value="<?= date('d/m/Y', strtotime($emprestimo_data_reserva)) ?>" class="form-control formDate">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                      <label class="bmd-label-floating"><?= $texto['DTENTREGi'] ?></label>
                            <input disabled type="text" name="emprestimo_data_entrega" value="<?= date('d/m/Y', strtotime($emprestimo_data_entrega)) ?>" class="form-control formDate">
                          
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
        header('Location: painel.php?exe=franqueador/dominios/cadastro_classificacao_literaria');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDAGOGICO_EMPRESTIMO_ACERVO ?>
  </div>
</div>
