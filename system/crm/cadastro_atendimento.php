<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
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
                                <h4 class="card-title"><?= $texto['CadATDNTMS'] ?></h4>
                                <p class="card-category"><?= $texto['CadATDNTMSi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                     <?php
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_TIPO_ATENDIMENTO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["inserir"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                     ?>
                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">

                        <div class="panel">
                            <div class="card-header card-header-tabs card-header-success">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <span class="nav-tabs-title"><?= $texto['TPATDNTP'] ?></span>
                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <?php
                                            $Read->ExeRead("sys_crm_tipo_atendimento", "WHERE tipo_atendimento_status = 0");
                                            if($Read->getResult()){
                                              $i = 0;
                                              foreach($Read->getResult() as $Tipo){
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?= ($i == 0 ? "active show" : "") ?>" href="#<?= Check::Name($Tipo['tipo_atendimento_nome']) ?>" data-toggle="tab">
                                                    <?= $Tipo['tipo_atendimento_nome'] ?>
                                                    <div class="ripple-container"></div>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                </li>
                                            <?php
                                               $i++;
                                              }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <?php
                                    if($Read->getResult()){
                                      $j = 0;
                                      foreach($Read->getResult() as $Tipo){
                                    ?>
                                    <div class="tab-pane <?= ($j == 0 ? "active show" : "") ?>" id="<?= Check::Name($Tipo['tipo_atendimento_nome']) ?>">
                                        <form class="form_atendimento">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"><?= $texto['ClientAln'] ?></label>
                                                        <input autocomplete="off" readonly data-toggle="modal" data-target="#getCodeModal" placeholder="Clique e selecione o aluno" id="txt_aluno" type="text" name="pessoa_nome"  class="form-control">
                                                        <input autocomplete="off" id="txt_id_aluno" type="hidden" name="atendimento_pessoa_id" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $Read->ExeRead("sys_tipos_contato_atendimento", "WHERE tipo_atendimento_id = :id", "id={$Tipo['tipo_atendimento_id']}");
                                            if($Read->getResult()) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['TPCONTACT'] ?></label>
                                                            <select name="atendimento_tipo_contato_id" class="form-control">
                                                                <option selected value=""><?= $texto['SelOPTS'] ?></option>
                                                            <?php
                                                            foreach($Read->getResult() as $Contato){
                                                            ?>
                                                                <option value="<?= $Contato['tipo_contato_id'] ?>"><?= $Contato['tipo_contato_nome'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"><?= $texto ['OBSi'] ?></label>
                                                        <textarea name="atendimento_observacao" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                    $Read->ExeRead("sys_crm_resposta_tipo_atendimento", "WHERE tipo_atendimento_id = :id AND resposta_status = 0", "id={$Tipo['tipo_atendimento_id']}");
                                                    if($Read->getResult()){
                                                        foreach($Read->getResult() as $RespostaTipo){
                                                            ?>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" value="<?= $RespostaTipo['resposta_id'] ?>" class="custom-control-input" id="<?= Check::Name($RespostaTipo['resposta_nome']) . $RespostaTipo['resposta_id'] ?>" name="atendimento_resposta_id">
                                                                <label class="custom-control-label" for="<?= Check::Name($RespostaTipo['resposta_nome']) . $RespostaTipo['resposta_id'] ?>"><?= $RespostaTipo['resposta_nome'] ?></label>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <?php

                                            $linkto = array("agenda", "agendar", "visita", "Agendada");
                                            $form_agenda = false;
                                            foreach ($linkto as $agenda) {
                                                if (strpos($Tipo['tipo_atendimento_nome'], $agenda) !== FALSE) {
                                                    $form_agenda = TRUE;
                                                    break;
                                                }
                                            }
                                            if($form_agenda){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['DTAAGEND'] ?></label>
                                                            <input type="text" name="atendimento_agenda_data" class="form-control formDateTime" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['OBSAGEND'] ?></label>
                                                            <textarea name="atendimento_observacao_agenda" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <br>
                                            <label class="bmd-label-floating"><strong><?= $texto['NEXTACT'] ?></strong></label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                    $Read->ExeRead("sys_crm_proximas_acoes_tipo_atendimento", "WHERE tipo_atendimento_id = :id AND acoes_status = 0", "id={$Tipo['tipo_atendimento_id']}");
                                                    if($Read->getResult()){
                                                        foreach($Read->getResult() as $AcoesTipo){
                                                            ?>
                                                            <div class="custom-control custom-checkbox">
                                                                <input name="atendimento_proxima_acao_id" type="checkbox" value="<?= $AcoesTipo['acoes_id'] ?>" class="custom-control-input" id="<?= Check::Name($AcoesTipo['acoes_nome']) . $AcoesTipo['acoes_id'] ?>">
                                                                <label class="custom-control-label" for="<?= Check::Name($AcoesTipo['acoes_nome']) . $AcoesTipo['acoes_id'] ?>"><?= $AcoesTipo['acoes_nome'] ?></label>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <br/>
                                            <input type="hidden" name="action" value="AtendimentoAdd"/>
                                            <input type="hidden" name="tipo_atendimento_id" value="<?= $Tipo['tipo_atendimento_id']; ?>"/>
                                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                        </form>
                                    </div>
                                    <?php
                                      $j++;
                                      }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    <br/>
                </div>
                <br/>
                <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= CRM_ATENDIMENTOS ?>
  </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
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
                            data-click-to-select="true"
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