<?php
if (empty($Read)):
    $Read = new Read;
endif;

$sala = 16;
$turma = 25;
$situacao = 2;

  $Read->FullRead("SELECT * FROM sys_sala WHERE unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");

  $salas = $Read->getResult();
        
  $total_salas = $Read->getRowCount();

  $Read->FullRead("SELECT * FROM sys_projetos WHERE unidade_id = {$_SESSION['userSYSFranquia']['unidade_padrao']}");

  $turmas = $Read->getResult();
        
  $total_turmas = $Read->getRowCount();

  $media_turmas_sala = intval($total_turmas / $total_salas);

  $Read->FullRead("SELECT * FROM sys_situacao_projeto");

  $situacoes = $Read->getResult();
        
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
        margin-right:100px;
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 100px;
        text-align: center;
    }
      .nome{
              min-width: 400px;
          }

           .apelido{
              min-width: 200px;
          }

            .e-mail{
              min-width: 200px;
          }
            .endereco{
              min-width: 400px;
          }
            .bairro{
              min-width: 320px;
          }
            .complemento{
              min-width: 400px;
          }
           .cidade{
              min-width: 400px;
          }
          .cep{
              min-width: 200px;
          }
          .observacao{
              min-width: 500px;
          }
           .escola{
              min-width: 400px;
          }
           .catalogoobs{
              min-width: 400px;
          }
           .cpf, .rg{
              min-width: 150px;
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
 
  <div id="loader" class="loader"></div>
   
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
                          <h4 class="card-title">Relação de turmas por salas</h4>
                          <p class="card-category">Turmas por salas</p>
                      </div>
                      <div class="col-md-1">
                      </div>
                  </div>
              </div>
            <div class="card-body">
                
                <?php
                  $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".RELATORIOS_ALUNOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
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

                <div id="botao" class="border_shadow" style="padding: 15px; margin-bottom: 5px">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="texto_trocar_parcela"></p>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <p>Total de salas: <?php echo $total_salas;?>, Total de turmas: <?php echo $total_turmas;?>, Média de turmas por sala: <?php echo $media_turmas_sala;?></p>
                      </div>
                    </div>

                    <div class="row">                      
                        <div class="ml-2">
                            Sala : 
                            <select name="sala" id="sala" class="form-control sala" style="width: 200px"> 
                            <option value="">Selecione</option>                           
                            <?php foreach ($salas as $sala) { ?>

                              <option class="form-control" value="<?php echo $sala['sala_id']; ?>"><?php echo $sala['sala_nome']; ?></option>

                            <?php } ?>

                            </select> 
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-2">
                          Turma :
                            <select name="turma" id="turma" class="form-control turma" style="width: 200px"> 
                            <option value=''>Selecione</option> 

                            </select> 
                            <div class="clearfix"></div>
                        </div>
                        <div class="ml-2">
                            Situação da turma: 
                            <select name="situacao" id="situacao" class="form-control situacao" style="width: 200px"> 
                            <option value="">Selecione</option>                           
                            <?php foreach ($situacoes as $situacao) { ?>

                              <option class="form-control" value="<?php echo $situacao['situacao_projeto_id']; ?>"><?php echo $situacao['situacao_projeto_nome']; ?></option>

                            <?php } ?>

                            </select>
                            <div class="clearfix"></div>
                          </div>
                          <div class="ml-2">

                            Data de criação:  <input type="date" name="data" class="form-control data" value="">

                            <div class="clearfix"></div>

                        </div>

                        <div class="ml-2">
                            <span rel="relatorios/ListTurmasSalas" class="btn btn-primary pull-right mt-4 j_sys_turmas_salas">PESQUISAR</span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="border_shadow" style="padding: 20px">
                    <span rel="relatorios/ListTurmasSalas" class="btn btn-primary pull-left mt-4 pdf">GERAR PDF</span>
                    <div class="table-wrap">
                    <div class="table-scroll">
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
                        data-minimum-count-columns="2"
                        data-url="_ajax/relatorios/ListTurmasSalas.ajax.php?action=list"
                        data-pagination="true"
                        data-id-field="id"
                        data-buttons-class="primary">
                    <thead>
                    <tr>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" class="sala" data-field="sala" data-filter-control="input">Sala</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="turma" data-filter-control="input">Turma</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="professor" data-filter-control="input">Professor</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="situacao" data-filter-control="input">Situação</th>
                        <th data-filter-control-placeholder="⌕" data-sortable="true" data-field="data_criacao" data-filter-control="input">Data Criação</th> 
                    </tr>
                    </thead>
                </table>
              </div>
            </div>
                    <?php
                }
                ?>
            </div>
          </div>
        </div>
      </div>
        ID FUNCIONALIDADE: <?= RELATORIOS_TURMAS_SALAS ?>
    </div>