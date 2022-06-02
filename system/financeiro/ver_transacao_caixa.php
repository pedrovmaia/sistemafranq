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
                                <h4 class="card-title"><?= $texto['VerTDC'] ?></h4>
                                <p class="card-category"><?= $texto['VerTDCi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".FINANCEIRO_TRANSACAO_CAIXA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["ler"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
    $Read->ExeRead("sys_transacao_caixa", "WHERE transacao_caixa_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_transacao_caixa">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label class="bmd-label-floating"><?= $texto['ESDD'] ?></label>
                                              <select style="margin-top: -3px" class="form-control"  value="<?= $transacao_caixa_tipo_id ?>" disabled name="transacao_caixa_tipo_id">
                                                    <option selected disabled value=""><?= $texto['SelGENE'] ?></option>
                                                    <option value="1" <?= ($FormData['transacao_caixa_tipo_id'] == 1 ? 'selected="selected"' : ''); ?>>Entrada de Caíxa</option>
                                                    <option value="2" <?= ($FormData['transacao_caixa_tipo_id'] == 2 ? 'selected="selected"' : ''); ?>>Saída de caíxa</option>
                                                </select>                                         
                                </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['DTA'] ?></label>
                                             <input type="text" value="<?= date('d/m/Y', strtotime($transacao_caixa_data)) ?>" disabled name="transacao_caixa_data" class="form-control">
                                        </div>
                                    </div>
                                  </div>




                               

                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PYM'] ?></label>
                                                  <select disabled value="<?= $FormData['transacao_caixa_forma'] ?>" name="transacao_caixa_forma" class="form-control" data-style="btn btn-link">
                                                <?php
                                                $Read->ExeRead("sys_forma_pagamento", "WHERE forma_pagamento_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Forma):
                                                        ?>
                                                         <option value="<?= $Forma['forma_pagamento_id'] ?>" <?php if ($FormData['transacao_caixa_forma']  == $Forma['forma_pagamento_id'] ) { echo "selected";}  ?>  ><?php echo $Forma['forma_pagamento_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                                    </div>
                                    </div>
                                     

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                                            <input autocomplete="off" type="text" value="<?= $transacao_caixa_descricao ?>" disabled name="transacao_caixa_descricao" class="form-control">
                                        </div>
                                    </div>

                         

                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                            <input autocomplete="off" type="text" value="<?=number_format($transacao_caixa_valor, 2, ',', '.') ?>" disabled name="transacao_caixa_valor" class="form-control dinheiro">
                                           
                                        </div>
                                    </div> 

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ACOT'] ?></label>
                                                  <select disabled value="<?= $FormData['transacao_conta_bancaria_id'] ?>" name="transacao_conta_bancaria_id" class="form-control" data-style="btn btn-link">
                                                <?php
                                                $Read->ExeRead("sys_conta_bancaria", "WHERE conta_bancaria_status = :st", "st=0");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Forma):
                                                        ?>
                                                         <option value="<?= $Forma['conta_bancaria_id'] ?>" <?php if ($FormData['transacao_conta_bancaria_id']  == $Forma['conta_bancaria_id'] ) { echo "selected";}  ?>  ><?php echo $Forma['conta_bancaria_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>

                                    </div>
                                    </div>

                                   
                                </div>


  <div id="informacoes_basicas" class="border_shadow" style="margin-top: 15px; padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['RATE'] ?></strong></label>

                                                <div class="row">
                                                    
                                                    <div class="table-responsive" style="padding: 10px">
                                                        <table class="table table-bordered table-responsive-md table-striped text-center table_centro_custo">
                                                            <tr>
                                                                <th class="text-center"><?= $texto['CentCost'] ?></th>
                                                                <th class="text-center"><?= $texto['CXC'] ?></th>
                                                                <th class="text-center"><?= $texto['PriceM'] ?></th>

                                                                
                                                            </tr>

                                                            <?php
                                                            $Read->ExeRead("sys_transacao_rateio", "WHERE rateio_conta_id = :id", "id={$Id}");
                                                            if($Read->getResult()) {
                                                                $QTDTelefones = $Read->getRowCount();
                                                                $i = 0;
                                                                foreach ($Read->getResult() as $Rateios) {
                                                                    ?>
                                                            <tr>
                                                               
                                                                <td class="pt-4-half">
                                                                <input disabled type="hidden" name="centro_custo_<?= $i ?>"
                                                                       value="<?= $Rateios['rateio_id'] ?>">
                                                                <select disabled name='centro_custo_<?= $i ?>' class="form-control">
                                                                     <option value="0">SELECIONE UM CENTRO DE CUSTO</option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_centro_custo");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $CentroCusto):
                                                                            echo "<option " . ($Rateios['rateio_centro_custo_id'] == $CentroCusto['centro_custo_id'] ? 'selected="selected"': '') . "  value='{$CentroCusto['centro_custo_nome'] }'>{$CentroCusto['centro_custo_nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                                </td>



                                                                 <td class="pt-4-half">
                                                                <input disabled type="hidden" name="conta_contabil_<?= $i ?>"
                                                                       value="<?= $Rateios['rateio_id'] ?>">
                                                                <select disabled name='conta_contabil_<?= $i ?>' class="form-control">
                                                                     <option value="0">SELECIONE UMA CONTA CONTÁBIL</option>
                                                                    <?php
                                                                    $Read->ExeRead("sys_conta_contabil", "WHERE conta_contabil_status = :st", "st=0");
                                                                    if ($Read->getResult()):
                                                                        foreach ($Read->getResult() as $ContaContabil):
                                                                            echo "<option " . ($Rateios['rateio_conta_contabil_id'] == $ContaContabil['conta_contabil_id'] ? 'selected="selected"': '') . "  value='{$ContaContabil['conta_contabil_nome'] }'>{$ContaContabil['conta_contabil_nome'] }</option>";
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                                </td>


                                                             

                                                                <td class="pt-4-half">
                                                                    <div class="form-group">

                                                                       
                                                                         <input disabled name="valor_rateio_<?= $i ?>" type="text"
                                                                       placeholder="Valor" class="form-control"
                                                                       value="<?= 'R$ ' . number_format($Rateios['rateio_valor'], 2, ',', '.')    ?>">


                                                                    </div>
                                                                </td>


                                                             



                                                            </div>



                                                            </tr>
                                                            <?php
                                                                $i++;
                                                                }
                                                            } else {
                                                                $QTDTelefones = 0;
                                                            }
                                                            ?>


                                                            </table>
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
        header('Location: painel.php?exe=financeiro/cadastro_transacao_caixa');
        exit;
    endif;
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= FINANCEIRO_TRANSACAO_CAIXA ?>
  </div>
</div>
