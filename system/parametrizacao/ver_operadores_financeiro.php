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
                                <h4 class="card-title"><?= $Texto['VerOPFNC'] ?></h4>
                                <p class="card-category"><?= $Texto['VerOPFNCi'] ?></p>
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
    if($permissao["ler"] != 1){
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
                                                    <select disabled value="<?= $FormData['pessoa_id'] ?>" name="pessoa_id" class="form-control" data-style="btn btn-link">
                                                <option value="0">Selecione o aluno</option>
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
                                                    <label class="bmd-label-floating">SENHA</label>
                                                    <input disabled type="text" name="senha" value="<?= $senha ?>"  class="form-control">
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
        header('Location: painel.php?exe=parametrizacao/cadastro_operadores_financeiro');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= PARAMETRIZAÇÃO_OPERADORES_FINANCEIRO ?>
  </div>
</div>