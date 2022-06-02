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
                                <h4 class="card-title"><?= $Texto['CadOPFNC'] ?></h4>
                                <p class="card-category"><?= $Texto['CadOPFNCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZAÇÃO_OPERADORES_FINANCEIRO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["alterar"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            $Read->ExeRead("sys_operadores_financeiro", "WHERE operador_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                                extract($FormData);
                                ?>
                                <form class="form_operadores_financeiro">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                                        <div class="row">
<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['PEOPLE'] ?></label>
                                                    <select disabled value="<?= $FormData['pessoa_id'] ?>" name="pessoa_id" class="form-control" data-style="btn btn-link">
                                                <?php
                                                $Read->ExeRead("sys_pessoas");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                         <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['pessoa_id']  == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                                </div>
                                            </div>

                                                   <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $Texto['NEWPASS'] ?></label>
                                                    <input type="password" name="senha" class="form-control">
                                                </div>
                                            </div>
                                        </div>                      
                                        <br/>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="action" value="OperadorEditar"/>
                                    <input type="hidden" name="operador_id" value="<?= $Id; ?>"/>
                                    <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                    <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                    <?php
                                    if($permissao["deletar"] == 1) {
                                        ?>
                                        <span rel='single_user_addr' callback='parametrizacao/OperadoresFinanceiro' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </form>
                            <?php
                            else:
                                $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                                header('Location: painel.php?exe=parametrizacao/cadastro_operadores_financeiro');
                                exit;
                            endif;
                        else:
                            $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PARAMETRIZAÇÃO_OPERADORES_FINANCEIRO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                            $permissao = $Read->getResult()[0];
                            if($permissao["inserir"] != 1){
                                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                                die;
                            }
                            ?>
                            <form class="form_operadores_financeiro">
                                <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                    <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                    <div class="row">
<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating"><?= $texto['PEOPLEi'] ?></label>
                                                        <a data-toggle="modal" data-target="#getCodeModal">
                                                            <input readonly type="text" placeholder="Clique e selecione a pessoa"  id="txt_pessoa" class="form-control">
                                                        </a>
                                                        <input  id="txt_id_pessoa" type="hidden" name="pessoa_id" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                            <div class="form-group">

                                                 <label class="bmd-label-floating"><?= $Texto['PASS'] ?></label>
                                                    <input type="password" name="senha" class="form-control senha">
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                                <br/>
                                <input type="hidden" name="action" value="OperadorAdd"/>
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
        ID FUNCIONALIDADE: <?= PARAMETRIZAÇÃO_OPERADORES_FINANCEIRO ?>
    </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_funcionarios"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListFuncionarios.ajax.php?action=list"
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
                            <th data-field="cpf" data-filter-control="input"><?= $texto['CRG'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
