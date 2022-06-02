<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$Read->ExeRead("sys_parametros_matricula_rateio", "WHERE unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
$ResultadoRateio = $Read->getResult();
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
                                <h4 class="card-title"><?= $texto['RATPLANCTNSM'] ?></h4>
                                <p class="card-category"><?= $texto['GEREPLANDECNTSM'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($ResultadoRateio):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ESCOLA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }

                            $FormData = array_map('htmlspecialchars', $ResultadoRateio[0]);
                            extract($FormData);
                            ?>
                            <form class="form_sys_rateio_matricula">
                                <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                    <span class="table-centro-custo-add float-right mb-3 mr-2">
                                        <a href="#" class="btn btn-success"><i class="material-icons">add</i><?= $texto['ADDRAT'] ?></a>
                                    </span>
                                        </div>
                                        <div class="table-responsive" style="padding: 10px">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                <tr>
                                                    <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                    <th class="text-center"><?= $texto['CXC'] ?></th>
                                                    <th class="text-center"><?= $texto['PricePER'] ?></th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                <?php
                                                $Read->FullRead("SELECT R.parametros_matricula_rateio_id, C.centro_custo_nome, CC.conta_contabil_nome, R.parametros_matricula_rateio_valor, R.parametros_matricula_rateio_centro_custo_id, R.parametros_matricula_rateio_conta_contabil_id
                                                    FROM sys_centro_custo AS C 
                                                    INNER JOIN sys_parametros_matricula_rateio AS R ON C.centro_custo_id = R.parametros_matricula_rateio_centro_custo_id 
                                                    INNER JOIN sys_conta_contabil AS CC ON R.parametros_matricula_rateio_conta_contabil_id = CC.conta_contabil_id 
                                                    WHERE R.unidade_id = :id", "id={$_SESSION["userSYSFranquia"]["unidade_padrao"]}");
                                                if($Read->getResult()) {
                                                    $QTDCentroCusto = $Read->getRowCount();
                                                    $j = 0;
                                                    foreach ($Read->getResult() as $Custo) {
                                                        ?>
                                                        <tr>
                                                            <td class="pt-4-half">
                                                                <input type="hidden" name="rateio_<?= $j ?>" value="<?= $Custo['parametros_matricula_rateio_id'] ?>">
                                                                <select style="margin-top: -3px" name="centro_custo_<?= $j ?>" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                                    <option value="0"><?= $texto['SELCDC'] ?></option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_centro_custo", "WHERE centro_custo_status = :st", "st=0");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $CentroCusto):
                                                                            ?>
                                                                            <option <?= ($CentroCusto['centro_custo_id'] == $Custo['parametros_matricula_rateio_centro_custo_id'] ? "selected='selected'" : '') ?> value="<?= $CentroCusto['centro_custo_id'] ?>"><?= $CentroCusto['centro_custo_nome'] ?></option>
                                                                        <?php
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>

                                                            </td>
                                                            <td class="pt-4-half">
                                                                <select style="margin-top: -3px" class="form-control" name="conta_contabil_<?= $j ?>">
                                                                    <option value="0"><?= $texto['SELUCC'] ?></option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $ContaContabil):
                                                                            ?>
                                                                            <option <?= ($ContaContabil['conta_contabil_id'] == $Custo['parametros_matricula_rateio_conta_contabil_id'] ? "selected='selected'" : '') ?> value="<?= $ContaContabil['conta_contabil_id'] ?>"><?= $ContaContabil['conta_contabil_nome'] ?></option>
                                                                        <?php
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td class="pt-4-half">
                                                                <div class="form-group">
                                                                    <input autocomplete="off" type="number" value="<?= $Custo['parametros_matricula_rateio_valor'] ?>" name="valor_rateio_<?= $j ?>" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if($permissao["deletar"] == 1) {
                                                                    ?>
                                                                    <span rel="<?= $Custo['parametros_matricula_rateio_id'] ?>" class="table-remove">
                                                                        <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">
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
                                <br/>
                                <input type="hidden" name="action" value="RateioMatriculaEdit"/>
                                <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="<?= $QTDCentroCusto ?>"/>
                                <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/><?php
                                ?>
                                <div class="clearfix"></div>
                            </form>
                            <?php
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FRANQUEADOR_ESCOLA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_sys_rateio_matricula">
                                <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                        <span class="table-centro-custo-add float-right mb-3 mr-2">
                                            <a href="#" class="btn btn-success"><i class="material-icons">add</i><?= $texto['ADDRAT'] ?></a>
                                        </span>
                                        </div>
                                        <div class="table-responsive" style="padding: 10px">
                                            <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                <tr>
                                                    <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                    <th class="text-center"><?= $texto['CXC'] ?></th>
                                                    <th class="text-center"><?= $texto['PricePER'] ?></th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                <tr>
                                                    <td class="pt-4-half">
                                                        <select style="margin-top: -3px" name="centro_custo_0" class="form-control jsys_tipo" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                            <option value="0"><?= $texto['SELCDC'] ?></option>
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
                                                            <option value="0"><?= $texto['SELUCC'] ?></option>
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
                                                            <input autocomplete="off" type="number" name="valor_rateio_0" class="form-control">
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
                                <input type="hidden" name="action" value="RateioMatriculaAdd"/>
                                <input type="hidden" class="quantidade_centro_custo" name="quantidade_centro_custo" value="1"/>
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
        ID FUNCIONALIDADE: <?= FRANQUEADOR_ESCOLA ?>
    </div>
</div>
