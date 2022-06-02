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
            <h4 class="card-title"><?= $texto['RelPEOPSUNIT'] ?></h4>
            <p class="card-category"><?= $texto['CadPEOPSUNIT'] ?></p>
          </div>
          <div class="card-body">

              <form class="form_relacao_pessoas_unidades">
                  <div class="form-group">
                      <label for="exampleFormControlSelect1"><?= $texto['PEOPLE'] ?></label>
                      <select name="pessoa_id" class="form-control jsys_relacao_pessoas_unidades_pessoa" data-style="btn btn-link" id="exampleFormControlSelect1">
                          <option value="0"><?= $texto['SelPEOP'] ?></option>
                          <?php
                          $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE unidade_id = :id AND pessoa_tipo_id = :p", "id={$_SESSION['userSYSFranquia']['unidade_padrao']}&p=6");
                          if ($Read->getResult()):
                              foreach ($Read->getResult() as $Pessoa):
                                  ?>
                                  <option value="<?= $Pessoa['pessoa_id'] ?>"><?= $Pessoa['pessoa_nome'] ?></option>
                              <?php
                              endforeach;
                          endif;
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2"><?= $texto['PERMUNITS'] ?></label>
                      <select name="unidades[]" multiple class="form-control selectpicker" data-style="btn btn-link" id="select_unidades">

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
