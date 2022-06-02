C<?php
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
                        <h4 class="card-title"><?= $texto['RelGCCC'] ?></h4>
                        <p class="card-category"><?= $texto['CadRELGECAMP'] ?></p>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>

          <div class="card-body">

              <form class="form-cadastro-relacao-gerente-campo-consultor-campo">
                  <div class="form-group">
                      <label for="exampleFormControlSelect1"><?= $texto['GECAMP'] ?></label>
                      <select name="pessoa_principal_id" class="form-control jsys_gerente_consultor_campo" data-style="btn btn-link">
                          <option value="0"><?= $texto['SelGECAMP'] ?></option>
                          <?php
                          $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st AND unidade_id = :unidade", "st=6&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
                          if ($Read->getResult()):
                              foreach ($Read->getResult() as $Coordenador):
                                  ?>
                                  <option value="<?= $Coordenador['pessoa_id'] ?>"><?= $Coordenador['pessoa_nome'] ?></option>
                              <?php
                              endforeach;
                          endif;
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2"><?= $texto['CONSCAMP'] ?></label>
                      <div class="dropdown bootstrap-select show-tick form-control dropup">
                          <select name="consultores[]" multiple="" class="form-control selectpicker" data-style="btn btn-link" id="select_consultores">
                              <option value="0" disabled=""><?= $texto['SelCONSCAMP'] ?></option>
                              <?php
                              $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st AND unidade_id = :unidade", "st=7&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
                              if ($Read->getResult()):
                                  foreach ($Read->getResult() as $Professor):
                                      ?>
                                      <option value="<?= $Professor['pessoa_id'] ?>"><?= $Professor['pessoa_nome'] ?></option>
                                  <?php
                                  endforeach;
                              endif;
                              ?>
                          </select>
                      </div>
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
    ID FUNCIONALIDADE: <?= RH_RELACAO_GERENTE_CAMPO_CONSULTO_CAMPO ?>
  </div>
</div>
