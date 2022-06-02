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
<style>
    thead tr {
        background: #e7e7e7;
    }
    thead tr th, tbody tr td {
        border: 1px solid;
    }
    .back_white{
        background: white;
    }
</style>
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
                                <h4 class="card-title">VER AVALIAÇÕES DA TURMA</h4>
                                <p class="card-category">Exibição de Avaliações da Turma</p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
            <?php
            $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($Id):
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_CURSO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                $permissao = $Read->getResult()[0];
                if($permissao["ler"] != 1){
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }

                $Read->FullRead("SELECT curso.envolvidos_projeto_projeto_id, aluno.pessoa_id, aluno.pessoa_nome AS aluno_nome, professor.pessoa_nome AS professor_nome, livro.produto_nome AS livro_nome FROM sys_envolvidos_projeto AS curso 
                LEFT OUTER JOIN sys_pessoas AS aluno ON aluno.pessoa_id = curso.envolvidos_envolvido_id 
                LEFT OUTER JOIN sys_projetos AS projeto ON projeto.projeto_id = curso.envolvidos_projeto_projeto_id
                LEFT OUTER JOIN sys_pessoas AS professor ON professor.pessoa_id = projeto.projeto_gerente_id
                LEFT OUTER JOIN sys_materiais_estagio_produto AS livro_busca ON livro_busca.estagio_id = projeto.projeto_produto_id
                LEFT OUTER JOIN sys_produto AS livro ON livro.produto_id = livro_busca.produto_id
                WHERE curso.envolvidos_projeto_projeto_id = :id", "id={$Id}");
                if(!$Read->getResult()){
                    echo "<div class='trigger trigger_error ajax_close'>Opps, Não foram encontrados resultados!</div>";
                } else {
                    foreach ($Read->getResult() as $InfoCabecalho) {


                        $Read->FullRead("SELECT SUM(nota) / COUNT(acompanhamento_id) AS media, etapa FROM sys_acompanhamento_aula_homework AS a WHERE a.projeto_id = :id AND pessoa_id = :p GROUP BY etapa", "id={$Id}&p={$InfoCabecalho['pessoa_id']}");
                        $Total_HomeWork = $Read->getResult()[0];

                        $Read->FullRead("SELECT SUM(a.nota) / COUNT(a.acompanhamento_id) AS media, a.etapa FROM sys_acompanhamento_aula_exercicios AS a 
                            LEFT OUTER JOIN sys_escola_exercicios AS e ON e.exercicio_id = a.exercicio_id
                            WHERE a.projeto_id = :id AND pessoa_id = :p AND e.exercicio_tipo = 1 GROUP BY etapa", "id={$Id}&p={$InfoCabecalho['pessoa_id']}");
                        $Total_Listening = $Read->getResult()[0];

                        $Read->FullRead("SELECT SUM(a.nota) / COUNT(a.acompanhamento_id) AS media, a.etapa FROM sys_acompanhamento_aula_exercicios AS a 
                            LEFT OUTER JOIN sys_escola_exercicios AS e ON e.exercicio_id = a.exercicio_id
                            WHERE a.projeto_id = :id AND pessoa_id = :p AND e.exercicio_tipo = 0 GROUP BY etapa", "id={$Id}&p={$InfoCabecalho['pessoa_id']}");
                        $Total_Speaking = $Read->getResult()[0];


                        $Read->FullRead("SELECT (((sum(acompanhamento.presenca)) /  count(aulas.planejamento_id)) * 100) as porcentagem_presenca, 
                        aulas.etapa
                        FROM sys_envolvidos_projeto alunos_turma LEFT OUTER JOIN sys_pessoas aluno ON aluno.pessoa_id = alunos_turma.envolvidos_envolvido_id
                        LEFT OUTER JOIN sys_projetos turma ON turma.projeto_id = alunos_turma.envolvidos_projeto_projeto_id
                        LEFT OUTER JOIN sys_estagio_produto estagio ON estagio.estagio_produto_id = turma.projeto_produto_id
                        LEFT OUTER JOIN sys_pessoas professor ON professor.pessoa_id = turma.projeto_gerente_id
                        LEFT OUTER JOIN sys_planejamento aulas ON aulas.planejamento_projeto_id = turma.projeto_id
                        LEFT OUTER JOIN sys_acompanhamento_aula acompanhamento ON acompanhamento.planejamento_id = aulas.planejamento_id
                        WHERE turma.projeto_status = 0 AND aulas.planejamento_status = 2
                        AND acompanhamento.pessoa_id = :p
                        AND acompanhamento.projeto_id = :id", "p={$InfoCabecalho['pessoa_id']}&id={$Id}");
                        $Total_Presenca = $Read->getResult()[0];

                        ?>
                        <div class="row" style="border-bottom: 2px dashed;">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="profile">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6" style="border-right: 1px solid #000">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <img width="150px" class="img-fluid"
                                                                         src="<?= BASE ?>/assets/img/logo_1.png"/>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="mt-4"
                                                                       style="color: #191919; font-size: 1.8em; margin-bottom: 1px">
                                                                        <b>REPORT CARD</b></p>
                                                                    <p style="font-size: 1.5em">BOOK</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p style="font-size: 1.2em; margin-bottom: 2px">
                                                                        <b>Student:</b> <?= $InfoCabecalho['aluno_nome'] ?>
                                                                    </p>
                                                                    <p style="font-size: 1.2em; margin-bottom: 2px">
                                                                        <b>Teacher:</b> <?= $InfoCabecalho['professor_nome'] ?>
                                                                    </p>
                                                                    <p style="font-size: 1.2em; margin-bottom: 2px">
                                                                        <b>Book:</b> <?= $InfoCabecalho['livro_nome'] ?>
                                                                    </p>
                                                                    <p style="font-size: 1.2em; margin-bottom: 2px">
                                                                        <b>Date:</b> <?= date('d-m-Y H:i') ?>
                                                                    </p>
                                                                    <p style="font-size: 1.2em; margin-bottom: 2px">
                                                                        <b>Group:</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                <th>Term</th>
                                                                <th>Preparation</th>
                                                                <th>Speaking</th>
                                                                <th>Listening</th>
                                                                <th>Homework</th>
                                                                <th>C.R.</th>
                                                                <th>Average</th>
                                                                <th>Absence</th>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                for($i = 1; $i < 6; $i++){
                                                                    $media = 0;
                                                                    echo "<tr><td><b>{$i}</b></td>";
                                                                    echo "<td class='back_white'>0.0</td>";
                                                                    if($Total_HomeWork['etapa'] == $i) {
                                                                        $media += $Total_Speaking['media'];
                                                                        echo "<td class='back_white'>" . number_format($Total_Speaking['media'], 1) . "</td>";
                                                                    } else {
                                                                        echo "<td class='back_white'>0.0</td>";
                                                                    }
                                                                    if($Total_HomeWork['etapa'] == $i) {
                                                                        $media += $Total_Listening['media'];
                                                                        echo "<td class='back_white'>" . number_format($Total_Listening['media'], 1) . "</td>";
                                                                    } else {
                                                                        echo "<td class='back_white'>0.0</td>";
                                                                    }
                                                                    if($Total_HomeWork['etapa'] == $i) {
                                                                        $media += $Total_HomeWork['media'];
                                                                        echo "<td class='back_white'>" . number_format($Total_HomeWork['media'], 1) . "</td>";
                                                                    } else {
                                                                        echo "<td class='back_white'>0.0</td>";
                                                                    }
                                                                    echo "<td class='back_white'>0.0</td>";
                                                                    if($Total_Presenca['etapa'] == $i) {
                                                                        echo "<td class='back_white'>" . number_format($media/5, 1) . "</td>";
                                                                        echo "<td class='back_white'>" . number_format($Total_Presenca['porcentagem_presenca'], 0) . "%</td>";
                                                                    } else {
                                                                        echo "<td class='back_white'>0.0</td>";
                                                                        echo "<td class='back_white'>0%</td>";
                                                                    }
                                                                }
                                                                ?>
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
                            </div>
                        </div>
                        <?php
                    }
                }
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= ESCOLA_TURMA ?>
    </div>
</div>