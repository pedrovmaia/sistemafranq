<?php
if (empty($Read)):
    $Read = new Read;
endif;
?>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet">
<script>

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();

        if(ev.target.localName == "td"){

            var data = ev.dataTransfer.getData("text");
            var tipo = data.split("_");
            ev.target.appendChild(document.getElementById(data));

            document.getElementById(data).style.margin = "0px 0px 0px 0px";

            if(tipo[1] == "materia"){
                document.getElementById(data).style.backgroundColor = "red";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "atividade"){
                document.getElementById(data).style.backgroundColor = "orange";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "homework"){
                document.getElementById(data).style.backgroundColor = "blue";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "exercicios"){
                document.getElementById(data).style.backgroundColor = "green";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }
        } else {

            var data = ev.dataTransfer.getData("text");
            var tipo = data.split("_");
            ev.target.after(document.getElementById(data));

            document.getElementById(data).style.margin = "0px 0px 0px 0px";

            if(tipo[1] == "materia"){
                document.getElementById(data).style.backgroundColor = "red";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "atividade"){
                document.getElementById(data).style.backgroundColor = "orange";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "homework"){
                document.getElementById(data).style.backgroundColor = "blue";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }

            if(tipo[1] == "exercicios"){
                document.getElementById(data).style.backgroundColor = "green";
                document.getElementById(data).style.color = "white";
                document.getElementById(data).style.margin = "0px 3px 0px 0px";
            }
        }
    }
</script>
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
    .sticky {
        position: fixed;
        top: 0;
    }
</style>
<?php
$Id = filter_input(INPUT_GET, 'idmodalidade', FILTER_VALIDATE_INT);
$Idestagio = filter_input(INPUT_GET, 'estagio', FILTER_VALIDATE_INT);
$Idcarga = filter_input(INPUT_GET, 'carga_id', FILTER_VALIDATE_INT);
if($Id && $Idestagio && $Idcarga){

$Read->FullRead("SELECT cp.*, m.modalidade_nome, ep.estagio_produto_nome FROM sys_conteudo_programatico AS cp 
INNER JOIN sys_modalidades AS m ON cp.modalidade_id = m.modalidade_id
INNER JOIN sys_estagio_produto AS ep ON cp.estagio_id = ep.estagio_produto_id
WHERE cp.modalidade_id = :m AND cp.estagio_id = :id AND cp.carga = :c", "m={$Id}&id={$Idestagio}&c={$Idcarga}");
if($Read->getResult()){
    $Estagio = $Read->getResult()[0];
    $Modalidade = $Read->getResult()[0]['modalidade_nome'];
    $Aulas = $Read->getRowCount();
    $Conteudos = $Read->getResult();
} else {
    die("Erro Conteúdo");
}
?>
<div class="content">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-md-1">
                        <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                    </div>
                    <div class="col-md-10 text-center">
                        <h4 class="card-title">Editar conteúdo programático de <?= $Estagio["estagio_produto_nome"] ?></h4>
                        <p class="card-category">Edição de conteúdo programático</p>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".ESCOLA_ETAPA_AVALIACAO."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                if($Read->getResult()){
                    $permissao = $Read->getResult()[0];
                    $_SESSION['permissao'] = $permissao;
                } else {
                    echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                    die;
                }
                if($permissao["ler"] == 1){
                    ?>
                    <div class="border_shadow" style="padding: 20px">

                        <div class="col-md-12 div_aulas_qtd">
                            Modalidade <?= $Modalidade ?> - <span class="text_carga"><?= $Aulas ?></span> Aulas
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="myHeader">

                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 style="cursor: pointer" class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <span class="card-title"><strong>Matérias</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php
                                                $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_estagio_id = :id", "id={$Idestagio}");
                                                if($Read->getResult()){
                                                    $materiasArr = [];
                                                    foreach ($Conteudos as $Conteudo){
                                                        $materias = explode(", ", $Conteudo['materias']);
                                                        for($i = 0; $i < count($materias); $i++){
                                                            $materiasArr[] = $materias[$i];
                                                        }
                                                    }

                                                    foreach ($Read->getResult() as $Materia) {
                                                        if(!in_array($Materia['materias_aula_id'], $materiasArr)){
                                                            ?>
                                                            <span accesskey="<?= $Materia['materias_aula_id'] ?>" style="margin: 1px; white-space: pre; background: rgba(0, 0, 0, 0.5); color: #fff" ondragstart="drag(event)" class="j_drag_active" draggable="true" id="<?= $Materia['materias_aula_id'] ?>_materia"><?= $Materia['materias_aula_nome'] ?></span>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 style="cursor: pointer" class="mb-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                <span class="card-title"><strong>Avaliações</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php
                                                $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_status = 0 AND estagio_id = :id", "id={$Idestagio}");
                                                if($Read->getResult()){
                                                    $avaliacoesArr = [];
                                                    foreach ($Conteudos as $Conteudo){
                                                        $avaliacoes = explode(", ", $Conteudo['atividades']);
                                                        for($i = 0; $i < count($avaliacoes); $i++){
                                                            $avaliacoesArr[] = $avaliacoes[$i];
                                                        }
                                                    }
                                                    foreach ($Read->getResult() as $Avaliacao) {
                                                        if(!in_array($Avaliacao['avaliacao_id'], $avaliacoesArr)) {
                                                            ?>
                                                            <span accesskey="<?= $Avaliacao['avaliacao_id'] ?>"
                                                                  style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff"
                                                                  ondragstart="drag(event)" class="j_drag_active"
                                                                  draggable="true"
                                                                  id="<?= $Avaliacao['avaliacao_id'] ?>_atividade"><?= $Avaliacao['avaliacao_nome'] ?></span>
                                                            <?php
                                                        }
                                                    }
                                                } else{
                                                    echo "<p>Não existem avaliações disponíveis para esse estágio</p>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingThre">
                                            <h5 style="cursor: pointer" class="mb-0" data-toggle="collapse" data-target="#collapseThre" aria-expanded="true" aria-controls="collapseThre">
                                                <span class="card-title"><strong>Home Work</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseThre" class="collapse" aria-labelledby="headingThre" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php
                                                $Read->ExeRead("sys_escola_homework", "WHERE homework_status = 0 AND homework_estagio_id = :id", "id={$Idestagio}");
                                                if($Read->getResult()){
                                                    $homeworkArr = [];
                                                    foreach ($Conteudos as $Conteudo){
                                                        $homework = explode(", ", $Conteudo['homework']);
                                                        for($i = 0; $i < count($homework); $i++){
                                                            $homeworkArr[] = $homework[$i];
                                                        }
                                                    }
                                                    foreach ($Read->getResult() as $Avaliacao) {

                                                        if(!in_array($Avaliacao['homework_id'], $homeworkArr)) {
                                                            ?>
                                                            <span accesskey="<?= $Avaliacao['homework_id'] ?>"
                                                                  style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff"
                                                                  ondragstart="drag(event)" class="j_drag_active"
                                                                  draggable="true"
                                                                  id="<?= $Avaliacao['homework_id'] ?>_homework"><?= $Avaliacao['homework_nome'] ?></span>
                                                            <?php
                                                        }
                                                    }
                                                } else{
                                                    echo "<p>Não existem homeworks disponíveis para esse estágio</p>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingFour">
                                            <h5 style="cursor: pointer" class="mb-0" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                <span class="card-title"><strong>Exercícios</strong></span>
                                                <i class="material-icons" style="float: right">expand_more</i>
                                            </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php
                                                $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_status = 0 AND exercicio_estagio_id = :id", "id={$Idestagio}");
                                                if($Read->getResult()){
                                                    $exerciciosArr = [];
                                                    foreach ($Conteudos as $Conteudo){
                                                        $exercicios = explode(", ", $Conteudo['exercicios']);
                                                        for($i = 0; $i < count($exercicios); $i++){
                                                            $exerciciosArr[] = $exercicios[$i];
                                                        }
                                                    }
                                                    foreach ($Read->getResult() as $Avaliacao) {
                                                        if(!in_array($Avaliacao['exercicio_id'], $exerciciosArr)) {
                                                            ?>
                                                            <span accesskey="<?= $Avaliacao['exercicio_id'] ?>"
                                                                  style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff"
                                                                  ondragstart="drag(event)" class="j_drag_active"
                                                                  draggable="true"
                                                                  id="<?= $Avaliacao['exercicio_id'] ?>_exercicios"><?= $Avaliacao['exercicio_nome'] ?></span>
                                                            <?php
                                                        }
                                                    }
                                                } else{
                                                    echo "<p>Não existem exercícios disponíveis para esse estágio</p>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1 mt-2"><b>Conteúdo Programático</b></p>
                                <div class="card mt-0" style="overflow-y: scroll; max-height: 650px">
                                    <form class="form_conteudo_programatico">
                                        <input type="hidden" name="action" value="updategerarConteudo">
                                        <input class="text_carga_input" type="hidden" name="quantidade" value="<?= $Aulas ?>">
                                        <input class="modalidade_id" type="hidden" name="modalidade_id" value="<?= $Id ?>">
                                        <input type="hidden" name="estagio_produto_id" value="<?= $Idestagio ?>">
                                        <table class="table table-bordered table_qtd_carga_horaria mb-0">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Aulas
                                                </th>
                                                <th>
                                                    Atividades
                                                </th>
                                                <th>
                                                    Etapa
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($Conteudos as $Conteudo) {
                                                $materias = explode(", ", $Conteudo['materias']);
                                                $avaliacoes = explode(", ", $Conteudo['atividades']);
                                                $homework = explode(", ", $Conteudo['homework']);
                                                $exercicios = explode(", ", $Conteudo['exercicios']);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="programatico_id_<?= $Conteudo['aula'] ?>" value="<?= $Conteudo['projeto_programatico_id'] ?>">
                                                        <?= $Conteudo['aula'] ?>ª Aula
                                                    </td>
                                                    <td class="itens_conteudo j_editar_conteudo" accesskey="<?= $Conteudo['aula'] ?>" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                        <?php
                                                        for($i = 0; $i < count($materias); $i++){
                                                            $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_id = :id", "id={$materias[$i]}");
                                                            if($Read->getResult()){
                                                                foreach ($Read->getResult() as $Materia) {
                                                                    ?>
                                                                    <span accesskey="<?= $Materia['materias_aula_id'] ?>" style="margin: 0px 3px 0px 0px; white-space: pre; background: red; color: white;" ondragstart="drag(event)" id="<?= $Materia['materias_aula_id'] ?>_materia" draggable="true"><?= $Materia['materias_aula_nome'] ?></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        for($i = 0; $i < count($avaliacoes); $i++){
                                                            $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_id = :id", "id={$avaliacoes[$i]}");
                                                            if($Read->getResult()){
                                                                foreach ($Read->getResult() as $Avaliacao) {
                                                                    ?>
                                                                    <span accesskey="<?= $Avaliacao['avaliacao_id'] ?>" style="margin: 0px 3px 0px 0px; background: orange; color: white;" ondragstart="drag(event)" id="<?= $Avaliacao['avaliacao_id'] ?>_atividade" draggable="true"><?= $Avaliacao['avaliacao_nome'] ?></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        for($i = 0; $i < count($homework); $i++){
                                                            $Read->ExeRead("sys_escola_homework", "WHERE homework_id = :id", "id={$homework[$i]}");
                                                            if($Read->getResult()){
                                                                foreach ($Read->getResult() as $Avaliacao) {
                                                                    ?>
                                                                    <span accesskey="<?= $Avaliacao['homework_id'] ?>" style="margin: 0px 3px 0px 0px; background: blue; color: white;" ondragstart="drag(event)" id="<?= $Avaliacao['homework_id'] ?>_homework" draggable="true"><?= $Avaliacao['homework_nome'] ?></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        for($i = 0; $i < count($exercicios); $i++){
                                                            $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_id = :id", "id={$exercicios[$i]}");
                                                            if($Read->getResult()){
                                                                foreach ($Read->getResult() as $Avaliacao) {
                                                                    ?>
                                                                    <span accesskey="<?= $Avaliacao['exercicio_id'] ?>" style="margin: 0px 3px 0px 0px; background: green; color: white;" ondragstart="drag(event)" id="<?= $Avaliacao['exercicio_id'] ?>_exercicios" draggable="true"><?= $Avaliacao['exercicio_nome'] ?></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="etapa_<?= $Conteudo['aula'] ?>" required>
                                                            <option value="">Selecione um etapa</option>
                                                            <option <?= ($Conteudo['etapa'] == 1 ? "selected='selected'" : '') ?> value="1">Etapa 1</option>
                                                            <option <?= ($Conteudo['etapa'] == 2 ? "selected='selected'" : '') ?> value="2">Etapa 2</option>
                                                            <option <?= ($Conteudo['etapa'] == 3 ? "selected='selected'" : '') ?> value="3">Etapa 3</option>
                                                            <option <?= ($Conteudo['etapa'] == 4 ? "selected='selected'" : '') ?> value="4">Etapa 4</option>
                                                            <option <?= ($Conteudo['etapa'] == 5 ? "selected='selected'" : '') ?> value="5">Etapa 5</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
                                        <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        ID FUNCIONALIDADE: <?= ESCOLA_ETAPA_AVALIACAO ?>
    </div>
    <?php
    } else {
        die("Erro");
    }
    ?>