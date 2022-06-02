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
                                <h4 class="card-title"><?= $texto['VerACRV'] ?></h4>
                                <p class="card-category"><?= $texto['VerACRVi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ACERVO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_acervo", "WHERE acervo_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_acervo">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating"><?= $texto['TITE'] ?></label>
                        <input disabled type="text" name="acervo_titulo" value="<?= $acervo_titulo ?>" class="form-control">
                    </div>

                </div>
                <div class="col-md-6">
                <div class="form-group">
                        <label class="bmd-label-floating"><?= $texto['SUBTIT'] ?></label>
                        <input disabled type="text" name="acervo_subtitulo" value="<?= $acervo_subtitulo ?>" class="form-control">
                    </div>

                </div>
            </div>


                                         <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $texto['TYPOBRAS'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="acervo_tipo_obra_id" value="<?= $acervo_tipo_obra_id ?>"  class="form-control jsys_tipo_obra" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelTYPOB'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_tipo_obra", "WHERE tipo_obra_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $TipoObra):
                                                                ?>
                                                                <option value="<?= $TipoObra['tipo_obra_id'] ?>" <?php if ($FormData['acervo_tipo_obra_id']  == $TipoObra['tipo_obra_id'] ) { echo "selected";}  ?>  ><?php echo $TipoObra['tipo_obra_nome']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    </div>

                                      </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $Texto['EDITRA'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="acervo_editora_id" value="<?= $acervo_editora_id ?>" class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelEDTR'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_editora", "WHERE editora_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Editora):
                                                                ?>
                                                                <option value="<?= $Editora['editora_id'] ?>" <?php if ($FormData['acervo_editora_id']  == $Editora['editora_id'] ) { echo "selected";}  ?>  ><?php echo $Editora['editora_nome']; ?></option>
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
                                            <label class="bmd-label-floating"><?= $texto['VOLUMI'] ?></label>
                        <input disabled type="text" name="acervo_volume" value="<?= $acervo_volume ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                                                <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['NUMPAGS'] ?></label>
                        <input disabled type="text" name="acervo_numero_paginas" value="<?= $acervo_numero_paginas ?>" class="form-control">
                    </div>
                </div>                                                 
                                      </div>

                                         <div class="row">
                                            
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['EDITSS'] ?></label>
                        <input disabled type="text" name="acervo_edicao" value="<?= $acervo_edicao ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['YEAREDT'] ?></label>
                        <input disabled type="text" name="acervo_ano_edicao" value="<?= $acervo_ano_edicao ?>" class="form-control">
                                    </div>
                                    </div>
                                    </div>
                                         <div class="row">
                                            
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">ISBN</label>
                        <input disabled type="text" name="acervo_ISBN" value="<?= $acervo_ISBN?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['KEYWOR'] ?></label>
                        <input disabled type="text" name="acervo_palavra_chave" value="<?= $acervo_palavra_chave ?>" class="form-control">



                                            </div>
                </div>
                                                </div>

                                         <div class="row">

                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label  class="bmd-label-floating"><?= $Texto['CLASLIT'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="acervo_classificacao_id" value="<?= $acervo_classificacao_id ?>" class="form-control jsys_instituicao_financeiras" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0"><?= $texto['SelCLASLIT'] ?></option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_classificacao_literaria", "WHERE classificacao_literaria_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Classificacao):
                                                                ?>
                                                                <option value="<?= $Classificacao['classificacao_literaria_id'] ?>" <?php if ($FormData['acervo_classificacao_id']  == $Classificacao['classificacao_literaria_id'] ) { echo "selected";}  ?>  ><?php echo $Classificacao['classificacao_literaria_nome']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    </div>

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
        header('Location: painel.php?exe=franqueador/dominios/cadastro_acervo');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FRANQUEADOR_ACERVO ?>
  </div>
</div>
