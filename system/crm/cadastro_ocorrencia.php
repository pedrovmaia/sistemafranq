<?php
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;
$IdPessoa = filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);
$Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-1">
                                <button onclick="window.history.back();" style="color: white" class="btn btn-outline-primary"><i class="material-icons">arrow_back</i></button>
                            </div>
                            <div class="col-md-10 text-center">
                                <h4 class="card-title"><?= $texto['CadOCRR'] ?></h4>
                                <p class="card-category"><?= $texto['CadOCRRi'] ?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
<?php

if ($Id):
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_OCORRENCIA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["alterar"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
     $Read->ExeRead("sys_ocorrencia", "WHERE ocorrencia_id = :id", "id={$Id}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
        ?>
        <form class="form_ocorrencia">
            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>

              <div class="row">
                                    
                                    <div class="col-md-6">
                        <div class="form-group">
                              <label class="bmd-label-floating"><?= $texto['ALNSE'] ?></label>
                                            <select disabled value="<?= $FormData['ocorrencia_pessoa_id'] ?>" name="ocorrencia_pessoa_id" class="form-control" data-style="btn btn-link">
                                                <option value="0"><?= $texto['SelALNS'] ?></option>
                                                <?php
                                                $Read->ExeRead("sys_pessoas");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Pessoa):
                                                        ?>
                                                         <option value="<?= $Pessoa['pessoa_id'] ?>" <?php if ($FormData['ocorrencia_pessoa_id']  == $Pessoa['pessoa_id'] ) { echo "selected";}  ?>  ><?php echo $Pessoa['pessoa_nome']; ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                        </div>
                    </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTAATNDT'] ?></label>
                            <input type="text" value="<?= date('d/m/Y', strtotime($ocorrencia_data)) ?>" name="ocorrencia_data" class="form-control formDate">
                        </div>
                    </div>
                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ATNDT'] ?></label>
                                            <a data-toggle="modal" data-target="#getCodeModal">
                                                <input readonly type="text" placeholder="Clique e selecione o atendente"  id="txt_pessoa" class="form-control">
                                            </a>
                                            <input  id="txt_id_pessoa" type="hidden" name="ocorrencia_atendente_id" class="form-control">
                                        </div>
                                    </div>
                            

                            <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating"><?= $texto['Nati'] ?></label>
                                                   
                                                     <select style="margin-top: -3px" name="ocorrencia_natureza_id" value="<?= $ocorrencia_natureza_id ?>" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelNATRE'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencias_natureza_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Natureza):
                                                                ?>
                                                                 <option value="<?= $Natureza['ocorrencia_natureza_id'] ?>" <?php if ($FormData['ocorrencia_natureza_id']  == $Natureza['ocorrencia_natureza_id'] ) { echo "selected";}  ?>  ><?php echo $Natureza['ocorrencias_natureza_nome']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                        </div>
                    </div>
            </div>


                        <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <textarea name="ocorrencia_descricao"  class="form-control" rows="4" cols="50"> <?= $ocorrencia_descricao ?></textarea>
                    </div>
                </div>
            </div>
                <br/>
            </div>
            <br/>
            <input type="hidden" name="action" value="OcorrenciaEditar"/>
            <input type="hidden" name="ocorrencia_id" value="<?= $Id; ?>"/>
            <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
            <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
            <?php
            if($permissao["deletar"] == 1) {
                ?>
                <span rel='single_user_addr' callback='Crm/Ocorrencia' action="delete" class='j_delete_action_confirm icon-warning btn btn-danger' id='<?= $Id; ?>'><?= $texto['Del'] ?></span>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </form>
        <?php
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: painel.php?exe=crm/cadastro_ocorrencia');
        exit;
    endif;
else:
    $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CRM_OCORRENCIA."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
    $permissao = $Read->getResult()[0];
    if($permissao["inserir"] != 1){
        echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
        die;
    }
     $Read->FullRead("SELECT pessoa_nome FROM sys_pessoas WHERE pessoa_id = :idpessoa AND unidade_id = :unidade", "idpessoa={$IdPessoa}&unidade={$_SESSION['userSYSFranquia']['unidade_padrao']}");

    ?>
    <form class="form_ocorrencia">
        <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
            <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
            
               
              <div class="row">
                                    
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['ALNS'] ?></label>
                            <span class="form-control"><?= $Read->getResult()[0]['pessoa_nome'] ?></span>
                        </div>
                    </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating"><?= $texto['DTAATNDT'] ?></label>
                            <input type="text" name="ocorrencia_data" class="form-control formDate">
                        </div>
                    </div>
                </div>
                               
                               <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"><?= $texto['ATNDT'] ?></label>
                                            <a data-toggle="modal" data-target="#getCodeModal">
                                                <input readonly type="text" placeholder="Clique e selecione o atendente"  id="txt_pessoa" class="form-control">
                                            </a>
                                            <input  id="txt_id_pessoa" type="hidden" name="ocorrencia_atendente_id" class="form-control">
                                        </div>
                                    </div>
                            

                            <div class="col-md-6">
                        <div class="form-group">
                            <label  class="bmd-label-floating"><?= $texto['Nati'] ?></label>
                                                   
                                                     <select style="margin-top: -3px" name="ocorrencia_natureza_id" class="form-control" data-style="btn btn-link">

                                                         <option value="0"><?= $texto['SelNATRE'] ?></option>
                                                       
                                                        <?php
                                                        
                                                        $Read->ExeRead("sys_ocorrencias_natureza", "WHERE ocorrencias_natureza_status = :st", "st=0");
                                                        if ($Read->getResult()):
                                                            foreach ($Read->getResult() as $Natureza):
                                                                ?>
                                                                <option value="<?= $Natureza['ocorrencia_natureza_id'] ?>"><?= $Natureza['ocorrencias_natureza_nome'] ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                        </div>
                    </div>
            </div>


                        <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="bmd-label-floating"><?= $texto['dscM'] ?></label>
                            <textarea name="ocorrencia_descricao" class="form-control" rows="4" cols="50"></textarea>
                    </div>
                </div>
            </div>
           
            <br/>   
        </div>
        <br/>
        <input type="hidden" name="action" value="OcorrenciaAdd"/>
        <input type="hidden" name="ocorrencia_pessoa_id" value="<?= $IdPessoa ?>"/>
        <button type="submit" class="btn btn-primary pull-right"><?= $texto['sav'] ?></button>
        <img class="form_load pull-right" src="<?= BASE ?>/assets/img/load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>
        <div class="clearfix"></div>
    </form>
    <?php
endif;
?>
          </div>
        </div>
      </div>
    </div>
      ID FUNCIONALIDADE: <?= CRM_OCORRENCIA ?>
  </div>
</div>

<div class="showcase hide-print" id="getCodeModal">
    <a data-dismiss="modal" id="close-showcase" href="#"><i class="material-icons">clear</i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="showbox-example" class="showbox">
                    <table  class="table table-hover display"
                            id="table_modal_funcionarios"
                            data-toolbar="#table"
                            data-locale="pt-BR"
                            data-filter-control="true"
                            data-minimum-count-columns="2"
                            data-url="_ajax/lookups/ListFuncionarios.ajax.php?action=list"
                            data-pagination="true"
                            data-id-field="nome"
                            data-toggle="table"
                            data-select-item-name="nome"
                            data-buttons-class="primary"
                            data-click-to-select="true"
                    >
                        <thead>
                        <tr>
                            <th data-radio="true"></th>
                            <th data-field="id" data-filter-control="input">ID</th>
                            <th  data-field="nome" data-filter-control="input"><?= $texto['NomeMi'] ?></th>
                            <th  data-field="cpf" data-filter-control="input"><?= $texto['CRG'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
