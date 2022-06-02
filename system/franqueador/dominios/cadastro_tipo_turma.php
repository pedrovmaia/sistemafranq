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
    $Read->ExeRead("sys_tipo_turma", "WHERE tipo_turma_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=franqueador/dominios/cadastro_tipo_turma');
        exit;
    endif;
else:
    $CreateUserDefault = [
        "tipo_turma_status" => 0
    ];
    $Create->ExeCreate("sys_tipo_turma", $CreateUserDefault);
    header("Location: painel.php?exe=franqueador/dominios/cadastro_tipo_turma&id={$Create->getResult()}");
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
                  <h4 class="card-title">CADASTRO DE TIPOS DE TURMAS</h4>
                  <p class="card-category">Cadastro de tipos de turmas</p>
              </div>
              <div class="col-md-1">
              </div>
              </div>
          </div>
          <div class="card-body">
            <form class="form_tipo_turma">
              
              <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                 <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?> </label>
                    <input type="text" name="tipo_turma_nome" value="<?= $tipo_turma_nome ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                   
                     <input type="checkbox" name="tipo_turma_status" value="1" <?= ($tipo_turma_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
                  </div>
                </div>
               
              </div>
    
              <br/>
             
              </div>

   
              <br/>

           
               
              <input type="hidden" name="action" value="TipoTurmaAdd"/>
              <input type="hidden" name="tipo_turma_id" value="<?= $Id; ?>"/>
                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button> 
                <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                <span rel='single_user_addr' callback='franqueador/TipoTurma' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>

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
