<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id){
    $Read = new Read;
    $Read->FullRead("SELECT projeto.projeto_id,
                projeto.projeto_descricao,
                projeto.projeto_codigo,
                projeto.projeto_data_inicio,
                projeto.projeto_data_termino,
                projeto.projeto_observacao,
                projeto.projeto_qtd_participantes,
                modalidades.modalidade_nome,
                sala.sala_nome,
                pessoas.pessoa_nome,
                situacao.situacao_projeto_nome,
                produto.produto_nome,
                tipo_projeto.tipo_projeto_nome,
                grade.projeto_grade_carga_dia,
                grade.projeto_grade_carga_hora_inicial,
                grade.projeto_grade_carga_hora_final
                FROM sys_projetos projeto
                LEFT OUTER JOIN sys_sala sala ON projeto.projeto_sala_id = sala.sala_id 
                LEFT OUTER JOIN sys_modalidades modalidades ON projeto.projeto_modalidade_id = modalidades.modalidade_id 
                LEFT OUTER JOIN sys_pessoas pessoas ON projeto.projeto_gerente_id = pessoas.pessoa_id 
                LEFT OUTER JOIN sys_situacao_projeto situacao ON projeto.projeto_situacao_id = situacao.situacao_projeto_id
                LEFT OUTER JOIN sys_produto produto ON produto.produto_id = projeto.projeto_produto_id 
                LEFT OUTER JOIN sys_tipo_projeto tipo_projeto ON tipo_projeto.tipo_projeto_id = projeto.projeto_tipo_id
								LEFT OUTER JOIN sys_projeto_grade grade ON grade.projeto_grade_projeto_id = projeto.projeto_id
WHERE projeto.projeto_id = :id", "id={$Id}");
    if($Read->getResult()){
        $Turma = $Read->getResult();
        $TurmaQTD = $Read->getRowCount();
    } else {
        die("<br><br><center>ERRO!!!</center><br><br>");
    }
} else {
    die("<br><br><center>ERRO!!!</center><br><br>");
}
?>
<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        border-color: #000;
    }
</style>
<div class="content" style="background: white">
    <div class="container-fluid">
        <div class="row" id="HTMLtoPDF">
            <div class="col-md-12">
                <div class="card-header-primary">
                    <h4 class="card-title"><?= $texto['DRACLAS'] ?></h4>
                </div>
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['TRMP'] ?></strong><?= $Turma[0]['projeto_descricao'] ?></p>
                <p><strong><?= $texto['CRSOP'] ?></strong><?= $Turma[0]['produto_nome'] ?></p>
                <p><strong><?= $texto['INIP'] ?></strong><?= date('d/m/Y', strtotime($Turma[0]['projeto_data_inicio'])) ?></p>
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['Profp'] ?> </strong><?= $Turma[0]['pessoa_nome'] ?></p>
                <p><strong><?= $texto['ESTP'] ?></strong><?= $Turma[0]['produto_nome'] ?></p>
                <p><strong><?= $texto['TERMP'] ?></strong><?= date('d/m/Y', strtotime($Turma[0]['projeto_data_termino'])) ?></p>
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['SALP'] ?></strong><?= $Turma[0]['sala_nome'] ?></p>
                <p><strong><?= $texto['MODAP'] ?></strong><?= $Turma[0]['modalidade_nome'] ?></p>
                <p><strong><?= $texto['HRRP'] ?></strong><?= substr(getDiaSemana($Turma[0]['projeto_grade_carga_dia']), 0, 3) ?>: <?= date('H:i', strtotime($Turma[0]['projeto_grade_carga_hora_inicial'])) ?> às <?= date('H:i', strtotime($Turma[0]['projeto_grade_carga_hora_final'])) ?> <?php if ($TurmaQTD > 1) { echo " - " . substr(getDiaSemana($Turma[1]['projeto_grade_carga_dia']), 0, 3) . " : " . date('H:i', strtotime($Turma[1]['projeto_grade_carga_hora_inicial'])) . " às " . date('H:i', strtotime($Turma[1]['projeto_grade_carga_hora_final'])); } ?></p>
            </div>
            <div class="col-md-12">
                <p><strong><?= $texto['IMPRP'] ?></strong><?= date('d/m/Y') ?></p>
            </div>
            <div class="col-md-12">
                <div>
                    <table style="border-top: 1px solid;" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; background: lightgrey" rowspan="2">
                                    <div class="th-inner sortable both">At.</div>
                                </th>
                                <th style="text-align: center; background: lightgrey" colspan="2">
                                    <div class="th-inner"><?= $texto['PREVS'] ?></div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="text-align: center; background: lightgrey" colspan="2">
                                    <div class="th-inner "><?= $texto['REALZ'] ?></div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="text-align: center; vertical-align: middle; background: lightgrey" rowspan="2">
                                    <div class="th-inner sortable both"><?= $texto['VST'] ?></div>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['DTAi'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['CONTED'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner "><?= $texto['DTAi'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['CONTED'] ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $Read->FullRead("SELECT * FROM sys_planejamento AS p
LEFT OUTER JOIN sys_acompanhamento_aula_atividades AS aaa ON p.planejamento_id = aaa.acompanhamento_ativ_planejamento_id
WHERE p.planejamento_projeto_id = :id ORDER BY p.planejamento_data", "id={$Id}");
                                if($Read->getResult()) {
                                    $i = 1;
                                    foreach ($Read->getResult() as $Diario) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;"><?= $i ?></td>
                                            <td style="text-align: left;"><?= date("d/m/Y", strtotime($Diario['planejamento_data'])) ?></td>
                                            <?php
                                            if($Diario['planejamento_status'] == 1){
                                                ?>
                                                <td style="text-align: left;"><?= $Diario['planejamento_descricao'] ?></td>
                                                <td style="text-align: left;"></td>
                                                <td style="text-align: left;"></td>
                                                <?php
                                            } else{

                                                if(!empty($Diario['materias'])) {
                                                    $arrMaterias = explode(",", $Diario['materias']);
                                                    $materias_aula = "";
                                                    for ($j = 0; $j < count($arrMaterias); $j++) {

                                                        $Read->ExeRead("sys_materias_aula",
                                                            "WHERE materias_aula_id = :id", "id={$arrMaterias[$j]}");
                                                        if ($Read->getResult()) {
                                                            $materias_aula .= $Read->getResult()[0]["materias_aula_nome"];
                                                            if ($j + 1 != count($arrMaterias)) {
                                                                $materias_aula .= ", ";
                                                            }
                                                        }

                                                    }
                                                }

                                                $arrAtividades = explode(",", $Diario['atividades']);
                                                $atividade_aula = "";
                                                for ($j = 0; $j < count($arrAtividades); $j++) {

                                                    $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_id = :id",
                                                        "id={$arrAtividades[$j]}");
                                                    if ($Read->getResult()) {
                                                        $atividade_aula .= $Read->getResult()[0]["avaliacao_nome"];
                                                        if ($j + 1 != count($arrAtividades)) {
                                                            $atividade_aula .= ", ";
                                                        }
                                                    }

                                                }

                                                if(isset($Diario['acompanhamento_ativ_atividade_realizada'])){
                                                    $conteudo = "{$Diario['acompanhamento_ativ_atividade_realizada']}, {$Diario['acompanhamento_ativ_avaliacao_realizada']}:";
                                                } else {
                                                    $conteudo = "";
                                                }

                                                ?>
                                                <td style="text-align: left;"><?= $materias_aula ?>, <?= $atividade_aula ?>:</td>
                                                <td style="text-align: left;"><?= date("d/m/Y", strtotime($Diario['planejamento_data'])) ?></td>
                                                <td style="text-align: left;"><?= $conteudo ?></td>
                                                <?php
                                            }
                                            ?>
                                            <td style="text-align: center;"></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button class="btn btn-primary imprimir_diario_classe"><?= $texto['IMPRS'] ?></button>
    </div>
</div>