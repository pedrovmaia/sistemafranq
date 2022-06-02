<?php
session_start();
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$jSON = null;
usleep(50000);

if ($PostData['action']):
    require '../../_app/Config.inc.php';
    $action = $PostData['action'];
    unset($PostData['action']);
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $trigger = new Trigger;
endif;

switch ($action):

    case 'buscarCargaHoraria':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $Id = $PostData['modalidade'];
            unset($PostData['modalidade']);
        
            $Read->ExeRead("sys_carga_horaria_cursos", "WHERE modalidade_id = :id", "id={$Id}");
            if($Read->getResult()){
                $select = "";
                foreach ($Read->getResult() as $Horario) {
                    $select .= "<option value='".$Horario['carga_id'].','.$Horario['carga_horas']."'>".$Horario['carga_horas']."</option>";
                }
                $jSON['success'] = $select;

            } else {
                $jSON['error'] = "true";
            }
        endif;
        break;

    case 'carregarCargaHoraria':

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:
            $Id = $PostData['carga'];
            $modalidade = $PostData['modalidade'];
            unset($PostData['carga'], $PostData['modalidade']);

            $Read->ExeRead("sys_conteudo_programatico", "WHERE estagio_id = :id AND modalidade_id = :m AND carga = :c", "id={$PostData['estagio_id']}&m={$modalidade}&c={$PostData['carga_id']}");
            if($Read->getResult()){
                if($Read->getRowCount() == $Id){
                    $jSON['redirect'] = "painel.php?exe=escola/admin/ver_programatico&idmodalidade=" . $modalidade . "&estagio=" . $PostData['estagio_id'] . "&carga_id=" . $PostData['carga_id'];
                    echo json_encode($jSON);
                    die();
                }
            }

            $jSON['redirect'] = "painel.php?exe=escola/admin/gerar-conteudoprogramatico&idmodalidade=" . $modalidade . "&estagio=" . $PostData['estagio_id'] . "&carga=" . $Id . "&carga_id=" . $PostData['carga_id'];

        endif;
        break;

    case 'gerarConteudo':

        $quantidade = $PostData["quantidade"];
        unset($PostData["quantidade"]);

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            for($i = 0; $i < $quantidade; $i++){
                if(!$PostData['etapa_'.($i+1)]){
                    $jSON['error'] = 'Favor, preencha todos os campos!';
                    echo json_encode($jSON);
                    die;
                }
            }

            $Aulas = explode(";", $PostData['conteudo']);
            $QtdArrAulas = count($Aulas);
            $ArrConteudoBaseMaterias = [];
            $ArrConteudoBaseAtividades = [];
            $ArrConteudoBaseHomeWork = [];
            $ArrConteudoBaseExercicios = [];
            $ArrEtapas = [];

            for($i = 0; $i < $QtdArrAulas; $i++){

                if(isset($Aulas[$i])){
                    $AulaMateriaAtividade = explode("-", $Aulas[$i]);
                    $AulaCheia = $AulaMateriaAtividade[0];
                    $Tarefa = $AulaMateriaAtividade[1];

                    $Aula = explode("_", $AulaCheia);
                    $tipo = explode("_", $Tarefa);

                    if($tipo[0] == "materia") {
                        $ArrConteudoBaseMaterias[] = [
                            'aula' => $Aula[1],
                            'materia' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "atividade") {
                        $ArrConteudoBaseAtividades[] = [
                            'aula' => $Aula[1],
                            'atividade' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "homework") {
                        $ArrConteudoBaseHomeWork[] = [
                            'aula' => $Aula[1],
                            'homework' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "exercicios") {
                        $ArrConteudoBaseExercicios[] = [
                            'aula' => $Aula[1],
                            'exercicios' => $tipo[1]
                        ];
                    }
                }

            }

            $novoMaterias = [];
            foreach ($ArrConteudoBaseMaterias as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoMaterias as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['materia']) && !empty($arr['materia'])) {
                            $valorAntigo = $subArr['materia'];
                            $novoValor = $arr['materia'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['materia'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoMaterias[$prg_cod_barra] = $arr;
            }

            $novoAtividades = [];
            foreach ($ArrConteudoBaseAtividades as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoAtividades as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['atividade']) && !empty($arr['atividade'])) {
                            $valorAntigo = $subArr['atividade'];
                            $novoValor = $arr['atividade'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['atividade'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoAtividades[$prg_cod_barra] = $arr;
            }

            $novoHomeWork = [];
            foreach ($ArrConteudoBaseHomeWork as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoHomeWork as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['homework']) && !empty($arr['homework'])) {
                            $valorAntigo = $subArr['homework'];
                            $novoValor = $arr['homework'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['homework'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoHomeWork[$prg_cod_barra] = $arr;
            }

            $novoExercicios = [];
            foreach ($ArrConteudoBaseExercicios as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoExercicios as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['exercicios']) && !empty($arr['exercicios'])) {
                            $valorAntigo = $subArr['exercicios'];
                            $novoValor = $arr['exercicios'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['exercicios'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoExercicios[$prg_cod_barra] = $arr;
            }

            for($i = 1; $i <= $quantidade; $i++){
                if(isset($PostData['etapa_'.($i)])){

                    if(isset($novoMaterias[$i])) {
                        $materias = $novoMaterias[$i]["materia"];
                    } else {
                        $materias = null;
                    }

                    if(isset($novoAtividades[$i])) {
                        $atividades = $novoAtividades[$i]["atividade"];
                    } else {
                        $atividades = null;
                    }

                    if(isset($novoHomeWork[$i])) {
                        $homework = $novoHomeWork[$i]["homework"];
                    } else {
                        $homework = null;
                    }

                    if(isset($novoExercicios[$i])) {
                        $exercicios = $novoExercicios[$i]["exercicios"];
                    } else {
                        $exercicios = null;
                    }

                    $ArrCompleto[] = [
                        'aula' => $i,
                        'etapa' => $PostData['etapa_'.$i],
                        'materias' => $materias,
                        'atividades' => $atividades,
                        'estagio_id' => $PostData['estagio_produto_id'],
                        'unidade_id' => $_SESSION["userSYSFranquia"]["unidade_padrao"],
                        'modalidade_id' => $PostData['modalidade_id'],
                        'carga' => $PostData['carga_id'],
                        'horas' => $quantidade,
                        'homework' => $homework,
                        'exercicios' => $exercicios,
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'usuario_criacao' => $_SESSION["userSYSFranquia"]["pessoa_id"]
                    ];
                }
            }

            $Create->ExeCreateMulti("sys_conteudo_programatico", $ArrCompleto);

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            $jSON['redirect'] = "painel.php?exe=escola/admin/ver_programatico&idmodalidade=".$PostData['modalidade_id']."&estagio=".$PostData['estagio_produto_id'] . "&carga_id=" . $PostData['carga_id'];
        endif;

        break;

    case 'updategerarConteudo':

        $quantidade = $PostData["quantidade"];
        unset($PostData["quantidade"]);

        if (in_array('', $PostData)):
            $jSON['error'] = 'Favor, preencha todos os campos!';
        else:

            $Aulas = explode(";", $PostData['conteudo']);
            $QtdArrAulas = count($Aulas);
            $ArrConteudoBaseMaterias = [];
            $ArrConteudoBaseAtividades = [];
            $ArrConteudoBaseHomeWork = [];
            $ArrConteudoBaseExercicios = [];
            $ArrEtapas = [];

            for($i = 0; $i < $QtdArrAulas; $i++){

                if(isset($Aulas[$i])){
                    $AulaMateriaAtividade = explode("-", $Aulas[$i]);
                    $AulaCheia = $AulaMateriaAtividade[0];
                    $Tarefa = $AulaMateriaAtividade[1];

                    $Aula = explode("_", $AulaCheia);
                    $tipo = explode("_", $Tarefa);

                    if($tipo[0] == "materia") {
                        $ArrConteudoBaseMaterias[] = [
                            'aula' => $Aula[1],
                            'materia' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "atividade") {
                        $ArrConteudoBaseAtividades[] = [
                            'aula' => $Aula[1],
                            'atividade' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "homework") {
                        $ArrConteudoBaseHomeWork[] = [
                            'aula' => $Aula[1],
                            'homework' => $tipo[1]
                        ];
                    }

                    if($tipo[0] == "exercicios") {
                        $ArrConteudoBaseExercicios[] = [
                            'aula' => $Aula[1],
                            'exercicios' => $tipo[1]
                        ];
                    }
                }

            }

            $novoMaterias = [];
            foreach ($ArrConteudoBaseMaterias as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoMaterias as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['materia']) && !empty($arr['materia'])) {
                            $valorAntigo = $subArr['materia'];
                            $novoValor = $arr['materia'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['materia'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoMaterias[$prg_cod_barra] = $arr;
            }

            $novoAtividades = [];
            foreach ($ArrConteudoBaseAtividades as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoAtividades as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['atividade']) && !empty($arr['atividade'])) {
                            $valorAntigo = $subArr['atividade'];
                            $novoValor = $arr['atividade'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['atividade'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoAtividades[$prg_cod_barra] = $arr;
            }

            $novoHomeWork = [];
            foreach ($ArrConteudoBaseHomeWork as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoHomeWork as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['homework']) && !empty($arr['homework'])) {
                            $valorAntigo = $subArr['homework'];
                            $novoValor = $arr['homework'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['homework'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoHomeWork[$prg_cod_barra] = $arr;
            }

            $novoExercicios = [];
            foreach ($ArrConteudoBaseExercicios as $arr) {
                $prg_cod_barra = $arr['aula'];
                $existe = false;
                foreach ($novoExercicios as &$subArr) {
                    if ($prg_cod_barra == $subArr['aula']){
                        if(!empty($subArr['exercicios']) && !empty($arr['exercicios'])) {
                            $valorAntigo = $subArr['exercicios'];
                            $novoValor = $arr['exercicios'];
                            $existe = $valorAntigo . ', ' . $novoValor;
                            $subArr['exercicios'] = $existe;
                        }
                    }
                }
                if (!$existe) $novoExercicios[$prg_cod_barra] = $arr;
            }

            for($i = 1; $i <= $quantidade; $i++){
                if(isset($PostData['etapa_'.($i)])){

                    $ArrCompleto = [];

                    if(isset($novoMaterias[$i])) {
                        $materias = $novoMaterias[$i]["materia"];
                    } else {
                        $materias = null;
                    }

                    if(isset($novoAtividades[$i])) {
                        $atividades = $novoAtividades[$i]["atividade"];
                    } else {
                        $atividades = null;
                    }

                    if(isset($novoHomeWork[$i])) {
                        $homework = $novoHomeWork[$i]["homework"];
                    } else {
                        $homework = null;
                    }

                    if(isset($novoExercicios[$i])) {
                        $exercicios = $novoExercicios[$i]["exercicios"];
                    } else {
                        $exercicios = null;
                    }

                    $ArrCompleto = [
                        'etapa' => $PostData['etapa_'.$i],
                        'materias' => $materias,
                        'atividades' => $atividades,
                        'horas' => $quantidade,
                        'homework' => $homework,
                        'exercicios' => $exercicios
                    ];

                    $Update->ExeUpdate("sys_conteudo_programatico", $ArrCompleto, "WHERE projeto_programatico_id = :id", "id={$PostData['programatico_id_'.$i]}");

                }
            }

            $jSON['success'] = 'Seu registro foi salvo com sucesso!';
            //$jSON['redirect'] = "ver_programatico&idmodalidade=".$PostData['modalidade_id']."&estagio=".$PostData['estagio_produto_id'];
        endif;

        break;

    case 'delete':
        $Id = $PostData['del_id'];
        $Read->ExeRead("escola_faq", "WHERE faq_id = :user", "user={$Id}");
        if (!$Read->getResult()):
            //$jSON['trigger'] = WSErro("<b class='icon-warning'>USUÁRIO NÃO EXISTE:</b>", WS_ALERT);
        else:
            extract($Read->getResult()[0]);
            $Delete->ExeDelete("escola_faq", "WHERE faq_id = :user", "user={$Id}");
            //$jSON['trigger'] = WSErro("<b class='icon-checkmark'>USUÁRIO REMOVIDO COM SUCESSO!</b>", WS_ALERT);
            $jSON['redirect'] = "painel.php?exe=pedagogico/filtro_escola_faq";

        endif;
        break;

endswitch;

echo json_encode($jSON);