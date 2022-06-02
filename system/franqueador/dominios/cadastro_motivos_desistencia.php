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
if ($Id):
    $Read->ExeRead("sys_motivos_desistencias", "WHERE motivo_desistencia_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=franqueador/dominios/cadastro_motivos_desistencia');
        exit;
    endif;
else:
    $CreateUserDefault = [
        "motivo_desistencia_status" => 0
    ];
    $Create->ExeCreate("sys_motivos_desistencias", $CreateUserDefault);
    header("Location: painel.php?exe=franqueador/dominios/cadastro_motivos_desistencia&id={$Create->getResult()}");
    exit;
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
                  <h4 class="card-title"><?= $texto['CadMD'] ?></h4>
                  <p class="card-category"><?= $texto['CadMDi'] ?></p>
              </div>
              <div class="col-md-1">
              </div>
              </div>
          </div>
          <div class="card-body">
            <form class="form_motivos_desistencia">
              
              <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                 <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?> </label>
                    <input type="text" name="motivo_desistencia_nome" value="<?= $motivo_desistencia_nome ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                   
                     <input type="checkbox" name="motivo_desistencia_status" value="1" <?= ($motivo_desistencia_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                  </div>
                </div>
               
              </div>
    
              <br/>
             
              </div>

   
              <br/>

           
               
              <input type="hidden" name="action" value="MotivoDesistenciaAdd"/>
              <input type="hidden" name="motivo_desistencia_id" value="<?= $Id; ?>"/>
                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button> 
                <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>

                 <span rel='single_user_addr' callback='franqueador/MotivoDesistencia' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>

              <button type="submit" class="btn btn-primary pull-right">CANCELAR</button>
              
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
      
    

    </div>
  </div>
</div>


</html>
