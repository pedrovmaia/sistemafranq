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


<?php 
  
   $Id =  $_SESSION["userSYSFranquia"]["pessoa_id"];

   if(isset($_SESSION['caixaSYS'])){
     $caixa_idx = $_SESSION['caixaSYS']['caixa_id'];
   }else{
      $caixa_idx = null;
   }


    $Read->FullRead("SELECT sum(sys_transacao_caixa.transacao_caixa_valor) as valor
    FROM sys_transacao_caixa 
    WHERE sys_transacao_caixa.transacao_caixa_caixa_id = ".$caixa_idx."
    AND sys_transacao_caixa.unidade_id = :unidade
    AND sys_transacao_caixa.transacao_caixa_forma is not null
    AND sys_transacao_caixa.transacao_caixa_tipo_id = 1", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

    if(isset($Read->getResult()[0]['valor']))
      $valor_entrada = $Read->getResult()[0]['valor'];
    else
      $valor_entrada = 0;



    $Read->FullRead("SELECT sum(sys_transacao_caixa.transacao_caixa_valor) as valor
    FROM sys_transacao_caixa 
    WHERE sys_transacao_caixa.transacao_caixa_caixa_id = ".$caixa_idx."
    AND sys_transacao_caixa.unidade_id = :unidade
    AND sys_transacao_caixa.transacao_caixa_forma is not null
    AND sys_transacao_caixa.transacao_caixa_tipo_id = 2", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
    var_dump($Read->getResult());
    if(isset($Read->getResult()[0]['valor']))
      $valor_saida = $Read->getResult()[0]['valor'];
    else
      $valor_saida = 0;


?>

<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">

                    <form class="form_caixa"> 
              
                    <?php if(isset($_SESSION['caixaSYS']))
                    {?> 
                    <h4 class="card-title">SEU CAIXA ESTÁ ABERTO</h4>
                    <p class="card-category">Data de abertura : <?php echo date("d/m/Y", strtotime( $_SESSION['caixaSYS']['caixa_data_abertura'])); ?> ás  <?php echo date("H:i:s", strtotime( $_SESSION['caixaSYS']['caixa_hora_abertura'])); ?> </p>
                    <input type="hidden" name="action" value="FecharCaixa"/>
                    <button type="submit" style="margin-top: -45px" class="btn btn-success pull-right">FECHAR CAIXA</button>

                    <?php }
                    ?>

                    <?php if(!isset($_SESSION['caixaSYS']))
                    {?> 
                    <h4 class="card-title">SEU CAIXA ESTÁ FECHADO</h4>
                    <p class="card-category">Abra seu caixa para efetuar transações</p>
                     <input type="hidden" name="action" value="AbrirCaixa"/>
                     <button type="submit" style="margin-top: -45px" class="btn btn-success pull-right">ABRIR CAIXA</button>
                    <?php }
                    ?>

                    </form>

                    
                </div>
                <div class="card-body">


                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="javascript:void(0);"><span style="font-size: 30px">R$ <?php echo  number_format($valor_entrada + $valor_saida, 2, ',', '.') ?></span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="javascript:void(0);">MEU SALDO DO CAIXA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="javascript:void(0);"><span style="font-size: 30px"> R$ <?php echo  number_format($valor_entrada, 2, ',', '.') ?> </span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="javascript:void(0);">TOTAL DE ENTRADAS (+)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <div class="card-icon">
                                                <i class="material-icons">list_alt</i>
                                            </div>
                                            <p class="card-category"><strong><a href="javascript:void(0);"><span style="font-size: 30px">R$ <?php echo  number_format($valor_saida * (-1), 2, ',', '.')   ?> </span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="javascript:void(0);">TOTAL DE RETIRADAS (-)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>


            <div class="col-lg-9 col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Ultimos caixas</h4>
                        <p class="card-category">Listagem dos ultimos caixas </p>
                    </div>
                    
                  <div style="padding: 20px">
                  <table  class="table table-hover display"
                          id="table"
                          data-toolbar="#toolbar"
                          data-locale="pt-BR"
                          
                          data-minimum-count-columns="2"
                          data-url="_ajax/caixa/ListCaixaPorPessoaId.ajax.php?action=list&pessoa_id=<?= $Id ?>
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>
                      <tr>
                          <th data-field="id" data-filter-control="input">ID</th>
                          <th data-field="data_abertura" data-filter-control="input">Data abertura</th>                     
                          <th data-field="hora_abertura" data-filter-control="input">Hora abertura</th>
                          <th data-field="data_fechamento" data-filter-control="input">Data fechamento</th>
                          <th data-field="hora_fechamento" data-filter-control="input">Hora fechamento</th>
                          <th data-field="caixa_status" data-filter-control="input">Status</th>                  
                          <th data-field="acoes"><?= $texto['Act'] ?></th>

                      </tr>
                      </thead>
                  </table>
                </div>

                </div>
            </div>



            <div class="col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Resumo de caixa</h4>
                        <p class="card-category">Resumo do caixa</p>
                    </div>
                     <div  style="padding: 20px">
                      <table  class="table table-hover display"
                              id="table_resumo"
                              data-toolbar="#toolbar"
                              data-locale="pt-BR"
                        
                              data-minimum-count-columns="2"
                              data-url="_ajax/caixa/ListResumoCaixa.ajax.php?action=list&caixa_id=<?= $caixa_idx?>"
                              data-pagination="true"
                              data-id-field="id"
                              data-buttons-class="primary">
                          <thead>
                          <tr>
                              <th data-field="forma_pagamento_nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                              <th data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>                        
                          </tr>
                          </thead>
                      </table>
                    </div>

                </div>
            </div>    


    </div>
</div>