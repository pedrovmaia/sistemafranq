<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdCurso = filter_input(INPUT_GET, 'idcurso', FILTER_VALIDATE_INT);
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
                                <h4 class="card-title">VER ESTÁGIO DO CURSO</h4>
                                <p class="card-category">Exibição de estagio do curso</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ESTAGIO_CURSO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_id = :id", "id={$Id}");
                if ($Read->getResult()):
                    $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
                    extract($FormData);
                    ?>
                     <div id="botao" class="border_shadow" style="padding: 15px; margin-bottom: 5px">
                    <div class="row">
                    <div class="ml-3">
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                            <a href="<?= BASE ?>/painel.php?exe=pedagogico/filtro_materias_aula&id=<?= $FormData["estagio_produto_id"] ?>"
                               class="btn btn-primary pull-right">MATÉRIAS DE AULA</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                      <div class="ml-3">
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                            <a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_etapa_avaliacao&id=<?= $FormData["estagio_produto_id"] ?>&idcurso=<?= $IdCurso ?>"
                               class="btn btn-primary pull-right">Etapa de avaliação</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                        <div class="ml-3">
                            <?php
                            if($permissao["inserir"] == 1) {
                                ?>
                                <a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_avaliacao&id=<?= $FormData["estagio_produto_id"] ?>&idcurso=<?= $IdCurso ?>"
                                   class="btn btn-primary pull-right">Cadastro de avaliação</a>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-3">
                            <?php
                            if($permissao["inserir"] == 1) {
                                ?>
                                <a href="<?= BASE ?>/painel.php?exe=escola/admin/conteudo_programatico&id=<?= $FormData["estagio_produto_id"] ?>&idcurso=<?= $IdCurso ?>"
                                   class="btn btn-primary pull-right">Conteúdo programático</a>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                        </div>


                        <div class="ml-3">
                            <?php
                            if($permissao["inserir"] == 1) {
                                ?>
                                <a href="<?= BASE ?>/painel.php?exe=escola/admin/filtro_materiais_estagio&id=<?= $FormData["estagio_produto_id"] ?>"
                                   class="btn btn-primary pull-right">Materiais</a>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                        </div>

                        <div class="ml-3">
                            <?php
                            if($permissao["inserir"] == 1) {
                                ?>
                                <a href="<?= BASE ?>/painel.php?exe=escola/avaliacao/filtro_homework&id=<?= $FormData["estagio_produto_id"] ?>"
                                   class="btn btn-primary pull-right">HOMEWORK</a>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                        </div>

                        <div class="ml-3">
                            <?php
                            if($permissao["inserir"] == 1) {
                                ?>
                                <a href="<?= BASE ?>/painel.php?exe=escola/avaliacao/filtro_exercicio&id=<?= $FormData["estagio_produto_id"] ?>"
                                   class="btn btn-primary pull-right">EXERCÍCIO</a>
                                <?php
                            }
                            ?>
                            <div class="clearfix"></div>
                        </div>

                    </div>


                    </div>

                     

            


                    <form class="form_estagio_curso">
                        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">NOME</label>
                                        <input type="text" disabled name="estagio_produto_nome" value="<?= $estagio_produto_nome ?>" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">

                                        <input type="checkbox" disabled name="estagio_produto_status" value="1" <?= ($estagio_produto_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
                    header('Location: painel.php?exe=empresa/admin/cadastro_estagio_curso');
                    exit;
                endif;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_ESTAGIO_CURSO ?>
  </div>
</div>
