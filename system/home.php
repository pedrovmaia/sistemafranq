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

<?php 
  



    $Read->FullRead("SELECT * FROM sys_acesso_pessoas WHERE acesso_pessoa_id = :id", "id={$_SESSION['userSYSFranquia']['pessoa_id']}");

    if(isset($Read->getResult()[0]['acesso_tipo']))
      $acesso_tipo_selecionado = $Read->getResult()[0]['acesso_tipo'];
    else
      $acesso_tipo_selecionado = '';

  if($acesso_tipo_selecionado == "Professor")
  {
      include('dashboards/dash_pedagogico.php');
  }

  if($acesso_tipo_selecionado == "Gerente")
  {
      include('dashboards/dash_escola.php');
  }



?>