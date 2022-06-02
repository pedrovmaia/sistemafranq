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
                        <h4 class="card-title"><?= $texto['CadACCSSMENSS'] ?></h4>
                        <p class="card-category"><?= $texto['CadACCSSMENSSi'] ?></p>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>

          <div class="card-body">

              <form class="form-cadastro-acessos-menus">
                  <div class="form-group">
                      <label for="exampleFormControlSelect1"><?= $texto['NVLACSS'] ?></label>
                      <select name="nivel_acesso" class="form-control jsys_nivel_acesso_menu" data-style="btn btn-link">
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
                      <label for="exampleFormControlSelect1"><?= $texto['MENSYS'] ?></label>
                      <select name="menu_sistema" class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                          <option value="0"><?= $texto['SelMENUU'] ?></option>
                          <?php
                          $Read->ExeRead("sys_menus", "WHERE menu_status = 1 ORDER BY menu_id");
                          if ($Read->getResult()):
                              foreach ($Read->getResult() as $Menus):
                                  ?>
                                  <option value="<?= $Menus['menu_id'] ?>"><?= $Menus['menu_nome'] ?></option>
                              <?php
                              endforeach;
                          endif;
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2"><?= $texto['PERMACESSIS'] ?></label>
                      <select name="permissao" class="form-control" data-style="btn btn-link">
                          <option value="1"><?= $texto['HVACSS'] ?></option>
                          <option value="2"><?= $texto['DONTHV'] ?></option>
                      </select>
                  </div>
                  <br>
                  <input type="hidden" name="action" value="manager" />
                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                  <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                     <div class="clearfix"></div>
              </form>

              <div class="form-group minhas_permissoes" style="display: none">
                  <label for="exampleFormControlSelect2">Permissões</label>
                  <table class="table table-hover menus">
                      <thead>
                      <tr>
                          <th><?= $texto['NomeMi'] ?></th>
                      </tr>
                      </thead>
                  </table>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</html>
