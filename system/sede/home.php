<?php
$Read->FullRead("SELECT count(pessoa.pessoa_id) as alunos
            FROM sys_pessoas pessoa
            WHERE pessoa.pessoa_tipo_id = 4 
            ");

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
           ");

        if($Read->getResult()){
            $qtd_turmas = $Read->getResult()[0]['turmas'];
} else {
$qtd_alunos = 0;
}

                    ?>

                    <?php
          $Read->FullRead("SELECT count(matriculas.matricula_id) as matriculas from sys_matriculas matriculas
     ");

        if($Read->getResult()){
            $qtd_matriculas = $Read->getResult()[0]['matriculas'];
} else {
$qtd_alunos = 0;
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
                            <a href="#pablo"><?= $texto['AllMTMTH'] ?></a>
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
                            <i class="material-icons">trending_up</i> <?= $texto['EFEM'] ?>
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
                        <h3 class="card-title">75</h3>
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
                        <p class="card-category"><?= $texto['alunos'] ?></p>
                        <h3 class="card-title"><?php echo $qtd_alunos ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">trending_up</i> <?= $texto['ALNATV'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-primary">
                        <div class="ct-chart" id="dailySalesChartd"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $texto['PANMAT'] ?></h4>
                        <p class="card-category">
                            <?= $texto['PANGERAL'] ?></p>
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
                        <div class="ct-chart" id="websiteViewsChart"></div>
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
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-primary">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <span class="nav-tabs-title"><?= $texto['RELATORIOS'] ?></span>
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#profile" data-toggle="tab">
                                            <i class="material-icons">bug_report</i> <?= $texto['COMERCIAL'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#messages" data-toggle="tab">
                                            <i class="material-icons">code</i> <?= $texto['MenFN'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#settings" data-toggle="tab">
                                            <i class="material-icons">cloud</i> <?= $texto['ADMNSS'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#pedagogico" data-toggle="tab">
                                            <i class="material-icons">cloud</i> <?= $texto['MenP'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="profile">
                                <table class="table">
                                    <tbody>
                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"> <?= $texto['ACCRANK'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos">  <?= $texto['ACCREL'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_pedido_sede"> <?= $texto['ACCPED'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="messages">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_negociacao_sede"> <?= $texto['ACCRELREN'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"> <?= $texto['ACCRELINSC'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"> <?= $texto['ACCEFIC'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="settings">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_franquia_sede"> <?= $texto['ACCRELFRANQ'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_curso_sede"> <?= $texto['ACCLISTCR'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_materiais_didaticos_sede"> <?= $texto['ACCRELMATD'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="pedagogico">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_turma_sede"> <?= $texto['ACCTURMAS'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_alunos_sede"> <?= $texto['ACCALUNOS'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=sede/list_matricula_sede"> <?= $texto['ACCTODASMAT'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><?= $texto['PEDLIV'] ?></h4>
                        <p class="card-category"><?= $texto['ULTPEDLIV'] ?></p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <th>ID</th>
                            <th><?= $texto['FRANNQ'] ?></th>
                            <th><?= $texto['QNTi'] ?></th>
                            <th><?= $texto['Price'] ?></th>
                            
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Dakota Rice</td>
                                <td>$36,738</td>
                                <td>Niger</td>

                            
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Minerva Hooper</td>
                                <td>$23,789</td>
                                <td>Curaçao</td>


                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Sage Rodriguez</td>
                                <td>$56,142</td>
                                <td>Netherlands</td>

                                

                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Philip Chaney</td>
                                <td>$38,735</td>
                                <td>Korea, South</td>

                                

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>