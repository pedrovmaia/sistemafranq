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
                            data-url="_ajax/lookups/ListClientesAlunos.ajax.php?action=list"
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
                            <th  data-field="cpf" data-filter-control="input"><?= $texto['CPF'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                <h4 class="card-title"><?= $texto['CadTDC'] ?></h4>
                                <p class="card-category"><?= $texto['CadTDCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <?php
                          $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_TRANSACAO_CAIXA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                          $permissao = $Read->getResult()[0];
                          if($permissao["alterar"] != 1){
                              echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                              die;
                          }
                      ?>
                      <form class="form_transacao_caixa">
                          <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                              <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                         <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                   <label class="bmd-label-floating"><?= $texto['ESDD'] ?></label>
                                      <select style="margin-top: -3px" class="form-control transacao_caixa_tipo_id" name="transacao_caixa_tipo_id">
                                      <option value=1><?= $texto['CXIN'] ?></option>
                                      <option value=2><?= $texto['CXOUT'] ?></option>

                                      </select>
                        </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                                     <input type="text" value="<?= date('d/m/Y') ?>" name="transacao_caixa_data" class="form-control formDate">
                                </div>
                            </div>
                          </div>

                         <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                    <input autocomplete="off" type="text" name="transacao_caixa_descricao" class="form-control">
                                </div>
                            </div>

                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                     <input autocomplete="off" type="text" name="transacao_caixa_valor" class="form-control transacao_caixa_valor dinheiro">

                                 </div>
                             </div>
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
                        <br/>
                    </div>

                     <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                        <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>

                         <div class="row">
                            <div class="col-md-12">

                                <span class="table-centro-custo-add float-right mb-3 mr-2">
                                    <a href="#" class="btn btn-success"><i class="material-icons">add</i> <?= $texto['ADDRAT'] ?></a>
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
                                <tr>
                                    <td class="pt-4-half">
                                      <select style="margin-top: -3px" name="centro_custo_0" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">

                                           <option value=""><?= $texto['SELCDC'] ?></option>

                                          <?php
                                          $Read->ExeRead("sys_centro_custo", "WHERE centro_custo_status = :st", "st=0");
                                          if ($Read->getResult()):
                                              foreach ($Read->getResult() as $CentroCusto):
                                                  ?>
                                                  <option value="<?= $CentroCusto['centro_custo_id'] ?>"><?= $CentroCusto['centro_custo_nome'] ?></option>
                                              <?php
                                              endforeach;
                                          endif;
                                          ?>
                                      </select>

                                    </td>
                                    <td class="pt-4-half">
                                        <select style="margin-top: -3px" class="form-control" name="conta_contabil_0">

                                       <option value=""><?= $texto['SELUCC'] ?></option>

                                       <?php
                                      $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                      if ($Read->getResult()):
                                          foreach ($Read->getResult() as $ContaContabil):
                                              ?>
                                              <option value="<?= $ContaContabil['conta_contabil_id'] ?>"><?= $ContaContabil['conta_contabil_nome'] ?></option>
                                          <?php
                                          endforeach;
                                      endif;
                                      ?>

                                    </select>
                                    </td>


                                     <td class="pt-4-half">
                                      <div class="form-group">

                                          <input autocomplete="off" type="text" name="valor_rateio_0" class="form-control formMoney">
                                      </div>
                                      </td>


                                    <td>
                                        <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0"><i class="material-icons">clear</i></button></span>
                                    </td>
                            </div>
                                </tr>
                            </table>
                            </div>
                        </div>

                    <br/>
                    <input type="hidden" name="action" value="TransacaoCaixaAdd"/>
                    <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="1"/>

                     <?php if(isset($_SESSION['caixaSYS']))
                            {?>
                          <button type="submit" id="btn_tipo" class="btn btn-primary pull-right"><?= $texto['LACCX'] ?></button>
                     <?php
                       }
                      ?>

                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                    <div class="clearfix"></div>
                </form>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FINANCEIRO_TRANSACAO_CAIXA ?>
  </div>
</div>