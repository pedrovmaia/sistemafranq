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
            <h4 class="card-title"><?= $texto['CadACESSIS'] ?></h4>
            <p class="card-category"><?= $texto['CadACESSISi'] ?></p>
          </div>
          <div class="card-body">

              <form class="form-cadastro-acessos">
                  <div class="form-group">
                      <label for="exampleFormControlSelect1"><?= $texto['NVLACSS'] ?></label>
                      <select name="nivel_acesso" class="form-control jsys_nivel_acesso" data-style="btn btn-link" id="exampleFormControlSelect1">
                          <option value="0"><?= $texto['SelNVLAC'] ?></option>
                          <?php
                          $Read->ExeRead("sys_niveis_acesso", "WHERE niveis_acesso_status = :st", "st=0");
                          if ($Read->getResult()):
                              foreach ($Read->getResult() as $Funcionalidades):
                                  ?>
                                  <option value="<?= $Funcionalidades['niveis_acesso_id'] ?>"><?= $Funcionalidades['niveis_acesso_nome'] ?></option>
                              <?php
                              endforeach;
                          endif;
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect1"><?= $texto['FUNCSYS'] ?></label>
                      <select name="funcionalidade" class="form-control jsys_funcionalidade" data-style="btn btn-link" id="exampleFormControlSelect1">
                          <option value="0"><?= $texto['SelFUNCTS'] ?></option>
                          <?php
                          $Read->ExeRead("sys_funcionalidades", "WHERE 1=1 ORDER BY funcionalidade_nome");
                          if ($Read->getResult()):
                              foreach ($Read->getResult() as $Funcionalidades):
                                  ?>
                                  <option value="<?= $Funcionalidades['funcionalidade_id'] ?>"><?= $Funcionalidades['funcionalidade_nome'] ?></option>
                              <?php
                              endforeach;
                          endif;
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2"><?= $texto['PERMACESSIS'] ?></label>
                      <select name="permissoes[]" multiple class="form-control selectpicker" data-style="btn btn-link" id="select_niveis">

                      </select>
                  </div>
                  <br>
                  <input type="hidden" name="action" value="manager" />
                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                  <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                     <div class="clearfix"></div>
              </form>

          </div>
        </div>
      </div>
      
    

    </div>
  </div>
</div>


</html>
