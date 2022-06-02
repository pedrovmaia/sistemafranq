<?php

class PDF {

public function geraPDF($arr, $arquivo, $tipo) 
{     
  require_once 'vendor/autoload.php';

  if($tipo == 'TurmasSalas') {
    
      $html = "<style>tr, th{text-align:left; font-weight:normal; font-family: Arial}</style>
          <div style='width:100%; text-align:center; font-weight:bold; font-size:1.5em; font-family: Arial'>
           RELAÇÃO DE TURMAS POR SALAS
           </div>        
          ";

      $mpdf = new \Mpdf\Mpdf();

      $image = "<div align='center' style='padding:20px'><img src='logo.png' width='150'></div>";

      $mpdf->WriteHTML($image);

      $mpdf->WriteHTML($html);

      $dados = '';
      $sala = ''; 

      for ($i=0;$i<sizeof($arr);$i++) {

        $salas = '<div style=padding:10px 0px 0px 0px; font-family:Arial; text-align:left><strong>'.$arr[$i]['sala'].'</strong></div>';

        $turmas = "<table style='width:100%; text-align:left; border:solid 1px #666'>
        <tr style='text-align:left'><th style='width:40%; padding-left:5px'>
        ".$arr[$i]['turma']."</th>
        <th style='width:40%'>".$arr[$i]['professor']."</th>
        <th style='width:20%; text-align:right; padding-right:5px'>".$arr[$i]['situacao']."</th>
        </tr></table>";

        if($arr[$i]['sala'] != $sala) {      	

           $mpdf->WriteHTML($salas);

        }

        $mpdf->WriteHTML($turmas);

        $sala = $arr[$i]['sala'];       
      }

    } elseif ($tipo == 'TurmasProfessor') {

      $html = "<style>tr, th{text-align:left; font-weight:normal; font-family: Arial}</style>
          <div style='width:100%; text-align:center; font-weight:bold; font-size:1.5em; font-family: Arial'>
           RELAÇÃO DE TURMAS POR PROFESSOR
           </div>        
          ";

      $mpdf = new \Mpdf\Mpdf();

      $image = "<div align='center' style='padding:20px'><img src='logo.png' width='150'></div>";

      $mpdf->WriteHTML($image);

      $mpdf->WriteHTML($html);

      $dados = '';
      $professor = '';
      $count = 0;

      for ($i=0;$i<sizeof($arr);$i++) {

        if(!empty($arr[$i]['professor'])) {

          $professores = '<div style=padding:10px 0px 0px 0px; font-family:Arial; text-align:left><strong>'.$arr[$i]['professor'].'</strong></div>';

        } else {

          $professores = '<div style=padding:10px 0px 0px 0px; font-family:Arial; text-align:left><strong>SEM PROFESSOR</strong></div>';

        }

        $turmas = "<table style='width:100%; text-align:left; border:solid 1px #666'>
        <tr style='text-align:left'><th style='width:40%; padding-left:5px'>
        ".$arr[$i]['turma']."</th>
        <th style='width:20%; text-align:left; padding-right:5px'>
        ".$arr[$i]['dia']."</th>
        <th style='width:20%; text-align:right; padding-right:5px'>
        ".$arr[$i]['hora_inicio']."</th>
        <th style='width:20%; padding-left:5px; text-align:right; padding-right:5px'>
        ".$arr[$i]['hora_final']."</th>
        </tr></table>";

        if($arr[$i]['professor'] != $professor) {       

          $mpdf->WriteHTML($professores);

        }

        if(empty($arr[$i]['professor']) && $count == 0) {

          $mpdf->WriteHTML($professores);

          $count++;      

        }

        $mpdf->WriteHTML($turmas);

        $professor = $arr[$i]['professor'];    
      }

    } elseif ($tipo == 'TurmasAlunos'){

      $html = "<style>tr, th{text-align:left; font-weight:normal; font-family: Arial}</style>
            <div style='width:100%; text-align:center; font-weight:bold; font-size:1.5em; font-family: Arial'>
             RELAÇÃO DE ALUNOS/TURMAS POR DIA DA SEMANA
             </div>        
            ";

      $mpdf = new \Mpdf\Mpdf();

      $image = "<div align='center' style='padding:20px'><img src='logo.png' width='150'></div>";

      $mpdf->WriteHTML($image);

      $mpdf->WriteHTML($html);

      $dados = '';
      $dia = '';
      $nome_turma = '';

      for ($i=0;$i<sizeof($arr);$i++) {

          $dias = '<div style=padding:10px 0px 0px 0px; text-align:left>
          <strong>'.strtoupper($arr[$i]['dia']).'</strong></div>';

          $turma = "<br><table style='width:100%; text-align:left; border:solid 1px #666'>
          <tr><th><strong>TURMA: ".$arr[$i]['turma']." - ".$arr[$i]['sala']."</strong></th></tr></table>";

          $turmas = "<table style='width:100%; text-align:left; border:solid 1px #666'>
          <tr style='text-align:left'>
          <th style='width:80%; text-align:left; padding-right:5px'>
          ".$arr[$i]['aluno']."</th>
          <th style='width:10%; text-align:right; padding-right:5px'>
          ".$arr[$i]['hora_inicio']."</th>
          <th style='width:10%; padding-left:5px; text-align:right; padding-right:5px'>
          ".$arr[$i]['hora_final']."</th>
          </tr></table>";

          if($arr[$i]['dia'] != $dia) {       

            $mpdf->WriteHTML($dias);

          }

          if($arr[$i]['turma'] != $nome_turma) {       

            $mpdf->WriteHTML($turma);

          }

          $mpdf->WriteHTML($turmas);

          $dia = $arr[$i]['dia'];
          $nome_turma = $arr[$i]['turma']; 

        }
      }

    //salva o arquivo PDF
    $mpdf->Output($arquivo, 'F');    

  }    

}