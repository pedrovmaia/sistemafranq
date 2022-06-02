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
        
        overflow-y:visible;
        padding-bottom:1px;
    }
    .acoes{
        width: 100px;
        text-align: center;
    }
      .aluno{
              min-width: 280px;
          }
          .professor{
              min-width: 280px;
          }
          .turma{
            min-width: 360px;
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
$Read->FullRead("SELECT count(pessoa.pessoa_id) as alunos
            FROM sys_pessoas pessoa
            WHERE pessoa.pessoa_tipo_id = 4 
            AND pessoa.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $qtd_alunos = $Read->getResult()[0]['alunos'];
} else {
$qtd_alunos = 0;
}

                    ?>

                    <?php
          $Read->FullRead("SELECT count(p.projeto_id) as turmas
           FROM sys_projetos AS p 
           WHERE projeto_status = 0
            AND p.unidade_id = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $qtd_turmas = $Read->getResult()[0]['turmas'];
} else {
$qtd_alunos = 0;
}

                    ?>

                    <?php
          $Read->FullRead("SELECT count(matriculas.matricula_id) as matriculas from sys_matriculas matriculas
     WHERE matriculas.unidade_id  = :unidade", "unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

        if($Read->getResult()){
            $qtd_matriculas = $Read->getResult()[0]['matriculas'];
} else {
$qtd_alunos = 0;
}

                    ?>

                     <?php
          $Read->FullRead("SELECT count(ocorrencias.ocorrencia_id) as ocorrencias from sys_ocorrencia ocorrencias
     WHERE ocorrencias.ocorrencia_atendente_id  = :pessoa", "pessoa={$_SESSION['userSYSFranquia']['pessoa_id']}");

        if($Read->getResult()){
            $qtd_ocorrencias = $Read->getResult()[0]['ocorrencias'];
} else {
$qtd_ocorrencias = 0;
}
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">supervisor_account</i>
                        </div>
                        <p class="card-category"><?= $texto['Turm'] ?></p>
                        <h3 class="card-title"><?php echo $qtd_turmas ?></h3>
                    </div>
                    <div class="card-footer">
                    <div class="stats">
                    <i class="material-icons">trending_up</i>
                    <a href="#pablo"><?= $texto['TurmMat'] ?></a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">insert_drive_file</i>
                        </div>
                        <p class="card-category"><?= $texto['Mat'] ?></p>
                        <h3 class="card-title"><?php echo $qtd_matriculas ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">trending_up</i> <?= $texto['UltM'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">info_outline</i>
                        </div>
                        <p class="card-category"><?= $texto['Pend'] ?></p>
                        <h3 class="card-title"><?php echo $qtd_ocorrencias ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">trending_up</i> <?= $texto['AlertPend'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">perm_identity</i>
                        </div>
                        <p class="card-category"><?php echo $texto['alunos'];?></p>
                        <h3 class="card-title"><?php echo $qtd_alunos ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">trending_up</i> <?= $texto['MatAt'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!-- <div class="row">
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-primary">
                      <div class="ct-chart" id="dailySalesChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $texto['FdD'] ?></h4>
                        <p class="card-category">
                        <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> <?= $texto['Aumt'] ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">access_time</i> <?= $texto['Times'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-primary">
                      <div class="ct-chart" id="dailySalesChartTurmas"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $texto['FxD'] ?></h4>
                        <p class="card-category"><?= $texto['PrevFxD'] ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">access_time</i> <?= $texto['Times'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-primary">
                      <div class="ct-chart" id="completedTasksChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $texto['CeD'] ?></h4>
                        <p class="card-category"><?= $texto['Viz'] ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">access_time</i> <?= $texto['Times'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><?= $texto['OCRR'] ?></h4>
                        <p class="card-category"><?= $texto['ListOCRR'] ?></p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-forum"
                                id="table_turma_dash"
                                data-locale="pt-BR"
                                data-show-export="false"
                                data-filter-control="false"
                                data-filter-show-clear="false"
                                data-show-toggle="false"
                                data-show-columns="false"
                                data-minimum-count-columns="2"
                                data-url="_ajax/dashboard/ListOcorrencias.ajax.php?action=list"
                                data-id-field="id"
                                data-pagination="true"
                                data-page-size="50"
                                data-buttons-class="primary">
                            <thead>
                                <tr>
                                    <th data-field="id" data-filter-control="input">ID</th>
                                    <th data-field="data" data-filter-control="input"><?= $texto['DTAi'] ?></th>
                                    <th data-field="natureza" data-filter-control="input"><?= $texto['Nat'] ?></th>
                                    <th data-field="descricao" data-filter-control="input"><?= $texto['dsc'] ?></th>
                                    <th data-field="status" data-filter-control="input">Status</th>
                                    <th class="acoes" data-field="acoes"><span> <?= $texto['Act'] ?></span></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>