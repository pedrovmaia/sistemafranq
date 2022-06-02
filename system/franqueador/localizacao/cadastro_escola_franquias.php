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
                                <h4 class="card-title">CADASTRO DE FRANQUIAS</h4>
                                <p class="card-category">Cadastro de franquias</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ESCOLA_FRANQUIAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("escola_franquias", "WHERE escola_franquias_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_escola_franquia">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?> </label>
                                                    <input type="text" name="escola_franquias_nome" value="<?= $escola_franquias_nome ?>" class="form-control">
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="bmd-label-floating">FRANQUIA</label>
                                            <select name="escola_franquias_pessoa_id" value="<?= $escola_franquias_pessoa_id ?>" class="form-control">
                                                <option value="0">SELECIONE A FRANQUIA</option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 7");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                          <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($Pessoa['pessoa_id'] == $FormData['escola_franquias_pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>

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
                                              <label class="bmd-label-floating">ESTADOS</label>
                                            <select name="escola_franquias_estado" value="<?= $escola_franquias_estado ?>" class="form-control">
                                                <option value="0">SELECIONE O ESTADO</option>
                                                <?php
                                                $Read->ExeRead("sys_estados");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Estado):
                                                        ?>
                                                          <option value="<?= $Estado['estado_id'] ?>" <?php if ($Estado['estado_id'] == $FormData['escola_franquias_estado'] ) { echo "selected";}  ?>  ><?php echo $Estado['estado_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                    </div>
                </div>

                 <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                            <select name="escola_franquias_cidade" value="<?= $escola_franquias_cidade ?>" class="form-control">
                                                <option value="0">SELECIONE A CIDADE</option>
                                                <?php
                                                $Read->ExeRead("sys_cidades");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Cidade):
                                                        ?>
                                                          <option value="<?= $Cidade['cidade_id'] ?>" <?php if ($Cidade['cidade_id'] == $FormData['escola_franquias_cidade'] ) { echo "selected";}  ?>  ><?php echo $Cidade['cidade_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                    </div>
                </div>

                                    </div>
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="EscolaFranquiaEditar"/>
                                    <input type="hidden" name="escola_franquias_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='franqueador/Cidades' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=franqueador//cadastro_grupo_economico');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ESCOLA_FRANQUIAS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                             <form class="form_escola_franquia">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['NomeMa'] ?> </label>
                                                    <input type="text" name="escola_franquias_nome" class="form-control">
                                                </div>
                                            </div>

                                             <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="bmd-label-floating">FRANQUIA</label>
                                            <select name="escola_franquias_pessoa_id" class="form-control">
                                                <option value="0">SELECIONE A FRANQUIA</option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas", "WHERE pessoa_tipo_id = 7");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                          <option value="<?= $Pessoa['pessoa_id'] ?>"><?= $Pessoa['pessoa_nome']; ?></option>

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
                                              <label class="bmd-label-floating">ESTADOS</label>
                                            <select name="escola_franquias_estado"  class="form-control">
                                                <option value="0">SELECIONE O ESTADO</option>
                                                <?php
                                                $Read->ExeRead("sys_estados");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Estado):
                                                        ?>
                                                          <option value="<?= $Estado['estado_id'] ?>"><?= $Estado['estado_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                    </div>
                </div>

                 <div class="col-md-6">
                                          <div class="form-group">
                                              <label class="bmd-label-floating"><?= $texto['CDDE'] ?></label>
                                            <select name="escola_franquias_cidade"  class="form-control">
                                                <option value="0">SELECIONE A CIDADE</option>
                                                <?php
                                                $Read->ExeRead("sys_cidades");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Cidade):
                                                        ?>
                                                          <option value="<?= $Cidade['cidade_id'] ?>"><?= $Cidade['cidade_nome']; ?></option>

                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                    </div>
                </div>

                                    </div>
                                    
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="EscolaFranquiaAdd"/>
                                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                <div class="clearfix"></div>
                            </form>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $texto['IDFunc'] ?> <?= FRANQUEADOR_ESCOLA_FRANQUIAS ?>
    </div>
</div>
