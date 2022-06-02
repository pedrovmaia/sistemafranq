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
                    <form id="form_planejamento_aulas" class="form_planejamento_aulas"  method="post" >

                        <input id="primeiro_dia" name="primeiro_dia" type="hidden" value="">
                        <input id="primeiro_dia_hora_inicio" name="primeiro_dia_hora_inicio" type="hidden" value="">
                        <input id="primeiro_dia_hora_final" name="primeiro_dia_hora_final" type="hidden" value="">
                        <input id="projeto_grade" name="projeto_grade" type="hidden" value="">
                        <input id="segundo_dia"  name="segundo_dia" type="hidden" value="">
                        <input id="segundo_dia_hora_inicio" name="segundo_dia_hora_inicio" type="hidden" value="">
                        <input id="segundo_dia_hora_final" name="segundo_dia_hora_final" type="hidden" value="">

                        <fieldset>
                            <legend><?= $texto['EscTrm'] ?></legend>
                            <div class="row" style="margin-bottom: 100px">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?= $texto['TMAS'] ?></label>
                                        <input  autocomplete="off" data-toggle="modal" data-target="#getCodeModalTurma" placeholder="Clique e selecione a turma" id="txt_turma" type="text"   class="form-control">
                                        <input autocomplete="off" name="txt_id_turma" id="txt_id_turma" type="hidden">
                                        <input name="pessoa_id" id="pessoa_id" type="hidden">

                                        <input name="modalidade_id" id="modalidade_id" type="hidden">
                                        <input name="produto_id" id="produto_id" type="hidden">

                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><?= $texto['FNZPL'] ?></legend>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?= $texto['OBS'] ?></label>
                                        <input type="email" class="form-control" placeholder="Digite uma observação">
                                    </div>
                                </div>
                                
                                
                            </div>
                        </fieldset>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    ID FUNCIONALIDADE: <?= ESCOLA_PLANEJAMENTO ?>
</div>

<div class="showcase hide-print" id="getCodeModalTurma">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_turma"
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