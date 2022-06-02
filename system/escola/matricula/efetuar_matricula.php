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
             
                    <form class="form_efetuar_matricula" id="wizard_example" action="" autocomplete="off">
                        <fieldset>
                            <legend>Informe o futuro aluno</legend>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>LOCALIZE O ALUNO</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e selecione o aluno" id="txt_aluno" type="text" name="pessoa_nome"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_aluno" data-remove2="txt_cpf" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_aluno" type="hidden" name="pessoa_id" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><?= $texto['CPF'] ?></label>
                                        <input readonly type="text" name="pessoa_cpf" id="txt_cpf" class="form-control">
                                    </div>
                                </div>

                                 <div class="col-lg-6" id="div_image_aluno" style="display: none">

                                    <div class="form-group"> 
                                   
                                       <img style="width: 150px; height: 150px; margin-left: 50px; border-radius: 8px; border-color: #000" src="assets/img/pessoa.jpg">
                                   </div>

                                 </div>
                                
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Informe a curso</legend>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input readonly autocomplete="off" data-toggle="modal" data-target="#getCodeModalProposta" placeholder="Clique e selecione a proposta" id="txt_proposta" type="text" name="proposta_nome"  class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_proposta" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" id="txt_id_proposta" type="hidden" name="proposta_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                      <label>Descrição</label>
                                        <input type="text" class="form-control" name="descricao" placeholder="Insira uma descrição">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Dia de vencimento</label>
                                        <select class="form-control" name="dia_vencimento">
                                            <option value="" selected disabled>Selecione o dia de vencimento</option>
                                            <?php
                                            $Read->ExeRead("sys_dias_vencimento", "WHERE dias_vencimento_status = :st", "st=0");
                                            if($Read->getResult()){
                                                foreach ($Read->getResult() as $Vencimento) {
                                                    ?>
                                                        <option value="<?= $Vencimento['dias_vencimento_id'] ?>"><?= $Vencimento['dias_vencimento_nome'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Escolha a turma</legend>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                       <label for="exampleInputEmail1">TURMA</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input readonly autocomplete="off" data-toggle="modal" data-target="#getCodeModalTurma" placeholder="Clique e selecione a turma" id="txt_turma" type="text"   class="form-control">
                                            <div class="input-group-prepend">
                                                <div data-remove1="txt_turma" data-remove2="txt_id_turma" class="input-group-text j_click_limpa_lookup" style="color: red; cursor: pointer">X</div>
                                            </div>
                                        </div>
                                        <input autocomplete="off" name="txt_id_turma" id="txt_id_turma" type="hidden"  class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                  <legend>ou Lista de espera</legend>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Período de preferência</label>
                                        <select class="form-control" name="periodo_preferencia">
                                            <option disabled selected value="0">Selecione um período</option>
                                            <option value="1">Manhã</option>
                                            <option value="2">Tarde</option>
                                            <option value="3">Noite</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Dia de preferência</label>
                                        <select class="form-control" name="dia_semana_preferencia">
                                            <option disabled selected value="0">Selecione um dia da semana</option>
                                            <option value="1">Segunda-feira</option>
                                            <option value="2">Terça-feira</option>
                                            <option value="3">Quarta-feira</option>
                                            <option value="4">Quinta-feira</option>
                                            <option value="5">Sexta-feira</option>
                                            <option value="6">Sábado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Horário de preferência</label>
                                        <input type="text" class="form-control formTime" name="horario_preferencia" placeholder="00:00">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefone de contato</label>
                                        <input type="text" class="form-control formPhone" name="telefone_contato" placeholder="(00) 00000-0000">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Finalizar matrícula</legend>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">OBSERVAÇÃO</label>
                                        <input type="email" class="form-control" name="observacao" placeholder="Digite uma observação">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <input type="hidden" name="action" value="MatriculaAdd">
                    </form>
                </div>
            </div>
           
        </div>
    </div>
    </div>


     <div id="getCodeModal" class="modal fade in" >
  <div class="modal-dialog modal-confirm">
    <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
      <div class="modal-header" style=" border-bottom: none">
         <h4 class="card-title  text-center">LOCALIZAR CLIENTES E ALUNOS</h4>
         

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body text-center">
         

          <div class="border_shadow" style="background-color: #fff; padding: 20px">
                  <table  class="table table-hover display"
                          id="table_modal_aluno_matricula"
                          data-toolbar="#table"
                          data-locale="pt-BR"                         
                          data-filter-control="true"
                          data-minimum-count-columns="2"
                          data-url="_ajax/lookups/ListClientesAlunos.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="nome"
                          data-toggle="table"
                          data-select-item-name="nome"
                          data-buttons-class="primary"

                          >
                      <thead>
                      <tr>
                          <th data-radio="true"></th> 
                         
                          <th data-field="id" data-filter-control="input">ID</th>
                           <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                           <th  data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                          
                      </tr>
                      </thead>
                  </table>
                  </div>
      </div>
    </div>


  </div>
</div>

<div id="getCodeModalProposta" class="modal fade in">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
            <div class="modal-header" style=" border-bottom: none">
                <h4 class="card-title  text-center">LOCALIZAR PROPOSTA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <div class="border_shadow" style="background-color: #fff; padding: 20px">
                    <table  class="table table-hover display"
                            id="table_modal_proposta_matricula"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListPropostas.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary">
                        <thead>
                            <tr>
                                <th data-radio="true"></th>
                                <th data-field="id" data-filter-control="input">ID</th>
                                <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                                <th  data-field="total" data-filter-control="input">Valor Total</th>
                                <th  data-field="entrada" data-filter-control="input">Entrada</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="getCodeModalTurma" class="modal fade in">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content" style=" background-color: #EAEAEA; width: 600px; height: auto">
            <div class="modal-header" style=" border-bottom: none">
                <h4 class="card-title  text-center">LOCALIZAR TURMA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <div class="border_shadow" style="background-color: #fff; padding: 20px">
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
                            data-buttons-class="primary">
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="professor" data-filter-control="input">Professor</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    ID FUNCIONALIDADE: <?= ESCOLA_CURSO ?>
</div>
