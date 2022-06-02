<?php
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($Id){
    $Read->ExeRead("sys_politica_acrescimo");
    if($Read->getResult()) {
        header("Location: painel.php?exe=politica_comercial/cadastro_politica_acrescimo=" . $Id . "&id=". $Id);
        die;
    } else {
        header("Location: painel.php?exe=politica_comercial/cadastro_politica_acrescimo=" . $Id);
        die;
    }
}