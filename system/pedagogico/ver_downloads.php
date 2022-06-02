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
                                <h4 class="card-title">VER DOWNLOAD</h4>
                                <p class="card-category">Exibição de download</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".PEDAGOGICO_DOWNLOADS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_downloads", "WHERE escola_download_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_download">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">TÍTULO</label>
                            <input type="text" disabled name="escola_download_titulo" value="<?= $escola_download_titulo ?>" class="form-control">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">DESCRIÇÃO</label>
                            <input type="text" disabled name="escola_download_descricao" value="<?= $escola_download_descricao ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating">TIPO</label>
                                                   
                                                     <select style="margin-top: -3px" disabled name="escola_download_tipo" value="<?= $escola_download_tipo ?>" class="form-control" data-style="btn btn-link">
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("escola_categoria_anexos", "WHERE escola_categoria_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Tipo):
                                                                ?>
                                                                <option <?= ($escola_download_tipo == $Tipo['unidade_id'] ? "selected='selected'" : "") ?> value="<?= $Tipo['escola_categoria_anexo_id'] ?>"><?= $Tipo['escola_categoria_descricao'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                    </div>
                </div>
                </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <input type="checkbox" disabled name="escola_download_status" value="1" <?= ($escola_download_status == 1 ? 'checked' : ''); ?>><?= $texto['InaC'] ?></label>
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
        header('Location: painel.php?exe=pedagogico/cadastro_downloads');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PEDAGOGICO_DOWNLOADS ?>
  </div>
</div>
