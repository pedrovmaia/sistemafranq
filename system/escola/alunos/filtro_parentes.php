<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id){
    $Read->ExeRead("sys_pessoas_parentesco", "WHERE pessoa_id = :id", "id={$Id}");
    if($Read->getResult()) {
        header("Location: painel.php?exe=escola/alunos/cadastro_parentes&idAluno=" . $Id . "&id=". $Id);
        die;
    } else {
        header("Location: painel.php?exe=escola/alunos/cadastro_parentes&idAluno=" . $Id);
        die;
    }
}