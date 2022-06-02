<?php
if (empty($Read)):
  $Read = new Read;
endif;
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if($Id){

    $Read->FullRead("SELECT 
    parcela.mov_recebimento_data_recebimento,
    parcela.mov_recebimento_data_vencimento,
    parcela.mov_recebimento_id,
    parcela.mov_recebimento_movimento_id,
    parcela.mov_recebimento_numero,
    parcela.mov_recebimento_parcela,
    parcela.mov_recebimento_pessoa_id,
    parcela.mov_recebimento_status,
    parcela.mov_recebimento_tipo_id,
    parcela.mov_recebimento_valor,
    pessoa.pessoa_nome,
	  parcela.mov_recebimento_desc_identificador
    FROM sys_movimentacao_recebimento parcela
    LEFT OUTER JOIN sys_pessoas pessoa ON pessoa_id = parcela.mov_recebimento_pessoa_id 
    WHERE pessoa.pessoa_id = :id AND parcela.unidade_id = :unidade AND (parcela.mov_recebimento_status = 0 OR parcela.mov_recebimento_status = 1 OR parcela.mov_recebimento_status IS NULL)", "id={$Id}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");
    $totalNegociacao = $Read->getRowCount();

    $aluno = $Read->getResult()[0]['pessoa_nome'];

} else {
    die("<br><br><center>Erro ao selecionar Títulos do Usuário</center><br><br>");
}
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">

<style>
  .filter-control input {
        border: 0.55px !important;
         height: 20px !important;

    }
  .filter-control select {
      border: 0.55px solid gray !important;
  }
  select.form-control:not([size]):not([multiple]){
      height: 36px;
  }
  .titulo_id, .parcela{
      width: 80px;
  }
  .valor, .status{
    width: 90px;
  }
</style>
<div class="content">
  <div class="col-lg-12 col-md-12" style="display:none" id="tudo_page">
      <div class="card">
          <div class="card-header card-header-primary">
              <div class="row">
                  <div class="col-md-1">
                   <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                  </div>
                  <div class="col-md-10 text-center">
                      <h4 class="card-title">Todos os títulos a receber</h4>
                      <p class="card-category">Relação de títulos a receber</p>
                  </div>
                  <div class="col-md-1">
                  </div>
              </div>
          </div>


          <div class="card-body">

              <div >

                <div class="btn-group">

                <?php
                  if(isset($_SESSION['caixaSYS'])) {
                ?>
                   <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Financeiro <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="j_click_baixa_parcela" href="#">Baixar Parcela Selecionada</a></li>
                        <?php
                        if($totalNegociacao > 0){
                          echo '<li><a href="painel.php?exe=contasreceber/negociacao_por_pessoa&id='.$Id.'">Renegociação</a></li>';
                        } else {
                          echo '<li><a href="javascript:void()" class="j_nao_possui_negociacao">Renegociação</a></li>';
                        }
                        ?>
                        <li><a href="<?= BASE ?>/painel.php?exe=financeiro/filtro_historico_renegociacao&id=<?= $Id ?>">Histórico de Renegociação</a></li>
                        <li><a class="j_click_estornar_baixa_parcela" href="#">Estornar Baixa</a></li>
                        <li><a class="j_click_cancelar_titulos" href="#">Cancelar titulos</a></li>
                   </ul>
                   </div>
                <?php
                  }
                ?>
                   <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Impressão <span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">

                    <li><a class="j_click_gerar_carne_titulos" href="#">Carnês </a></li>
                    <li><a class="j_click_gerar_recibo_titulos" href="#">Recibo </a></li>
                    <li><a href="">Boletos </a></li>

                   </ul>
                   </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">SCPC <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="j_click_marcar_scpc_titulos" href="#">Marcar como negativo SCPC</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">

                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Alteração <span class="caret"></span></button>

                    <ul class="dropdown-menu" role="menu">
                        <li><a class="j_click_alteracao_data_vencimento" href="#">Alteração data de vencimento</a></li>

                        <li><a class="j_click_alteracao_data_vencimento_massa" href="#">Alteração todas as datas de vencimento</a></li>
                    </ul>
                   </div>

                  <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Calcular <span class="caret"></span></button>

                      <ul class="dropdown-menu" role="menu">
                          <li><a class="j_click_calcular_debitos_titulos" href="#">Calcular Débitos</a></li>
                         
                     </ul>
                   </div>
                  
                </div>

              <?php
              $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASRECEBER_TITULOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
              if($Read->getResult()){
                  $permissao = $Read->getResult()[0];
                  $_SESSION['permissao'] = $permissao;
              } else {
                echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                die;
              }
              if($permissao["ler"] == 1){
                  ?>
                  <div id="toolbar">
                      <br/>
                      
                      <div class="clearfix"></div>
                  </div>
                  <div class="border_shadow" style="padding: 20px">
                  <p style="font-size:1.2em"><b><i>Aluno</i></b>: <?=$aluno;?></p>
                  <table class="table table-hover display"
                          id="table"
                          data-toolbar="#toolbar"
                          data-locale="pt-BR"
                          data-show-export="true"
                          data-filter-control="true"
                          data-filter-show-clear="true"
                          data-show-toggle="true"
                          data-show-fullscreen="true"
                          data-show-columns="true"
                          data-click-to-select="true"
                          data-minimum-count-columns="2"
                          data-url="_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id=<?= $Id ?>"
                          data-pagination="true"
                          data-id-field="id"
                          data-buttons-class="primary">
                      <thead>                       
                      <tr>
                          <th data-field="state" data-checkbox="true"></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="titulo_id" data-field="titulo_id1" data-filter-control="input">ID</th>

                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="produto1" data-filter-control="input">Produto</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="parcela" data-field="parcela1" data-filter-control="input">Parcela</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="tipoparcela" data-field="tipoparcela" data-filter-control="input">Tipo Parcela</th>
                          <th data-filter-control-placeholder="⌕" data-field="vencimento1" data-filter-control="input"><?= $texto['DDVC'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="valor" data-field="valor1" data-filter-control="input">Valor</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="multa" data-field="multa" data-filter-control="input">Multa</th>
                          <th data-filter-control-placeholder="⌕" data-field="recebimento" data-filter-control="input"><?= $texto['DTRECi'] ?></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="valorpago" data-field="valorpago" data-filter-control="input">Valor Pago</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" class="status" data-field="status1" data-filter-control="input">Status (Aberto, Pago, Cancelado, Renegociado)</th>
                          <th data-field="acoes"><?= $texto['Act'] ?></th>
                      </tr>
                      </thead>
                  </table>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
      ID FUNCIONALIDADE: <?= CONTASRECEBER_TITULOS ?>
      </div>
  </div>
</div>

<div class="showcase hide-print" id="getCodeOperadoresModal">
  <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
  <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
              <div id="showbox-example" class="showbox">
                  <table  class="table table-hover display"
                          id="table_modal_operadores_financeiros"
                          data-locale="pt-BR"
                          data-filter-control="true"
                          data-minimum-count-columns="2"
                          data-url="_ajax/lookups/ListOperadoresFinanceiros.ajax.php?action=list"
                          data-pagination="true"
                          data-id-field="nome"
                          data-toggle="table"
                          data-select-item-name="nome"
                          data-buttons-class="primary"
                          data-click-to-select="true">
                      <thead>
                      <tr>
                          <th data-radio="true"></th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="id" data-filter-control="input">Id</th>
                          <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="nome" data-filter-control="input">Nome</th>
                      </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_escolher_operador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Escolher operador financeiro</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_autenticar_operador_financeiro">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating">Operador</label>
                              <a data-toggle="modal" data-target="#getCodeOperadoresModal">
                                  <input readonly type="text" placeholder="Clique e selecione o operador" name="pessoa_nome" id="txt_nome_pessoa" class="form-control">
                              </a>
                              <input id="txt_id_pessoa" type="hidden" name="pessoa_id" class="form-control">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="bmd-label-floating">Senha de autenticação</label>
                              <input type="password" placeholder="Digite a senha" name="senha" class="form-control clear_senha">
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="LoginOperadorFinanceiro"/>
                          <input type="hidden" class="tipo_operador" name="tipo" value=""/>
                          <button type="submit" class="btn btn-primary pull-right">Entrar</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_alterar_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Alterar data de vencimento</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="form_alteracao_data_vencimento">
              <div class="append_itens_alterar_data_vencimento"></div>
              <div class="row">
                  <input type="hidden" name="action" value="AlterarDataVencimento"/>
                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_alterar_data_massa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Alterar todas as datas de vencimento</p>               
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="produto" style="font-weight: 600"></div>
          <form class="form_alteracao_data_vencimento_massa">
              <div class="append_itens_alterar_data_vencimento_massa"></div>
              <div class="row">
                  <input type="hidden" name="action" value="AlterarDataVencimentoMassa"/>
                  <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                  <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_estornar_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">ESTORNAR BAIXA</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_estornar_parcelas">
                  <div class="append_itens_estornar_parcelas"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="EstornarParcelas"/>
                          <button type="submit" class="btn btn-primary pull-right">ESTORNAR PARCELAS</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_baixar_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document" style="min-width: 96%">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">DAR BAIXA</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_dar_baixa_parcelas">
                  <div class="append_itens"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="DarBaixaParcelas"/>
                          <button type="submit" class="btn btn-primary pull-right">DAR BAIXA NAS PARCELAS</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_cancelar_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Cancelar Títulos</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_cancelar_parcelas">
                  <div class="append_itens_cancelar"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="CancelarTitulos"/>
                          <button type="submit" class="btn btn-primary pull-right">CANCELAR TÍTULOS</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_carne_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document" style="max-width: 650px">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Gerar Carnê</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_gerar_carne_titulos">
                  <div class="append_itens_carnet"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="CarnetTitulos"/>
                          <button type="submit" class="btn btn-primary pull-right">GERAR CARNÊ</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="modal_recibo_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document" style="max-width: 650px">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Gerar Recibo</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_gerar_recibo_titulos">
                  <div class="append_itens_recibo"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="RecibotTitulos"/>
                          <button type="submit" class="btn btn-primary pull-right">GERAR RECIBO DE PAGAMENTO</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_calculo_debitos_titulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document" style="min-width: 96%">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Cálculo de Débitos</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_gerar_calculo_debitos">
                  <div class="append_itens_calculo"></div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="modal_calculo_titulos_negativad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document" style="min-width: 650px">
      <div class="modal-content">
          <div class="modal-header">
              <p class="heading lead">Marcar títulos como negativado</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form class="form_gerar_titulos_negativado">
                  <div class="append_itens_titulos_negativado"></div>
                  <div class="row">
                      <div class="col-md-12">
                          <input type="hidden" name="action" value="NegativarTitulos"/>
                          <button type="submit" class="btn btn-primary pull-right">MARCAR NEGATIVADO</button>
                          <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>