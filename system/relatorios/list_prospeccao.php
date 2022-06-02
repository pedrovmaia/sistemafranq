<?php
if (empty($Read)):
    $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">

<style>
    .headcol {
        position:absolute;
        right:0;
        top:auto;
        border-right: 1px black;
        border-top-width:3px; /*only relevant for first row*/
        margin-top:-3px; /*compensate for top border*/
        background: linear-gradient(#EEEEEE, #EEEEEE, #EEEEEE);
        border-radius: 3px;
    }
    table {
        width:100%;
        margin:auto;
        border-collapse:separate;
        border-spacing:0;
    }
    .fixed-table-body {
        width: auto;
        overflow-x:scroll;
        margin-right:100px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 100px;
        text-align: center;
    }
   .apelido{
              min-width: 200px;
          }
           .nome{
              min-width: 280px;
          }
           .e-mail{
              min-width: 200px;
          }
           .endereco{
              min-width: 400px;
          }
           .bairro{
              min-width: 300px;
          }
            .complemento{
              min-width: 400px;
          }
          .cidade{
              min-width: 400px;
          }
           .cep{
              min-width: 200px;
          }
          .observacao{
              min-width: 500px;
          }
           .escola{
              min-width: 400px;
          }
           .catalogoobs{
              min-width: 400px;
          }
           .cpf{
              min-width: 150px;
          }
          .rg{
              min-width: 150px;
          }
          .filter-control input {
        border: 0.55px !important;
    }
    .filter-control select {
        border: 0.55px solid  !important;
    }
    select.form-control:not([size]):not([multiple]){
      height: 36px;
    }
     
</style>
 
   <div id="loader" class="loader"></div>
   
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
                          <h4 class="card-title">Todas as prospecções</h4>
                          <p class="card-category">Todas prospecções cadastradas</p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RELATORIOS_PROSPECCAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                  if($Read->getResult()){
                      $permissao = $Read->getResult()[0];
                      $_SESSION['permissao'] = $permissao;
                  } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                  }


                $_SESSION['permissao'] = $permissao;
                if($permissao["ler"] == 1){
                ?>

                <div id="toolbar">
                    <br/>
                    <?php
                    if($permissao["inserir"] == 1) {
                        ?>
                        <a href="<?= BASE ?>/painel.php?exe=crm/cadastro_prospeccao"
                           class="btn btn-primary pull-right"><?= $texto['AdcNv'] ?></a>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>

                <div class="border_shadow" style="padding: 20px">
                  <div >
                        <div class="table-wrap">
                <table  class="table table-hover display"
                        id="table"
                        data-toolbar="#toolbar"
                        data-locale="pt-BR"
                        data-show-export="true"
                        data-filter-control="true"
                        data-filter-show-clear="true"
                        data-show-toggle="true"
                        data-show-fullscreen="true"
                        data-show-columns="true"
                        data-minimum-count-columns="2"
                        data-url="_ajax/relatorios/ListProspeccao.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead>
                    <tr>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">ID</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="nome" data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="sexo" data-filter-control="input"><?= $texto['GENE'] ?></th>  
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="apelido" data-field="apelido" data-filter-control="input"><?= $texto['APEL'] ?></th> 
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="e-mail" data-field="e-mail" data-filter-control="input">E-mail</th> 
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="nascimento" data-filter-control="input"><?= $texto['nascm'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="cpf" data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="rg"  data-field="rg" data-filter-control="input">RG</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="emissor" data-filter-control="input"><?= $texto['OrgEM'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="profissao" data-filter-control="input"><?= $texto['PROFSSA'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="observacao"  data-field="observacao" data-filter-control="input"><?= $texto['OBSi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="status" data-filter-control="input"><?= $texto['STASS'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="responsavel" data-filter-control="input"><?= $texto['RESPONSELi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="ie" data-filter-control="input">IE</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="im" data-filter-control="input">IM</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="estuda" data-filter-control="input"><?= $texto['ESTDi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="escola"  data-field="escola" data-filter-control="input"><?= $texto['Schooli'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="grauescolaridade" data-filter-control="input"><?= $texto['GRSDESC'] ?></th> 
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="trabalha" data-filter-control="input"><?= $texto['TRABLi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="trabalho" data-filter-control="input"><?= $texto['WORKi'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="periodo" data-filter-control="input"><?= $texto['PERIOD'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="serie" data-filter-control="input"><?= $texto['SCHGRADE'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="homepage" data-filter-control="input">Homepage</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="facebook" data-filter-control="input">Facebook</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="instagram" data-filter-control="input">Instagram</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="linkedin" data-filter-control="input">Linkedin</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="twitter" data-filter-control="input">Twitter</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="youtube" data-filter-control="input">Youtube</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="cargo" data-filter-control="input"><?= $texto['CRG'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="endereco" data-field="endereco" data-filter-control="input"><?= $texto['ENDEREC'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="numero" data-filter-control="input"><?= $texto['NUMB'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="complemento" data-field="complemento" data-filter-control="input"><?= $texto['COMPLEMT'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="bairro" data-field="bairro" data-filter-control="input"><?= $texto['BAIR'] ?></th>   
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="cep" data-field="cep" data-filter-control="input">CEP</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="cidade" data-field="cidade" data-filter-control="input"><?= $texto['CDDE'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="pais" data-filter-control="input"><?= $texto['PAISS'] ?></th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" data-field="uf" data-filter-control="input">UF</th>
                        <th  data-filter-control-placeholder="⌕" data-sortable="true" class="catalogoobs" data-field="catalogoobs" data-filter-control="input"><?= $texto['OBSi'] ?></th>
                        <th class="acoes headcol" data-field="acoes"><span style="";> <?= $texto['Act'] ?></span>
                    </tr>
                    </thead>
                </table>
              </div>
            </div>
                </div>
                    <?php
                }
                ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= RELATORIOS_PROSPECCAO ?>
    </div>
