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
<style>
    .pt-3-half {
        padding-top: 1.4rem;
    }
</style>

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
                                <h4 class="card-title"><?= $texto['CadPLTCACRES'] ?></h4>
                                <p class="card-category"><?= $texto['CadPLTCACRESi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_INTERESSE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                                ?>
                                <form class="form_politica_acrescimo">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['DADS'] ?></strong></label>
                                        <div class="row">
                                            <div class="col-md-12">
                                        <span class="table-add-politica_acrescimo float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                            </div>
                                            <div class="table-responsive">

                                                <div style="padding: 15px;">
                                                    <table class="table table-bordered table-responsive-md table-striped text-center table_politica_acrescimo">
                                                        <tr>
                                                            <th class="text-center">Nº <?= $texto['PARC'] ?></th>
                                                            <th class="text-center"><?= $texto['ACRESS'] ?></th>
                                                            <th class="text-center"><?= $texto['TPi'] ?></th>
                                                            <th class="text-center"></th>
                                                        </tr>
                                                        <?php
                                                            $Read->ExeRead("sys_politica_acrescimo");
                                                            if($Read->getResult()){
                                                                $QTDAcrescimo = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Acrescimo){
                                                                    ?>
                                                                    <tr>
                                                                        <td class="pt-3-half">
                                                                            <input type="hidden" name="acresc_id_<?= $i ?>"
                                                                                   value="<?= $Acrescimo['id'] ?>">
                                                                            <input type="text" disabled name="parcelas_<?= $i ?>"  class="form-control" value="<?= $Acrescimo['parcelas'] ?>">
                                                                        </td>
                                                                        <td class="pt-3-half">
                                                                            <input type="number" name="acrescimo_<?= $i ?>"
                                                                                   placeholder="0"
                                                                                   class="form-control "
                                                                                   value="<?= $Acrescimo['acrescimo'] ?>">
                                                                        </td>
                                                                        <td class="pt-3-half">
                                                                            <select style="margin-top: -3px" name="tipo_<?= $i ?>" class="form-control" data-style="btn btn-link">
                                                                                <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                                                                <option <?= ($Acrescimo['tipo'] == 1 ? "selected='selected'" : '') ?> name="tipo_<?= $i ?>" value="1"><?= $texto['PERCNT'] ?></option>
                                                                                <option <?= ($Acrescimo['tipo'] == 2 ? "selected='selected'" : '') ?> name="tipo_<?= $i ?>" value="2"><?= $texto['Price'] ?></option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <span rel="<?= $Acrescimo['id'] ?>" class="table-remove">
                                                                                <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                                    <i class="material-icons">clear</i>
                                                                                </button>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                $QTDAcrescimo = 0;
                                                            }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="AcrescimoEditar"/>
                                    <input type="hidden" class="quantidade_politica_acrescimo" name="quantidade_politica_acrescimo" value="<?= $QTDAcrescimo ?>"/>
                                    <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                    <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                         title="CARREGANDO..."/>
                                    <div class="clearfix"></div>
                                </form>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=politica_comercial/home');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_INTERESSE."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_politica_acrescimo">

                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong>DADOS INDICAÇÃO</strong></label>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-add-politica_acrescimo float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive">

                                            <div style="padding: 15px;">
                                                <table class="table table-bordered table-responsive-md table-striped text-center table_politica_acrescimo">
                                                    <tr>
                                                       <th class="text-center">Nº <?= $texto['PARC'] ?></th>
                                                            <th class="text-center"><?= $texto['ACRESS'] ?></th>
                                                            <th class="text-center"><?= $texto['TPi'] ?></th>
                                                            <th class="text-center"></th>
                                                    </tr>

                                                    <td class="pt-3-half">
                                                            <input type="text" name="parcelas_0"  class="form-control" value="">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <input type="number" name="acrescimo_0"
                                                                   placeholder="0"
                                                                   class="form-control"
                                                                   value="">
                                                        </td>
                                                        <td class="pt-3-half">
                                                            <select style="margin-top: -3px" name="tipo_0" class="form-control" data-style="btn btn-link">
                                                             <option value="0"><?= $texto['SelTYPEi'] ?></option>
                                                              <option name="tipo_0" value="1"><?= $texto['PERCNT'] ?></option>
                                                              <option name="tipo_0" value="2"><?= $texto['Price'] ?></option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span class="table-remove">
                                                                <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
                                                                    <i class="material-icons">clear</i>
                                                                </button>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br/>

                                <input type="hidden" name="action" value="AcrescimoAdd"/>
                                <input type="hidden" class="quantidade_politica_acrescimo" name="quantidade_politica_acrescimo" value="1"/>
                                <button type="submit" class="btn btn-primary"><?= $texto['sav'] ?></button>
                                <img class="form_load" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]"
                                     title="CARREGANDO..."/>
                                <div class="clearfix"></div>
                            </form>

                        <?php
                        endif;
                        ?>

                    </div>
                </div>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= CRM_INTERESSE ?>
    </div>
</div> 