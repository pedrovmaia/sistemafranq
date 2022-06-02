<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
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
                                <h4 class="card-title">VER REPOSIÇÃO</h4>
                                <p class="card-category">Exibição de reposição</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_REPOSICAO_AULA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
               $Read->ExeRead("sys_reposicao", "WHERE reposicao_id = :id", "id={$Id}");
                          if ($Read->getResult()):
                              $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                              extract($FormData);
                              ?>
                              <form class="form_reposicao">
                                  <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                      <label class="bmd-label-floating"><strong>INFORMAÇÕES BASICAS</strong></label>

                                      <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">DATA</label>
                                                  <input disabled type="text" name="reposicao_data" value="<?= date('d/m/Y', strtotime($reposicao_data)) ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">DESCRIÇÃO</label>
                                                  <input  disabled type="text" name="reposicao_descricao" value="<?= $reposicao_descricao ?>" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">HORA INICIAL</label>
                                                  <input disabled type="text" name="reposicao_hora_inicial" value="<?= $reposicao_hora_inicial ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">HORA FINAL</label>
                                                  <input disabled type="text" name="reposicao_hora_final" value="<?= $reposicao_hora_final ?>" class="form-control">
                                              </div>
                                          </div>
                                        </div>

                                        <div class="row">

                                          <div class="col-md-6">
                                              <div class="form-group">                                                
                                                  <label class="bmd-label-floating">MATÉRIAS</label>
                                                  <input disabled type="text" name="reposicao_materias" value="<?= $reposicao_materias ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label  class="bmd-label-floating">MODALIDADE</label>
                                                     <select disabled style="margin-top: -3px" name="reposicao_modalidade_id" class="form-control jsys_produtos" data-style="btn btn-link" id="exampleFormControlSelect1">

                                                         <option value="0">SELECIONE A MODALIDADE</option>
                                                       
                                                        <?php
                                                        $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Modalidade):
                                                                ?>
                                                               
                                                                 <option value="<?= $Modalidade['modalidade_id'] ?>" <?php if ($reposicao_modalidade_id == $Modalidade['modalidade_id'] ) { echo "selected";}  ?>  ><?php echo $Modalidade['modalidade_nome']; ?></option>



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
                                                  <label class="bmd-label-floating">ATIVIDADES</label>
                                                  <input disabled type="text" name="reposicao_atividades" value="<?= $reposicao_atividades ?>" class="form-control">
                                              </div>
                                          </div>

                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">PAGO</label>
                                                  <select disabled required name="reposicao_pago"  class="form-control">
                                                      <option value="">Selecione uma opção</option>
                                                      <option <?= ($reposicao_pago == 0 ? 'selected="selected"' : '') ?> value="0">Não</option>
                                                      <option <?= ($reposicao_pago == 1 ? 'selected="selected"' : '') ?> value="1">Sim</option>
                                                  </select>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="bmd-label-floating">STATUS</label>
                                                  <select disabled required name="reposicao_status"  class="form-control">
                                                      <option value="">Selecione uma opção</option>
                                                      <option <?= ($reposicao_status == 0 ? 'selected="selected"' : '') ?> value="0">Aberto</option>
                                                      <option <?= ($reposicao_status == 1 ? 'selected="selected"' : '') ?> value="1">Fechado</option>
                                                  </select>
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
                    header('Location: painel.php?exe=escola/turma/cadastro_reposicao');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_REPOSICAO_AULA ?>
  </div>
</div>
