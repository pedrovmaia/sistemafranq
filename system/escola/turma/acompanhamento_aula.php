<?php
if (empty($Read)):
  $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">
<div class="content">
      <div id="loader" class="loader"></div>
     <div id="informacoes_basicas" class="border_shadow" style="padding: 15px; background-color: #fff">
    <div class="site-index">
        <div class="body-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="form_acompanhamento_aulas" class="form_acompanhemento_aulas"  method="post" >
                        <fieldset>
                            <legend><?= $texto['EscTrm'] ?></legend>
                            <div class="row" style="margin-bottom: 100px">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?= $texto['TMAS'] ?></label>
                                        <input type="hidden" name="action" value="acompanhamento_aula">
                                        <input type="hidden" class="planejamento" name="planejamento" value="0">
                                        <input type="hidden" class="quantidade_alunos" name="quantidade_alunos" value="0">

                                        <input type="hidden" class="quantidade_avaliacoes" name="quantidade_avaliacoes" value="0">
                                        <input type="hidden" class="quantidade_homework" name="quantidade_homework" value="0">
                                        <input type="hidden" class="quantidade_exercicios" name="quantidade_exercicios" value="0">
                                        <input type="hidden" class="quantidade_materias" name="quantidade_materias" value="0">
                                        <input type="hidden" class="etapa" name="etapa" value="0">

                                        <input  autocomplete="off" data-toggle="modal" data-target="#getCodeModalTurma" placeholder="Clique e selecione a turma" id="txt_turma" type="text"   class="form-control">
                                        <input autocomplete="off" name="txt_id_turma" id="txt_id_turma" type="hidden"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><?= $texto['PLANNS'] ?></legend>
                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="card-body table-responsive" style="padding: 0">
                                        <table class="table table-hover tabela_planejamento_acompanhamento_aulas">
                                            <thead>
                                                <tr>
                                                    <th><?= $texto['DTAi'] ?></th>
                                                    <th><?= $texto['dsc'] ?></th>
                                                    <th><?= $texto['HRINIC'] ?></th>
                                                    <th><?= $texto['HRFINA'] ?></th>
                                                    <th><?= $texto['ACSSE'] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><?= $texto['ConcAla'] ?></legend>
                            <div class="row">

                                <div class="col-lg-12 mb-3">
                                    <div class="card" style="margin: 0">
                                        <div class="card-header" id="headingOne" style="padding: 0.75rem 0.5rem;">
                                            <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <span class="card-title"><strong><?= $texto['ListPRES'] ?></strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body table-responsive" style="padding: 0.9375rem 0px;">
                                                <table class="table table-hover tabela_turma_acompanhamento_aulas">
                                                    <thead>
                                                    <tr>
                                                        <th><?= $texto['NomeMi'] ?></th>
                                                        <th>E-mail</th>
                                                        <th><?= $texto['Presen'] ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card" style="margin: 0">
                                        <div class="card-header" id="headingThree" style="padding: 0.75rem 0.5rem;">
                                            <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                <span class="card-title"><strong>Matérias</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body table-responsive" style="padding: 0.9375rem 0px;">
                                                <table class="table table-hover tabela_turma_materias_aulas" style="max-width: 40%">
                                                    <thead>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <input readonly name="materias_da_aula" type="text" class="form-control materias_da_aula">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card" style="margin: 0">
                                        <div class="card-header" id="headingFour" style="padding: 0.75rem 0.5rem;">
                                            <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                <span class="card-title"><strong><?= $texto['AVALi'] ?></strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                            <div class="card-body table-responsive" style="padding: 0.9375rem 0px;">
                                                <table class="table table-hover tabela_turma_avaliacao_aulas">
                                                    <thead>
                                                    <tr>
                                                        <th><?= $texto['ALNSE'] ?></th>
                                                        <th><?= $texto['AVALIO'] ?></th>
                                                        <th><?= $texto['NOTEA'] ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card" style="margin: 0">
                                        <div class="card-header" id="headingTwo" style="padding: 0.75rem 0.5rem;">
                                            <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                <span class="card-title"><strong>Home Work</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body table-responsive" style="padding: 0.9375rem 0px;">
                                                <table class="table table-hover tabela_turma_homework_aulas">
                                                    <thead>
                                                    <tr>
                                                        <th><?= $texto['ALNSE'] ?></th>
                                                        <th><?= $texto['ATIVDS'] ?></th>
                                                        <th><?= $texto['NOTEA'] ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card" style="margin: 0">
                                        <div class="card-header" id="headingFive" style="padding: 0.75rem 0.5rem;">
                                            <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                <span class="card-title"><strong><?= $texto['EXCERCV'] ?></strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                            <div class="card-body table-responsive" style="padding: 0.9375rem 0px;">
                                                <table class="table table-hover tabela_turma_exercicio_aulas">
                                                    <thead>
                                                    <tr>
                                                        <th><?= $texto['ALNSE'] ?></th>
                                                        <th><?= $texto['EXCERCV'] ?></th>
                                                        <th><?= $texto['NOTEA'] ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
         ID FUNCIONALIDADE: <?= ESCOLA_ACOMPANHAMENTO_AULAS ?>
</div>
</div>

<div class="showcase hide-print" id="getCodeModalTurma">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_turma_acompanhamento_aula"
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