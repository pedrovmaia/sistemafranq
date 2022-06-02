<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id){
    $Read->ExeRead("sys_materiais_estagio_produto", "WHERE estagio_id = :id", "id={$Id}");
    if($Read->getResult()) {
        header("Location: painel.php?exe=escola/admin/cadastro_materiais_estagio&idEstagio=" . $Id . "&id=". $Id);
        die;
    } else {
        header("Location: painel.php?exe=escola/admin/cadastro_materiais_estagio&idEstagio=" . $Id);
        die;
    }
}