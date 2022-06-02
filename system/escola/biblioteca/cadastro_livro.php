<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    KNN Idiomas
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
     <?php require_once("../../includes/menu_lateral.php");  ?>

    <div class="main-panel">
      <!-- Navbar -->
      
        <?php require_once("../../includes/menu_top.php");  ?>

         <!-- End Navbar -->
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">CADASTRO DE LIVROS</h4>
                    <p class="card-category">Cadastre os livros de sua biblioteca</p>
                  </div>
                  <div class="card-body">
                    <form>
                      
                      <div id="informacoes_basicas" class="border border-secondary" style="padding: 15px;">
                         <label class="bmd-label-floating"><strong>INFORMAÇÕES DO LIVRO</strong></label>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating">Titulo</label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                <label class="bmd-label-floating">Sub Titulo</label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                          </div>


                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['TYPOBRASi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $Texto['EDITRAi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                          </div>


                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['VOLUMIi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['NUMPAGSi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                          </div>



                         
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['EDITSSi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating">Ano da edição</label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            
                          </div>



                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating">ISBN</label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['KEYWORi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            
                          </div>



                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $Texto['CLASLITi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating">Autor</label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            
                          </div>


                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="bmd-label-floating"><?= $texto['OBSi'] ?></label>
                                <input type="text" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" value="">Inativo</label>
                              </div>
                            </div>
                            
                          </div>




                          


                      </div>

           
                      <br/>

                   
                      <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>  
                      <button type="submit" class="btn btn-primary pull-right">CANCELAR</button>
                      
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
              
              


            </div>
          </div>
        </div>


    <?php require_once("../../includes/footer.php");  ?>
            
     
</body>

</html>
