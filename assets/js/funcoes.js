$(function () {

    var base = $('link[rel="base"]').attr('href') + "/";

    function trigger(data) {
        if(data[0]){
            $.each(data, function(key, value){
                triggerNotify(data[key]);
            })
        } else {
            triggerNotify(data);
        }
    }

    $(function () { //ready
        $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
    });


    $('body').on('focus', 'input[data-mask="hour"]', function(){
        $(this).mask("00:00");
        });


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

    $('html, body').on('click', '.j_delete_action_confirm', function (e) {
        var Prevent = $(this);
        var DelId = $(this).attr('id');
        var Callback = $(this).attr('callback');
        var Callback_action = $(this).attr('action');
        Prevent.find('.form_load').css('display', 'inline');

        swal({
            title: "Deseja excluir?",
            text: "Você tem certeza que deseja remover esse item?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                $.post(base + '_ajax/' + Callback + '.ajax.php', {callback: Callback, action: Callback_action, del_id: DelId}, function (data) {

                    if (data.error) {
                        trigger(data.error);
                    }
                    if (data.success) {
                        trigger(data.success);
                    }

                    //REDIRECIONA
                    if (data.redirect) {

                        window.setTimeout(function () {
                            window.location.href = data.redirect;
                            if (window.location.hash) {
                                window.location.reload();
                            }
                        }, 1500);

                    } else {
                        Prevent.find('.form_load').fadeOut();
                    }
                }, 'json');

            }
        });

        e.preventDefault();
        e.stopPropagation();
    });

    $('.form_pesquisa').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var form = $(this);
        var Callback = $('.Callback').val();
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        $('.result_search').empty();

        $.post(base + '_ajax/' + Callback + '.ajax.php', formData, function (data) {

            if (data.content) {
                $('.result_search').append(data.content);
            } else {

                form.prepend("<div class='trigger trigger_error ajax_close'>Não encontrado</div>");
            }

        }, 'json');

    });




    $('.form_colaborador').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/Colaborador.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

  


    $('.form_funcoes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Funcao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_fornecedor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/fornecedores/Fornecedor.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


$('.form_pedido_compra').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/suprimentos/Suprimentos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
    $('.form_aluno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Aluno.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_extra_professor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/AtividadeExtra.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
 
    $('.form_grupo_pedagogico').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/GrupoPedagogico.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_franquia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Franquia.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_grau_escolaridade').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/GrauEscolaridade.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_planejamento_aulas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/PlanejamentoAula.ajax.php', formData, function (data) {

            form.find('.form_load').fadeOut();
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
                }).then((value) => {

                    if (value) {

                        window.setTimeout(function () {
                            window.location.href = "painel.php?exe=escola/turma/planejamento_sucesso";
                            if (window.location.hash) {
                                window.location.reload();
                            }
                        }, 500);
                    }

                });
            }
        }, 'json');

        return false;
    });


    

    $('.form_grau_parentesco').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/GrauParentesco.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_int_tipo_contrato').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/IntTipoContrato.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_modalidades').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Modalidade.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivos_cancelamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoCancelamento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivos_desistencias').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivosDesistencias.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivo_nao_fechamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoNaoFechamento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivo_reat_venda').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoReatVenda.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivo_tranc_matricula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoTrancMatricula.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_motivo_transferencia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoTransferencia.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ocorrencias_natureza').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/OcorrenciaNatureza.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ocorrencias_tipo_acao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/OcorrenciaTipoAcao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ocupacoes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Ocupacoes.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_operadoras_celular').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/OperadoraCelular.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_origem').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Origem.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_autor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Autor.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

   $('.form_classificacao_literaria').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/ClassificacaoLiteraria.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


    $('.form_idioma').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Idioma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_periodo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Periodo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_promocoes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Promocao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_segmento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Segmento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

  

    $('.form_tipo_acrescimo_abatimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoAcrescimoAbatimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_carta_cobranca').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoCartaCobranca.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_desconto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoDesconto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_carta_quitacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoCartaQuitacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_franquia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoFranquia.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_obra').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoObra.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_produto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/produto/TipoProduto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_prestador').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/fornecedores/Prestador.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });



    $('.form_categoria_anexo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaCategoriaAnexo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_categoria_treinamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaCategoriaTreinamento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_faq').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaFaq.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_origem_materia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaOrigemMateria.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_portal').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaTipoPortal.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_contratos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/documentos/TipoContratos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_estagio_contrato').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/documentos/EstagioContrato.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });



    $('.form_niveis_acesso').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/NiveisAcesso.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_cadastro_funcionalidade').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Funcionalidades.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-acessos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Acessos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_sala').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Sala.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


    $('.form_produto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        form.ajaxSubmit({
            url: base + '_ajax/produto/Produto.ajax.php',
            data: "",
            dataType: 'json',
            beforeSubmit: function () {
                form.find('.form_load').fadeIn('fast');
                $('.trigger_ajax').fadeOut('fast');
            },
            uploadProgress: function (evento, posicao, total, completo) {

            },
            success: function (data) {
                //REMOVE LOAD
                form.find('.form_load').fadeOut('slow', function () {
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

                });
            }
        });

        return false;
    });

  
     $('.form_curso').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Curso.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_turma').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Turma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_acompanhemento_aulas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Turma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


    $('.form_lista_assinatura').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Turma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    


    $('.form_avaliacao_turma').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/AvaliacaoTurma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_instituicao_financeira').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/InstituicaoFinanceira.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_movimentacao_pagamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);

         if(controlaSubmeterForm == false && $(".movimentacao_pago_recebido").val() == 1){

             var valor_total = $(".movimentacao_valor_total").val();

             if(valor_total != undefined && valor_total != ""){

                 valor_total = parseFloat(valor_total.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

             } else {

                 swal("Opps!", "Insira um valor!", "info");

                 return false;
             }

             var cliente_id = $('#txt_id_fornecedor').val();
             var nome_cliente = $('#nome_fornecedor').val();

             if(cliente_id != undefined && cliente_id != "" && nome_cliente != undefined && nome_cliente != ""){

                 abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, numberToReal(valor_total), '.form_movimentacao_pagamento');

             } else {
                 swal("Opps!", "Escolha um fornecedor!", "info");

                 return false;
             }

             return false;
         }

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoPagamento.ajax.php', formData + '&' + FormCamposParcelas, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {
                controlaSubmeterForm = false;
                
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }
            if (data.success) {
                controlaSubmeterForm = false;
                FormCamposParcelas = false;
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

        return false;
    });

    $('.form_movimentacao_recebimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);

          if(controlaSubmeterForm == false && $(".movimentacao_pago_recebido").val() == 1){

              var valor_total = $(".movimentacao_valor_total").val();

              if(valor_total != undefined && valor_total != ""){

                  valor_total = parseFloat(valor_total.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

              } else {

                  swal("Opps!", "Insira um valor!", "info");

                  return false;
              }

              var cliente_id = $('#txt_id_fornecedor').val();
              var nome_cliente = $('#txt_fornecedor').val();

              if(cliente_id != undefined && cliente_id != "" && nome_cliente != undefined && nome_cliente != ""){

                  abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, numberToReal(valor_total), '.form_movimentacao_recebimento');

              } else {
                  swal("Opps!", "Escolha um cliente / aluno!", "info");

                  return false;
              }

              return false;
          }

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData+ '&' + FormCamposParcelas, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_tipo_conta_bancaria').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/TipoContaBancaria.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_modelo_contrato').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/documentos/ModeloContrato.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

  
     $('.form_contrato').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/documentos/Contrato.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
 

    $('.form_movimento_estoque').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/produto/MovimentacaoEstoque.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };

    var pagamentoEntrega = "";
    $('.matricula_close_parcelas').click(function () {

        var valorEntrada = 0;
        var valor = 0;

        $.each($('.proposta_valor_entrada'), function(index, value) {
            if(value.value != "" && value.value != undefined) {
                valorEntrada += parseFloat(value.value.replaceAll(".", "").replace(",", "."));
            }
        });

        $.each($('.valor_valor_entrada'), function(index, value) {

            if(value.value != "" && value.value != undefined) {
                valor += parseFloat(value.value.replaceAll(".", "").replace(",", "."));
                pagamentoEntrega += "&forma_"+index+"="+$('.' + value.accessKey).val() + "&valor_"+index+"="+value.value;
            }
        });

        pagamentoEntrega += "&numeroParcela="+$('.quantidade_entrada_itens_matricula').val();

        if(valorEntrada == valor){
            $('.definir_forma_pagamento').attr('disabled', true);
            $('.lancar_pedido').attr('disabled', false);
        } else {
            $('.lancar_pedido').attr('disabled', true);
            $('.definir_forma_pagamento').attr('disabled', false);
        }

    });

    var tipo = null;

    $(".lancar_matricula_button").click(function () {

        tipo = "1";

    });

    $(".orcamento_matricula_button").click(function () {

        tipo = "2";

    });

    $('.form_pedido_matricula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);

        if(controlaSubmeterForm == false) {

            var telefone = $(".telefone_contato").val();
            var turma = $("#txt_turma").val();

            var checkTurma = 0;
            var checkEspera = 0;

            if(turma == undefined || turma == "" || turma == null){
                checkTurma = 0;
            } else {
                checkTurma = 1;
            }

            if(telefone == undefined || telefone == "" || telefone == null){
                checkEspera = 0;
            } else {
                checkEspera = 1;
            }

            if(checkTurma == 0 && checkEspera == 0){
                swal("Opps!", "Escolha uma turma ou lista de espera!", "info");
                return false;
            }

            var valor_total = 0;
            var valorTotalEntrada = 0;
            var valorTotalaVista = 0;

            $.each($('.proposta_item_forma_parcelamento'), function(index, value) {
                if(value.value == 1){
                    valorTotalaVista += parseFloat($(this).attr('accesskey'));
                }
            });

            $.each($('.proposta_valor_entrada'), function(index, value) {
                if(value.value != "" && value.value != undefined && value.value != 0){
                    valorTotalEntrada += parseFloat(value.value.replaceAll(".", "").replace(",", "."));
                }
            });

            valor_total = valorTotalaVista + valorTotalEntrada;

            var cliente_id = $('#txt_id_aluno').val();
            var nome_cliente = $('#txt_aluno').val();

            if(valor_total > 0) {

                if (cliente_id != undefined && cliente_id != "" && nome_cliente != undefined && nome_cliente != "") {
                    abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, numberToReal(valor_total), '.form_pedido_matricula');
                } else {
                    swal("Opps!", "Escolha um cliente!", "info");
                }

                return false;
            }
        }

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        var idProdutos = "";
        $.each($('.j_produto_proposta'), function(index, value) {
            idProdutos += "&curso_id=" + value.accessKey;
        });

        $.post(base + '_ajax/pedido/Matricula.ajax.php', formData + '' + idProdutos + '&tipo_matricula=' + tipo + '&' + FormCamposParcelas, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {
                controlaSubmeterForm = false;

                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }
            if (data.success) {
                controlaSubmeterForm = false;
                FormCamposParcelas = false;

                swal({
                    title: data.titulo,
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

        return false;
    });

     $('.form_pedido').submit(function () {

         var formData = $(this).serialize();
         var form = $(this);

         if(controlaSubmeterForm == false){

             var valor_total = $(".valor_total_list_pedidos").text();

             if(valor_total != undefined && valor_total != ""){

                 valor_total = parseFloat(valor_total.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

             } else {

                 swal("Opps!", "Insira algum produto no carrinho!", "info");

                 return false;
             }

             var cliente_id = $('#txt_id_aluno').val();
             var nome_cliente = $('#txt_aluno').val();

             if(cliente_id != undefined && cliente_id != "" && nome_cliente != undefined && nome_cliente != ""){

                 abrirFormasDePagamentoGerarCaixaPedidoMatricula(cliente_id, nome_cliente, numberToReal(valor_total), '.form_pedido');

             } else {
                 swal("Opps!", "Escolha um cliente!", "info");

                 return false;
             }

             return false;
         }

         form.find('.form_load').css('display', 'inline');
         $('.ajax_close').fadeOut();
         var idProdutos = "";
         $.each($('.produto_id_venda'), function(index, value) {
             idProdutos += "&produto_id_" + index + "=" + value.value;
         });

         $.post(base + '_ajax/pedido/Pedido.ajax.php', formData + '' + idProdutos + '&qtd=' + $('.produto_id_venda').length + '&' + FormCamposParcelas, function (data) {
             form.find('.form_load').fadeOut();

             if (data.error) {
                 controlaSubmeterForm = false;

                 swal({
                     title: "Opps!",
                     text: data.error,
                     icon: "error",
                     button: "Ok!",
                 });

             }
             if (data.success) {
                 controlaSubmeterForm = false;
                 FormCamposParcelas = false;

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

         return false;
     });

     $('.form_conta_bancaria').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/ContaBancaria.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_estagio_projeto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/EstagioProjeto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_envolvido_projeto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoEnvolvidoProjeto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_convenio').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Convenio.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_proposta').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
         var idProdutos = "";
         $.each($('.j_produto_proposta'), function(index, value) {
             idProdutos += "&" + value.name + "_id=" + value.accessKey;
         });

        $.post(base + '_ajax/pedido/Proposta.ajax.php', formData + '' + idProdutos, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_telefone').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TipoTelefone.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_treinamentos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Treinamentos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_escola_colecao_livros').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaColecaoLivros.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_livros').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EscolaLivros.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_sys_escola').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/Escola.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_sys_rateio_matricula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/PlanoContas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


     $('.form_empresas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Empresas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_centro_custo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/contabil/CentroCusto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_conta_contabil').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/contabil/ContaContabil.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_unidades').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Unidades.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_acervo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Acervo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_editora').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Editora.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

   

     $('.form_etapa_produto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EtapaProduto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_avaliacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/TipoAvaliacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_formulacao_nota').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/FormulacaoNota.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_feriado').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Feriado.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_mensagem').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Mensagens.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_coordenadoria').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Coordenadorias.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_grupo_economico').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/GrupoEconomico.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_grupo_marketing').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/GrupoMarketing.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_itinerario').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/transporte/Itinerario.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_caixa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

         swal({
             title: "Você tem certeza?",
             text: "Tem certeza que deseja prosseguir com a operação?",
             icon: "warning",
             buttons: ['Não quero', "Continuar"],
             dangerMode: true,
         }).then((willDelete) => {
             if (willDelete) {
                 $.post(base + '_ajax/financeiro/Caixa.ajax.php', formData, function (data) {
                     form.find('.form_load').fadeOut();
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

        return false;
    });
 
  
    $('.form_caixa_conferencia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/Caixa.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
 


     $('.form_forma_pagamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/FormaPagamento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_avaliacoes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Avaliacoes.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_avaliacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Avaliacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_plano_contas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/PlanoContas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipos_doc_liquidacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/TiposDocLiquidacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_estagio_curso').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EstagioCurso.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_cargo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/Cargo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_forma_parcelamento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/FormaParcelamento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_origem_interesse').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/OrigemInteresse.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_motivo_interesse').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/MotivoInteresse.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_atendimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/TipoAtendimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_atendimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Atendimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_tipo_teste_nivel').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/TipoTesteNivel.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_menu').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/Menu.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_submenu').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/SubMenu.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_resposta').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/RespostaTipoAtendimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_acoes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/ProximasAcoes.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

            }        }, 'json');

        return false;
    });

     $('.form_dias_vencimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/DiasVencimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_juros_multa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/JurosMulta.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_descontos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/Descontos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_professor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Professor.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_prospeccao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Prospeccao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_materias_aula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/MateriasAula.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-relacao-coordenador-professor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/RelacaoCoordenadorProfessor.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-relacao-gerente-consultor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/RelacaoGerenteConsultor.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-relacao-gerente-campo-consultor-campo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/RelacaoGerenteCampoConsultorCampo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-habilitacao-professor').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/HabilitacaoProfessorMateria.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-acessos-menus').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/Menu.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form-cadastro-acessos-submenus').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/SubMenu.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ocorrencia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_teste_pessoa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/TipoTeste.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_testes_pessoa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/TestePessoa.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('select[name=transacao_caixa_tipo_id]').change(function() {        

        if($('select[name=transacao_caixa_tipo_id]').val() == 1) {

            $('#btn_tipo').html('LANÇAR ENTRADA DE CAIXA');

        } else {

            $('#btn_tipo').html('LANÇAR SAÍDA DE CAIXA');
        }       

    });

    $('.form_transacao_caixa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);

        if(controlaSubmeterForm == false && $(".transacao_caixa_tipo_id").val() == 1){

            var valor_total = $(".transacao_caixa_valor").val();

            if(valor_total != undefined && valor_total != ""){

                valor_total = parseFloat(valor_total.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));

            } else {

                swal("Opps!", "Insira um valor!", "info");

                return false;
            }

            var cliente_id = 1;
            var nome_cliente = "Transação Manual de Caixa";

            if(cliente_id != undefined && cliente_id != "" && nome_cliente != undefined && nome_cliente != ""){

                abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, numberToReal(valor_total), '.form_transacao_caixa');

            } else {
                swal("Opps!", "Escolha um fornecedor!", "info");

                return false;
            }

            return false;
        }

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/TransacaoCaixa.ajax.php', formData+ '&' + FormCamposParcelas, function (data) {
            form.find('.form_load').fadeOut();
           if (data.error) {

               controlaSubmeterForm = false;

                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }
            if (data.success) {

                controlaSubmeterForm = false;
                FormCamposParcelas = false;

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

        return false;
    });

    $('.form_quiz').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        form.ajaxSubmit({
            url: base + '_ajax/escola/Quiz.ajax.php',
            data: "",
            dataType: 'json',
            beforeSubmit: function () {
                form.find('.form_load').fadeIn('fast');
                $('.trigger_ajax').fadeOut('fast');
            },
            uploadProgress: function (evento, posicao, total, completo) {

            },
            success: function (data) {
                //REMOVE LOAD
                form.find('.form_load').fadeOut('slow', function () {
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

                });
            }
        });
        return false;
    });

    $('.form_quiz_pergunta').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/QuizPerguntas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_quiz_respostas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/QuizRespostas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.jsys_coordenador_professor').on('change', function () {
        $('#select_professores option').remove();
        var formData = "action=coordenador_professor&coordenador=" + $(this).val();
        $.post(base + '_ajax/escola/RelacaoCoordenadorProfessor.ajax.php', formData, function (data) {
            $('#select_professores option').remove();
            $("#select_professores").selectpicker('refresh');
            if (data.error) {
                $('#select_professores').append('<option value="0" disabled>Selecione os professores</option>');
                $("#select_professores").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_professores').append('<option value="0" disabled>Selecione as professores</option>');
                $("#select_professores").selectpicker('refresh');
                $('#select_professores').append(data.success);
                $("#select_professores").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.j_modalidade_conteudo').on('change', function () {
        $('.j_carga_horaria_conteudo option').remove();
        $('.modalidade_id').val($(this).val());
        var formData = "action=buscarCargaHoraria&modalidade=" + $(this).val();
        $.post(base + '_ajax/escola/ConteudoProgramatico.ajax.php', formData, function (data) {
            $('.j_carga_horaria_conteudo option').remove();

            if (data.error) {
                $(".div_carga_horaria_conteudo").fadeIn();
                $('.j_carga_horaria_conteudo').append('<option value="0" selected disabled>Selecione uma carga horária</option>');
            }
            if (data.success) {
                $(".div_carga_horaria_conteudo").fadeIn();
                $('.j_carga_horaria_conteudo').append('<option value="0" selected disabled>Selecione uma carga horária</option>');
                $('.j_carga_horaria_conteudo').append(data.success);
            }
        }, 'json');
    });

    $('.j_carga_horaria_conteudo').on('change', function () {

        var splitCarga = $(this).val().split(",");
        var qtd_carga = splitCarga[1];
        var carga_id = splitCarga[0];
        var modalidade = $('.j_modalidade_conteudo').val();

        $(".j_drag_active").attr('draggable', true);

        var formData = "action=carregarCargaHoraria&carga_id="+carga_id+"&carga=" + qtd_carga + "&modalidade=" + modalidade + "&estagio_id=" + $(".estagio_produto_id").val();
        $.post(base + '_ajax/escola/ConteudoProgramatico.ajax.php', formData, function (data) {

            if (data.redirect) {

                window.setTimeout(function () {
                    window.location.href = data.redirect;
                    if (window.location.hash) {
                        window.location.reload();
                    }
                }, 1500);

            }

        }, 'json');
    });

    $('.jsys_gerente_consultor').on('change', function () {
        $('#select_consultores option').remove();
        var formData = "action=gerente_consultor&gerente=" + $(this).val();
        $.post(base + '_ajax/escola/RelacaoGerenteConsultor.ajax.php', formData, function (data) {
            $('#select_consultores option').remove();
            $("#select_consultores").selectpicker('refresh');
            if (data.error) {
                $('#select_consultores').append('<option value="0" disabled>Selecione os consultores</option>');
                $("#select_consultores").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_consultores').append('<option value="0" disabled>Selecione as consultores</option>');
                $("#select_consultores").selectpicker('refresh');
                $('#select_consultores').append(data.success);
                $("#select_consultores").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.jsys_gerente_consultor_campo').on('change', function () {
        $('#select_consultores option').remove();
        var formData = "action=gerente_consultor&gerente=" + $(this).val();
        $.post(base + '_ajax/escola/RelacaoGerenteCampoConsultorCampo.ajax.php', formData, function (data) {
            $('#select_consultores option').remove();
            $("#select_consultores").selectpicker('refresh');
            if (data.error) {
                $('#select_consultores').append('<option value="0" disabled>Selecione os consultores</option>');
                $("#select_consultores").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_consultores').append('<option value="0" disabled>Selecione as consultores</option>');
                $("#select_consultores").selectpicker('refresh');
                $('#select_consultores').append(data.success);
                $("#select_consultores").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.jsys_habilitacao_professor_materia').on('change', function () {
        $('.table_habilitacao').remove();
        var formData = "action=professor_materia&professor=" + $(this).val();
        $.post(base + '_ajax/escola/HabilitacaoProfessorMateria.ajax.php', formData, function (data) {
            if (data.error) {
                $('.table').append("<tr><td>Selecione um professor</td></tr>");
            }
            if (data.success) {
                $('.table').append(data.success);
            }
        }, 'json');
    });

$('.form_livro_download').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/LivroDownload.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
    
    $('.form_livro_dica').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/LivroDica.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

   $('.form_download').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        form.ajaxSubmit({
            url: base + '_ajax/escola/Download.ajax.php',
            data: "",
            dataType: 'json',
            beforeSubmit: function () {
                form.find('.form_load').fadeIn('fast');
                $('.trigger_ajax').fadeOut('fast');
            },
            uploadProgress: function (evento, posicao, total, completo) {

            },
            success: function (data) {
                //REMOVE LOAD
                form.find('.form_load').fadeOut('slow', function () {

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

                });
            }
        });
        return false;
    });

    $('.form_anexo_sistema').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        form.ajaxSubmit({
            url: base + '_ajax/escola/Anexos.ajax.php',
            data: "",
            dataType: 'json',
            beforeSubmit: function () {
                form.find('.form_load').fadeIn('fast');
                $('.trigger_ajax').fadeOut('fast');
            },
            uploadProgress: function (evento, posicao, total, completo) {

            },
            success: function (data) {
                //REMOVE LOAD
                form.find('.form_load').fadeOut('slow', function () {

                    if (data.error) {

                        swal({
                            title: "Opps!",
                            text: data.error,
                            icon: "error",
                            button: "Ok!",
                        });

                    }
                    if (data.success) {
                        $('.anexos_list').remove();
                        $('.corpo_tabela_anexo').append(data.tabela);

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

                    if (data.clear) {
                        $('input[type="text"]').val('');
                        $('input[type="file"]').val('');
                    }

                });
            }
        });
        return false;
    });

    $('.form_recesso').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/Recesso.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ferias').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/Ferias.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_pessoas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Pessoas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_mesas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/restaurante/Mesas.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });
    

    $('.jsys_funcionalidade').on('change', function () {
        $('#select_niveis option').remove();
        var formData = "action=funcionalidaderead&funcionalidade=" + $(this).val() + "&nivelacesso=" + $('.jsys_nivel_acesso').val();
        $.post(base + '_ajax/Acessos.ajax.php', formData, function (data) {

            $('#select_niveis option').remove();
            $("#select_niveis").selectpicker('refresh');
            if (data.error) {
                $('#select_niveis').append('<option value="0" disabled>Selecione as permissões</option>');

                $('#select_niveis').append('<option value="insert">Adicionar</option>');

                $('#select_niveis').append('<option value="update">Editar</option>');

                $('#select_niveis').append('<option value="read">Consultar</option>');

                $('#select_niveis').append('<option value="delete">Remover</option>');

                $("#select_niveis").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_niveis').append('<option value="0" disabled>Selecione as permissões</option>');

                if(data.success.inserir){
                    $('#select_niveis').append('<option value="insert" selected="selected">Adicionar</option>');
                }else{
                    $('#select_niveis').append('<option value="insert">Adicionar</option>');
                }

                if(data.success.alterar){
                    $('#select_niveis').append('<option value="update" selected="selected">Editar</option>');
                }else{
                    $('#select_niveis').append('<option value="update">Editar</option>');
                }

                if(data.success.ler){
                    $('#select_niveis').append('<option value="read" selected="selected">Consultar</option>');
                }else{
                    $('#select_niveis').append('<option value="read">Consultar</option>');
                }

                if(data.success.deletar){
                    $('#select_niveis').append('<option value="delete" selected="selected">Remover</option>');
                }else{
                    $('#select_niveis').append('<option value="delete">Remover</option>');
                }

                $("#select_niveis").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.jsys_nivel_acesso').on('change', function () {
        $('#select_niveis option').remove();
        $("#select_niveis").selectpicker('refresh');
        var formData = "action=funcionalidaderead&funcionalidade=" + $('.jsys_funcionalidade').val() + "&nivelacesso=" + $(this).val();
        $.post(base + '_ajax/Acessos.ajax.php', formData, function (data) {

            if (data.error) {
                $('#select_niveis').append('<option value="0" disabled>Selecione as permissões</option>');

                $('#select_niveis').append('<option value="insert">Adicionar</option>');

                $('#select_niveis').append('<option value="update">Editar</option>');

                $('#select_niveis').append('<option value="read">Consultar</option>');

                $('#select_niveis').append('<option value="delete">Remover</option>');

                $("#select_niveis").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_niveis').append('<option value="0" disabled>Selecione as permissões</option>');

                if(data.success.inserir){
                    $('#select_niveis').append('<option value="insert" selected="selected">Adicionar</option>');
                }else{
                    $('#select_niveis').append('<option value="insert">Adicionar</option>');
                }

                if(data.success.alterar){
                    $('#select_niveis').append('<option value="update" selected="selected">Editar</option>');
                }else{
                    $('#select_niveis').append('<option value="update">Editar</option>');
                }

                if(data.success.ler){
                    $('#select_niveis').append('<option value="read" selected="selected">Consultar</option>');
                }else{
                    $('#select_niveis').append('<option value="read">Consultar</option>');
                }

                if(data.success.deletar){
                    $('#select_niveis').append('<option value="delete" selected="selected">Remover</option>');
                }else{
                    $('#select_niveis').append('<option value="delete">Remover</option>');
                }

                $("#select_niveis").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.jsys_unidade_id_padrao').on('change', function () {

        var formData = "action=unidade&unidade=" + $(this).val();
        $.post(base + '_ajax/admin/Unidades.ajax.php', formData, function (data) {

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
                }).then((value) => {
                    window.setTimeout(function () {
                            window.location.href = window.location.href;
                            if (window.location.hash) {
                                window.location.reload();
                            }
                        }, 500);

                    

                });

            }
        }, 'json');
    });
    
    $('.jsys_relacao_pessoas_unidades_pessoa').on('change', function () {
        $('#select_unidades option').remove();
        var formData = "action=pessoa_unidade&pessoa_id=" + $(this).val();
        $.post(base + '_ajax/admin/Unidades.ajax.php', formData, function (data) {
            $('#select_unidades option').remove();
            $("#select_unidades").selectpicker('refresh');
            if (data.error) {
                $('#select_unidades').append('<option value="0" disabled>Selecione as unidades</option>');
                $("#select_unidades").selectpicker('refresh');
            }
            if (data.success) {
                $('#select_unidades').append('<option value="0" disabled>Selecione as unidades</option>');
                $("#select_unidades").selectpicker('refresh');
                $('#select_unidades').append(data.success);
                $("#select_unidades").selectpicker('refresh');
            }
        }, 'json');
    });

    $('.form_relacao_pessoas_unidades').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/admin/Unidades.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_efetuar_matricula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        $.LoadingOverlay("show");

        $.post(base + '_ajax/escola/Matricula.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {
                $.LoadingOverlay("hide");
                trigger(data.error);
            }
            if (data.success) {
                trigger(data.success);
            }
            if (data.redirect) {

                window.setTimeout(function () {
                    $.LoadingOverlay("hide");
                    window.location.href = data.redirect;
                    if (window.location.hash) {
                        window.location.reload();
                    }
                }, 200);
            }
        }, 'json');

        return false;
    });

    $('.form_indicacao_aluno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/IndicacaoAluno.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_escola_respostas_quiz').submit(function () {

         var formData = $(this).serialize();
         var form = $(this);
         form.find('.form_load').css('display', 'inline');
         $('.ajax_close').fadeOut();

         form.ajaxSubmit({
             url: base + '_ajax/escola/EscolaRespostasQuiz.ajax.php',
             data: "",
             dataType: 'json',
             beforeSubmit: function () {
                 form.find('.form_load').fadeIn('fast');
                 $('.trigger_ajax').fadeOut('fast');
             },
             uploadProgress: function (evento, posicao, total, completo) {

             },
             success: function (data) {
                 //REMOVE LOAD
                 form.find('.form_load').fadeOut('slow', function () {

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

                 });
             }
         });
         return false;
     });

     $('.form_preco_produtos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/PrecoProduto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_interesse').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Interesse.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_politica_acrescimo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/PoliticaAcrescimo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

       $('.form_tipo_evento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/marketing/TipoEvento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

         $('.form_tipo_campanha').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/marketing/TipoCampanha.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

          $('.form_politica_comercial_produto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/PoliticaProduto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

            $('.form_evento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/marketing/Evento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_campanha').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/marketing/Campanha.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $(".imprimir_diario_classe").click(function () {
        window.print();
    });

    $(".form_lista_assinaturas").on('click', "#btn", function () {
        var conteudo = document.getElementById('HTMLtoPDF').innerHTML,
            tela_impressao = window.open('Lista de Assinaturas');

        tela_impressao.document.write(conteudo);
        tela_impressao.window.print();
        tela_impressao.window.close();
    });

    $('.form_etapa_curso').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/EtapaAvaliacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_conteudo_programatico').submit(function (e) {
        e.preventDefault();
        var lista = "";

        $('.itens_conteudo').each(function(entry, index) {
            var aula = $(this).attr('accesskey');

            if($(this).find('span').length != undefined) {

                for(var i = 0; i < $(this).find('span').length; i++){

                    var tipo =  $(this).find('span')[i].id.split("_");
                    if(tipo[1] == "materia"){
                        lista += "aula_" + aula + "-materia_" + $(this).find('span')[i].accessKey + ";";
                    }

                    if(tipo[1] == "atividade"){
                        lista += "aula_" + aula + "-atividade_" + $(this).find('span')[i].accessKey + ";";
                    }

                    if(tipo[1] == "homework"){
                        lista += "aula_" + aula + "-homework_" + $(this).find('span')[i].accessKey + ";";
                    }

                    if(tipo[1] == "exercicios"){
                        lista += "aula_" + aula + "-exercicios_" + $(this).find('span')[i].accessKey + ";";
                    }
                }

            }
        });
        lista = lista.substring(0,(lista.length - 1));

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/ConteudoProgramatico.ajax.php', formData + "&conteudo=" + lista, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.j_sys_busca_data_historico_pedagogico').click(function () {

        var formData = "id="+$('.id_pesquisa').val()+"&action=search&inicio="+$('.data_inicio_busca').val()+"&fim="+$('.data_fim_busca').val();
        var request = $(this).attr('rel');

        $.post(base + "_ajax/"+request+".ajax.php", formData, function (data) {

            if (data.error) {
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });
            }

            if (data.success) {
                $('.list_retorno_search').remove();
                $('.resultado_serch').append(data.success);
            }

        }, 'json');

        return false;
    });

    $('.j_sys_turmas_salas').click(function () {

        var formData = "action=filtro&sala="+$('select[name=sala]').val()
        +"&turma="+$('select[name=turma]').val()+"&situacao="
        +$('select[name=situacao]').val()+"&data="+$('.data').val();

        var request = $(this).attr('rel');

        $('#table').bootstrapTable('refreshOptions', {
            showColumns: true,
            search: false,
            showRefresh: false,
            url: base + "_ajax/"+request+".ajax.php?"+formData
        });

        return false;
    });

    $('select[name=sala]').change(function () {

        if($(this).val() == '') {

            $('select[name=turma').val(''); 

        }

        $('select[name=turma').prop('disabled', true);               

        var formData = $(this).val();

        $.post(base + '_ajax/relatorios/ListTurmasSalas.ajax.php?action=filtro_salas&sala='+$('select[name=sala]').val(), formData, 

        function (data) { 

            $('select[name=turma').html(''); 

            $('select[name=turma').prop('disabled', false);      

            $('select[name=turma]').append("<option value=''>Selecione</option>");

            for(i = 0; i < data.rows.length; i++) {
                
                $('select[name=turma]').append('<option value=' + data.rows[i].id + '>' + data.rows[i].turma + '</option>');

            }                      

        }, 'json');

        return false;
    });

    $('.pdf').click(function () {

        var formData = "action=filtro&sala="+$('select[name=sala]').val()
        +"&turma="+$('select[name=turma]').val()
        +"&situacao="+$('select[name=situacao]').val()
        +"&data="+$('.data').val();      

        $.post(base + '_ajax/relatorios/ListTurmasSalas.ajax.php?'+formData, 

        function (data) { 

            window.open(data.arquivo, '_blank');        

        }, 'json');

        return false;
    });

    $('.pdfTurmasProfessor').click(function () {

        var formData = "action=filtro";      

        $.post(base + '_ajax/relatorios/ListTurmasProfessor.ajax.php?'+formData, 

        function (data) { 

            window.open(data.arquivo, '_blank');        

        }, 'json');

        return false;
    });

    $('.pdfTurmasAlunos').click(function () {

        var formData = "action=filtro";      

        $.post(base + '_ajax/relatorios/ListTurmasAlunos.ajax.php?'+formData, 

        function (data) { 

            window.open(data.arquivo, '_blank');        

        }, 'json');

        return false;
    });

    $('.j_sys_busca_data').click(function () {

        var formData = "action=list&inicio="+$('.data_inicio_busca').val()+"&fim="+$('.data_fim_busca').val();
        var request = $(this).attr('rel');

        $('#table').bootstrapTable('refreshOptions', {
            showColumns: true,
            search: false,
            showRefresh: false,
            url: base + "_ajax/"+request+".ajax.php?"+formData,
            onLoadSuccess: function(status, res) {                  
                $('.texto_trocar').text(status.total + ' títulos em aberto de ' + status.qtd_alunos + " aluno(s), com um valor a receber de R$" + status.valor);
                $('.texto_trocar_parcela').text(status.total + ' parcelas recebidas ' + " de " + status.qtd_alunos + " aluno(s), com o valor total recebido de R$" + status.valor);
            }
        });

        return false;
    });

    $('.j_sys_busca_parcelas_atraso').click(function () {

        var formData = "action=listParcelas&inicio="+$('.inicio_parcela').val()+"&fim="+$('.fim_parcela').val();
        var request = $(this).attr('rel');

        $('#table').bootstrapTable('refreshOptions', {
            showColumns: true,
            search: false,
            showRefresh: false,
            url: base + "_ajax/"+request+".ajax.php?"+formData,
            onLoadSuccess: function(status, res) {                  
                //$('.texto_trocar').text(status.total + ' títulos em aberto de ' + status.qtd_alunos + " aluno(s), com um valor a receber de R$" + status.valor);
                //$('.texto_trocar_parcela').text(status.total + ' parcelas recebidas ' + " de " + status.qtd_alunos + " aluno(s), com o valor total recebido de R$" + status.valor);
            }
        });

        return false;
    });

    $('.j_sys_lancamento_conta').change(function () {

        var formData = "action=list&conta="+$('.conta_busca').val();
        var request = $(this).attr('rel');

        $('#table').bootstrapTable('refreshOptions', {
            showColumns: true,
            search: false,
            showRefresh: true,
            url: base + "_ajax/"+request+".ajax.php?"+formData
        });

        return false;
    });

    $('.j_click_limpa_lookup').click(function () {

        var data_remove1 = $(this).attr('data-remove1');
        $('#'+data_remove1).val('');

        var data_remove2 = $(this).attr('data-remove2');
        $('#'+data_remove2).val('');

        return false;
    });

    $('.form_alteracao_data_vencimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();

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

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    search: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                $('#modal_alterar_data').modal('hide');
                $('#modal_alterar_data_massa').modal('hide');

            }

        }, 'json');

        return false;
    });

    $('.form_alteracao_data_vencimento_massa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();

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

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    search: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                $('#modal_alterar_data_massa').modal('hide');

            }

        }, 'json');

        return false;
    });

    $('.form_autenticar_operador_financeiro').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();

            $('#txt_id_pessoa').val('');
            $('#txt_nome_pessoa').val('');
            $('.clear_senha').val('');

            if (data.error) {

                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }

            if(data.success == "alteracao_data_vencimento"){

                if($('#table').bootstrapTable('getSelections').length == 1){

                    $('.list_alterar_data_vencimento').remove();

                    $("#modal_escolher_operador").modal("hide");

                    $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', {action: "buscaMotivoDataVencimento"}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }
                        if (data.success) {

                            var count = $('#table').bootstrapTable('getSelections').length;

                            var itens = "";

                            for(var i = 0; i < count; i++){

                                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                                    return false;
                                }

                                var data_vencimento = $('#table').bootstrapTable('getSelections')[0].vencimento;
                                var id = $('#table').bootstrapTable('getSelections')[0].titulo_id;
                                var aluno = $('#table').bootstrapTable('getSelections')[0].fornecedor;
                                var pessoa_id = $('#table').bootstrapTable('getSelections')[0].pessoa_id;

                                itens += "<div class='row list_alterar_data_vencimento'>";
                                itens += "<div class='col-md-6'><div class='form-group'><label>Data de vencimento</label><input type='hidden' name='titulo_id' value='"+id+"'><input type='hidden' name='pessoa_id' value='"+pessoa_id+"'><input type='text' name='data_vencimento' value='"+data_vencimento+"' class='form-control formDate j_data_vencimento'>";
                                itens += "</div></div>";
                                itens += "</div>";
                            }

                            itens += data.success;

                            $('.append_itens_alterar_data_vencimento').append(itens);

                            $('#modal_alterar_data').modal('show');

                        }
                    }, 'json');

                } else {
                    swal("Opps!", "Para esse função selecione apenas um título!", "info");
                }

            }

            if(data.success == "alteracao_data_vencimento_massa"){

                if($('#table').bootstrapTable('getSelections').length == 1){

                    $('.list_alterar_data_vencimento').remove();

                    $("#modal_escolher_operador").modal("hide");

                    $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', {action: "buscaMotivoDataVencimento"}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }
                        if (data.success) {

                            var count = $('#table').bootstrapTable('getSelections').length;

                            var itens = "";

                            for(var i = 0; i < count; i++){

                                if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado"){

                                    swal("Opps!", "Você selecionou títulos que já foram Pagos ou Cancelados!", "info");

                                    return false;
                                }

                                var data_vencimento = $('#table').bootstrapTable('getSelections')[0].vencimento;
                                var id = $('#table').bootstrapTable('getSelections')[0].titulo_id;
                                var aluno = $('#table').bootstrapTable('getSelections')[0].fornecedor;
                                var pessoa_id = $('#table').bootstrapTable('getSelections')[0].pessoa_id;
                                var tipo = $('#table').bootstrapTable('getSelections')[0].tipo;
                                var produto = $('#table').bootstrapTable('getSelections')[0].produto;

                                $('.produto').html('Produto: '+produto);

                                itens += "<div class='row list_alterar_data_vencimento'>";
                                itens += "<div class='col-md-6'><div class='form-group'><label>Data de vencimento</label><input type='hidden' name='titulo_id' value='"+id+"'><input type='hidden' name='tipo_id' value='"+tipo+"'><input type='hidden' name='produto' value='"+produto+"'><input type='hidden' name='pessoa_id' value='"+pessoa_id+"'><input type='text' name='data_vencimento' value='"+data_vencimento+"' class='form-control formDate j_data_vencimento'>";
                                itens += "</div></div>";
                                itens += "</div>";
                            }

                            itens += data.success;

                            $('.append_itens_alterar_data_vencimento_massa').append(itens);

                            $('#modal_alterar_data_massa').modal('show');

                        }
                    }, 'json');

                } else {
                    swal("Opps!", "Para esse função selecione apenas um título!", "info");
                }

            }

            if(data.success == "estornar_baixa_parcela"){

                if($('#table').bootstrapTable('getSelections').length >= 1){

                    $('.list_remove_estornar_baixa_parcela').remove();

                    $("#modal_escolher_operador").modal("hide");

                    $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', {action: "buscaMotivoEstornarParcela"}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }
                        if (data.success) {

                            var count = $('#table').bootstrapTable('getSelections').length;

                            var itens = "";

                            for(var i = 0; i < count; i++){

                                if($('#table').bootstrapTable('getSelections')[i].status != "Pago"){

                                    swal("Opps!", "Você precisa selecionar títulos que já foram pagos!", "info");

                                    return false;
                                }

                                var recebimento = $('#table').bootstrapTable('getSelections')[i].recebimento;
                                var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;
                                var aluno = $('#table').bootstrapTable('getSelections')[i].fornecedor;
                                var pessoa_id = $('#table').bootstrapTable('getSelections')[i].pessoa_id;
                                var valor = $('#table').bootstrapTable('getSelections')[i].valor;
                                var vencimento = $('#table').bootstrapTable('getSelections')[i].vencimento;
                                var parcela = $('#table').bootstrapTable('getSelections')[i].parcela;

                                itens += "<div class='row list_remove_estornar_baixa_parcela'>";
                                itens += "<div class='col-md-3'><div class='form-group'><label>Parcela</label>";
                                itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                                itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                                itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                                itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                                itens += "<div class='col-md-4'><div class='form-group'><label>Recebimento</label><input readonly class='form-control' type='text' value='"+recebimento+"'></div></div>";
                                itens += "<div class='col-md-4'><div class='form-group'><label>Valor</label>";
                                itens += "<input readonly type='text' value='"+valor+"' class='form-control formMoney'></div></div>";
                                itens += "</div>";
                            }

                            itens += data.success;

                            $('.append_itens_estornar_parcelas').append(itens);

                            $('#modal_estornar_titulos').modal('show');

                        }
                    }, 'json');

                } else {
                    swal("Opps!", "Para esse função selecione ao menos um título!", "info");
                }

            }

            if(data.success == "cancelar_titulos"){

                if($('#table').bootstrapTable('getSelections').length >= 1){

                    $('.list_remove_cancelar').remove();

                    $("#modal_escolher_operador").modal("hide");

                    $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', {action: "buscaMotivoCancelamento"}, function (data) {

                        if (data.error) {
                            swal({
                                title: "Opps!",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }
                        if (data.success) {

                            var count = $('#table').bootstrapTable('getSelections').length;

                            var itens = "";

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

                                itens += "<div class='row list_remove_cancelar'>";
                                itens += "<div class='col-md-3'><div class='form-group'><label>Parcela</label>";
                                itens += "<input type='hidden' name='titulo_parcela_id_"+i+"' value='"+id+"'/>";
                                itens += "<input type='hidden' class='j_pessoa_id' value='"+pessoa_id+"'/>";
                                itens += "<input type='hidden' name='qtd' value='"+count+"'/>";
                                itens += "<input readonly type='text' name='parcela_pagamento_"+i+"' value='"+parcela+"' class='form-control'></div></div>";
                                itens += "<div class='col-md-4'><div class='form-group'><label>Vencimento</label><input readonly class='form-control' type='text' value='"+vencimento+"'></div></div>";
                                itens += "<div class='col-md-5'><div class='form-group'><label>Valor Pagamento</label>";
                                itens += "<input readonly type='text' value='"+valor+"' class='form-control formMoney'></div></div>";
                                itens += "</div>";
                            }

                            itens += data.success;

                            $('.append_itens_cancelar').append(itens);

                            $('#modal_cancelar_titulos').modal('show');

                        }
                    }, 'json');


                } else {
                    swal("Opps!", "Para esse função selecione ao menos um título!", "info");
                }

            }

            if (data.success == "baixa_parcela") {

                var count = $('#table').bootstrapTable('getSelections').length;

                var valor_total = 0;
                var titulosId = "qtd=" + count;

                for(var i = 0; i < count; i++){

                    if($('#table').bootstrapTable('getSelections')[i].status == "Pago" || $('#table').bootstrapTable('getSelections')[i].status == "Cancelado" || $('#table').bootstrapTable('getSelections')[i].status == "Renegociado"){

                        swal("Opps!", "Você selecionou títulos que não são permitidos baixa, ou já foram pagos!", "info");

                        return false;
                    }

                    var id = $('#table').bootstrapTable('getSelections')[i].titulo_id;

                    titulosId += "&id_" + i + "=" + id;
                }

                titulosId += "&action=buscarParametrosMultaJurosBaixaParcelas";

                $("#modal_escolher_operador").modal("hide");

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

                        $('.append_itens').append(itens);

                        $('#modal_baixar_titulos').modal('show');

                    }
                }, 'json');
            }

        }, 'json');

        return false;
    });

    $('.form_renegociacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    search: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                $('#modal_baixar_titulos').modal('hide');
                $('#modal_cancelar_titulos').modal('hide');

            }

        }, 'json');

        return false;
    });

    $('.form_estornar_parcelas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    search: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                $('#modal_estornar_titulos').modal('hide');

            }

        }, 'json');

        return false;
    });

    $('.form_gerar_titulos_negativado').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

                $('#modal_calculo_titulos_negativad').modal('hide');

            }

        }, 'json');

        return false;
    });

    $('.form_cancelar_parcelas').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    search: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                $('#modal_cancelar_titulos').modal('hide');

            }

        }, 'json');

        return false;
    });

    var controlaSubmeterForm = false;
    var FormCamposParcelas = false;
    function abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, valor_total, formulario){

        $('#abrirEscolhaParcelasGeral').modal('show');

        $(".cliente_id_geral_parcelas").val(cliente_id);
        $(".cliente_nome_geral_parcelas").val(nome_cliente);
        $(".subtotal_geral_parcelas").val(valor_total);
        $(".valor_pos_desconto_geral_parcelas").val(valor_total);
        $(".formulario_atual_geral_parcelas").val(formulario);
        $(".valor_pago_geral_parcelas").val("0,00");
        $(".valor_desconto_geral_parcelas").val("0,00");
        //$(".valor_troco_geral_parcelas").val("0,00");
        $('.button_geral_parcelas').attr("disabled", true);

        $('.forma_pagamento_geral_parcelas').each(function(){
            $(this).val("0,00");
        });

    }

    function abrirFormasDePagamentoGerarCaixaPedidoMatricula(cliente_id, nome_cliente, valor_total, formulario){

        $('#abrirEscolhaParcelasGeralPedidoMatricula').modal('show');

        $(".cliente_id_geral_parcelas_pedido_matricula").val(cliente_id);
        $(".cliente_nome_geral_parcelas_pedido_matricula").val(nome_cliente);
        $(".subtotal_geral_parcelas_pedido_matricula").val(valor_total);
        $(".valor_pos_desconto_geral_parcelas_pedido_matricula").val(valor_total);
        $(".formulario_atual_geral_parcelas_pedido_matricula").val(formulario);
        $(".valor_pago_geral_parcelas_pedido_matricula").val("0,00");
        //$(".valor_troco_geral_parcelas_pedido_matricula").val("0,00");
        $('.button_geral_parcelas_pedido_matricula').attr("disabled", true);

        $('.forma_pagamento_geral_parcelas_pedido_matricula').each(function(){
            $(this).val("0,00");
        });

    }

    function numberToReal(numero) {
        var numero = numero.toFixed(2).split('.');
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
        return numero.join(',');
    }

    $(".valor_desconto_geral_parcelas").blur(function () {

        var valor = $(this).val();
        var subtotal = $(".subtotal_geral_parcelas").val();

        if(valor != undefined && valor != "" && valor != " " && valor.length > 0){

            var desconto = parseFloat(valor.replace(" ", "").replaceAll(".", "").replace(",", "."));
            subtotal = parseFloat(subtotal.replace(" ", "").replaceAll(".", "").replace(",", "."));

            var total = subtotal - desconto;
            $(".valor_pos_desconto_geral_parcelas").val(numberToReal(total));

        } else {
            $(".valor_pos_desconto_geral_parcelas").val($(".subtotal_geral_parcelas").val());
        }

    });

    $(".forma_pagamento_geral_parcelas").change(function () {

        //$('.button_geral_parcelas').attr("disabled", false);

        var total = parseFloat($(".valor_pos_desconto_geral_parcelas").val().replaceAll(".", "").replace(",", "."));

        var count = $('#table').bootstrapTable('getSelections').length;

        setTimeout(function () {

            var valor_total = 0;

            $('.forma_pagamento_geral_parcelas').each(function(){
                valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
            });

            $('.valor_pago_geral_parcelas').val(numberToReal(valor_total));

            //cadastro_transacao_caixa
            if(count == 0){
                if(valor_total <= total && valor_total > 0){
                    $('.button_geral_parcelas').attr("disabled", false);
                } else {
                    $('.button_geral_parcelas').attr("disabled", true);
                }
            }

            if(count == 1){
                if(valor_total <= total && valor_total > 0){
                    $('.button_geral_parcelas').attr("disabled", false);
                } else {
                    $('.button_geral_parcelas').attr("disabled", true);
                }
            }

            if(count > 1){
                if(valor_total == total){
                    $('.button_geral_parcelas').attr("disabled", false);
                } else {
                    $('.button_geral_parcelas').attr("disabled", true);
                }
            }

            $('.formMoney').mask('#.##0,00', {reverse: true});
            $(".dinheiro").mask('#.##0,00', {reverse: true});

        }, 100);

    });

    $('.form_gerar_parcelas_geral_padrao').submit(function (e) {

        var formData = $(this).serialize();
        var form = $(this);
        var formulario = $(".formulario_atual_geral_parcelas").val();
        FormCamposParcelas = formData;

        $('#abrirEscolhaParcelasGeral').modal('hide');

        controlaSubmeterForm = true;

        $(formulario).submit();

        return false;
    });

    $('.form_gerar_parcelas_geral_padrao_pedido_matricula').submit(function (e) {

        var formData = $(this).serialize();
        var form = $(this);
        var formulario = $(".formulario_atual_geral_parcelas_pedido_matricula").val();
        FormCamposParcelas = formData;

        $('#abrirEscolhaParcelasGeralPedidoMatricula').modal('hide');

        controlaSubmeterForm = true;

        $(formulario).submit();

        return false;
    });

    var pagamentoGeralEntrada = 0;
    $(".forma_pagamento_geral_parcelas_pedido_matricula").change(function () {

        var total = parseFloat($(".valor_pos_desconto_geral_parcelas_pedido_matricula").val().replaceAll(".", "").replace(",", "."));

        if(pagamentoGeralEntrada == 1){

            $('.button_geral_parcelas_pedido_matricula').attr("disabled", false);

            setTimeout(function () {

                var valor_total = 0;

                $('.forma_pagamento_geral_parcelas_pedido_matricula').each(function () {
                    valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
                });

                $('.valor_pago_geral_parcelas_pedido_matricula').val(numberToReal(valor_total));

                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".dinheiro").mask('#.##0,00', {reverse: true});

            }, 100);

        } else {

            setTimeout(function () {

                var valor_total = 0;

                $('.forma_pagamento_geral_parcelas_pedido_matricula').each(function () {
                    valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
                });

                $('.valor_pago_geral_parcelas_pedido_matricula').val(numberToReal(valor_total));

                /*if (valor_total >= total) {
                    $('.button_geral_parcelas_pedido_matricula').attr("disabled", false);
                } else {
                    $('.button_geral_parcelas_pedido_matricula').attr("disabled", true);
                }*/

                if (valor_total == total) {
                    //var troco = valor_total - total;
                    //$(".valor_troco_geral_parcelas_pedido_matricula").val(numberToReal(troco));
                    $('.button_geral_parcelas_pedido_matricula').attr("disabled", false);
                } else {
                    $('.button_geral_parcelas_pedido_matricula').attr("disabled", true);
                }

                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".dinheiro").mask('#.##0,00', {reverse: true});

            }, 100);
        }

    });

    $(".valor_desconto_geral_parcelas_pedido_matricula").blur(function () {

        var valor = $(this).val();
        var subtotal = $(".subtotal_geral_parcelas_pedido_matricula").val();

        if(valor != undefined && valor != "" && valor != " " && valor.length > 0){

            var desconto = parseFloat(valor.replace(" ", "").replaceAll(".", "").replace(",", "."));
            subtotal = parseFloat(subtotal.replace(" ", "").replaceAll(".", "").replace(",", "."));

            var total = subtotal - desconto;
            $(".valor_pos_desconto_geral_parcelas_pedido_matricula").val(numberToReal(total));

        } else {
            $(".valor_pos_desconto_geral_parcelas_pedido_matricula").val($(".subtotal_geral_parcelas_pedido_matricula").val());
        }

    });

    $(".forma_parcelamento_entrada_geral_parcelas_pedido_matricula").change(function () {

        var array = $(this).val().split("-", 2);
        if(array[1] == 1){
            $('.button_geral_parcelas_pedido_matricula').attr("disabled", true);
            pagamentoGeralEntrada = 1;
        } else {
            $('.button_geral_parcelas_pedido_matricula').attr("disabled", true);
            pagamentoGeralEntrada = 0;
        }

    });

    $('.form_transferir_aluno_turma').submit(function (e) {
        var formData = $(this).serialize();
        var form = $(this);

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        $.post(base + '_ajax/escola/Turma.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();

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
                    icon: "success"
                });

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    showRefresh: true,
                    url: base + "_ajax/escola/ListTransferenciaEnvolvidos.ajax.php?action=list"
                });

                $('#modal_transferencia_aluno').modal('hide');

            }
        }, 'json');

        return false;
    });

    $('.form_dar_baixa_parcelas').submit(function (e) {
        /*var code = null;
        code = e.type;
        alert("AAAEEEPPPAAAAAA.... NÂO pode apertar enter para slavar");
        return (code == "submit") ? false : true;*/
        var formData = $(this).serialize();
        var form = $(this);

        if(controlaSubmeterForm == false){

            var valor_total = 0;
            var count = $('#table').bootstrapTable('getSelections').length;
            for(var i = 0; i < count; i++){
                var valor = $('.valor_a_pagar_pagamento_' + i).val();
                valor_total += parseFloat(valor.replace("R$", "").replace(" ", "").replaceAll(".", "").replace(",", "."));
            }

            var cliente_id = $('#table').bootstrapTable('getSelections')[0].pessoa_id;
            var nome_cliente = $('#table').bootstrapTable('getSelections')[0].fornecedor;

            abrirFormasDePagamentoGerarCaixa(cliente_id, nome_cliente, numberToReal(valor_total), '.form_dar_baixa_parcelas');

            return false;
        }

        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        form.find('button').attr('disabled', true);
        $('.button_geral_parcelas').attr('disabled', true);

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData + '&' + FormCamposParcelas, function (data) {
            form.find('.form_load').fadeOut();

            if (data.error) {

                controlaSubmeterForm = false;
                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

                form.find('button').attr('disabled', false);
                $('.button_geral_parcelas').attr('disabled', false);

            }
            if (data.success) {

                $('#table').bootstrapTable('refreshOptions', {
                    showColumns: true,
                    showRefresh: true,
                    url: base + "_ajax/financeiro/ListTitulosReceberPorPessoa.ajax.php?action=list&pessoa_id="+data.pessoa
                });

                swal({
                    title: "Bom trabalho!",
                    text: data.success,
                    icon: "success",
                    buttons: ["Gerar Recibo(s)", "Continuar"],
                }).then((willDelete) => {
                    if (!willDelete) {

                        for(var i = 0; i < data.qtd; i++){

                            const returnedTarget = Object.assign(data.cliente[i], data.empresa, {forma_pagemento: data.nomeFormasPagamento, qtd: data.qtd, logo: base + "assets/carne/img/logo.svg", obs: "Após vencimento cobrar multa de R$ 2,00 e Juros de 1% ao mês"});
                            $.redirect(base + "assets/carne/recibo.php", returnedTarget, "POST", "_blank", true, true);

                        }

                    }
                });

                controlaSubmeterForm = false;
                FormCamposParcelas = false;

                $('#modal_baixar_titulos').modal('hide');

                form.find('button').attr('disabled', false);
                $('.button_geral_parcelas').attr('disabled', false);

            }
        }, 'json');

        return false;
    });

    $('.form_gerar_carne_titulos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        var count = $('#table').bootstrapTable('getSelections').length;

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {

                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }
            if (data.cliente) {

                const returnedTarget = Object.assign(data.cliente, data.empresa, {qtd: count, logo: base + "assets/carne/img/logo.svg", obs: "Após vencimento cobrar multa e juros conforme sistema"});

                $.redirect(base + "assets/carne/carne.php", returnedTarget, "POST", "_blank");

            }
        }, 'json');

        return false;
    });

    $('.form_gerar_recibo_titulos').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();
        var count = $('#table').bootstrapTable('getSelections').length;

        $.post(base + '_ajax/financeiro/MovimentacaoRecebimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
            if (data.error) {

                swal({
                    title: "Opps!",
                    text: data.error,
                    icon: "error",
                    button: "Ok!",
                });

            }
            if (data.cliente) {

                const returnedTarget = Object.assign(data.cliente, data.empresa, {qtd: count, logo: base + "assets/carne/img/logo.svg", obs: "Após vencimento cobrar multa de R$ 2,00 e Juros de 1% ao mês"});

                $.redirect(base + "assets/carne/recibo.php", returnedTarget, "POST", "_blank");

            }
        }, 'json');

        return false;
    });



    $('.form_envio_scpc').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/EnvioScpc.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_paises').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Paises.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_estados').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Estados.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_cidades').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/Cidades.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_escola_franquia').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/EscolaFranquias.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


    $('.form_parente_aluno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/ParenteAluno.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_controle_cheque').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/ControleCheque.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


    $('.form_situacao_cheque').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/SituacaoCheque.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_emprestimo_acervo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Emprestimo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_reposicao_aluno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Reposicao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_reposicao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Reposicao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_materiais_estagio').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/MateriaisEstagio.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_feriado_municipal').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/FeriadoMunicipal.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_clientes').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/pedido/Clientes.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_ano_letivo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/AnoLetivo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_periodo_letivo').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/PeriodoLetivo.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_patrocinador').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Patrocinador.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_niveis_empresa').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/NiveisEmpresa.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_exercicio').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Exercicio.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_exercicio2').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Exercicio2.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_homework').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Homework.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_homework2').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/escola/Homework2.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

     $('.form_politica_comercial_estagio').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/politica_comercial/PoliticaComercialEstagio.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_motivo_negociacao').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MotivoNegociacao.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_parametrizacao_matricula').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/ParametrizacaoMatricula.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_motivo_estorno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoEstorno.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_motivo_alterar_vencimento').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/franqueador/MotivoAlterarVencimento.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_parametrizacao_sistema').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/ParametrizacaoSistema.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

      $('.form_ocorrencia_retencao_aluno').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/retencao/RetencaoAluno.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $(".j_click_abrir_ocorrencia").click(function () {

        $("#abrirOcorrenciasGeral").modal('show');

        return false;
    });

    $('.form_ocorrencias_geral').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

                $("#abrirOcorrenciasGeral").modal('hide');

            }
        }, 'json');

        return false;
    });

    $('.form_alterar_senha_geral').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/Acessos.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_tipo_historico_funcionario').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/rh/TipoHistoricoFuncionario.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

    $('.form_operadores_financeiro').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/OperadoresFinanceiro.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


});

  $('.form_atividade_extra').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/parametrizacao/AtividadeExtra.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });

 $('.form_matriz_perda_desconto').submit(function () {

        var formData = $(this).serialize();
        var form = $(this);
        form.find('.form_load').css('display', 'inline');
        $('.ajax_close').fadeOut();

        $.post(base + '_ajax/financeiro/MatrizPerdaDesconto.ajax.php', formData, function (data) {
            form.find('.form_load').fadeOut();
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

        return false;
    });


