<script>
    <?php
        if (in_array('filtro_colaborador', $linkto)){
    ?>
    var $table = $('#table-colaborador');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable();
        $(".table_list_none").fadeIn(1500);
    });
    <?php
    }

    if (in_array('filtro_autor', $linkto)){
    ?>
        var $table = $('#table');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

        $(function() {
            initTable()
        });
    <?php
    }

    if (in_array('filtro_prestador', $linkto)){
    ?>
        var $table = $('#table-prestador');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

        $(function() {
            initTable()
        });
    <?php
    }

    if (in_array('filtro_fornecedores', $linkto)){
    ?>
        var $table = $('#table-fornecedor');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

        $(function() {
            initTable()
        });
    <?php
    }

    
    if (in_array('filtro_alunos', $linkto)){
    ?>
        var $table = $('#table-aluno');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

        $(function() {
            initTable()
        });
    <?php
    }



    if (in_array('list_funcionalidades', $linkto)){
        ?>
        var $table = $('#table-funcionalidades');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

        $(function() {
            initTable()
        });
    <?php
    }

    if (in_array('filtro_extra_professor', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }



     if (in_array('filtro_pedido', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


     if (in_array('ver_produto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


     if (in_array('filtro_modelo_contrato', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_contrato', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

  
    if (in_array('filtro_movimentacao_estoque', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }



    if (in_array('filtro_escola_faq', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_escola_categoria_anexo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_escola_categoria_treinamentos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_escola_origem_materia', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_escola_tipo_portal', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('ver_movimentacao_pagamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('ver_movimentacao_recebimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    

    if (in_array('filtro_funcoes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_grau_escolaridade', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }



    if (in_array('ver_caixa', $linkto)){
    ?>
        var $table = $('#table');
        var $table2 = $('#table_resumo');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

         function initTable2() {
            $table2.bootstrapTable('destroy').bootstrapTable();
        }


        $(function() {
            initTable()
            initTable2()
        });
    <?php
    }


     if (in_array('ver_caixa_conferencia', $linkto)){
    ?>
        var $table = $('#table');
        var $table2 = $('#table_resumo');

        function initTable() {
            $table.bootstrapTable('destroy').bootstrapTable();
        }

         function initTable2() {
            $table2.bootstrapTable('destroy').bootstrapTable();
        }


        $(function() {
            initTable()
            initTable2()
        });
    <?php
    }
    if (in_array('filtro_titulos_pagar', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            onLoadSuccess: function(status, res) {
                $('.texto_trocar').text(status.total + " de títulos em aberto de " + status.qtd_alunos + ", com um valor a receber de R$" + status.valor);
            }
        });
    }

    $(function() {
        initTable()
    });
    <?php
    }
    if (in_array('filtro_titulos_aberto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            onLoadSuccess: function(status, res) {
                $('.texto_trocar').text(status.total + " de títulos em aberto de " + status.qtd_alunos + " aluno(s), com um valor a receber de R$" + status.valor);
            }
        });
    }

    $(function() {
        initTable()
    });
    <?php
    }

        if (in_array('list_parcelas_recebidas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            onLoadSuccess: function(status, res) {
                $('.texto_trocar_parcela').text(status.total + " parcelas recebidas de " + status.qtd_alunos + " aluno(s), com um valor a receber de R$" + status.valor);
            }
        });
    }

    $(function() {
        initTable()
    });
    <?php
    }
    if (in_array('filtro_grau_parentesco', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_idioma', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('filtro_franquia', $linkto)){
    ?>
    var $table = $('#table-franquia');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('filtro_int_tipo_contrato', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }

    if (in_array('filtro_salas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }


    if (in_array('filtro_turma', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }

    
    if (in_array('filtro_curso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }


    if (in_array('filtro_produto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }


    if (in_array('filtro_movimentacao_recebimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }


    if (in_array('filtro_titulos_receber', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });

    <?php
    }




    if (in_array('filtro_motivo_nao_fechamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivo_reat_venda', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivo_tranc_matricula', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivo_transferencia', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivos_cancelamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivos_desistencias', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_ocorrencias_natureza', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_ocorrencias_tipo_acao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


     if (in_array('filtro_titulos_receber_por_pessoa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }



    if (in_array('filtro_ocupacoes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_operadoras_celular', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_movimentacao_recebimento_por_pessoa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('negociacao_por_pessoa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_origem', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('filtro_modalidades', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_periodo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_promocoes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_acrescimo_abatimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_carta_cobranca', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_tipo_carta_quitacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_desconto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_franquia', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_obra', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_produto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_instituicao_financeira', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_conta_bancaria', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_movimentacao_pagamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('cadastro_movimentacao_pagamento', $linkto)){
    ?>
    var $table = $('#table_modal_fornecedor');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }



   

    if (in_array('filtro_conta_bancaria', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_contratos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_estagio_contrato', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_estagio_projeto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_envolvido_projeto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_convenio', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_propostas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_telefone', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_treinamentos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_colecao_livros', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_livros', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_sys_escola', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_empresas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_centro_custo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_conta_contabil', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_unidades', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_acervo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_editora', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_classificacao_literaria', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_etapa_curso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_avaliacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_formulacao_nota', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_feriado', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_mensagens', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_coordenadorias', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_grupos_economicos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_grupos_marketing', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_grupos_pedagogicos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_itinerario', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_forma_pagamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_avaliacoes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_avaliacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


    if (in_array('filtro_segmento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_plano_contas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipos_doc_liquidacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_cargo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_estagio_curso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

  
    if (in_array('filtro_forma_parcelamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_origem_interesse', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivo_interesse', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_tipo_atendimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_tipo_teste_nivel', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_menu', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_submenu', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_resposta_tipo_atendimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_proximas_acoes_tipo_atendimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_dias_vencimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_juros_multa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_descontos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_professor', $linkto)){
    ?>
    var $table = $('#table-professor');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_prospeccao', $linkto)){
    ?>
    var $table = $('#table-prospeccao');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_materias_aula', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_ocorrencia', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_teste_pessoa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_teste_pessoa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_transacao_caixa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_quiz', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_quiz_perguntas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_quiz_respostas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_livro_dica', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_livro_download', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_downloads', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_recesso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_ferias', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_pessoas', $linkto)){
    ?>
    var $table = $('#table-pessoas');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_mesas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_escola_respostas_quiz', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_preco_produto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_lista_espera', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('ver_alunos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_interesse', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('grade_horarios', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_matriculas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_evento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

if (in_array('filtro_tipo_campanha', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_politica_comercial_produto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_evento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_campanha', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_atendimentos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('ver_pedido', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('avaliacoes_aluno', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos', $linkto)){
    ?>
    var $table = $('#table-list-aluno');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_turma_salas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_turmas_professor', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_turmas_alunos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_empresas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_ocorrencias', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_turmas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_prospeccao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_clientes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_feriado', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_etapa_avaliacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_aulas_realizadas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_saldo_estoque', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_atendimentos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

      if (in_array('list_aniversariantes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

      if (in_array('ver_titulo_receber', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

      if (in_array('list_alunos_matriculados', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_paises', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_estados', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_cidades', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_consultor', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_scpc', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_vendas_realizadas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('acompanhamento_turma', $linkto)){
    ?>
    var $table = $('#table');
    var $table2 = $('#table2');
    var $table3 = $('#table3');
    var $table4 = $('#table4');
    var $table5 = $('#table5');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
        $table2.bootstrapTable('destroy').bootstrapTable();
        $table3.bootstrapTable('destroy').bootstrapTable();
        $table4.bootstrapTable('destroy').bootstrapTable();
        $table5.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_escola_franquias', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_tipo_historico_funcionario', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_historico_funcionario', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_horarios_professor', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_turma', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_turma', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_faltosos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_frequencia_geral', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('cadastro_controle_cheque', $linkto)){
    ?>
    var $table = $('#table_modal_pessoas');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_controle_cheque', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_situacao_cheque', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_emprestimo_acervo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('diario_classe', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('lista_chamada', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_reposicao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_reposicao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

       if (in_array('filtro_feriado_municipal', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_transacao_caixa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_trancados', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_cancelados', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_titulos_atraso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_titulos_atraso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_conferir_caixa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


     if (in_array('filtro_clientes', $linkto)){
    ?>
    var $table = $('#table-clientes');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

       if (in_array('filtro_ano_letivo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

       if (in_array('filtro_periodo_letivo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

       if (in_array('filtro_patrocinador', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

      if (in_array('filtro_niveis_empresa', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

      if (in_array('filtro_exercicio', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_exercicio2', $linkto)){
    ?>
    var $table = $('#tableexercicio');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_homework', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_homework2', $linkto)){
    ?>
    var $table = $('#tablehomework');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('historico_pedido', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }


if (in_array('historico_matricula', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_politica_estagio', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_negociacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_franquia_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_curso_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_turma_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_matricula_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_alunos_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('list_materiais_didaticos_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_pedido_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_motivo_negociacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_negociacao_sede', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_parcela_atraso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_recebimento_detalhado', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_parametrizacao_matricula', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('', $linkto)){
    ?>

    if($('#table_alunos_dash').length){
        var $table_alunos_dash = $('#table_alunos_dash');
    }

    if($('#table_turma_dash').length){
        var $table_turma_dash = $('#table_turma_dash');
    }

    function initTable_alunos_dash() {
        $table_alunos_dash.bootstrapTable('destroy').bootstrapTable();
    }

    function initTable_turma_dash() {
        $table_turma_dash.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {

        if($('#table_alunos_dash').length){
            initTable_alunos_dash();
        }

        if($('#table_turma_dash').length){
            initTable_turma_dash();
        }

    });
    <?php
    }

     if (in_array('relatorio_rateio_centro_custo', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_motivo_estorno', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

     if (in_array('filtro_motivo_alterar_vencimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('log_cancelamento_parcela', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('log_estorno_parcela', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('log_alteracao_vencimento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_ocorrencia_retencao_aluno', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_matricula_mes', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_contrato_aluno', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_historico_renegociacao', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_lancamento_conta', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_operadores_financeiro', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_transferencia_envolvidos', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_transferencia_envolvidos', $linkto)){
    ?>
    var $tableTurma = $('#table_modal_turma_transferencia');

    function initTableTurma() {
        $tableTurma.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTableTurma()
    });
    <?php
    }


    if (in_array('filtro_atividade_extra', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_matriz_perda_desconto', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('list_parcelas_recebidas', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_niveis_acesso', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_orcamento', $linkto)){
    ?>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }
    if (in_array('planejamento_aula_turma', $linkto)){
    ?>
    var $table2 = $('#table2');
    var $table3 = $('#table3');
    var $table4 = $('#table4');
    var $table5 = $('#table5');

    function initTable() {
        $table2.bootstrapTable('destroy').bootstrapTable();
        $table3.bootstrapTable('destroy').bootstrapTable();
        $table4.bootstrapTable('destroy').bootstrapTable();
        $table5.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }

    if (in_array('filtro_turmas_iniciar', $linkto)){
    ?>
    var $table2 = $('#table_turmas_iniciar');

    function initTable() {
        $table2.bootstrapTable('destroy').bootstrapTable();
    }

    $(function() {
        initTable()
    });
    <?php
    }
    ?>
</script>