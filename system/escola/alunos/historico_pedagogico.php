<?php
if (empty($Read)):
    $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">

<style>
    .headcol {
        position:absolute;
        right:0;
        top:auto;
        border-right: 1px black;
        border-top-width:3px; /*only relevant for first row*/
        margin-top:-3px; /*compensate for top border*/
        background: linear-gradient(#EEEEEE, #EEEEEE, #EEEEEE);
        border-radius: 3px;
    }
    table {
        width:100%;
        margin:auto;
        border-collapse:separate;
        border-spacing:0;
    }
    .fixed-table-body {
        width: auto;
        overflow-x:scroll;
        margin-right:120px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 120px;
    }
    .funcionario{
        min-width: 200px;
    }
    
    .filter-control input {
        border: 0.55px !important;
    }
    .filter-control select {
        border: 0.55px solid  !important;
    }
    select.form-control:not([size]):not([multiple]){
        height: 36px;
    }
</style>
<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if($Id){
    $Read->FullRead("SELECT p.projeto_id, ep.estagio_produto_id, ep.estagio_produto_nome, p.projeto_descricao, mo.modalidade_nome, uni.pessoa_nome 
FROM sys_matriculas AS m 
INNER JOIN sys_matricula_item AS mi ON m.matricula_id = mi.matricula_item_proposta_id
LEFT OUTER JOIN sys_projetos AS p ON p.projeto_id = mi.matricula_projeto_id
LEFT OUTER JOIN sys_estagio_produto AS ep ON mi.matricula_item_produto_id = ep.estagio_produto_id
LEFT OUTER JOIN sys_modalidades AS mo ON mi.modalidade_id = mo.modalidade_id
LEFT OUTER JOIN sys_pessoas AS uni ON mi.unidade_id = uni.pessoa_id
WHERE mi.matricula_item_tipo = 1 AND m.matricula_cliente_id = :id ORDER BY ep.estagio_produto_id", "id={$Id}");
    $Resultados = $Read->getResult();
?>
   <div id="loader" class="loader"></div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card" style="background: #F7F7F7">
              <div class="card-header card-header-primary">
                  <div class="row">
                      <div class="col-md-1">
                         <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                      </div>
                      <div class="col-md-10 text-center">
                          <h4 class="card-title">Historico Pedagógico</h4>
                          <p class="card-category">Todas as matrículas</p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_HISTORICO_PEDAGOGICO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                  if($Read->getResult()){
                      $permissao = $Read->getResult()[0];
                      $_SESSION['permissao'] = $permissao;
                  } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                  }


                $_SESSION['permissao'] = $permissao;
                if($permissao["ler"] == 1){
                ?>

                    <div class="clearfix"></div>
                </div>

                <div class="" style="padding: 0 10px;">

                    <div id="botao" class="border_shadow" style="padding: 15px; margin-bottom: 5px">
                        <input type="hidden" value="<?= $Id ?>" class="id_pesquisa">
                        <div class="row">
                            <div class="ml-3">
                                Data Inicial : <span class="bmd-form-group is-filled"><input type="date" class="form-control data_inicio_busca"></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="ml-3">
                                Data Final :  <span class="bmd-form-group is-filled"><input type="date" class="form-control data_fim_busca"></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="ml-3">
                                <span rel="escola/Aluno" class="btn btn-primary pull-right mt-4 j_sys_busca_data_historico_pedagogico">PESQUISAR</span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="resultado_serch"></div>
                  <?php
                  if($Resultados){
                      foreach($Resultados as $Resultado) {

                        $Read->FullRead("SELECT SUM( case when aula.presenca = 1 then 1 else 0 end ) presente, SUM( case when aula.presenca = 0 then 1 else 0 end ) falta FROM sys_envolvidos_projeto AS ep
                            INNER JOIN sys_projetos AS p ON ep.envolvidos_projeto_projeto_id = p.projeto_id
                            INNER JOIN sys_acompanhamento_aula AS aula ON aula.projeto_id = p.projeto_id
                            WHERE p.projeto_produto_id = :p AND ep.envolvidos_envolvido_id = :id", "p={$Resultado['estagio_produto_id']}&id={$Id}");

                          $Presenca = $Read->getResult()[0]['presente'];
                          $Falta = $Read->getResult()[0]['falta'];

                          $Read->FullRead("SELECT SUM( case when pla.planejamento_status = 2 then 1 else 0 end ) status1,
                            COUNT( pla.planejamento_id ) id FROM sys_planejamento
                            AS pla WHERE pla.planejamento_projeto_id = :projeto", "projeto={$Resultado['projeto_id']}");

                          $Realizadas = $Read->getResult()[0]['status1'];
                          $Total = $Read->getResult()[0]['id'];
                      ?>
                          <div class="card border_shadow list_retorno_search">
                              <div class="card-body">
                                  <div class="row" style="padding: 5px">
                                      <div class="col-md-6">
                                          <label style="color: #422D66"><b>Turma-Curso-Estágio</b></label><br>
                                          <b><?= $Resultado['projeto_descricao'] . ' - ' . $Resultado['estagio_produto_nome'] . ' - ' . $Resultado['modalidade_nome'] ?></b>
                                      </div>
                                      <div class="col-md-6">
                                          <label style="color: #422D66"><b>Franquia</b></label><br>
                                          <b><?= $Resultado['pessoa_nome'] ?></b>
                                      </div>
                                  </div>
                                  <div class="row" style="padding: 5px">
                                      <div class="col-md-3">
                                          <label style="color: #422D66"><b>Frequência</b></label><br>
                                          <b><?= ($Presenca ? $Presenca : 0) ?>/<?= $Total ?></b>
                                      </div>
                                      <div class="col-md-3">
                                          <label style="color: #422D66"><b>Faltas</b></label><br>
                                          <b><?= ($Falta ? $Falta : 0) ?></b>
                                      </div>
                                      <div class="col-md-6">
                                          <label style="color: #422D66"><b>Progresso:</b></label>
                                          <div class="progress md-progress" style="height: 20px">
                                              <?php
                                              $total = $Total;
                                              $parte = $Realizadas;
                                              if($total != 0){
                                                $x = $parte*100/$total;
                                              } else {
                                                $x = 0;
                                              }
                                              $x=substr($x,0,strpos($x,'.')+3);
                                              ?>
                                              <div class="progress-bar" role="progressbar" style="width: <?= number_format($x, 0, '.', ',') ?>%; height: 20px" aria-valuenow="<?= $Realizadas ?>" aria-valuemin="0" aria-valuemax="<?= $Total ?>"><?= number_format($x, 0, '.', ',') ?>%</div>
                                          </div>
                                          <?php
                                          if($Resultado['projeto_descricao'] == null){
                                              echo '<button class="btn btn-primary">TRANSFERIR ALUNO</button>';
                                          }
                                          ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      <?php
                      }
                  } else {
                      echo "Não existem matrículas realizadas por esse aluno!";
                  }
                  ?>
                </div>
                    <?php
                }
                ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= ESCOLA_HISTORICO_PEDAGOGICO ?>
    </div>
     <?php
    } else {
  die("Erro");
}
?>
