<?php
if (empty($Read)):
  $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">
<div class="content">

      <div id="loader" class="loader"></div>

   <div class="col-lg-12 col-md-12">
      <div class="card">
     <div id="informacoes_basicas" class="border_shadow" style="padding: 15px; background-color: #fff">
<div style="margin-bottom: 20px" class="card-header card-header-primary">
              <div class="row">
                  <div  class="col-md-1">
                      <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title"><?= $texto['ListAssin'] ?></h4>
                      <p class="card-category"><?= $texto['VerListAssin'] ?></p>
                  </div>
              </div>
          </div>
    <div class="site-index">
        <div class="body-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="form_lista_assinaturas" class="form_lista_assinaturas"  method="post" >
                        <fieldset>
                            <legend><?= $texto['EscTrm'] ?></legend>
                            <div class="row" style="margin-bottom: 100px">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?= $texto['TMAS'] ?></label>
                                        <input type="hidden" name="action" value="acompanhamento_aula">
                                        <input type="hidden" class="planejamento" name="planejamento" value="0">
                                        <input type="hidden" class="quantidade_alunos" name="quantidade_alunos" value="0">
                                        <input  autocomplete="off" data-toggle="modal" data-target="#getCodeModalTurma" placeholder="Clique e selecione a turma" id="txt_turma" type="text"   class="form-control">
                                        <input autocomplete="off" name="txt_id_turma" id="txt_id_turma" type="hidden"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><?= $texto['ListASS'] ?></legend>
                            <div class="row">

                                <div class="col-lg-12">

                                    <div id="HTMLtoPDF">

                                        <table class="table_1" border="1" style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <th><?= $texto['Turm'] ?></th>
                                                <th><?= $texto['CRSESTi'] ?></th>
                                            </tr>
                                        </table>

                                        <table class="table_2" border="1" style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <th><?= $texto['HHR'] ?></th>
                                                <th><?= $texto['Modami'] ?></th>
                                            </tr>
                                        </table>

                                        <table class="table_3" border="1" style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <th><?= $texto['RMM'] ?></th>
                                                <th><?= $texto['Prof'] ?></th>
                                            </tr>
                                        </table>

                                        <table border="1" style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <th><?= $texto['DTAi'] ?></th>
                                                <th><?= $texto['OBSi'] ?></th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>

                                        <table class="table_4" border="1" style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <th>Nº</th>
                                                <th><?= $texto['Code'] ?></th>
                                                <th><?= $texto['NomeMi'] ?></th>
                                                <th><?= $texto['ASSIN'] ?></th>
                                            </tr>
                                        </table>

                                 


                                    </div>


                            </div>
                        </fieldset>


                    </form>
                </div>
            </div>
        </div>
  

</div>
    ID FUNCIONALIDADE: <?= ESCOLA_LISTA_ASSINATURA ?>
</div>


<div class="showcase hide-print" id="getCodeModalTurma">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_turma_matricula"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListTurmas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="professor" data-filter-control="input"><?= $texto['Prof'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>