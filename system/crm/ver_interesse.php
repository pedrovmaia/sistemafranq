<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdPessoa = filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">VER INTERESSE</h4>
                                <p class="card-category">Exibição de interesse</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_INTERESSE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_crm_interesse", "WHERE interesse_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
         <<form class="form_interesse">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>DADOS INTERESSE</strong></label>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Data do Cadastro</label>
                                                <input disabled type="text" value="<?= date('d/m/Y', strtotime($interesse_data)) ?>" class="form-control formDate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Atendente (Promotor)</label>
                                                <select disabled name="interesse_atendente_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0">Selecione um atendente</option>
                                                    <?php
                                                    $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 6");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Atendente):
                                                            ?>
                                                            <option value="<?= $Atendente['pessoa_id'] ?>" <?= ($Atendente['pessoa_id'] == $FormData['interesse_atendente_id'] ? 'selected="selected"' : ''); ?>><?= $Atendente['pessoa_nome'] ?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Sondagem (Descreva suas experiências anteriores e expectativas futuras)</label>   
                                                <textarea disabled name="interesse_sondagem" class="form-control" rows="4" cols="50"><?= $FormData['interesse_sondagem'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                           <label class="bmd-label-floating"><?= $texto['Schooli'] ?></label>
                                            <select disabled name="interesse_escola_id" class="form-control">
                                                <option value="0"><?= $texto['SelSchool'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_escola", "WHERE escola_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Escolas):
                                                        ?>
                                                          <option value="<?= $Escolas['escola_id'] ?>" <?php if ($FormData['interesse_escola_id'] == $Escolas['escola_id'] ) { echo "selected";}  ?>  ><?php echo $Escolas['escola_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Tempo (Experiência anterior)</label>
                                                <input disabled type="number"  value="<?= $FormData['interesse_tempo'] ?>" name="interesse_tempo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Quando parou (Experiência anterior)</label>
                                                <input disabled type="number" value="<?= $FormData['interesse_parou'] ?>" name="interesse_parou" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                           <label class="bmd-label-floating">Período letivo de interesse</label>
                                            <select disabled name="interesse_periodo_interesse_id" class="form-control">
                                                <option value="0"><?= $texto['SelSchool'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_periodo", "WHERE periodo_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $PeriodoInt):
                                                        ?>
                                                          <option value="<?= $PeriodoInt['periodo_id'] ?>" <?php if ($FormData['interesse_periodo_interesse_id'] == $PeriodoInt['periodo_id'] ) { echo "selected";}  ?>  ><?php echo $PeriodoInt['periodo_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Necessita de teste de nível?</label>

                                            <div class="radio">
                                                <input disabled type="radio" <?= (in_array('0', explode(',', $FormData['interesse_teste'])) ? 'checked' : '') ?> name="interesse_teste" value="0"> Sim<br>
                                            </div>
                                            <div class="radio">
                                                <input disabled type="radio" <?= (in_array('1', explode(',', $FormData['interesse_teste'])) ? 'checked' : '') ?> name="interesse_teste" value="1"> Não<br>
                                            </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                                <br/>

                                <div id="produto_procurado" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>PRODUTO PROCURADO E DISPONIBILIDADE</strong></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Idioma</label>
                                                <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('1', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="1"> Inglês<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('2', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="2"> Espanhol<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('3', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="3"> Alemão<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('4', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="4"> Português<br>
                                            </div>
                                            </div>
                                        </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"></label>
                                                        <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('5', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="5"> Francês<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('6', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="6"> Japonês<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('7', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="7"> Chinês<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('8', explode(',', $FormData['interesse_idioma_id'])) ? 'checked' : '') ?> name="interesse_idioma_id[]" value="8"> Outros Idiomas<br>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                  <label class="bmd-label-floating">Origem</label>
                                            <select disabled name="interesse_origem_id" class="form-control">
                                                <option value="0">Selecione uma origem do interesse</option>
                                                <?php
                                                $Read->ExeRead("sys_crm_origem_interesse", "WHERE origem_interesse_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Origem):
                                                        ?>
                                                          <option value="<?= $Origem['origem_interesse_id'] ?>" <?php if ($FormData['interesse_origem_id'] == $Origem['origem_interesse_id'] ) { echo "selected";}  ?>  ><?php echo $Origem['origem_interesse_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Modalidade</label>
                                            <select disabled name="interesse_modalidade_id" class="form-control">
                                                <option value="0">Selecione uma modalidade</option>
                                                <?php
                                                $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Modalidade):
                                                        ?>
                                                          <option value="<?= $Modalidade['modalidade_id'] ?>" <?php if ($FormData['interesse_modalidade_id'] == $Modalidade['modalidade_id'] ) { echo "selected";}  ?>  ><?php echo $Modalidade['modalidade_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                               <label class="bmd-label-floating">Motivo de interesse</label>
                                            <select disabled name="interesse_motivo_id" class="form-control">
                                                <option value="0">Selecione o motivo do interesse</option>
                                                <?php
                                                $Read->ExeRead("sys_crm_motivo_interesse", "WHERE motivo_interesse_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Motivo):
                                                        ?>
                                                          <option value="<?= $Motivo['motivo_interesse_id'] ?>" <?php if ($FormData['interesse_motivo_id'] == $Motivo['motivo_interesse_id'] ) { echo "selected";}  ?>  ><?php echo $Motivo['motivo_interesse_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Dias da semana</label>
                                                <div class="checkbox">
                                               <input disabled type="checkbox" <?= (in_array('1', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="1">Segunda-Feira<br>
                                           </div>
                                           <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('2', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="2">Terça-Feira<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('3', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="3">Quarta-Feira<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('4', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="4">Quinta-Feira<br>
                                            </div>

                                            </div>
                                        </div>
                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"></label>
                                                        <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('5', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="5">Sexta-Feira<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('6', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="6">Sábado<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('7', explode(',', $FormData['interesse_dia_id'])) ? 'checked' : '') ?> name="interesse_dia_id[]" value="7">Domingo<br>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Período</label>
                                                <div class="checkbox">
                                               <input disabled type="checkbox" <?= (in_array('1', explode(',', $FormData['interesse_periodo_id'])) ? 'checked' : '') ?> name="interesse_periodo_id[]" value="1"> Integral<br>
                                           </div>
                                           <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('2', explode(',', $FormData['interesse_periodo_id'])) ? 'checked' : '') ?> name="interesse_periodo_id[]" value="2"> Matutino<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('3', explode(',', $FormData['interesse_periodo_id'])) ? 'checked' : '') ?> name="interesse_periodo_id[]" value="3"> Vespertino<br>
                                            </div>
                                            <div class="checkbox">
                                                <input disabled type="checkbox" <?= (in_array('4', explode(',', $FormData['interesse_periodo_id'])) ? 'checked' : '') ?> name="interesse_periodo_id[]" value="4"> Noturno<br>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Observações</label>
                                                <input disabled type="text" value="<?= $FormData['interesse_observacao'] ?>" name="interesse_observacao" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Objetivos a serem alcançados</label>
                                                <input disabled type="text" value="<?= $FormData['interesse_objetivo'] ?>" name="interesse_objetivo" class="form-control">
                                            </div>
                                        </div>           
                                </div>
                            </div>
                            </form>
                                <br/>
                               
                                <div id="intercambio" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>INTERCÂMBIO</strong></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Tem interesse em intercâmbio ?</label>
                                                <div class="radio">
                                               <input disabled type="radio" <?= (in_array('0', explode(',', $FormData['interesse_intercambio'])) ? 'checked' : '') ?> name="interesse_intercambio" value="0"> Sim<br>
                                           </div>
                                           <div class="radio">
                                                <input disabled type="radio" <?= (in_array('1', explode(',', $FormData['interesse_intercambio'])) ? 'checked' : '') ?> name="interesse_intercambio" value="1"> Não<br>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <br/>
            </div>
            <br/>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=crm/cadastro_motivo_interesse');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= CRM_INTERESSE ?>
  </div>
</div>
