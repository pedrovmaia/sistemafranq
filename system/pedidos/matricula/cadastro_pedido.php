<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
$Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
$Create = new Create;
endif;

$IdAluno = filter_input(INPUT_GET, 'aluno', FILTER_VALIDATE_INT);
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
                            <h4 class="card-title"><?= $texto['NewPDMT'] ?></h4>
                            <p class="card-category"><?= $texto['INPDMT'] ?></p>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <?php
                  $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                  if ($Id) {

                      $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso",
                          "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel",
                          "func=" . PEDIDOS_PEDIDO . "&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                      $permissao = $Read->getResult()[0];
                      if ($permissao["alterar"] != 1) {
                          echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                          die;
                      }

                  } else {

                      $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso",
                          "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel",
                          "func=" . PEDIDOS_PEDIDO . "&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                      $permissao = $Read->getResult()[0];
                      if ($permissao["inserir"] != 1) {
                          echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                          die;
                      }
                      ?>
                      <form class="form_pedido_matricula">

                          <div class="col-lg-12 mb-3" style="padding-left: 0; padding-right: 0">
                              <div class="card" style="margin: 0">
                                  <div class="card-header" id="headingInforBasica">
                                      <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse"
                                          data-target="#collapseInforBasica" aria-expanded="true"
                                          aria-controls="collapseInforBasica">
                                          <span class="card-title"><strong><?= $texto['informacoesBasicas'] ?></strong></span>
                                          <i class="material-icons" style="float: right">expand_more</i>
                                      </h5>
                                  </div>
                                  <div id="collapseInforBasica" class="collapse show"
                                       aria-labelledby="headingInforBasica" data-parent="#accordion">
                                      <div class="col-md-12">
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating"><?= $texto['CLAL'] ?></label>
                                                      <?php
                                                      if($IdAluno){
                                                          $Read->FullRead("SELECT pessoa_id, pessoa_nome FROM sys_pessoas WHERE pessoa_id = :id", "id={$IdAluno}");
                                                          if($Read->getResult()){
                                                              ?>
                                                              <input readonly type="text" value="<?= $Read->getResult()[0]['pessoa_nome'] ?>" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" id="txt_aluno" class="form-control">
                                                              <input id="txt_id_aluno" value="<?= $Read->getResult()[0]['pessoa_id'] ?>" type="hidden" name="pedido_cliente_id" class="form-control">
                                                              <?php
                                                          } else {
                                                              echo "Aluno Não Existe";
                                                          }
                                                      } else {
                                                          ?>
                                                          <a data-toggle="modal" data-target="#getCodeAlunosModal">
                                                              <input readonly type="text" placeholder="Clique e selecione o cliente / aluno" name="pessoa_nome" id="txt_aluno" class="form-control">
                                                          </a>
                                                          <input id="txt_id_aluno" type="hidden" name="pedido_cliente_id" class="form-control">
                                                          <?php
                                                      }
                                                      ?>
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                      <label class="form-control valor_total"></label>
                                                      <input type="hidden" name="pedido_valor_total" class="pedido_valor_total">
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating"><?= $texto['PATR'] ?></label>
                                                      <select style="margin-top: -3px" class="form-control"
                                                              name="matricula_patrocinador_id">
                                                          <option value=""><?= $texto['EscPATR'] ?></option>
                                                          <?php
                                                          $Read->ExeRead("sys_patrocinadores",
                                                              "WHERE patrocionador_status = :st", "st=0");
                                                          if ($Read->getResult()):
                                                              foreach ($Read->getResult() as $Patrocinador):
                                                                  ?>
                                                                  <option value="<?= $Patrocinador['patrocionador_id'] ?>"><?= $Patrocinador['patrocionador_nome'] ?></option>
                                                              <?php
                                                              endforeach;
                                                          endif;
                                                          ?>
                                                      </select>
                                                  </div>
                                              </div>

                                              <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label class="bmd-label-floating"><?= $texto['OBS'] ?></label>
                                                      <input autocomplete="off" type="text" name="pedido_observacao"
                                                             class="form-control">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="col-lg-12 mb-3" style="padding-left: 0; padding-right: 0">
                              <div class="card" style="margin: 0">
                                  <div class="card-header" id="headingCursoDesejado">
                                      <h5 style="cursor: pointer" class="mb-0 abrir_collapse" data-toggle="collapse"
                                          data-target="#collapseCursoDesejado" aria-expanded="true"
                                          aria-controls="collapseCursoDesejado">
                                          <span class="card-title"><strong><?= $texto['EscCRDJ'] ?></strong></span>
                                          <i class="material-icons" style="float: right">expand_more</i>
                                      </h5>
                                  </div>
                                  <div id="collapseCursoDesejado" class="collapse"
                                       aria-labelledby="headingCursoDesejado" data-parent="#accordion">
                                      <div class="col-md-12">
                                          <div class="row">
                                              <div class="table-responsive" style="padding: 10px">
                                                  <table class="table table-bordered table-responsive-md table-striped text-center table_produtos_matricula">
                                                      <tr>
                                                          <th class="text-center"><?= $texto['PesqCR'] ?></th>
                                                          <th class="text-center">DESCONTO DO CURSO</th>
                                                          <th class="text-center">PARCELAMENTO CURSO</th>
                                                          <th class="text-center">PARCELAMENTO MATERIAL</th>
                                                      </tr>
                                                      <tr>
                                                          <td class="pt-4-half">
                                                              <input readonly placeholder="Clique e selecione o curso" type="text"
                                                                     class="form-control j_produto_proposta">
                                                          </td>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <select style="margin-top: -3px" class="form-control j_matricula_desconto_padrao">
                                                                      <option value=""><?= $texto['SDSCT'] ?></option>
                                                                      <?php
                                                                      $Read->ExeRead("sys_descontos", "WHERE desconto_status = :st", "st=0");
                                                                      if ($Read->getResult()):
                                                                          foreach ($Read->getResult() as $Desconto):
                                                                              ?>
                                                                              <option value="<?= $Desconto['desconto_id'] ?>"><?= $Desconto['desconto_nome'] ?></option>
                                                                          <?php
                                                                          endforeach;
                                                                      endif;
                                                                      ?>
                                                                  </select>
                                                              </div>
                                                          </td>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <select style="margin-top: -3px" class="form-control j_proposta_forma_parcelamento">
                                                                      <option value=""><?= $texto['ESCPAi'] ?>
                                                                      </option>
                                                                      <?php
                                                                      $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st AND forma_parcelamento_id != 1",
                                                                          "st=0");
                                                                      if ($Read->getResult()):
                                                                          foreach ($Read->getResult() as $Forma):
                                                                              ?>
                                                                              <option value="<?= $Forma['forma_parcelamento_id'] ?>"><?= $Forma['forma_parcelamento_nome'] ?></option>
                                                                          <?php
                                                                          endforeach;
                                                                      endif;
                                                                      ?>
                                                                  </select>
                                                              </div>
                                                          </td>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <select style="margin-top: -3px" class="form-control j_proposta_forma_parcelamento_material">
                                                                      <option value=""><?= $texto['ESCPAi'] ?>
                                                                      </option>
                                                                      <?php
                                                                      $Read->ExeRead("sys_forma_parcelamento", "WHERE forma_parcelamento_status = :st AND forma_parcelamento_id != 1",
                                                                          "st=0");
                                                                      if ($Read->getResult()):
                                                                          foreach ($Read->getResult() as $Forma):
                                                                              ?>
                                                                              <option value="<?= $Forma['forma_parcelamento_id'] ?>"><?= $Forma['forma_parcelamento_nome'] ?></option>
                                                                          <?php
                                                                          endforeach;
                                                                      endif;
                                                                      ?>
                                                                  </select>
                                                              </div>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th class="text-center"><?= $texto['Modal'] ?></th>
                                                          <th class="text-center"><?= $texto['SDDVC'] ?></th>
                                                          <th class="text-center">DATA DO 1º VENCIMENTO CURSO</th>
                                                      </tr>
                                                      <tr>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <select style="margin-top: -3px"
                                                                          class="form-control j_proposta_modalidade">
                                                                      <option value=""><?= $texto['EscMDL'] ?></option>
                                                                      <?php
                                                                      $Read->ExeRead("sys_modalidades",
                                                                          "WHERE modalidade_status = :st", "st=0");
                                                                      if ($Read->getResult()):
                                                                          foreach ($Read->getResult() as $Modalidade):
                                                                              ?>
                                                                              <option value="<?= $Modalidade['modalidade_id'] ?>"><?= $Modalidade['modalidade_nome'] ?></option>
                                                                          <?php
                                                                          endforeach;
                                                                      endif;
                                                                      ?>
                                                                  </select>
                                                              </div>
                                                          </td>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <select class="form-control j_matricula_dia_vencimento">
                                                                      <option value="" selected disabled><?= $texto['SSDDVC'] ?>
                                                                      </option>
                                                                      <?php
                                                                      $Read->ExeRead("sys_dias_vencimento",
                                                                          "WHERE dias_vencimento_status = :st",
                                                                          "st=0");
                                                                      if ($Read->getResult()) {
                                                                          foreach ($Read->getResult() as $Vencimento) {
                                                                              ?>
                                                                              <option value="<?= $Vencimento['dias_vencimento_id'] ?>"><?= $Vencimento['dias_vencimento_nome'] ?></option>
                                                                              <?php
                                                                          }
                                                                      }
                                                                      ?>
                                                                  </select>
                                                              </div>
                                                          </td>
                                                          <td class="pt-4-half">
                                                              <div class="form-group">
                                                                  <input autocomplete="off" type="date"
                                                                         class="form-control j_matricula_data_vencimento"
                                                                         placeholder="dd/mm/yyyy">
                                                              </div>
                                                          </td>
                                                      </tr>
                                                      <tr class='separar'></tr>
                                                  </table>
                                                  <button type="button"
                                                          class="btn btn-primary j_completar_matricula"><?= $texto['CompMT'] ?>
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div style="display: none" class="div_none_matricula">
                              <div class="card-body">

                                  <div class="row">
                                      <div class="col-lg-6 col-md-12">
                                          <div class="card">
                                              <div class="card-header card-header-primary">
                                                  <h4 class="card-title">ESTÁGIOS DE CURSO Á MATRICULAR</h4>
                                              </div>
                                              <div class="card-body table-responsive">
                                                  <table class="table table-hover j_tabela_matricula_estagios_curso">
                                                      <thead>
                                                      <th>Nome do Estágio</th>
                                                      <th style="width: 115px;">Valor</th>
                                                      <th style="width: 85px;"></th>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-lg-6 col-md-12">
                                          <div class="card">
                                              <div class="card-header card-header-primary">
                                                  <h4 class="card-title">MATERIAIS DIDÁTICOS NECESSÁRIOS</h4>
                                              </div>
                                              <div class="card-body table-responsive">
                                                  <table class="table table-hover j_tabela_matricula_materia_didaticos_curso">
                                                      <thead>
                                                      <th>Nome do Material</th>
                                                      <th style="width: 120px;">Valor</th>
                                                      <th style="width: 85px;"></th>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div style="margin-top: 15px; padding: 15px;">

                                  <div class="card mb-3" style="margin: 0">
                                      <div class="card-header" id="headingFour">
                                          <h5 style="cursor: pointer" class="mb-0 abrir_collapse"
                                              data-toggle="collapse" data-target="#collapseFour"
                                              aria-expanded="true" aria-controls="collapseFour">
                                              <span class="card-title"><strong><?= $texto['RATE'] ?></strong></span>
                                              <i class="material-icons" style="float: right">expand_more</i>
                                          </h5>
                                      </div>
                                      <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                           data-parent="#accordion">
                                          <div class="card-body table-responsive">
                                              <div class="row">
                                                  <div class="col-md-12">
                                        <span class="table-centro-custo-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i> Adicionar Rateio</a>
                                        </span>
                                                  </div>
                                                  <div class="table-responsive" style="padding: 10px">
                                                      <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                          <tr>
                                                              <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                              <th class="text-center"><?= $texto['CXC'] ?></th>
                                                              <th class="text-center"><?= $texto['PriceM'] ?></th>
                                                              <th class="text-center"></th>
                                                          </tr>
                                                          <?php
                                                          $Read->FullRead("SELECT R.parametros_matricula_rateio_id, C.centro_custo_nome, CC.conta_contabil_nome, R.parametros_matricula_rateio_valor, R.parametros_matricula_rateio_centro_custo_id, R.parametros_matricula_rateio_conta_contabil_id
                                                FROM sys_centro_custo AS C 
                                                INNER JOIN sys_parametros_matricula_rateio AS R ON C.centro_custo_id = R.parametros_matricula_rateio_centro_custo_id 
                                                INNER JOIN sys_conta_contabil AS CC ON R.parametros_matricula_rateio_conta_contabil_id = CC.conta_contabil_id 
                                                WHERE R.unidade_id = :id",
                                                              "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
                                                          if ($Read->getResult()) {
                                                              $QTDCentroCusto = $Read->getRowCount();
                                                              $j = 0;
                                                              foreach ($Read->getResult() as $Custo) {
                                                                  ?>
                                                                  <tr>
                                                                      <td class="pt-4-half">
                                                                          <input type="hidden"
                                                                                 name="rateio_<?= $j ?>"
                                                                                 value="<?= $Custo['parametros_matricula_rateio_id'] ?>">
                                                                          <select style="margin-top: -3px"
                                                                                  name="centro_custo_<?= $j ?>"
                                                                                  class="form-control jsys_tipo"
                                                                                  data-style="btn btn-link">
                                                                              <option value="0">SELECIONE UM CENTRO
                                                                                  DE CUSTO
                                                                              </option>
                                                                              <?php
                                                                              $Read->ExeRead("sys_centro_custo",
                                                                                  "WHERE centro_custo_status = :st",
                                                                                  "st=0");
                                                                              if ($Read->getResult()):
                                                                                  foreach ($Read->getResult() as $CentroCusto):
                                                                                      ?>
                                                                                      <option <?= ($CentroCusto['centro_custo_id'] == $Custo['parametros_matricula_rateio_centro_custo_id'] ? "selected='selected'" : '') ?>
                                                                                              value="<?= $CentroCusto['centro_custo_id'] ?>"><?= $CentroCusto['centro_custo_nome'] ?></option>
                                                                                  <?php
                                                                                  endforeach;
                                                                              endif;
                                                                              ?>
                                                                          </select>

                                                                      </td>
                                                                      <td class="pt-4-half">
                                                                          <select style="margin-top: -3px"
                                                                                  class="form-control"
                                                                                  name="conta_contabil_<?= $j ?>">
                                                                              <option value="0">SELECIONE UMA CONTA
                                                                                  CONTÁBIL
                                                                              </option>
                                                                              <?php
                                                                              $Read->ExeRead("sys_conta_contabil",
                                                                                  "WHERE conta_contabil_status = :st",
                                                                                  "st=0");
                                                                              if ($Read->getResult()):
                                                                                  foreach ($Read->getResult() as $ContaContabil):
                                                                                      ?>
                                                                                      <option <?= ($ContaContabil['conta_contabil_id'] == $Custo['parametros_matricula_rateio_conta_contabil_id'] ? "selected='selected'" : '') ?>
                                                                                              value="<?= $ContaContabil['conta_contabil_id'] ?>"><?= $ContaContabil['conta_contabil_nome'] ?></option>
                                                                                  <?php
                                                                                  endforeach;
                                                                              endif;
                                                                              ?>
                                                                          </select>
                                                                      </td>
                                                                      <td class="pt-4-half">
                                                                          <div class="form-group">
                                                                              <input autocomplete="off" type="text"
                                                                                     rel="<?= $Custo['parametros_matricula_rateio_valor'] ?>"
                                                                                     value="<?= $Custo['parametros_matricula_rateio_valor'] ?>"
                                                                                     name="valor_rateio_<?= $j ?>"
                                                                                     class="form-control valor_rateio formMoney">
                                                                          </div>
                                                                      </td>
                                                                      <td>
                                                                          <?php
                                                                          if ($permissao["deletar"] == 1) {
                                                                              ?>
                                                                              <span rel="<?= $Custo['parametros_matricula_rateio_id'] ?>"
                                                                                    class="table-remove">
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-rounded btn-sm my-0">
                                                                    <i class="material-icons">clear</i>
                                                                  </button>
                                                                </span>
                                                                              <?php
                                                                          }
                                                                          ?>
                                                                      </td>
                                                                  </tr>
                                                                  <?php
                                                                  $j++;
                                                              }
                                                          } else {
                                                              $QTDCentroCusto = 0;
                                                          }
                                                          ?>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-12 mb-3">
                                  <div class="card" style="margin: 0">
                                      <div class="card-header" id="headingTurma">
                                          <h5 style="cursor: pointer" class="mb-0 abrir_collapse"
                                              data-toggle="collapse" data-target="#collapseTurma"
                                              aria-expanded="true" aria-controls="collapseTurma">
                                              <span class="card-title"><strong>ESCOLHA A TURMA</strong></span>
                                              <i class="material-icons" style="float: right">expand_more</i>
                                          </h5>
                                      </div>
                                      <div id="collapseTurma" class="collapse" aria-labelledby="headingTurma"
                                           data-parent="#accordion">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label for="exampleInputEmail1">TURMA</label>
                                                  <div class="input-group mb-2 mr-sm-2">
                                                      <input readonly autocomplete="off" data-toggle="modal"
                                                             data-target="#getCodeModalTurma"
                                                             placeholder="Clique e selecione a turma" id="txt_turma"
                                                             type="text" class="form-control">
                                                      <div class="input-group-prepend">
                                                          <div data-remove1="txt_turma" data-remove2="txt_id_turma"
                                                               class="input-group-text j_click_limpa_lookup"
                                                               style="color: red; cursor: pointer">X</div>
                                                      </div>
                                                  </div>
                                                  <input autocomplete="off" name="txt_id_turma" id="txt_id_turma"
                                                         type="hidden" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-12 mb-3">
                                  <div class="card" style="margin: 0">
                                      <div class="card-header" id="headingEscolha">
                                          <h5 style="cursor: pointer" class="mb-0 abrir_collapse"
                                              data-toggle="collapse" data-target="#collapseEscolha"
                                              aria-expanded="true" aria-controls="collapseEscolha">
                                              <span class="card-title"><strong>LISTA DE ESPERA</strong></span>
                                              <i class="material-icons" style="float: right">expand_more</i>
                                          </h5>
                                      </div>
                                      <div id="collapseEscolha" class="collapse" aria-labelledby="headingEscolha"
                                           data-parent="#accordion">
                                          <div class="col-md-12">
                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Período de preferência</label>
                                                          <select class="form-control" name="periodo_preferencia">
                                                              <option disabled selected value="0">Selecione um
                                                                  período
                                                              </option>
                                                              <option value="1">Manhã</option>
                                                              <option value="2">Tarde</option>
                                                              <option value="3">Noite</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Dia de preferência</label>
                                                          <select class="form-control"
                                                                  name="dia_semana_preferencia">
                                                              <option disabled selected value="0">Selecione um dia
                                                                  da semana
                                                              </option>
                                                              <option value="1">Segunda-feira</option>
                                                              <option value="2">Terça-feira</option>
                                                              <option value="3">Quarta-feira</option>
                                                              <option value="4">Quinta-feira</option>
                                                              <option value="5">Sexta-feira</option>
                                                              <option value="6">Sábado</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Horário de preferência</label>
                                                          <input type="text" class="form-control formTime"
                                                                 name="horario_preferencia" placeholder="00:00">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label>Telefone de contato</label>
                                                          <input type="text"
                                                                 class="form-control telefone_contato formPhone"
                                                                 name="telefone_contato"
                                                                 placeholder="(00) 00000-0000">
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <br/>
                              <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo"
                                     value="<?= $QTDCentroCusto ?>"/>
                              <input type="hidden" class="quantidade_produto_matricula"
                                     name="quantidade_produto_matricula" value="1"/>
                              <input type="hidden" name="action" value="PedidoAdd"/>

                              <!--<button type="button" data-toggle="modal" data-target="#getCodeEntradaPagamento" class="btn btn-primary pull-right definir_forma_pagamento">
                                  DEFINIR FORMA DE PAGAMENTO
                              </button>-->
                              <?php /*if (isset($_SESSION['caixaSYS'])) {
                                  ?>
                                  <button type="submit" class="btn btn-primary pull-right lancar_matricula_button">
                                      LANÇAR MATRÍCULA
                                  </button>
                                  <?php
                              }*/
                              ?>
                              <button type="submit" class="btn btn-primary pull-right lancar_matricula_button">
                                  LANÇAR MATRÍCULA
                              </button>

                              <button type="submit" class="btn btn-primary pull-right orcamento_matricula_button">
                                  ORÇAMENTO DE MATRÍCULA
                              </button>
                              <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif"
                                   alt="[CARREGANDO...]" title="CARREGANDO..."/>
                              <div class="clearfix"></div>
                          </div>
                      </form>
                      <?php
                  }
                ?>
      </div>
    </div>
  </div>
  ID FUNCIONALIDADE: <?= PEDIDOS_PEDIDO ?>
</div>
</div>
</div>
<style>
.nav-tabs .nav-item .nav-link{
    color: #000 !important;
}
.nav-tabs .nav-item .nav-link:hover{
    color: #F33527 !important;
}
.nav-tabs .nav-item .nav-link.active{
    background-color: rgba(255, 255, 255, 0.5);
}
</style>

<div class="showcase hide-print" id="getCodeModal">
<a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div id="showbox-example" class="showbox">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs" style="padding: 0">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#profile" data-toggle="tab">
                                    Cursos
                                    <div class="ripple-container"></div>
                                    <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active show" id="profile">
                        <div class="border_shadow" style="background-color: #fff; padding: 20px">
                            <table  class="table table-hover display"
                                    id="table_modal_produtos_matricula"
                                    data-toolbar="#table"
                                    data-locale="pt-BR"
                                    data-filter-control="true"
                                    data-minimum-count-columns="2"
                                    data-url="_ajax/lookups/ListProdutosMatricula.ajax.php?action=list"
                                    data-pagination="true"
                                    data-id-field="nome"
                                    data-toggle="table"
                                    data-select-item-name="nome"
                                    data-buttons-class="primary"
                                    data-click-to-select="true">
                                <thead>
                                <tr>
                                    <th data-radio="true"></th>
                                    <th data-field="id" data-filter-control="input">ID</th>
                                    <th data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                                    <th data-field="tipo" data-filter-control="input"><?= $texto['TPi'] ?></th>
                                    <th data-field="valor" data-filter-control="input">Valor</th>
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
                        data-url="_ajax/lookups/ListTurmas.ajax.php?action=list_matricula&id=0"
                        data-pagination="true"
                        data-id-field="nome"
                        data-toggle="table"
                        data-select-item-name="nome"
                        data-click-to-select="true"
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

<div class="showcase hide-print" id="getCodeAlunosModal">
<a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div id="showbox-example" class="showbox">
                <table  class="table table-hover display"
                        id="table_modal_alunos"
                        data-toolbar="#table"
                        data-locale="pt-BR"
                        data-filter-control="true"
                        data-minimum-count-columns="2"
                        data-url="_ajax/lookups/ListAlunos.ajax.php?action=list"
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
                        <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                        <th data-field="id" data-filter-control="input">Situação</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="showcase hide-print" id="getCodeModalDetalhesItens">
<a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div id="showbox-example" class="showbox">
                <div class="tab-content">
                    <div class="tab-pane active show" id="profile">
                        <div class="border_shadow" style="background-color: #fff; padding: 20px">

                          <div class="">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Item</label>
                                          <input readonly type="text" class="form-control nome_item_modal">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Valor Unitário</label>
                                          <input disabled type="text" class="form-control valor_unitario_item_modal dinheiro">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Quantidade</label>
                                          <input disabled type="number" class="form-control quantidade_item_modal">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Desconto</label>
                                          <select style='margin-top: -3px' class='form-control desconto_item_modal'>
                                              <option value=''>Escolha um desconto</option>
                                              <?php
                                                $Read->ExeRead('sys_descontos', 'WHERE desconto_status = :st', 'st=0');
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Desconto):
                                                        echo "<option value='{$Desconto['desconto_id']}'>{$Desconto['desconto_nome']}</option>";
                                                    endforeach;
                                                endif;
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Valor Total</label>
                                          <input disabled type="text" class="form-control valor_total_item_modal dinheiro">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Parcela</label>
                                          <select style='margin-top: -3px' class='form-control forma_parcelamento_item_modal'>
                                              <option value=''>Escola a forma de parcelamento</option>
                                              <?php
                                              $Read->ExeRead('sys_forma_parcelamento', 'WHERE forma_parcelamento_status = :st AND forma_parcelamento_id != 1', 'st=0');
                                              if ($Read->getResult()):
                                                  foreach ($Read->getResult() as $Forma):
                                                      echo "<option value='{$Forma['forma_parcelamento_id']}'>{$Forma['forma_parcelamento_nome']}</option>";
                                                  endforeach;
                                              endif;
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2" style="display: none">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Entrada</label>
                                          <input autocomplete="off" min="0" type="text" class="form-control valor_entrada_item_modal dinheiro">
                                      </div>
                                  </div>
                                  <div class="col-md-2" style="display: none">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating"><?= $texto['SDTENi'] ?></label>
                                          <input autocomplete="off" type="date" class="form-control data_entrada_item_modal" placeholder="dd/mm/yyyy">
                                      </div>
                                  </div>
                                  <div class="col-md-2 div_display_none">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating"><?= $texto['SDDVCi'] ?></label>
                                          <select class="form-control dia_vencimento_item_modal">
                                              <option value="" selected disabled><?= $texto['SSDDVC'] ?></option>
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
                                  <div class="col-md-2 div_display_none">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Data 1º vencimento</label>
                                          <input autocomplete="off" type="date" class="form-control data_primeiro_vencimento_item_modal" placeholder="dd/mm/yyyy">
                                      </div>
                                  </div>
                                  <div class="col-md-2 div_display_none_modalidade">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Modalidade</label>
                                          <select style='margin-top: -3px' class='form-control modalidade_item_modal'>
                                              <option value=''>Escola a modalidade</option>
                                              <?php
                                              $Read->ExeRead('sys_modalidades', 'WHERE modalidade_status = :st', 'st=0');
                                              if ($Read->getResult()):
                                                  foreach ($Read->getResult() as $Modalidade):
                                                      echo "<option value='{$Modalidade['modalidade_id']}'>{$Modalidade['modalidade_nome']}</option>";
                                                  endforeach;
                                              endif;
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>

                        </div>
                    </div>
                    <input type="hidden" class="table_atual_item_modal">
                    <button class="btn btn-primary btn_salvar_aleracoes_matricula"><?= $texto['sav'] ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="showcase hide-print" id="getCodeEntradaPagamento">
<a data-dismiss="modal" class="matricula_close_parcelas" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div id="showbox-example" class="showbox">

                <div class="col-md-12">
                    <span class="table_entrada_itens_matricula_add float-right mb-3 mr-2">
                        <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                    </span>
                </div>
                <div class="table-responsive" style="padding: 10px">
                    <input type="hidden" value="1" class="quantidade_entrada_itens_matricula">
                    <table class="table table-bordered table-responsive-md table-striped text-center table_forma_pagamento_entrada_matricula">
                        <tr>
                            <th class="text-center">FORMA PAGAMENTO</th>
                            <th class="text-center">VALOR</th>
                            <th class="text-center"></th>
                        </tr>
                        <tr>
                            <td class="pt-4-half">
                                <select style="margin-top: -3px" class="form-control forma_pagamento_valor_entrada_0" name="forma_pagamento_valor_entrada_0">
                                    <option value="0">SELECIONE UMA FORMA DE PAGAMENTO</option>
                                    <?php
                                    $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                                    if ($Read->getResult()):
                                        foreach ($Read->getResult() as $FormaPagamento):
                                            ?>
                                            <option value="<?= $FormaPagamento['forma_pagamento_id'] ?>"><?= $FormaPagamento['forma_pagamento_nome'] ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                            <td class="pt-4-half">
                                <div class="form-group">
                                    <input accessKey="forma_pagamento_valor_entrada_0" autocomplete="off" type="text" name="valor_valor_entrada_0" class="form-control valor_valor_entrada formMoney">
                                </div>
                            </td>
                            <td>
                                <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                            </td>
                        </tr>
                    </table>
            </div>

            </div>
        </div>
    </div>
</div>
</div>