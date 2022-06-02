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
                                <h4 class="card-title">VER LIVRO</h4>
                                <p class="card-category">Exibição de livro</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_LIVROS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_livros", "WHERE livro_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
         <div class="row">
                    <div class="ml-3">
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                             <a href="<?= BASE ?>/painel.php?exe=pedagogico/livros/filtro_livro_dica&id=<?= $FormData["livro_id"] ?>"
                           class="btn btn-primary pull-right">Dicas</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <?php
                        if($permissao["inserir"] == 1) {
                            ?>
                             <a href="<?= BASE ?>/painel.php?exe=pedagogico/livros/filtro_livro_download&id=<?= $FormData["livro_id"] ?>"
                           class="btn btn-primary pull-right">Downloads</a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
        <form class="form_livros">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">NOME</label>
                            <input type="text" disabled name="livro_nome" value="<?= $livro_nome ?>" class="form-control">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                     <label class="bmd-label-floating">Coleção</label>
                                                <select disabled name="livro_colecao_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0">Selecione a coleção</option>
                                                    <?php
                                                    $Read->ExeRead("escola_colecao_livros", "WHERE escola_colecao_livros_status = :st", "st=0");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Colecao):
                                                            ?>
                                                            <option value="<?= $Colecao['escola_colecao_livros_id'] ?>" <?= ($Colecao['escola_colecao_livros_id'] == $FormData['livro_colecao_id'] ? 'selected="selected"' : ''); ?>><?= $Colecao['escola_colecao_livros_nome'] ?></option>
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
                            <label class="bmd-label-floating"></label>
                            <img disabled name="livro_capa" src="<?= $livro_capa ?>" height="150" width="150">
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
        header('Location: painel.php?exe=pedagogico/cadastro_livros');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_LIVROS ?>
  </div>
</div>
