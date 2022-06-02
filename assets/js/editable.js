function MensagensNow() {
    $.post('_ajax/Dashboard.ajax.php', {callback: 'Dashboard', callback_action: 'mensagens'}, function (data) {
        $('.sys_mensagens_novas').text(data.num_mensagens);
        $('.num_mensagens').val(data.num_mensagens);
        if(data.num_mensagens > 0){
            $('.sys_mensagens_novas').fadeIn();
        } else {
            $('.sys_mensagens_novas').fadeOut();
        }
        $('.list_notificacoes_msg_novas').remove();
        $('.list_notificacoes_msg').append(data.novas_mensagens);
    }, 'json');
}

$(function () {

    setInterval(function () {
        MensagensNow();
    }, 300000);

    $("#input-pago-mov-pag").on("change", function() {
       
        var pago = document.getElementById("input-pago-mov-pag").value;

        if (pago === '0') {

             document.getElementById("hidden_div_recorrente").style.display = "block";
             document.getElementById("hidden_div_data").style.display = "none";
            
        } else {
           
            document.getElementById("hidden_div_recorrente").style.display = "none";
            document.getElementById("parcela").value = "1";
            document.getElementById("hidden_div_data").style.display = "block";
            
        }


    });


     $('.formMoney').mask('#.##0,00', {reverse: true});


    //############## GET PARCELAMENTO

     $("#movimentacao_forma_parcelamento_id").on("change", function() {
       
        var parcelamento = document.getElementById("movimentacao_forma_parcelamento_id").value;

        $.getJSON(
            'assets/function/retorna_parcelamento.php',
            { id: $( this ).val() },
            function( json )
            {
                //$( endereco ).val( json.endereco );
               // $( telefone ).val( json.telefone );
               
                $('.sys_parcela').val(json.parcela);        
                $('.sys_intervalo').val(json.intervalo);
                $('.sys_tipo').val(json.tipo);
                $('.sys_tipo_nome').val(json.tipo_nome);
            }
        );   

    });


    $("#proposta_forma_parcelamento_id").on("change", function() {
       
        var parcelamento = document.getElementById("proposta_forma_parcelamento_id").value;

        $.getJSON(
            'assets/function/retorna_parcelamento.php',
            { id: $( this ).val() },
            function( json )
            {
                //$( endereco ).val( json.endereco );
               // $( telefone ).val( json.telefone );
               
                $('.sys_parcela').val(json.parcela);        
                $('.sys_intervalo').val(json.intervalo);
                $('.sys_tipo').val(json.tipo);
                $('.sys_tipo_nome').val(json.tipo_nome);
            }
        );   

    });

    function trigger(data) {
        if(data[0]){
            $.each(data, function(key, value){
                triggerNotify(data[key]);
            })
        } else {
            triggerNotify(data);
        }
    }

    function triggerNotify(data) {

        var triggerContent = "<div class='trigger_notify trigger_notify_" + data.color + "' style='left: 100%; opacity: 0;'>";
        triggerContent += "<p class='" + data.icon + "'> " + data.title + "</p>";
        triggerContent += "<span class='trigger_notify_timer'></span>";
        triggerContent += "</div>";

        if(!$('.trigger_notify_box').length){
            $('body').prepend("<div class='trigger_notify_box'></div>");
        }

        $('.trigger_notify_box').prepend(triggerContent);
        $('.trigger_notify').stop().animate({'left': '0', 'opacity': '1'}, 200, function(){
            $(this).find('.trigger_notify_timer').animate({'width': '100%'}, data.timer, 'linear', function(){
                $(this).parent('.trigger_notify').animate({'left': '100%', 'opacity': '0'}, function(){
                    $(this).remove();
                });
            });
        });

        $('body').on('click', '.trigger_notify', function(){
            $(this).animate({'left': '100%', 'opacity': '0'}, function(){
                $(this).remove();
            });
        });
    }

    $('.item_selecionado').on('click', '.j_remove_produto_linha', function () {

        $(this).closest(".itens_pedido").remove();
        var valorTotal = 0;
        $.each($('.produto_valor_venda'), function(index, value) {
            if(value.value != "" && value.value != undefined) {
                valorTotal += parseFloat(value.value);
            }
        });

        $('.valor_total_list_pedidos').text(numberToReal(valorTotal));

    });

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };

    $('.j_sys_add_produto_pedido').click(function () {

        $.post(base + '_ajax/pedido/Pedido.ajax.php', {callback: 'Pedido', action: 'add_prod_list', produto_id: $(this).attr('id')}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                swal({
                    title: "Bom trabalho!",
                    text: data.success,
                    icon: "success",
                    button: "Ok!",
                });
            }

            if (data.produto) {
                $('.item_selecionado').append(data.produto);
                var valorTotal = 0;
                $.each($('.produto_valor_venda'), function(index, value) {
                    if(value.value != "" && value.value != undefined) {
                        valorTotal += parseFloat(value.value);
                    }
                });

                $('.valor_total_list_pedidos').text(numberToReal(valorTotal));
            }

        }, 'json');

    });

    var $TABLE = $('.table_telefone');
    var numero = $('.quantidade_telefone').val();
    var base = $('link[rel="base"]').attr('href') + "/";

    $('.table-add').click(function (e) {
        e.preventDefault();
        numero++;
        $('.quantidade_telefone').val(numero);

        $.post(base + '_ajax/rh/Colaborador.ajax.php', {callback: 'Colaborador', action: 'infos_tel', numero: numero}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE.append(data.success);

                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };
                $('.formPhone').unmask().mask(SPMaskBehavior, spOptions);
            }
        }, 'json');
    });

    $('.table_telefone').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse telefone?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/rh/Colaborador.ajax.php', {callback: 'Colaborador', action: 'remove_tel', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });

    //############## TABLE PRODUTOS MATRÍCULA
    var $TABLEPRODUTOSMATRICULA = $('.table_produtos_matricula');
    var numeroProdutoMatricula = $('.quantidade_produto_matricula').val();

    $('.table-produtos-add-matricula').click(function (e) {
        e.preventDefault();
        numeroProdutoMatricula = $('.quantidade_produto_matricula').val();
        numeroProdutoMatricula++;
        $('.quantidade_produto_matricula').val(numeroProdutoMatricula);

        $.post(base + '_ajax/pedido/Matricula.ajax.php', {callback: 'Matricula', action: 'infos_produto', numero: numeroProdutoMatricula}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLEPRODUTOSMATRICULA.append(data.success);
                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");
                $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
            }
        }, 'json');
    });

    $TABLEPRODUTOSMATRICULA.on('click', '.table-remove', function () {
        remove = $(this);

        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse item?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/pedido/Proposta.ajax.php', {callback: 'Proposta', action: 'remove_tel', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            $("." + remove.attr('accessKey')).remove();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });

                            setTimeout(function () {

                                var valor_total = 0;

                                $('.valor_total_tabela').each(function(){

                                    valor_total += parseFloat($(this).val());
                                });

                                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                                $('.valor_total').focus();
                            }, 100);
                        }
                    }, 'json');

                }
            });
        } else {
            $("." + remove.attr('accessKey')).remove();

            setTimeout(function () {

                var valor_total = 0;

                $('.valor_total_tabela').each(function(){

                    valor_total += parseFloat($(this).val());
                });

                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                $('.valor_total').focus();
            }, 100);
        }
    });

    //############## TABLE PRODUTOS CADASTRO PROPOSTA
    var $TABLEPRODUTOSPROPOSTA = $('.table_produtos_proposta');
    var numeroProdutoProposta = $('.quantidade_produto_proposta').val();

    $('.table-produtos-add-proposta').click(function (e) {
        e.preventDefault();
        numeroProdutoProposta++;
        $('.quantidade_produto_proposta').val(numeroProdutoProposta);

        $.post(base + '_ajax/pedido/Proposta.ajax.php', {callback: 'Proposta', action: 'infos_produto', numero: numeroProdutoProposta}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLEPRODUTOSPROPOSTA.append(data.success);
                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");
                $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
            }
        }, 'json');
    });

    $('.table_centro_custo').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse item?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/parametrizacao/PlanoContas.ajax.php', {callback: 'PlanoContas', action: 'remove_centro', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });

    $('.table_produtos_proposta').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse item?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/pedido/Proposta.ajax.php', {callback: 'Proposta', action: 'remove_tel', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });

                            setTimeout(function () {

                                var valor_total = 0;

                                $('.valor_total_tabela').each(function(){

                                    valor_total += parseFloat($(this).val());
                                });

                                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                                $('.valor_total').focus();
                            }, 100);
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();

            setTimeout(function () {

                var valor_total = 0;

                $('.valor_total_tabela').each(function(){

                    valor_total += parseFloat($(this).val());
                });

                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                $('.valor_total').focus();
            }, 100);
        }
    });

    //############## TABLE PRODUTOS CADASTRO PEDIDO DE COMPRA
    var $TABLEPRODUTOSPEDIDOCOMPRA = $('.table_produtos_compra');
    var numeroProdutoPedidoCompra = $('.quantidade_produto_proposta').val();

    $('.table-produtos-add-pedido-compra').click(function (e) {
        e.preventDefault();
        numeroProdutoPedidoCompra++;
        $('.quantidade_produto_proposta').val(numeroProdutoPedidoCompra);

        $.post(base + '_ajax/suprimentos/Suprimentos.ajax.php', {callback: 'Suprimentos', action: 'infos_produto', numero: numeroProdutoPedidoCompra}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLEPRODUTOSPEDIDOCOMPRA.append(data.success);
                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");
                $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
            }
        }, 'json');
    });

    $TABLEPRODUTOSPEDIDOCOMPRA.on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse item?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/pedido/Proposta.ajax.php', {callback: 'Proposta', action: 'remove_tel', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });

                            setTimeout(function () {

                                var valor_total = 0;

                                $('.valor_total_tabela').each(function(){

                                    valor_total += parseFloat($(this).val());
                                });

                                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                                $('.valor_total').focus();
                            }, 100);
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();

            setTimeout(function () {

                var valor_total = 0;

                $('.valor_total_tabela').each(function(){

                    valor_total += parseFloat($(this).val());
                });

                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                $('.valor_total').focus();
            }, 100);
        }
    });

    //############## MASK INPUT
    if ($('.formDate').length || $('.formTime').length || $('.formCep').length || $('.formCpf').length || $('.formPhone').length || $('.formDateTime').length) {
        $(".formDate").mask("99/99/9999");
        $(".formTime").mask("99:99");
        $(".formCep").mask("99999-999");
        $(".formCpf").mask("999.999.999-99");
        $(".formCnpj").mask("99.999.999/9999-99");
        $(".formDateTime").mask("99/99/9999 99:99");


        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('.formPhone').mask(SPMaskBehavior, spOptions);
    }


    //############## GET CEP
    $('.getCep').blur(function () {
        var cep = $(this).val().replace('-', '').replace('.', '');
        if (cep.length === 8) {
            $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                if (!data.erro) {
                    $('.sys_bairro').val(data.bairro);
                    $('.sys_complemento').val(data.complemento);
                    $('.sys_localidade').val(data.localidade);
                    $('.sys_logradouro').val(data.logradouro);
                    $('.sys_uf').val(data.uf);
                }
                if (data.error) {

                swal({
                    title: "Opps!",
                    text: "CEP INFORMADO NÃO É VALIDO",
                    icon: "error",
                    button: "Ok!",
                });

            }
            }, 'json');
        }
    });

    $(".j_sys_change_cpf").blur(function () {

        var cpf = $(this).val();
        var cpfInput = $(this);
        if (cpf.length === 14) {

            var formData = "action=buscaralunoscpf&cpf=" + cpf;

            $.post(base + '_ajax/escola/BuscaCPF.ajax.php', formData, function (data) {

                if (data.error) {

                }

                if (data.success) {

                    cpfInput.val('');

                    swal({
                        title: "Aluno encontrado.",
                        text: "Aluno " + data.nome + " encontrado com esse CPF, deseja ver seu cadastro?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {

                            window.location.href = "painel.php?exe=escola/alunos/ver_alunos&id=" + data.id;

                        }
                    });

                }

            }, 'json');

        }

    });

    $(".jsys_nivel_acesso_menu").change(function () {

        var formData = "action=list_menus_nivel&id=" + $(this).val();

        $.post(base + '_ajax/admin/Menu.ajax.php', formData, function (data) {

            $(".minhas_permissoes").fadeIn();

            if (data.error) {
                $('.list_menus').remove();
                $(".menus").append(data.error);
            }

            if (data.success) {
                $('.list_menus').remove();
                $(".menus").append(data.success);
            }

        }, 'json');
    });

    $(".jsys_menu_submenu").change(function () {

        if($(".jsys_nivel_acesso_submenu").val() != ""){
            $('#select_professores option').remove();

            var formData = "action=list_menus_nivel&nivelacesso=" + $(".jsys_nivel_acesso_submenu").val() + "&menu=" + $(this).val();

            $.post(base + '_ajax/admin/SubMenu.ajax.php', formData, function (data) {

                $('#select_submenus option').remove();
                $("#select_submenus").selectpicker('refresh');
                if (data.error) {
                    $('#select_submenus').append('<option value="0" disabled>Selecione os submenus</option>');
                    $("#select_submenus").selectpicker('refresh');
                }
                if (data.success) {
                    $('#select_submenus').append('<option value="0" disabled>Selecione as submenus</option>');
                    $("#select_submenus").selectpicker('refresh');
                    $('#select_submenus').append(data.success);
                    $("#select_submenus").selectpicker('refresh');
                }

            }, 'json');

        }
    });

    $('.wc_logout').click(function (e) {
        e.preventDefault();
        var formData = "callback_action=logout&callback=Login";

        $.post(base + '_ajax/Login.ajax.php', formData, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }
            if (data.trigger) {
                swal({
                    title: "Até logo!",
                    text: data.trigger,
                    icon: "success",
                    button: "Ok!",
                });
            }
            if (data.redirect) {
                setTimeout(function () {
                    window.location.href = base + "" + data.redirect;
                }, 3000)
            }
        }, 'json');

    });

    $('.ok_modal_responsavel_financeiro').click(function () {

        if($(".pessoa_nome_responsavel_financeiro").val() != ""){
            $('#pessoa_nome_responsavel_financeiro').val($(".pessoa_nome_responsavel_financeiro").val());
            $('#txt_id_pessoa_financeiro').val("");
        }

        $("#modal_responsavel_finan_cad").modal('hide');

    });

    $('.ok_modal_responsavel_pedagogico').click(function () {

        if($(".pessoa_nome_responsavel_pedagogico").val() != ""){
            $('#pessoa_nome_responsavel_pedagogico').val($(".pessoa_nome_responsavel_pedagogico").val());
            $('#txt_id_pessoa_pedagogico').val("");
        }

        $("#modal_responsavel_peda_cad").modal('hide');

    });

    $("#repetir_responsavel").change(function () {

        if($(this).is(':checked')){

            if($(".pessoa_nome_responsavel_financeiro").val() != ""){
                $('.pessoa_responsavel_pedagogico_id option[value=""]').text($(".pessoa_nome_responsavel_financeiro").val());
                $('.pessoa_responsavel_pedagogico_id option[value=""]').val("");
            }

        } else {

            $('.pessoa_responsavel_pedagogico_id option[value=""]').text("Selecione o responsável pedagógico");
            $('.pessoa_responsavel_pedagogico_id option[value=""]').val("");

        }

    });


    /**
     *  INDICAÇÃO ALUNO TABELA DINÂMICA
     */
    var $TABLE_INDICACAO_ALUNO = $('.table_indicacao_aluno');
    var numero_indicacao_aluno = $('.quantidade_indicacao_aluno').val();

    $('.table-add-indicacao-aluno').click(function (e) {
        e.preventDefault();
        numero_indicacao_aluno++;
        $('.quantidade_indicacao_aluno').val(numero_indicacao_aluno);

        $.post(base + '_ajax/Crm/IndicacaoAluno.ajax.php', {callback: 'IndicacaoAluno', action: 'add_linha', numero: numero_indicacao_aluno}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE_INDICACAO_ALUNO.append(data.success);

                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };
                $('.formPhone').unmask().mask(SPMaskBehavior, spOptions);
            }
        }, 'json');
    });

    $('.table_indicacao_aluno').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover essa indicação?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/Crm/IndicacaoAluno.ajax.php', {callback: 'IndicacaoAluno', action: 'remove', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });

    /**
     *  PERIDICIDADE TABELA DINÂMICA
     */
    var $TABLE_PERIODICIDADE = $('.table_periodicidade');
    var numero_periodicidade = $('.quantidade_horarios').val();

    $('.table-add-periodicidade').click(function (e) {
        e.preventDefault();
        numero_periodicidade++;
        $('.quantidade_horarios').val(numero_periodicidade);

        $.post(base + '_ajax/escola/Turma.ajax.php', {callback: 'Periodicidade', action: 'add_linha', numero: numero_periodicidade}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE_PERIODICIDADE.append(data.success);

                $(".formTime").mask("99:99");
            }
        }, 'json');
    });

    $('.table_periodicidade').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover essa peridicidade?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/Turma.ajax.php', {callback: 'Periodicidade', action: 'remove', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            }).then((value) => {

                                if (data.redirect) {

                                    window.setTimeout(function () {
                                        window.location.href = data.redirect;
                                        if (window.location.hash) {
                                            window.location.reload();
                                        }
                                    }, 500);

                                }

                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });


    $('.table').on('click', ".j_sys_selecionar_turma_espera", function () {

        $("#modal_escolherTurma_listaEspera").modal('show');
        $('.id_lista_espera_projeto').val($(this).attr('rel'));

    });

    $('.j_click_alteracao_data_vencimento').click(function (e) {
        e.preventDefault();

        $('.tipo_operador').val('');

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_alterar_data_vencimento').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                    return false;
                }
            }

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');
            $('.tipo_operador').val('alteracao_data_vencimento');
            $("#modal_escolher_operador").modal("show");

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });

    $('.j_click_alteracao_data_vencimento_massa').click(function (e) {
        e.preventDefault();

        $('.tipo_operador').val('');

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_alterar_data_vencimento').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                    return false;
                }
            }

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');
            $('.tipo_operador').val('alteracao_data_vencimento_massa');
            $("#modal_escolher_operador").modal("show");

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }   

    });

    $(".j_click_confirmar_renegociacao_parcela").click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            var quatidadeParcelas = $(".qtd_parcelas_negociacao").val();
            var motivo = $(".motivo_negociacao").val();
            var observacao = $(".motivo_negociacao").val();
            var valor_total = 0;

            if(quatidadeParcelas != 0 && quatidadeParcelas != undefined && motivo != 0 && motivo != undefined && observacao != 0 && observacao != undefined) {

                var pessoa_id = $('#table').bootstrapTable('getSelections')[0].pessoa_id;
                var count = $('#table').bootstrapTable('getSelections').length;
                var IdParcelas = "";

                for(var i = 0; i < count; i++) {

                    var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                    valor_total += parseFloat(valor.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

                    var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;

                    IdParcelas += "parcela_" + i + "=" + id + "&";

                }

                var data = IdParcelas + "pessoa_id=" + pessoa_id + "&qtd=" + count + "&action=renegociacao&total=" + valor_total + "&obs=" + observacao + "&motivo=" + motivo + "&parcelaqtd=" + quatidadeParcelas;

                $.post(base + '_ajax/financeiro/Renegociacao.ajax.php', data, function (data) {

                    if (data.error) {
                        swal({
                            title: "Opps!",
                            text: data.error,
                            icon: "error",
                            button: "Ok!",
                        });
                    }
                    if (data.success) {

                        swal({
                            title: "Bom trabalho!",
                            text: 'As parcelas foram geradas com sucesso!',
                            icon: "success",
                            button: "Ok!",
                        }).then((value) => {

                            if (data.redirect) {

                                window.setTimeout(function () {
                                    window.location.href = data.redirect;
                                    if (window.location.hash) {
                                        window.location.reload();
                                    }
                                }, 500);

                            }

                        });
                    }
                }, 'json');

            } else {
                swal("Opps!", "Escolha uma quantidade de parcelas, um motivo de negociação e uma observação!", "info");

                return false;
            }

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });

    $('.j_click_renegociacao_parcela').click(function (e) {
        e.preventDefault();

        $('.list_remove_renegociacao').remove();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            var count = $('#table').bootstrapTable('getSelections').length;

            var itens = "";
            var total_parcelas = 0;
            var valor_total = 0;
            var quatidadeParcelas = $(".qtd_parcelas_negociacao").val();

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos!", "info");

                    return false;
                }

                var data_vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;
                var aluno = $('#table').bootstrapTable('getSelections')[i].fornecedor;
                var pessoa_id = $('#table').bootstrapTable('getSelections')[i].pessoa_id;
                var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                //var vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var parcela = $('#table').bootstrapTable('getSelections')[i].parcela;

                valor_total += parseFloat(valor.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

            }

            if(quatidadeParcelas != 0 && quatidadeParcelas != undefined) {

                var porparcela = parseFloat(valor_total/quatidadeParcelas);
                var vencimento = $('#table').bootstrapTable('getSelections')[0].vencimento.split("/");
                var dtavencimento = vencimento[2] + "/" + vencimento[1] + "/" + vencimento[0];

                var total = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total);
                
                $('#total').html("<span id='total' style='font-size:1.3em'>Total das parcelas "+total+"</span>");

                for(var i = 0; i < quatidadeParcelas; i++){

                    var dt = new Date(dtavencimento);
                    dt.setMonth( dt.getMonth() + i );
                    var mes = (dt.getMonth()+1).toString();
                    if (mes.length == 1) {
                        mes = "0" + mes;
                    }
                    var dia = dt.getDate().toString();
                    if (dia.length == 1) {
                        dia = "0" + dia;
                    }
                    var nova = dia + "/" + mes + "/" + dt.getFullYear();                    

                    var valor = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(porparcela);
                    
                    var parcela = i+1;
                    itens += "<div class='row list_remove_renegociacao'>";
                    itens += "<div class='col-md-3'><div class='form-group'><label>Parcela</label>";
                    itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                    itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                    itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                    itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                    itens += "<div class='col-md-4'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='"+nova+"'></div></div>";
                    itens += "<div class='col-md-4'><div class='form-group'><label>Valor</label>";
                    itens += "<input readonly type='text' value='"+valor+"' class='form-control j_valor_item_negociacao formMoney'></div></div>";
                    itens += "</div>";
                }

                $('.append_itens_renegociacao_novo').append(itens);

            } else {
                swal("Opps!", "Escolha uma quantidade de parcelas!", "info");

                return false;
            }
            valor_total = 0;


            $('.append_itens_renegociacao').append(itens);

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });

    $('.j_click_estornar_baixa_parcela').click(function (e) {
        e.preventDefault();

        $('.tipo_operador').val('');

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_remove_estornar_baixa_parcela').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status != "Pago"){

                    swal("Opps!", "Você precisa selecionar títulos que já foram pagos!", "info");

                    return false;
                }
            }

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');
            $('.tipo_operador').val('estornar_baixa_parcela');
            $("#modal_escolher_operador").modal("show");

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });

    $('.j_click_baixa_parcela').click(function (e) {
        e.preventDefault();

        $('.tipo_operador').val('');

        if($('#table').bootstrapTable('getSelections').length == 1){

            $('.list_remove').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            var valor_total = 0;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado" || $('#table').bootstrapTable('getSelections')[i].status == "Renegociado"){

                    swal("Opps!", "Você selecionou títulos que não são permitidos baixa, ou já foram pagos!", "info");

                    return false;
                }
            }

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');
            $('.tipo_operador').val('baixa_parcela');
            $("#modal_escolher_operador").modal("show");

        } else {
            swal("Opps!", "Para esse função selecione apenas um título!", "info");
        }

    });

    $('.j_click_cancelar_titulos').click(function (e) {
        e.preventDefault();

        $('.tipo_operador').val('');

        if($('#table').bootstrapTable('getSelections').length >= 1) {

            $('.list_remove_cancelar').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                    return false;
                }
            }

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');
            $('.tipo_operador').val('cancelar_titulos');
            $("#modal_escolher_operador").modal("show");

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });

    $('.j_click_gerar_carne_titulos').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_remove_carnes').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            var itens = "";
            var chaves = [];

            for(var i = 0; i < count; i++){
                chaves.push($('#table').bootstrapTable('getSelections')[i].receb_mov_id);
            }

            var uniqueCarne = chaves.filter( function( elem, i, array ) {
                return chaves.indexOf( elem ) === i;
            });

            if(uniqueCarne.length > 1){

                swal("Opps!", "Você selecionou títulos de movimentações diferentes!", "info");

                return false;
            }

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                    return false;
                }

                var data_vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;
                var aluno = $('#table').bootstrapTable('getSelections')[i].fornecedor;
                var pessoa_id = $('#table').bootstrapTable('getSelections')[i].pessoa_id;
                var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                var vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var parcela = $('#table').bootstrapTable('getSelections')[i].parcela;
                var receb_mov_id = $('#table').bootstrapTable('getSelections')[i].receb_mov_id;

                itens += "<div class='row list_remove_carnes'>";
                itens += "<div class='col-md-2'><div class='form-group'><label>Parcela</label>";
                itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='"+vencimento+"'></div></div>";
                itens += "<div class='col-md-4'><div class='form-group'><label>Valor Pagamento</label>";
                itens += "<input readonly type='text' value='"+valor+"' class='form-control formMoney'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Movimentação</label><input readonly class='form-control' type='text' value='"+receb_mov_id+"'></div></div>";
                itens += "</div>";
            }

            $('.append_itens_carnet').append(itens);

            $('#modal_carne_titulos').modal('show');

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });


    $('.j_click_gerar_recibo_titulos').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_remove_recibo').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            var itens = "";
            var chaves = [];

            for(var i = 0; i < count; i++){
                chaves.push($('#table').bootstrapTable('getSelections')[i].receb_mov_id);
            }

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Aberto" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você deve selecionar apenas títulos que já foram Pagos!", "info");

                    return false;
                }

                var data_vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;
                var aluno = $('#table').bootstrapTable('getSelections')[i].fornecedor;
                var pessoa_id = $('#table').bootstrapTable('getSelections')[i].pessoa_id;
                var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                var vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var parcela = $('#table').bootstrapTable('getSelections')[i].parcela;
                var receb_mov_id = $('#table').bootstrapTable('getSelections')[i].receb_mov_id;

                itens += "<div class='row list_remove_recibo'>";
                itens += "<div class='col-md-2'><div class='form-group'><label>Parcela</label>";
                itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='"+vencimento+"'></div></div>";
                itens += "<div class='col-md-4'><div class='form-group'><label>Valor Pagamento</label>";
                itens += "<input readonly type='text' value='"+valor+"' class='form-control'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Movimentação</label><input readonly class='form-control' type='text' value='"+receb_mov_id+"'></div></div>";
                itens += "</div>";
            }

            $('.append_itens_recibo').append(itens);

            $('#modal_recibo_titulos').modal('show');

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });


    $('.j_click_calcular_debitos_titulos').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_remove_item_calculo').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            var valor_total = 0;
            var titulosId = "qtd=" + count;

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você selecionou títulos que já foram Pagos!", "info");

                    return false;
                }

                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;

                titulosId += "&id_" + i + "=" + id;
            }

            titulosId += "&action=buscarParametrosCalculoDebitosParcelas";

            $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', titulosId, function (data) {

                if (data.error) {
                    swal({
                        title: "Opps!",
                        text: data.error,
                        icon: "error",
                        button: "Ok!",
                    });
                }
                if (data.success) {

                    var itens = data.success;

                    $('.append_itens_calculo').append(itens);

                    $('#modal_calculo_debitos_titulos').modal('show');

                }
            }, 'json');

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });


    $(".j_click_marcar_scpc_titulos").click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length >= 1){

            $('.list_remove_titulos_negativado').remove();

            var count = $('#table').bootstrapTable('getSelections').length;

            var itens = "";
            var chaves = [];

            for(var i = 0; i < count; i++){
                chaves.push($('#table').bootstrapTable('getSelections')[i].receb_mov_id);
            }

            for(var i = 0; i < count; i++){

                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                    swal("Opps!", "Você deve selecionar apenas títulos em aberto!", "info");

                    return false;
                }

                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;
                var aluno = $('#table').bootstrapTable('getSelections')[i].fornecedor;
                var pessoa_id = $('#table').bootstrapTable('getSelections')[i].pessoa_id;
                var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                var vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                var parcela = $('#table').bootstrapTable('getSelections')[i].parcela;
                var receb_mov_id = $('#table').bootstrapTable('getSelections')[i].receb_mov_id;

                var explodeData = vencimento.split('/');
                var data = new Date(explodeData[2] + '/' + explodeData[1] + '/' + explodeData[0]);
                var atual = new Date();

                if(data.getTime() > atual.getTime()){

                    swal("Opps!", "Você deve selecionar apenas títulos vencidos!", "info");

                    return false;
                }

                itens += "<div class='row list_remove_titulos_negativado'>";
                itens += "<div class='col-md-2'><div class='form-group'><label>Parcela</label>";
                itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='"+vencimento+"'></div></div>";
                itens += "<div class='col-md-4'><div class='form-group'><label>Valor Pagamento</label>";
                itens += "<input readonly type='text' value='"+valor+"' class='form-control formMoney'></div></div>";
                itens += "<div class='col-md-3'><div class='form-group'><label>Movimentação</label><input readonly class='form-control' type='text' value='"+receb_mov_id+"'></div></div>";
                itens += "</div>";
            }

            $('.append_itens_titulos_negativado').append(itens);

            $('#modal_calculo_titulos_negativad').modal('show');

        } else {
            swal("Opps!", "Para esse função selecione ao menos um título!", "info");
        }

    });


    $('.j_click_transferir_curso').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length == 1){

            var email = $('#table').bootstrapTable('getSelections')[0].email;
            var pessoa_id = $('#table').bootstrapTable('getSelections')[0].id;
            var aluno = $('#table').bootstrapTable('getSelections')[0].nome;
            var turma_id = $('.turma_id').val();

            swal({
                title: "Tem certeza?",
                text: "Ao confirmar você irá remover o vínculo do aluno com essa turma!",
                icon: "warning",
                buttons: ["Não tenho", "Eu tenho"],
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/Turma.ajax.php', {action: 'transferirAlunoTurma', turma_id: turma_id, pessoa_id: pessoa_id}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {

                            $('#table').bootstrapTable('refreshOptions', {
                                showColumns: true,
                                search: true,
                                showRefresh: true,
                                url: base + "_ajax/escola/ListAlunosTurma.ajax.php?action=list&id=" + turma_id
                            });

                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            });

                        }
                    }, 'json');

                }
            });

        } else {
            swal("Opps!", "Para esse função selecione apenas um aluno!", "info");
        }

    });


    $('.j_click_reposicao_aluno').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length == 1){

            var aluno_id = $('#table').bootstrapTable('getSelections')[0].aluno_id;
            var aluno = $('#table').bootstrapTable('getSelections')[0].aluno;



            window.location.href = "painel.php?exe=escola/alunos/filtro_reposicao&id=" + aluno_id;


        } else {
            swal("Opps!", "Para esse função selecione apenas um aluno!", "info");
        }

    });


    $('.j_click_transferir_aluno').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length == 1){

            var id = $('#table').bootstrapTable('getSelections')[0].id;
            var aluno_id = $('#table').bootstrapTable('getSelections')[0].aluno_id;
            var aluno = $('#table').bootstrapTable('getSelections')[0].aluno;

            $("#solicitacao_id").val(id);
            $("#txt_aluno").val(aluno);


            $("#modal_transferencia_aluno").modal('show');


        } else {
            swal("Opps!", "Para esse função selecione apenas um aluno!", "info");
        }

    });


    $('.j_click_cancelar_curso').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length == 1){

            var email = $('#table').bootstrapTable('getSelections')[0].email;
            var pessoa_id = $('#table').bootstrapTable('getSelections')[0].id;
            var aluno = $('#table').bootstrapTable('getSelections')[0].nome;
            var turma_id = $('.turma_id').val();

            swal({
                title: "Tem certeza?",
                text: "Ao confirmar você irá cancelar a matrícula do aluno e todos os seus títulos em aberto!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/Turma.ajax.php', {action: 'cancelarAlunoTurma', turma_id: turma_id, pessoa_id: pessoa_id}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {

                            $('#table').bootstrapTable('refreshOptions', {
                                showColumns: true,
                                search: true,
                                showRefresh: true,
                                url: base + "_ajax/escola/ListAlunosTurma.ajax.php?action=list&id=" + turma_id
                            });

                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            }).then((value) => {

                                if (data.redirect) {

                                    window.setTimeout(function () {
                                        window.location.href = data.redirect;
                                        if (window.location.hash) {
                                            window.location.reload();
                                        }
                                    }, 500);

                                }

                            });

                        }
                    }, 'json');

                }
            });

        } else {
            swal("Opps!", "Para esse função selecione apenas um aluno!", "info");
        }

    });

    $('.j_click_trancar_curso').click(function (e) {
        e.preventDefault();

        if($('#table').bootstrapTable('getSelections').length == 1){

            var email = $('#table').bootstrapTable('getSelections')[0].email;
            var pessoa_id = $('#table').bootstrapTable('getSelections')[0].id;
            var aluno = $('#table').bootstrapTable('getSelections')[0].nome;
            var turma_id = $('.turma_id').val();

            swal({
                title: "Tem certeza?",
                text: "Ao confirmar você irá trancar a matrícula do aluno para esse curso!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/Turma.ajax.php', {action: 'trancarAlunoTurma', turma_id: turma_id, pessoa_id: pessoa_id}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {

                            $('#table').bootstrapTable('refreshOptions', {
                                showColumns: true,
                                search: true,
                                showRefresh: true,
                                url: base + "_ajax/escola/ListAlunosTurma.ajax.php?action=list&id=" + turma_id
                            });

                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            }).then((value) => {

                                if (data.redirect) {

                                    window.setTimeout(function () {
                                        window.location.href = data.redirect;
                                        if (window.location.hash) {
                                            window.location.reload();
                                        }
                                    }, 500);

                                }

                            });

                        }
                    }, 'json');

                }
            });

        } else {
            swal("Opps!", "Para esse função selecione apenas um aluno!", "info");
        }

    });

    function numberToReal(numero) {
        var numero = numero.toFixed(2).split('.');
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
        return numero.join(',');
    }

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };

    $(document).on('keyup mouseup', '.qtd_itens_list', function () {

        var qtd = $(this).val();
        if(qtd <= 0){
            $(this).val('1');
            qtd = 1;
        }

        var totalClass = $(this).attr('data-total');
        var unitario = $(this).attr('data-uni');
        var novo = numberToReal(parseFloat(qtd*unitario));
        $("." + totalClass).val(novo);

        setTimeout(function () {

            $('.formMoney').mask('#.##0,00', {reverse: true});
            $(".dinheiro").mask('#.##0,00', {reverse: true});

            var valor_total = 0;

            $('.valor_total_tabela').each(function(){
                valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
            });

            $('.valor_total').val(numberToReal(valor_total));

        }, 100);

    });

    $(".jsys_modalidades").change(function () {

        $.post(base + '_ajax/escola/Turma.ajax.php', {action: 'buscarModalidadeGrade', modalidade: $(this).val()}, function (data) {

            $('.jsys_carga_horaria_turma option').remove();
            $('.jsys_carga_horaria_turma').attr('disabled', true);

            if (data.error) {
                $('.jsys_carga_horaria_turma').append('<option value="0" selected disabled>Selecione uma carga horária</option>');
            }
            if (data.success) {
                $('.jsys_carga_horaria_turma').attr('disabled', false);
                $('.jsys_carga_horaria_turma').append('<option value="0" selected disabled>Selecione uma carga horária</option>');
                $('.jsys_carga_horaria_turma').append(data.success);
            }
        }, 'json');

    });

    $(".j_abrirAnexos").click(function () {

        var tabela = $(this).attr('data-tabela-id');
        var origem = $(this).attr('data-origem');
        var tipo = $(this).attr('data-tipo');

        if(tipo == 0){
            $(".form_anexo_sistema").css("display", "none");
        }

        $(".tabelaid_anexo").val(tabela);
        $(".origemid_anexo").val(origem);

        $.post(base + '_ajax/escola/Anexos.ajax.php', {action: 'buscarAnexos', tabela: tabela, origem: origem}, function (data) {

            if (data.success) {
                $('.anexos_list').remove();
                $('.corpo_tabela_anexo').append(data.success);
                $("#abrirAnexos").modal("show");
            }
        }, 'json');

        return false;
    });

    $(".tabela_turma_materias_aulas").on("click", ".materia_check", function () {

        var conteudos = "";

        $.each($(".materia_check"), function(id , val){

            if($(val).is(":checked")){

                if (conteudos != ""){
                    conteudos += ", " + $(this).attr('data-nome');
                } else {
                    conteudos += $(this).attr('data-nome');
                }


            } else {

                conteudos += "";

            }
        });

        $(".materias_da_aula").val(conteudos);
    });

    $('.j_editar_conteudo').on('dblclick', 'span', function () {

        swal({
            title: "Deseja remover?",
            text: "Tem certeza que deseja remover esse item?",
            icon: "warning",
            buttons: ['Não Quero', "Remover"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                console.log($(this).attr('id'));

                /*var data = ev.dataTransfer.getData("text");
                var tipo = data.split("_");
                ev.target.appendChild(document.getElementById(data));

                document.getElementById(data).style.margin = "0px 0px 0px 0px";

                if(tipo[1] == "materia"){
                    document.getElementById(data).style.backgroundColor = "red";
                    document.getElementById(data).style.color = "white";
                    document.getElementById(data).style.margin = "0px 3px 0px 0px";
                }

                if(tipo[1] == "atividade"){
                    document.getElementById(data).style.backgroundColor = "orange";
                    document.getElementById(data).style.color = "white";
                    document.getElementById(data).style.margin = "0px 3px 0px 0px";
                }

                if(tipo[1] == "homework"){
                    document.getElementById(data).style.backgroundColor = "blue";
                    document.getElementById(data).style.color = "white";
                    document.getElementById(data).style.margin = "0px 3px 0px 0px";
                }

                if(tipo[1] == "exercicios"){
                    document.getElementById(data).style.backgroundColor = "green";
                    document.getElementById(data).style.color = "white";
                    document.getElementById(data).style.margin = "0px 3px 0px 0px";
                }*/

                $(this).remove();

            } else { }
        });

    });

});

  /**
     *  POLITICA DE ACRÉSCIMO TABELA DINÂMICA
     */
    var $TABLE_POLITICA_ACRESCIMO = $('.table_politica_acrescimo');
    var numero_politica_acrescimo = $('.quantidade_politica_acrescimo').val();

    $('.table-add-politica_acrescimo').click(function (e) {
        e.preventDefault();
        numero_politica_acrescimo++;
        $('.quantidade_politica_acrescimo').val(numero_politica_acrescimo);

        $.post(base + '_ajax/politica_comercial/PoliticaAcrescimo.ajax.php', {callback: 'PoliticaAcrescimo', action: 'add_linha', numero: numero_politica_acrescimo}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE_POLITICA_ACRESCIMO.append(data.success);
            }
        }, 'json');
    });

    $('.table_politica_acrescimo').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover essa politica de acréscimo?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/politica_comercial/PoliticaAcrescimo.ajax.php', {callback: 'PoliticaAcrescimo', action: 'remove', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            }).then((value) => {

                                if (data.redirect) {

                                    window.setTimeout(function () {
                                        window.location.href = data.redirect;
                                        if (window.location.hash) {
                                            window.location.reload();
                                        }
                                    }, 500);

                                }

                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });

      /**
     *  PARENTE ALUNO TABELA DINÂMICA
     */
    var $TABLE_PARENTE = $('.table_parente_aluno');
    var numero_parente = $('.quantidade_parente_aluno').val();

    $('.table-add-parente').click(function (e) {
        e.preventDefault();
        numero_parente++;
        $('.quantidade_parente_aluno').val(numero_parente);

        $.post(base + '_ajax/escola/ParenteAluno.ajax.php', {callback: 'ParenteAluno', action: 'add_linha', numero: numero_parente}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE_PARENTE.append(data.success);
            }
        }, 'json');
    });

    $('.table_parente_aluno').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover essa indicação?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/ParenteAluno.ajax.php', {callback: 'ParenteAluno', action: 'remove', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                                title: "Bom trabalho!",
                                text: data.success,
                                icon: "success",
                                button: "Ok!",
                            }).then((value) => {

                                if (data.redirect) {

                                    window.setTimeout(function () {
                                        window.location.href = data.redirect;
                                        if (window.location.hash) {
                                            window.location.reload();
                                        }
                                    }, 500);

                                }

                            });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });


    /**
     *  MATERIAIS ESTÁGIO TABELA DINÂMICA
     */
    var $TABLE_MATERIAIS_ESTAGIO = $('.table_materiais_estagio');
    var numero_materiais_estagio = $('.quantidade_material_estagio').val();

    $('.table-add-materiais-estagio').click(function (e) {
        e.preventDefault();
        numero_materiais_estagio++;
        $('.quantidade_material_estagio').val(numero_materiais_estagio);

        $.post(base + '_ajax/escola/MateriaisEstagio.ajax.php', {callback: 'MateriaisEstagio', action: 'add_linha', numero: numero_materiais_estagio}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $TABLE_MATERIAIS_ESTAGIO.append(data.success);
            }
        }, 'json');
    });

    $('.table_materiais_estagio').on('click', '.table-remove', function () {
        remove = $(this);
        if($(this).attr('rel')){
            swal({
                title: "Deseja excluir?",
                text: "Você tem certeza que deseja remover esse material?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.post(base + '_ajax/escola/MateriaisEstagio.ajax.php', {callback: 'MateriaisEstagio', action: 'remove', del_id: $(this).attr('rel')}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }

                        if (data.success) {
                            remove.parents('tr').detach();
                            swal({
                    title: "Bom trabalho!",
                    text: data.success,
                    icon: "success",
                    button: "Ok!",
                }).then((value) => {

                    if (data.redirect) {

                        window.setTimeout(function () {
                            window.location.href = data.redirect;
                            if (window.location.hash) {
                                window.location.reload();
                            }
                        }, 500);

                    }

                });
                        }
                    }, 'json');

                }
            });
        } else {
            remove.parents('tr').detach();
        }
    });

    $(".j_change_natureza_geral").change(function () {

        $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', {action: 'buscarResponsavel', id: $(this).val()}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $('#geral_ocorrencia_encaminha_id').val(data.success.pessoa_id);
                $('#txt_encaminha_geral').val(data.success.pessoa_nome);
            }
        }, 'json');

    });

    /*
        CLICK NEGOCIAÇÃO TÍTULOS ALUNO
     */
    $(".j_nao_possui_negociacao").click(function () {

        swal({
            title: "Opps!",
            text: "Aluno não possui nenhum título para renegociação.",
            icon: "warning",
            button: "Ok!",
        });

    });

    $(".expirar_orcamento_matricula_button").click(function () {

        $.post(base + '_ajax/pedido/Matricula.ajax.php', {action: 'expirarOrcamento', id: $(this).attr('rel')}, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                swal({
                    title: "Bom trabalho!",
                    text: data.success,
                    icon: "success",
                    button: "Ok!",
                })
            }

        }, 'json');

        return false;

    });