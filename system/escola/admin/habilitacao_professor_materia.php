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
                                <h4 class="card-title"><?= $texto['HABPRFSS'] ?></h4>
                                <p class="card-category"><?= $texto['DEFALS'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <form class="form-cadastro-habilitacao-professor">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1"><?= $texto['Prof'] ?></label>
                                <select name="pessoa_principal_id" class="form-control jsys_habilitacao_professor_materia" data-style="btn btn-link">
                                    <option value="0"><?= $texto['SelPROFSS'] ?></option>
                                    <?php
                                    $Read->FullRead("SELECT pessoa_nome, pessoa_id FROM sys_pessoas WHERE pessoa_cargo_id = :st AND unidade_id = :unidade", "st=1&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
                                    if ($Read->getResult()):
                                        foreach ($Read->getResult() as $Coordenador):
                                            ?>
                                            <option value="<?= $Coordenador['pessoa_id'] ?>"><?= $Coordenador['pessoa_nome'] ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php
                                  $Read->FullRead("SELECT p.produto_nome, e.estagio_produto_nome FROM sys_produto AS p INNER JOIN sys_estagio_produto AS e ON e.estagio_produto_produto_id = p.produto_id WHERE p.produto_tipo_id = 2 AND p.produto_status = 0");
                                ?>
                                <table class="table">
                                    <thead>
                                    <th>Situação</th>
                                    <th>Curso - Estágio</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($Read->getResult()){
                                        foreach ($Read->getResult() as $Cursos) {
                                            ?>
                                            <tr class="table_habilitacao">
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><?= $Cursos['produto_nome'] . ' - ' . strtoupper($Cursos['estagio_produto_nome']) ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <input type="hidden" name="action" value="manager" />
                            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                            <img class="form_load pull-right" src="<?= BASE  ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= ESCOLA_HABILITACAO_PROFESSOR_MATERIA ?>
    </div>
</div>
