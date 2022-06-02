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
                                <h4 class="card-title">VER TREINAMENTO</h4>
                                <p class="card-category">Exibição de treinamento</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_TREINAMENTOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("escola_treinamentos", "WHERE treinamentos_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_treinamentos">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">
                   <div class="col-md-6">
                    <div class="form-group">
                        <label class="bmd-label-floating">NOME</label>
                        <input type="text" disabled name="treinamentos_nome" value="<?= $treinamentos_nome ?>" class="form-control">
                    </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                         <label class="bmd-label-floating">CATEGORIA</label>
                                                <select disabled name="treinamentos_categoria_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0">Selecione a categoria</option>
                                                    <?php
                                                    $Read->ExeRead("escola_categoria_treinamentos");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Categoria):
                                                            ?>
                                                            <option value="<?= $Categoria['categoria_treinamentos_id'] ?>" <?= ($Categoria['categoria_treinamentos_id'] == $FormData['treinamentos_id'] ? 'selected="selected"' : ''); ?>><?= $Categoria['categoria_treinamentos_nome'] ?></option>
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
                                            <label class="bmd-label-floating">DESCRIÇÃO</label>
                        <input type="text" disabled name="treinamentos_descricao" value="<?= $treinamentos_descricao ?>"  class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                                                <div class="form-group">
                                            <label class="bmd-label-floating">DATA REALIZAÇÃO</label>
                        <input type="text" disabled name="treinamentos_data_realizacao" value="<?= date('d/m/Y', strtotime($treinamentos_data_realizacao)) ?>"  class="form-control">
                    </div>
                </div>
                                                    </div>

                                         <div class="row">
                                            
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">DATE</label>
                        <input type="text" disabled name="treinamentos_date" value="<?= date('d/m/Y', strtotime($treinamentos_date)) ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="bmd-label-floating">LOCAL</label>
                                                <select disabled name="local_unidade_id" class="form-control" data-style="btn btn-link">
                                                    <option value="0">Selecione o local</option>
                                                    <?php
                                                    $Read->ExeRead("sys_unidades");
                                                    if ($Read->getResult()):
                                                        foreach ($Read->getResult() as $Local):
                                                            ?>
                                                            <option value="<?= $Local['unidade_id'] ?>" <?= ($Local['unidade_id'] == $FormData['local_unidade_id'] ? 'selected="selected"' : ''); ?>><?= $Local['unidade_nome'] ?></option>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                    </div>   </div>
                    </div>    
                <br/>
            </div>
            <br/>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=pedagogico/cadastro_treinamentos');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TREINAMENTOS ?>
  </div>
</div>
