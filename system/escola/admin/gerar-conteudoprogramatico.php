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
$carga = filter_input(INPUT_GET, 'carga', FILTER_VALIDATE_INT);
$IdModalidade = filter_input(INPUT_GET, 'idmodalidade', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'estagio', FILTER_VALIDATE_INT);
$IdCarga = filter_input(INPUT_GET, 'carga_id', FILTER_VALIDATE_INT);
if($Id && $IdModalidade && $carga && $IdCarga) {

//MODALIDADE
$Read->ExeRead("sys_modalidades", "WHERE modalidade_id = :id", "id={$IdModalidade}");
if($Read->getResult()){
    $Modalidade = $Read->getResult()[0];
} else {
    die("Erro Estágio");
}

//ESTÁGIO
$Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_id = :id", "id={$Id}");
if($Read->getResult()){
    $Estagio = $Read->getResult()[0];
} else {
    die("Erro Estágio");
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
                        <h4 class="card-title">Cadastro de conteúdo programático de <?= $Estagio['estagio_produto_nome'] ?></h4>
                        <p class="card-category">Definição de conteúdo programático</p>
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
                            Modalidade <?= $Modalidade['modalidade_nome'] ?> - <span class="text_carga"><?= $carga ?></span> Aulas
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
                                                $Read->ExeRead("sys_materias_aula", "WHERE materias_aula_estagio_id = :id", "id={$Id}");
                                                if($Read->getResult()){
                                                    foreach ($Read->getResult() as $Materia) {
                                                        ?>
                                                        <span accesskey="<?= $Materia['materias_aula_id'] ?>" style="margin: 1px; white-space: pre; background: rgba(0, 0, 0, 0.5); color: #fff" ondragstart="drag(event)" class="j_drag_active" draggable="true" id="<?= $Materia['materias_aula_id'] ?>_materia"><?= $Materia['materias_aula_nome'] ?></span>
                                                        <?php
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
                                                $Read->ExeRead("sys_avaliacoes", "WHERE avaliacao_status = 0 AND estagio_id = :id", "id={$Estagio['estagio_produto_id']}");
                                                if($Read->getResult()){
                                                    foreach ($Read->getResult() as $Avaliacao) {
                                                        ?>
                                                        <span accesskey="<?= $Avaliacao['avaliacao_id'] ?>" style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff" ondragstart="drag(event)" class="j_drag_active" draggable="true" id="<?= $Avaliacao['avaliacao_id'] ?>_atividade"><?= $Avaliacao['avaliacao_nome'] ?></span>
                                                        <?php
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
                                                $Read->ExeRead("sys_escola_homework", "WHERE homework_status = 0 AND homework_estagio_id = :id", "id={$Estagio['estagio_produto_id']}");
                                                if($Read->getResult()){
                                                    foreach ($Read->getResult() as $Avaliacao) {
                                                        ?>
                                                        <span accesskey="<?= $Avaliacao['homework_id'] ?>" style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff" ondragstart="drag(event)" class="j_drag_active" draggable="true" id="<?= $Avaliacao['homework_id'] ?>_homework"><?= $Avaliacao['homework_nome'] ?></span>
                                                        <?php
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
                                                $Read->ExeRead("sys_escola_exercicios", "WHERE exercicio_status = 0 AND exercicio_estagio_id = :id", "id={$Estagio['estagio_produto_id']}");
                                                if($Read->getResult()){
                                                    foreach ($Read->getResult() as $Avaliacao) {
                                                        ?>
                                                        <span accesskey="<?= $Avaliacao['exercicio_id'] ?>" style="margin: 1px; background: rgba(0, 0, 0, 0.5); color: #fff" ondragstart="drag(event)" class="j_drag_active" draggable="true" id="<?= $Avaliacao['exercicio_id'] ?>_exercicios"><?= $Avaliacao['exercicio_nome'] ?></span>
                                                        <?php
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
                                        <input type="hidden" name="action" value="gerarConteudo">
                                        <input class="text_carga_input" type="hidden" name="quantidade" value="<?= $carga ?>">
                                        <input class="modalidade_id" type="hidden" name="modalidade_id" value="<?= $IdModalidade ?>">
                                        <input class="estagio_produto_id" type="hidden" name="estagio_produto_id" value="<?= $Id ?>">
                                        <input type="hidden" name="carga_id" value="<?= $IdCarga ?>">
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
                                            $tabela = "";
                                            for ($i = 1; $i <= $carga; $i++){
                                                $tabela .= "<tr><td>{$i}ª Aula</td><td class='itens_conteudo' accesskey='{$i}' ondrop='drop(event)' ondragover='allowDrop(event)'></td><td><select class='form-control' name='etapa_{$i}'><option value=''>Selecione um etapa</option>";
                                                for ($j = 1; $j <= 5; $j++) {
                                                    $tabela .= "<option value='{$j}'>Etapa {$j}</option>";
                                                }
                                                $tabela .= "</select></td></tr>";
                                            }
                                            echo $tabela;
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