<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$FuncionalidadeId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($FuncionalidadeId):
    $Read->ExeRead("sys_funcionalidades", "WHERE funcionalidade_id = :id", "id={$FuncionalidadeId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=admin/acesso/cadastro_funcionalidades');
        exit;
    endif;
else:

    $CreateUserDefault = [
        "funcionalidade_nome" => null
    ]; 

    $Create->ExeCreate("sys_funcionalidades", $CreateUserDefault);
    header("Location: painel.php?exe=admin/acesso/cadastro_funcionalidades&id={$Create->getResult()}");
    exit;
endif;
?>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title"><?= $texto['CadFUNCTS'] ?></h4>
            <p class="card-category"><?= $texto['CadFUNCTSi'] ?></p>
          </div>
          <div class="card-body">
            <form class="form_cadastro_funcionalidade">
              
              <div id="informacoes_basicas" class="border border-secondary" style="padding: 15px;">
                 <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?></label>
                    <input type="text" value="<?= $funcionalidade_nome ?>" name="funcionalidade_nome" class="form-control">
                  </div>
                </div>

              </div>
    
              <br/>
             
              </div>

   
              <br/>

           
               
              <input type="hidden" name="action" value="FuncionalidadesAdd"/>
               <input type="hidden" name="funcionalidade_id" value="<?= $FuncionalidadeId; ?>"/>

                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button> 
                <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>

               <span rel='single_user_addr' callback='Funcionalidades' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $FuncionalidadeId; ?>'><?= $texto['Del'] ?></span>

                <a href="<?= BASE ?>/painel.php?exe=admin/acesso/list_funcionalidades" class="btn btn-warning pull-right"><?= $texto['RETURN'] ?></a>
                <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
      
    

    </div>
  </div>
</div>


</html>
