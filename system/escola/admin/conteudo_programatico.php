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
$IdCurso = filter_input(INPUT_GET, 'idcurso', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if($Id && $IdCurso){

    //CURSO
    $Read->ExeRead("sys_produto", "WHERE produto_id = :id", "id={$IdCurso}");
    if($Read->getResult()){
        $Curso = $Read->getResult()[0];
    } else {
        die("Erro Curso");
    }

    //ESTÁGIO
    $Read->ExeRead("sys_estagio_produto", "WHERE estagio_produto_id = :id", "id={$Id}");
    if($Read->getResult()){
        $Estagio = $Read->getResult()[0];
    } else {
        die("Erro Estágio");
    }

    $Read->ExeRead("sys_modalidades", "WHERE modalidade_status = 0");
    if ($Read->getResult()):
        $Modalidades = $Read->getResult();
    endif;
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
                      <h4 class="card-title">Conteúdo programático de  <?= $Curso['produto_nome'] . " - " . $Estagio['estagio_produto_nome'] ?></h4>
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
                    <div class="row div_selecionar_configs">
                        <div class="col-md-6">
                            <input class="estagio_produto_id" type="hidden" name="estagio_produto_id" value="<?= $Estagio['estagio_produto_id'] ?>">
                            <label>ESCOLHA UMA MODALIDADE</label>
                            <select name="modalidade_id" class="form-control j_modalidade_conteudo">
                                <option disabled selected>Selecione uma modalidade</option>
                                <?php
                                foreach ($Modalidades as $Modalidade) {
                                    ?>
                                    <option value="<?= $Modalidade['modalidade_id'] ?>"><?= $Modalidade['modalidade_nome'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 div_carga_horaria_conteudo" style="display: none">
                            <label>ESCOLHA UMA CARGA HORÁRIA</label>
                            <select class="form-control j_carga_horaria_conteudo">
                                <option disabled selected>Selecione uma carga horária</option>
                            </select>
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
