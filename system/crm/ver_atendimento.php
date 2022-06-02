<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title"><?= $texto['VerATDNTMS'] ?></h4>
                                <p class="card-category"><?= $texto['VerATDNTMSi'] ?></p>
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
                        if($Id){
                            $Read->FullRead("SELECT a.atendimento_observacao, p.pessoa_nome AS atendente, pe.pessoa_nome AS cliente, res.resposta_nome, pro.acoes_nome, a.atendimento_date, ti.tipo_contato_nome, a.atendimento_agendamento, a.atendimento_agenda_data, a.atendimento_observacao_agenda, tp.tipo_atendimento_nome FROM sys_atendimentos AS a 
                                            INNER JOIN sys_pessoas AS p ON p.pessoa_id = a.atendimento_atendente_id
                                            INNER JOIN sys_pessoas AS pe ON pe.pessoa_id = a.atendimento_pessoa_id
                                            INNER JOIN sys_crm_resposta_tipo_atendimento AS res ON res.resposta_id = a.atendimento_resposta_id
                                            INNER JOIN sys_crm_proximas_acoes_tipo_atendimento AS pro ON pro.acoes_id = a.atendimento_proxima_acao_id
                                            LEFT OUTER JOIN sys_tipos_contato_atendimento AS ti ON ti.tipo_contato_id = a.atendimento_tipo_contato_id
                                            INNER JOIN sys_crm_tipo_atendimento AS tp ON tp.tipo_atendimento_id = a.tipo_atendimento_id WHERE a.atendimento_id = :id", "id={$Id}");

                            if ($Read->getResult()) {
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <div class="panel">
                                        <div class="card-header card-header-tabs card-header-success">
                                            <div class="nav-tabs-navigation">
                                                <div class="nav-tabs-wrapper">
                                                    <span class="nav-tabs-title"><?= $texto['TPATDNTP'] ?></span>
                                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active show"
                                                               href="#<?= Check::Name($tipo_atendimento_nome) ?>"
                                                               data-toggle="tab">
                                                                <?= $tipo_atendimento_nome ?>
                                                                <div class="ripple-container"></div>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <?php
                                                if ($Read->getResult()) {
                                                        ?>
                                                        <div class="tab-pane active show"
                                                             id="<?= Check::Name($tipo_atendimento_nome) ?>">
                                                            <form class="form_atendimento">
                                                                <div class="row">

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['ATNDTi'] ?></label>
                                                                            <input autocomplete="off" readonly
                                                                                   placeholder="Clique e selecione o aluno"
                                                                                   type="text" value="<?= $atendente ?>" name="pessoa_nome"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['ClientAln'] ?></label>
                                                                            <input autocomplete="off" readonly
                                                                                   placeholder="Clique e selecione o aluno"
                                                                                   type="text" value="<?= $cliente ?>" name="pessoa_nome"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if($tipo_contato_nome) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating"><?= $texto['TPCONTACT'] ?></label>
                                                                                <input autocomplete="off" readonly
                                                                                       placeholder="Tipo de contato"
                                                                                       type="text"
                                                                                       value="<?= $tipo_contato_nome ?>"
                                                                                       name="pessoa_nome"
                                                                                       class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="bmd-label-floating"><?= $texto['OBSi'] ?></label>
                                                                            <textarea name="atendimento_observacao" readonly
                                                                                      rows="3"
                                                                                      class="form-control"><?= $atendimento_observacao ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" readonly
                                                                                   class="custom-control-input"
                                                                                   name="atendimento_resposta_id" checked>
                                                                            <label class="custom-control-label"><?= $resposta_nome ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                                if ($atendimento_agendamento) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating"><?= $texto['DTAAGEND'] ?></label>
                                                                                <input readonly type="text" value="<?= date("d/m/Y H:i:s", strtotime($atendimento_agenda_data)) ?>"
                                                                                       name="atendimento_agenda_data"
                                                                                       class="form-control formDateTime">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="bmd-label-floating"><?= $texto['OBSAGEND'] ?></label>
                                                                                <textarea readonly
                                                                                        name="atendimento_observacao_agenda"
                                                                                        rows="3"
                                                                                        class="form-control"><?= $atendimento_observacao_agenda ?></textarea>
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
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input readonly checked name="atendimento_proxima_acao_id"
                                                                                   type="checkbox"
                                                                                   class="custom-control-input">
                                                                            <label class="custom-control-label"><?= $acoes_nome ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br/>
                                                            </form>
                                                        </div>
                                                        <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <br/>
                                </div>
                                <?php
                            } else {
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=crm/filtro_atendimentos');
                                exit;
                            }
                  }
                ?>
                <br/>
                <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= CRM_ATENDIMENTOS ?>
  </div>
</div>