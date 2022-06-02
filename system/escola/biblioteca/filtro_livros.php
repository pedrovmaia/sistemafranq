

 <!-- End Navbar -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">PESQUISA DE LIVROS</h4>
            <p class="card-category">Filtre seus livros no acervo da biblioteca</p>
          </div>
          <div class="card-body">
            <form>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Titulo</label>
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Sub titulo</label>
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
                    <label class="bmd-label-floating">Situação de Empréstimo</label>
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                   
                     <label class="checkbox-inline"><input type="checkbox" value="">Inativo</label>
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-md-12">
                
                    <div class="form-group">
                      <div class="radio">
                        <label><input type="radio" name="optradio" checked>Pesquisar pelo começo do nome</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="optradio">Pesquisar por qualquer parte do nome</label>
                      </div>
                    </div>
                  
                </div>
              </div>

              

              <br/>

              <button type="submit" class="btn btn-primary pull-right">PESQUISAR</button>
              <button type="submit" class="btn btn-primary pull-right">CADASTRAR</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
      
     


    </div>
  </div>



   <div class="col-lg-12 col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Todos os livros</h4>
      <p class="card-category">Relação de livros cadastrados</p>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
          <th>ID</th>
          <th>Titulo</th>
          <th>Sub titulo</th>
          
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Rafael Conceição</td>
            <td>Aluno</td>
         
          </tr>
          <tr>
            <td>2</td>
            <td>Jose da Silva</td>
            <td>Aluno</td>
           
          </tr>
          <tr>
            <td>3</td>
            <td>Karina Souza</td>
            <td>Ex Aluno</td>
           
          </tr>
          <tr>
            <td>4</td>
            <td>Vanessa Moura</td>
            <td>Aluno</td>
           
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>



</html>
