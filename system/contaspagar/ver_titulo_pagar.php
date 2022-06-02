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
                                   

                                    <h4 class="card-title"><?= $texto['VerTITEPG'] ?></h4>
                                    <p class="card-category"><?= $texto['VerTITEPGi'] ?></p>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                        $Id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($Id):
                        $Read->ExeRead("sys_relacao_funcionalidade_nivel_acesso", "WHERE funcionalidade_id = :func AND nivel_acesso_id = :nivel", "func=".CONTASPAGAR_TITULOS."&nivel={$_SESSION['userSYSFranquia']['pessoa_acesso_id']}");
                        $permissao = $Read->getResult()[0];
                        if($permissao["alterar"] != 1){
                            echo "<div class='trigger trigger_error ajax_close'>Acesso restrito ao sistema!</div>";
                            die;
                        }
                            $Read->ExeRead("sys_movimentacao_pagamento", "WHERE mov_pagamento_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                               $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);

                            $Read->ExeRead("sys_pessoas", "WHERE pessoa_id = :id", "id={$FormData['mov_pagamento_pessoa_id']}");
                            if ($Read->getResult()):
                                $Pessoa = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                die;
                            endif;

                           /* $Read->ExeRead("sys_transacao_rateio", "WHERE rateio_conta_id = :id", "id={$Id}");
                            if ($Read->getResult()):
                                $Rateio = array_map('htmlspecialchars', $Read->getResult()[0]);
                            else:
                                $Rateio = "";
                            endif;*/
                        ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-tabs card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">

                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#profile" data-toggle="tab">
                                         <?= $texto['INFOP'] ?>
                                        <div class="ripple-container"></div>
                                    </a>
                                            </li>
                                            
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="profile">


                                        <form class="form_movimentacao_pagamento">
                                            <div id="informacoes_basicas" class="border_shadow" style="padding: 15px;">
                                                <label class="bmd-label-floating"><strong><?= $texto['informacoesBasicas'] ?></strong></label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">ID</label>
                                                            <input disabled autocomplete="off" type="text" name="mov_pagamento_id"  value="<?= $FormData['mov_pagamento_id'] ?>"  class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['DateEmis'] ?></label>
                                                            <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_pagamento_emissao'])) ?>"  name="mov_pagamento_emissao" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['FORNi'] ?></label>
                                                            <input disabled type="text" value="<?= $Pessoa['pessoa_nome'] ?>"  name="mov_pagamento_pessoa_id" class="form-control">
                                                        </div>
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    
                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['DDVCi'] ?></label>
                                                            <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_pagamento_data_vencimento']))    ?>"  name="mov_pagamento_data_vencimento" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PAYDAi'] ?></label>
                                                            <input disabled type="text" value="<?=  date('d/m/Y',strtotime($FormData['mov_pagamento_data_pagamento'])) ?>"  name="mov_pagamento_data_pagamento" class="form-control">
                                                        </div>
                                                    </div>




                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PARCM'] ?></label>
                                                            <input disabled type="text" value="<?= $FormData['mov_pagamento_parcela'] ?>"  name="mov_pagamento_parcela" class="form-control">
                                                        </div>
                                                    </div>



                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['PriceM'] ?></label>
                                                            <input disabled type="text" value="<?= 'R$ ' . number_format($FormData['mov_pagamento_valor'], 2, ',', '.')    ?>"  name="mov_pagamento_valor" class="form-control">
                                                        </div>
                                                    </div>
                                                

                                                     <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"><?= $texto['NUMBM'] ?></label>
                                                            <input disabled type="text" value="<?= $FormData['mov_pagamento_numero'] ?>"  name="mov_pagamento_numero" class="form-control">
                                                        </div>
                                                    </div>



                                                </div>

                                            


                                                </div>

                                               


                                                <br/>
                                            </div>


                                            <br/>

                                            <div class="clearfix"></div>
                                        </form>
                         

                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                                <?php
                else:
                    $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
                    header('Location: painel.php?exe=escola/turma/cadastro_sala');
                    exit;
                endif;
            endif;
            ?>
                        </div>
                    </div>
                </div>
            </div>
            ID FUNCIONALIDADE:
            <?= CONTASPAGAR_TITULOS ?>
        </div>
    </div>

   