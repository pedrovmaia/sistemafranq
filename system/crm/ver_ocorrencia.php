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
                                <h4 class="card-title"><?= $texto['VerOCRR'] ?></h4>
                                <p class="card-category"><?= $texto['VerOCRRi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_OCORRENCIA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_ocorrencia", "WHERE ocorrencia_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        ?>

        <form class="form_ocorrencia">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

               
         <div class="row">
                                    
                                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating"><?= $texto['ALNSE'] ?></label>
                                            <select disabled value="<?= $FormData['ocorrencia_pessoa_id'] ?>" name="ocorrencia_pessoa_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelALNS'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                         <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['ocorrencia_pessoa_id']  == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                        </div>
                    </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTAATNDT'] ?></label>
                            <input disabled type="text" value="<?= date('d/m/Y', strtotime($ocorrencia_data)) ?>" name="ocorrencia_data" class="form-control">
                        </div>
                    </div>
                     <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label  class="bmd-label-floating"><?= $texto['ATNDT'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="ocorrencia_atendente_id" value="<?= $ocorrencia_atendente_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelATNDT'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 6");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Atendente):
                                                                ?>
                                                                  <option value="<?= $Atendente['pessoa_id'] ?>" <?php if ($FormData['ocorrencia_atendente_id']  == $Atendente['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Atendente['pessoa_nome']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                     
                    </div>
                </div>

                            <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating"><?= $texto['Nati'] ?></label>
                                                   
                                                     <select disabled style="margin-top: -3px" name="ocorrencia_natureza_id" value="<?= $ocorrencia_natureza_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelNATRE'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencias_natureza_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Natureza):
                                                                ?>
                                                                 <option value="<?= $Natureza['ocorrencia_natureza_id'] ?>" <?php if ($FormData['ocorrencia_natureza_id']  == $Natureza['ocorrencia_natureza_id'] ) { echo "selected";}  ?>  ><?php echo $Natureza['ocorrencias_natureza_nome']; ?></option>
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
                           <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <textarea disabled name="ocorrencia_descricao"  class="form-control" rows="4" cols="50"> <?= $ocorrencia_descricao ?></textarea>
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
        header('Location: painel.php?exe=crm/cadastro_ocorrencias');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= CRM_OCORRENCIA ?>
  </div>
</div>
