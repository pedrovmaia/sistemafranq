<div class="content">
    <div class="container-fluid">
       <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-primary">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <span class="nav-tabs-title"><?= $texto['RELATORIOS'] ?></span>
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#profile" data-toggle="tab">
                                            <i class="material-icons">bug_report</i> <?= $texto['ADMNSS'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#comercial" data-toggle="tab">
                                            <i class="material-icons">code</i> <?= $texto['COMERCIAL'] ?>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#financeiro" data-toggle="tab">
                                            <i class="material-icons">cloud</i> <?= $texto['MenFN'] ?>
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

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos"><?= $texto['ACCPDA'] ?></td>

                                    </tr>

                                    <tr>
                                         <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_clientes"><?= $texto['ACCPDC'] ?></td>
                                        
                                    </tr>

                                    <tr>
                                     
                                     <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_controle_entrega"><?= $texto['ACCCEM'] ?></td>
                                        
                                        
                                    </tr>

                                    <tr>
                                     
                                       <td> <a href="#pablo"><?= $texto['ACCMDE'] ?></td>
                                        
                                    </tr>

                                    <tr>
                                     
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_ocorrencias"><?= $texto['ACCOCRR'] ?></td>
                                        
                                    </tr>

                                    <tr>
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_empresas"><?= $texto['ACCPQDE'] ?></td>

                                    </tr>

                                    <tr>
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_ex_alunos"><?= $texto['ACCPQDEX'] ?></td>

                                    </tr>

                                    <tr>
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_prospeccao"><?= $texto['ACCPQDP'] ?></td>

                                    </tr>

                                    <tr>
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_turmas"><?= $texto['ACCPDT'] ?></td>

                                    </tr>

                                    <tr>
                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_saldo_estoque"><?= $texto['ACCSEE'] ?></td>

                                    </tr>

                                     <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos_trancados"><?= $texto['ACCPDAT'] ?></td>

                                    </tr>

                                    <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos_cancelados"><?= $texto['ACCPDAC'] ?></td>

                                    </tr>

                                    <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_turma_salas">ACESSAR - Turmas por Salas</td>

                                    </tr>
                                    <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_turmas_professor">ACESSAR - Turmas por Professor</td>

                                    </tr>                                    
                                   
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="comercial">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                         <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_atendimentos"><?= $texto['ACCATDNT'] ?></td>

                                    </tr>

                                    <tr>
                                         <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_vendas_realizadas"><?= $texto['ACCVRLZ'] ?></td>
                                        
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="financeiro">
                                <table class="table">
                                    <tbody>

                                        <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_scpc"><?= $texto['ACCENSPC'] ?></td>

                                    </tr>

                                    <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_titulos_atraso"><?= $texto['ACCTITATS'] ?></td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="pedagogico">
                                <table class="table">
                                    <tbody>
                                         <tr>

                                        <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_feriado"><?= $texto['ACCFERI'] ?></td>

                                    </tr>

                                    <tr>
                                         <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_aulas_realizadas"><?= $texto['ACCTDAR'] ?></td>
                                        
                                    </tr>

                                    <tr>
                                     
                                     <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_controle_entrega"><?= $texto['ACCCEMAL'] ?></td>
                                        
                                        
                                    </tr>


                                      <tr>
                                     
                                     <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos_faltosos"><?= $texto['ACCALFL'] ?></td>
                                        
                                        
                                    </tr>


                                     <tr>
                                     
                                     <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_frequencia_geral"><?= $texto['ACCFGDA'] ?></td>
                                        
                                        
                                    </tr>

                                    <tr>
                                     
                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_matricula_mes"><?= $texto['ACCRDMPM'] ?></td>
                                        
                                    </tr>



                                    <tr>
                                     
                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_movimentacao_estoque"><?= $texto['ACCMDE'] ?></td>
                                        
                                    </tr>

                                      <tr>
                                     
                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_aniversariantes"><?= $texto['ACCANVER'] ?></td>
                                       </tr>
                                        <tr>
                                     
                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_alunos_matriculados"><?= $texto['ACCALNSMATR'] ?></td>
                                       </tr>

                                        <tr>
                                     
                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_horarios_professor"><?= $texto['ACCRDHPP'] ?></td>
                                       </tr>

                                       <td> <a href="<?= BASE ?>/painel.php?exe=relatorios/list_reposicao"><?= $texto['ACCREPCS'] ?></td>
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