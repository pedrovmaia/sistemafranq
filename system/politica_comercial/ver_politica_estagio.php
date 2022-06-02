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
                                <h4 class="card-title"><?= $texto['VerPLTCEST'] ?></h4>
                                <p class="card-category"><?= $texto['VerPLTCESTi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".POLITICA_COMERCIAL_ESTAGIO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_politica_comercial_estagios", "WHERE politica_comercial_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
             <form class="form_politica_comercial_estagio">
                                    <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                        <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
               
                                        <div class="col-md-12">
                                        <div class="row">
                                               <div class="col-md-6">
                                                     <div class="form-group">
                                                     <label  class="bmd-label-floating"><?= $texto['ESSTT'] ?></label>
                                                     <select disabled style="margin-top: -3px" name="politica_comercial_estagio_id" value="<?= $politica_comercial_estagio_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelESTAGi'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_status  = :st", "st=0"
                                                        );
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Estagio):
                                                                ?>
                                                                 <option value="<?= $Estagio['estagio_produto_id'] ?>" <?= ($Estagio['estagio_produto_id'] == $FormData['politica_comercial_estagio_id'] ? 'selected="selected"' : ''); ?>><?= $Estagio['estagio_produto_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                    <input type="text" disabled name="politica_comercial_valor" value="<?=number_format($politica_comercial_valor, 2, ',', '.') ?>" class="form-control dinheiro">
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['InitialDateM'] ?></label>
                                                    <input type="text" disabled name="politica_comercial_data_inicio" value="<?= $politica_comercial_data_inicio ?>" class="form-control">
                                                </div>
                                            </div>

                                               <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating"><?= $texto['FinalDateM'] ?></label>
                                                    <input type="text" disabled name="politica_comercial_data_final" value="<?= $politica_comercial_data_final ?>" class="form-control">
                                                </div>
                                            </div>
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
        header('Location: painel.php?exe=politica_comercial/cadastro_politica_estagio');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= POLITICA_COMERCIAL_ESTAGIO ?>
  </div>
</div>
