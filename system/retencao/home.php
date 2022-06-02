<div class="content">
    <div class="container-fluid">

         

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <p class="card-category"><?= $texto['ALNSATRS'] ?></p>
                        <h3 class="card-title">12
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">trending_up</i>
                            <a href="#pablo"><?= $texto['ALNPARATR'] ?></a>
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
                        <p class="card-category"><?= $texto['ALNSFALTAS'] ?></p>
                        <h3 class="card-title">30</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">trending_up</i><?= $texto['ALNSDFALTS'] ?>
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
                        <p class="card-category"><?= $texto['ALERTEVS'] ?></p>
                        <h3 class="card-title">75</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">trending_up</i><?= $texto['ALNSALERTEV'] ?>
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
                        <p class="card-category"><?= $texto['REVERS'] ?></p>
                        <h3 class="card-title">145</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">trending_up</i><?= $texto['HISTREVERS'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 col-md-12">
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

                                        <td> <a href="<?= BASE ?>/painel.php?exe=retencao/list_parcela_atraso"><?= $texto['ACESSREVER'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"><?= $texto['ACESSALNSCRS'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"><?= $texto['ACESSREVERCANC'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="messages">
                                <table class="table">
                                    <tbody>
                                    
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="settings">
                                <table class="table">
                                    <tbody>
                                         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                 <div class="card">
                    <div class="card-header card-header-tabs card-header-primary">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <span class="nav-tabs-title"><?= $texto['FUNCES'] ?></span>
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#comercialf" data-toggle="tab">
                                            <i class="material-icons">bug_report</i> <?= $texto['COMERCIAL'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#financeirof" data-toggle="tab">
                                            <i class="material-icons">code</i> <?= $texto['MenFN'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#admf" data-toggle="tab">
                                            <i class="material-icons">cloud</i> <?= $texto['ADMNSS'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="comercialf">
                                <table class="table">
                                    <tbody>
                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=retencao/list_parcela_atraso"><?= $texto['ACESSCOMER'] ?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="financeirof">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=retencao/list_parcela_atraso"><?= $texto['ACESSFINAN'] ?></td>

                                    </tr>
                                    
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="admf">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=retencao/filtro_ocorrencia_retencao_aluno"><?= $texto['ACESSOCORRE'] ?></td>

                                    </tr>
                                         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>


    </div>
</div>