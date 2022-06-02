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

    $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  
    $caixa_idx = $Id;

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

    if(isset($Read->getResult()[0]['valor']))
      $valor_saida = $Read->getResult()[0]['valor'];
    else
      $valor_saida = 0;


     $Read->FullRead("
     SELECT     
           caixa.caixa_id,
           DATE_FORMAT(caixa.caixa_data_abertura,'%d/%m/%Y') AS data_abertura,
           caixa.caixa_hora_abertura,
           DATE_FORMAT(caixa.caixa_data_fechamento,'%d/%m/%Y') AS data_fechamento,
           caixa.caixa_hora_fechamento,
           pessoa.pessoa_nome,
           caixa.unidade_id,
          CASE

              WHEN caixa.caixa_status = 1 THEN 'Aberto'
              WHEN caixa.caixa_status = 2 THEN 'Fechado'
              WHEN caixa.caixa_status = 3 THEN 'Conferido'
              END AS caixa_status
                  
           FROM sys_caixa caixa
           LEFT OUTER JOIN sys_pessoas pessoa ON pessoa.pessoa_id = caixa.caixa_pessoa_id
           WHERE caixa.caixa_id = :id
           AND caixa.unidade_id =  :unidade 
           ORDER BY caixa.caixa_id", "id={$caixa_idx}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

      if(isset($Read->getResult()[0]['caixa_status']))
      {
        $caixa_selecionado = $Read->getResult()[0];

        
      }
      else
        $caixa_selecionado = null;


?>

<div class="container-fluid" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header card-header-primary">

                  <form class="form_caixa_conferencia">
                    <h4 class="card-title">Caixa de <?php echo $caixa_selecionado['pessoa_nome'] ?></h4>
                    <p class="card-category">Abertura : <?php echo date("d/m/Y", $caixa_selecionado['data_abertura']); ?> às  <?php echo date("H:i:s", strtotime( $caixa_selecionado['caixa_hora_abertura'])); ?>

                   // --- // Fechamento : <?php echo date("d/m/Y", strtotime( $caixa_selecionado['data_fechamento'])); ?> às  <?php echo date("H:i:s", strtotime( $caixa_selecionado['caixa_hora_fechamento'])); ?>

                     </p>                  

                    <input type="hidden" name="action" value="ConferidoCaixa"/>
                    <input type="hidden" name="caixa_id" value="<?= $caixa_idx; ?>"/>
                    <button type="submit" style="margin-top: -45px" class="btn btn-success pull-right">MARCAR COMO CONFERIDO</button>

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
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=fornecedores/fornecedor/filtro_fornecedores"><span style="font-size: 30px">R$ <?php echo  number_format($valor_entrada - $valor_saida, 2, ',', '.') ?></span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=fornecedores/fornecedor/filtro_fornecedores">MEU SALDO DO CAIXA</a>
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
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=fornecedores/prestador/filtro_prestador"><span style="font-size: 30px"> R$ <?php echo  number_format($valor_entrada, 2, ',', '.') ?> </span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=fornecedores/prestador/filtro_prestador">TOTAL DE ENTRADAS (+)</a>
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
                                            <p class="card-category"><strong><a href="<?= BASE ?>/painel.php?exe=fornecedores/prestador/filtro_prestador"><span style="font-size: 30px">R$ <?php echo  number_format($valor_saida, 2, ',', '.')   ?> </span></a></strong></p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">person</i>
                                                <a href="<?= BASE ?>/painel.php?exe=fornecedores/prestador/filtro_prestador">TOTAL DE RETIRADAS (-)</a>
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
                        <h4 class="card-title">Transações do caixa</h4>
                        <p class="card-category">Listagem dos transações do caixa </p>
                    </div>
                    
                  <div style="padding: 20px">
                  <table  class="table table-hover display"
                          id="table"
                          data-toolbar="#toolbar"
                          data-locale="pt-BR"
                          
                          data-minimum-count-columns="2"
                          data-url="_ajax/relatorios/ListTransacaoCaixa.ajax.php?action=list&id=<?= $Id ?>"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead >
                      <tr>
                          <th data-field="id" data-filter-control="input">ID</th>
                          <th data-field="tipo" data-filter-control="input">Entrada ou Saída</th>                        
                          <th data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                          <!--<th data-field="forma" data-filter-control="input"><?= $texto['PYMi'] ?></th> -->
                          <th data-field="descricao" data-filter-control="input"><?= $texto['dsc'] ?></th>
                          <th data-field="valor" data-filter-control="input"><?= $texto['Price'] ?></th>
                          <!--<th data-field="observacao" data-filter-control="input"><?= $texto['OBSi'] ?></th> -->

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
                              data-url="_ajax/caixa/ListResumoCaixa.ajax.php?action=list&caixa_id=<?= $caixa_idx ?>"
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