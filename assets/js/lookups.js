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

function trigger(data) {
    if(data[0]){
        $.each(data, function(key, value){
            triggerNotify(data[key]);
        })
    } else {
        triggerNotify(data);
    }
}

var base = $('link[rel="base"]').attr('href') + "/";

  var checkedRows = [];

  $('#table_modal_fornecedor').on('check.bs.table', function (e, row) {
    checkedRows.push({id: row.id, name: row.nome});

    $('#txt_id_fornecedor').val(row.id);
    $('#txt_fornecedor').val(row.nome);
    $('#getCodeModalFornecedor').modal('hide');
  });

  $('#table_modal_fornecedor').on('uncheck.bs.table', function (e, row) {
    $.each(checkedRows, function(index, value) {
      if (value.id === row.id) {
        checkedRows.splice(index,1);
      }
    });
    console.log(checkedRows);
  });

 
  var checkedRows = [];

  $('#table_modal_produtos').on('check.bs.table', function (e, row) {
    checkedRows.push({id: row.id, name: row.nome});

    $('#txt_id_produtos').val(row.id);
    $('#txt_produtos').val(row.nome);
    $('#getCodeProdutoModal').modal('hide');

    console.log(checkedRows);
  });

  $('#table_modal_produtos').on('uncheck.bs.table', function (e, row) {
    $.each(checkedRows, function(index, value) {
      if (value.id === row.id) {
        checkedRows.splice(index,1);
      }
    });
    console.log(checkedRows);
  });

  

  var checkedRows = [];

  $('#table_modal_alunos').on('check.bs.table', function (e, row) {
    checkedRows.push({id: row.id, name: row.nome});

    $('#txt_id_aluno').val(row.id);
    $('#txt_aluno').val(row.nome);
    $('#getCodeAlunosModal').modal('hide');

    console.log(checkedRows);
  });

  $('#table_modal_franquia').on('check.bs.table', function (e, row) {
    checkedRows.push({id: row.id, name: row.nome});

    $('#txt_id_franquia').val(row.id);
    $('#txt_franquia').val(row.nome);
    $('#getCodeFranquiaModal').modal('hide');

    console.log(checkedRows);
  });

  $('#table_modal_alunos').on('uncheck.bs.table', function (e, row) {
    $.each(checkedRows, function(index, value) {
      if (value.id === row.id) {
        checkedRows.splice(index,1);
      }
    });
    console.log(checkedRows);
  });

  var produtoCorrente;
  $('.table_produtos_proposta').on('click', '.j_produto_proposta', function () {

      produtoCorrente = $(this);

      $('#getCodeModal').modal('show');

  });

$(document).ajaxStart(function(){
    $.LoadingOverlaySetup({
        background      : "rgba(0, 0, 0, 0.5)",
        image           : "assets/img/knn-logo.png",
        imageAnimation  : "1.0s pulse",
    });
    $.LoadingOverlay("show");
});

$(document).ajaxStop(function(){
    $.LoadingOverlay("hide");
});

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

$('#table_modal_produtos_proposta').on('check.bs.table', function (e, row) {

    var formData = "action=buscarEstagio&produto_id=" + row.id + "&numero=" + $('.quantidade_produto_proposta').val();

    $.post(base + '_ajax/pedido/Proposta.ajax.php', formData, function (data) {

        if (data.error) {
            produtoCorrente.val(row.nome);
            produtoCorrente.attr('accessKey', row.id);
            $("." + produtoCorrente.attr('id')).val(row.valor);
            $("." + produtoCorrente.attr('data-qtd')).val(1);
            $("." + produtoCorrente.attr('data-qtd')).attr('data-uni', row.valor.replaceAll(".", "").replace(",", "."));
            $("." + produtoCorrente.attr('data-total')).val(row.valor);
            $("." + produtoCorrente.attr('data-tipo')).val(1);

            var valor_total = 0;

            $('.valor_total_tabela').each(function(){

                valor_total += parseFloat($(this).val());
            });

            $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
            $('.valor_total').focus();

            $('#getCodeModal').modal('hide');

        }
        if (data.success) {

            $('.j_produto_proposta').each(function(){

                if(!$(this).val()){
                    $(this).parents('tr').detach();
                }
            });

            setTimeout(function () {

                $('.formMoney').mask('#.##0,00', {reverse: true});
                $("input.dinheiro").mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");

                var valor_total = 0;

                $('.valor_total_tabela').each(function(){

                    valor_total += parseFloat($(this).val());
                });

                $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
                $('.valor_total').focus();

            }, 100);

            $('#getCodeModal').modal('hide');
            $('.table_produtos_proposta').append(data.success);
        }
        if(data.numero){
            $('.quantidade_produto_proposta').val(data.numero);
        }

    }, 'json');
});

$('#table_modal_estagios_proposta').on('check.bs.table', function (e, row) {
    produtoCorrente.val(row.nome);
    produtoCorrente.attr('accessKey', row.id);
    $("." + produtoCorrente.attr('id')).val(row.valor);
    $("." + produtoCorrente.attr('data-qtd')).val(1);
    $("." + produtoCorrente.attr('data-qtd')).attr('data-uni', row.valor.replaceAll(".", "").replace(",", "."));
    $("." + produtoCorrente.attr('data-total')).val(row.valor);
    $("." + produtoCorrente.attr('data-tipo')).val(2);

    setTimeout(function () {

        var valor_total = 0;

        $('.valor_total_tabela').each(function(){

            valor_total += parseFloat($(this).val());
        });

        $('.valor_total').val(new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor_total));
        $('.valor_total').focus();
    }, 100);

    $('#getCodeModal').modal('hide');
});

$('#table_modal_aluno_matricula').on('check.bs.table', function (e, row) {
    $('#txt_id_aluno').val(row.id);
    $('#txt_aluno').val(row.nome);
    $('#txt_cpf').val(row.cpf);
    $('#getCodeModal').modal('hide');
});

$('#table_modal_proposta_matricula').on('check.bs.table', function (e, row) {
    $('#txt_id_proposta').val(row.id);
    $('#txt_proposta').val(row.nome);
    $('#getCodeModalProposta').modal('hide');
});

$('#table_modal_turma_matricula').on('check.bs.table', function (e, row) {

    $('#txt_id_turma').val(row.id);
    $('#txt_turma').val(row.nome);
    $('#pessoa_id').val(row.professor);
    $('#getCodeModalTurma').modal('hide');
});

$('#table_modal_turma_transferencia').on('check.bs.table', function (e, row) {

    $('#txt_id_turma').val(row.id);
    $('#txt_turma').val(row.nome);
    $('#pessoa_id').val(row.professor);
    $('#getCodeModalTurmaTransferencia').modal('hide');
});

$('#table_modal_operadores_financeiros').on('check.bs.table', function (e, row) {

    $('#txt_id_pessoa').val(row.id);
    $('#txt_nome_pessoa').val(row.nome);
    $('#getCodeOperadoresModal').modal('hide');
});

$('#table_modal_turma').on('check.bs.table', function (e, row) {

    $('#txt_id_turma').val(row.id);
    $('#txt_turma').val(row.nome);
    $('#pessoa_id').val(row.professor);

    $.post(base + '_ajax/escola/Turma.ajax.php', {action: "buscar_dados_turma", projeto_id: row.id}, function (data) {

        if (data.error) {

            $('#getCodeModalTurma').modal('hide');
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }
        if (data.success) {

            $('#modalidade_id').val(row.modalidade_id);
            $('#produto_id').val(row.produto_id);

            $('#primeiro_dia').val(data.primeiro_dia);
            $('#primeiro_dia_hora_inicio').val(data.primeiro_dia_hora_inicial);
            $('#primeiro_dia_hora_final').val(data.primeiro_dia_hora_final);
            $('#projeto_grade').val(data.projeto_grade);

            if(!data.segundo){
                $('#segundo_dia').val(data.segundo_dia);
                $('#segundo_dia_hora_inicio').val(data.segundo_dia_hora_inicial);
                $('#segundo_dia_hora_final').val(data.segundo_dia_hora_final);
            } else {
                $('#segundo_dia').val("");
                $('#segundo_dia_hora_inicio').val("");
                $('#segundo_dia_hora_final').val("");
            }

            var sfw = $("#form_planejamento_aulas").stepFormWizard();
            sfw.goTo(1);
            sfw.refresh();

            $('#getCodeModalTurma').modal('hide');
        }
    }, 'json');
});

$('#table_modal_turma_acompanhamento_aula').on('check.bs.table', function (e, row) {

    $('#txt_id_turma').val(row.id);
    $('#txt_turma').val(row.nome);

    $(".list_planejamentos").remove();

    $.post(base + '_ajax/escola/Turma.ajax.php', {action: "buscarPanejamentoTurma", projeto_id: row.id}, function (data) {

        if (data.error) {

            $('#getCodeModalTurma').modal('hide');
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {
            var sfw = $("#form_acompanhamento_aulas").stepFormWizard();
            $(".tabela_planejamento_acompanhamento_aulas").append(data.success);
            sfw.goTo(1);
            sfw.refresh();
            $('#getCodeModalTurma').modal('hide');
        }
    }, 'json');
});

$(".tabela_planejamento_acompanhamento_aulas").on('click', ".j_sys_clique_planejamento_acompanhamento_aula", function () {

    var turma_id = $(this).attr("data-id-turma");
    var plano_id = $(this).attr("data-id-plano");
    $(".planejamento").val(plano_id);

    $(".list_turma_planejamentos").remove();

    $.post(base + '_ajax/escola/Turma.ajax.php', {action: "buscarAlunosPanejamentoTurma", projeto_id: turma_id, plano_id: plano_id}, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {
            var sfw = $("#form_acompanhamento_aulas").stepFormWizard();
            $(".tabela_turma_acompanhamento_aulas").append(data.success);

            $(".tabela_turma_homework_aulas").append(data.homework);
            $(".tabela_turma_materias_aulas").append(data.materias);
            $(".tabela_turma_avaliacao_aulas").append(data.avaliacao);
            $(".tabela_turma_exercicio_aulas").append(data.exercicio);

            $(".quantidade_alunos").val(data.qtd);
            $(".etapa").val(data.etapa);

            $(".quantidade_avaliacoes").val(data.qtdAvaliacoes);
            $(".quantidade_homework").val(data.qtdHomeWork);
            $(".quantidade_exercicios").val(data.qtdExercicios);
            $(".quantidade_materias").val(data.qtdMaterias);

            sfw.goTo(2);
            sfw.refresh();
        }
    }, 'json');

});

$(document).on('click', ".abrir_collapse", function () {
    var sfw = $("#form_acompanhamento_aulas").stepFormWizard();
    setTimeout(function () {
        sfw.refresh();
    }, 200)
});

$('#table_modal_turma_lista_assinatura').on('check.bs.table', function (e, row) {

    $('#txt_id_turma').val(row.id);
    $('#txt_turma').val(row.nome);

    $(".table_1_body").remove();
    $(".table_2_body").remove();
    $(".table_3_body").remove();
    $(".table_4_body").remove();

    $.post(base + '_ajax/escola/Turma.ajax.php', {action: "buscarListaAssinaturaTurma", projeto_id: row.id}, function (data) {

        if (data.error) {

            $('#getCodeModalTurma').modal('hide');
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if(data.table_1){
            $(".table_1").append(data.table_1);
        }

        if(data.table_2){
            $(".table_2").append(data.table_2);
        }

        if(data.table_3){
            $(".table_3").append(data.table_3);
        }

        if (data.success) {
            $(".table_4").append(data.success);
            var sfw = $("#form_lista_assinaturas").stepFormWizard();
            sfw.goTo(1);
            sfw.refresh();
            $('#getCodeModalTurma').modal('hide');
        }
    }, 'json');
});

$('#table_modal_turma_espera').on('check.bs.table', function (e, row) {
    var idlista = $('.id_lista_espera_projeto').val();

    swal({
        title: "Incluir aluno em turma?",
        text: "Você tem certeza que deseja incluir o aluno na " + row.nome + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {

            $.post(base + '_ajax/escola/ListaEspera.ajax.php', {action: "lista_espera", list_id: idlista, turma_id: row.id}, function (data) {

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

    $('#modal_escolherTurma_listaEspera').modal('hide');
});

$('#table_modal_alunos_rede').on('check.bs.table', function (e, row) {

    swal({
        title: "Deseja ver o aluno?",
        text: "Clique em OK para acessar as informações desse aluno.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {

            window.location.href = "painel.php?exe=escola/alunos/ver_alunos&id=" + row.id;

        }
    });
    //$('#getCodeModal').modal('hide');
});

var produtoCorrente;
$('.table_produtos_compra').on('click', '.j_produto_proposta', function () {

    produtoCorrente = $(this);

    $('#getCodeModal').modal('show');

});

var alunoCorrente;
$('.table_produtos_compra').on('click', '.j_cliente_pedido_compra', function () {

    alunoCorrente = $(this);

    $('#getCodeAlunosModal').modal('show');

});

$('#table_modal_alunos_pedido_compra').on('check.bs.table', function (e, row) {
    alunoCorrente.val(row.nome);
    alunoCorrente.attr('accessKey', row.id);
    $('#getCodeAlunosModal').modal('hide');

    console.log(checkedRows);
});

var parenteCorrente;
$('.table_parente_aluno').on('click', '.j_grau_parentes', function () {

    parenteCorrente = $(this);

    $('#getCodeModalGrauParentesco').modal('show');

});

$('#table_modal_parentes').on('check.bs.table', function (e, row) {
    parenteCorrente.val(row.nome);
    $("#" + parenteCorrente.attr('data-id')).val(row.id);
    $("#" + parenteCorrente.attr('data-cpf')).val(row.cpf);

    $('#getCodeModalGrauParentesco').modal('hide');
});

$('#table_modal_fornecedores').on('check.bs.table', function (e, row) {

    $("#nome_fornecedor").val(row.nome);
    $("#txt_id_fornecedor").val(row.id);

    $('#getCodeModalFornecedor').modal('hide');
});

$('#table_modal_pessoas').on('check.bs.table', function (e, row) {
    $('#txt_id_pessoa').val(row.id);
    $('#txt_pessoa').val(row.nome);
    $('#getCodeModal').modal('hide');
});

$('#table_modal_funcionarios').on('check.bs.table', function (e, row) {
    $('#txt_id_pessoa').val(row.id);
    $('#txt_pessoa').val(row.nome);
    $('#getCodeModal').modal('hide');
});

$('#table_modal_responsavel_financeiro').on('check.bs.table', function (e, row) {
    $('#txt_id_pessoa_financeiro').val(row.id);
    $('#pessoa_nome_responsavel_financeiro').val(row.nome);
    $('#getCodeModalFinanceiro').modal('hide');
});

$('#table_modal_responsavel_pedagogico').on('check.bs.table', function (e, row) {
    $('#txt_id_pessoa_pedagogico').val(row.id);
    $('#pessoa_nome_responsavel_pedagogico').val(row.nome);
    $('#getCodeModalPedagogico').modal('hide');
});


$('#table_modal_alunos_reposicao').on('check.bs.table', function (e, row) {
    $('#txt_id_pessoa').val(row.id);
    $('#txt_pessoa').val(row.nome);
    $('#getCodeModal').modal('hide');
});

var produtoCorrente;
$('.table_materiais_estagio').on('click', '.j_produto_materias_estagio', function () {
    produtoCorrente = $(this);
    $('#getCodeModal').modal('show');
});


$('#table_modal_materiais').on('check.bs.table', function (e, row) {

    produtoCorrente.val(row.nome);
    $("#" + produtoCorrente.attr('data-id')).val(row.id);
    $('#getCodeModal').modal('hide');
});

var produtoCorrente;
$('.table_produtos_matricula').on('click', '.j_produto_proposta', function () {

    produtoCorrente = $(this);

    $('#getCodeModal').modal('show');

});

$(".j_completar_matricula").click(function () {

    var produto = $(".j_produto_proposta").val();
    var produto_id = $(".j_produto_proposta").attr('accessKey');
    var desconto = $(".j_matricula_desconto_padrao").val();
    var forma_parcelamento = $(".j_proposta_forma_parcelamento").val();
    var forma_parcelamento_material = $(".j_proposta_forma_parcelamento_material").val();
    var modalidade = $(".j_proposta_modalidade").val();
    var dia_vencimento = $(".j_matricula_dia_vencimento").val();
    var data_vencimento = $(".j_matricula_data_vencimento").val();

    if (produto == "" || produto == undefined || produto_id == "" || produto_id == undefined) {

        swal({
            title: "Opps",
            text: "Você precisa seleciona um curso antes",
            icon: "warning"
        });

        return false;
    }

    var formData = "action=completarMatricula&produto_id=" + produto_id + "&desconto=" + desconto + "&forma_parcelamento=" + forma_parcelamento + "&forma_parcelamento_material=" + forma_parcelamento_material + "&dia_vencimento=" + dia_vencimento + "&data_vencimento=" + data_vencimento + "&modalidade=" + modalidade;

    $.post(base + '_ajax/pedido/Matricula.ajax.php', formData, function (data) {

        if (data.error) {

            swal({
                title: "Opps!",
                text: "Erro, tente novamente.",
                icon: "error",
                button: "Ok!",
            });

        }
        if (data.success) {

            $(".listagem_dos_itens").remove();

            $('#getCodeModal').modal('hide');
            $('.j_tabela_matricula_estagios_curso').append(data.estagios_curso);
            $('.j_tabela_matricula_materia_didaticos_curso').append(data.material_dicatico);
            $(".quantidade_produto_matricula").val(data.numero);
            console.log(data.total);

            $(".j_completar_matricula").text("Atualizar Matrícula");

            setTimeout(function () {

                $('.formMoney').mask('#.##0,00', {reverse: true});
                $("input.dinheiro").mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");

                /*var valor_total = 0;

                $('.valor_total_tabela').each(function(){
                    valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
                });*/

                $('.valor_rateio').each(function(index, value){
                    let por = $(this).attr('rel');
                    if (por != undefined) {
                        this.value = numberToReal(((data.total/100) * por ));
                    }
                });

                $('.valor_total').text(numberToReal(data.total));
                $('.pedido_valor_total').val(numberToReal(data.total));
                $('.valor_total').focus();

            }, 200);

            $('#table_modal_turma_matricula').bootstrapTable('refreshOptions', {
                showColumns: false,
                search: false,
                showRefresh: false,
                url: base + "_ajax/lookups/ListTurmas.ajax.php?action=list_matricula&id=" + data.idsEstagios
            });

            $('.div_none_matricula').fadeIn('300');
        }

    }, 'json');

});

function numberToReal(numero) {
    var numero = numero.toFixed(2).split('.');
    numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}

$('#table_modal_produtos_matricula').on('check.bs.table', function (e, row) {

    var formData = "action=buscarTemplateMatricula";
    var input = $(this);

    $.post(base + '_ajax/pedido/Matricula.ajax.php', formData, function (data) {

        if (data.error) {

            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
            $('#getCodeModal').modal('hide');
        }
        if (data.success) {

            produtoCorrente.val(row.nome);
            produtoCorrente.attr('accessKey', row.id);
            $(".j_proposta_forma_parcelamento").val(data.success.parametro_forma_parcelamento_id);
            $(".j_proposta_forma_parcelamento_material").val(data.success.parametro_forma_parcelamento_material_id);
            $(".j_matricula_dia_vencimento").val(data.success.parametro_dia_vencimento_id);
            $(".j_matricula_data_vencimento").val(data.success.vencimento_data);
            $(".j_proposta_modalidade").val(data.success.parametro_modalidade_id);
            $('#getCodeModal').modal('hide');
        }

    }, 'json');
});

$('.j_tabela_matricula_estagios_curso').on('click', '.btn_remove', function (e) {
    e.preventDefault();

    if($(".lista_de_estagios").length > 1){
        $("." + $(this).attr('accesskey')).remove();

        setTimeout(function () {

            var valor_total = 0;

            $('.valor_total_tabela').each(function(){

                valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
            });

            $('.valor_rateio').each(function(index, value){
                let por = $(this).attr('rel');
                this.value = numberToReal(((valor_total/100) * por ));
            });

            $('.valor_total').text(numberToReal(valor_total));
            $('.pedido_valor_total').val(numberToReal(valor_total));

        }, 100);

    } else {
        swal({
            title: "Opps",
            text: "Você não pode remover todos os itens",
            icon: "warning"
        });
    }

});

$('.j_tabela_matricula_estagios_curso').on('click', '.btn-editar', function (e) {
    e.preventDefault();

    var tabelaNumero = $(this).attr('accesskey').split("_");
    var local = tabelaNumero[1];

    var pedido_item_tipo = $('.pedido_item_tipo_' + local).val();
    var nome_produto = $('.nome_produto_' + local).val();
    var proposta_item_valor_total = $('.proposta_item_valor_total_' + local).val();
    var proposta_item_valor_original = $('.proposta_item_valor_original_' + local).val();
    var proposta_item_valor_unitario = $('.proposta_item_valor_unitario_' + local).val();
    var proposta_item_quantidade = $('.proposta_item_quantidade_' + local).val();
    var desconto_matricula = $('.desconto_matricula_' + local).val();
    var proposta_item_parcelamento_id = $('.proposta_item_parcelamento_id_' + local).val();
    var proposta_entrada = $('.proposta_entrada_' + local).val();
    var proposta_data_entrada = $('.proposta_data_entrada_' + local).val();
    var proposta_dia_vencimento = $('.proposta_dia_vencimento_' + local).val();
    var proposta_data_primeiro_vencimento = $('.proposta_data_primeiro_vencimento_' + local).val();
    var proposta_item_modalidade = $('.proposta_item_modalidade_' + local).val();

    $('#getCodeModalDetalhesItens').modal('show');

    setTimeout(function () {
        $(".nome_item_modal").val(nome_produto);
        $(".valor_unitario_item_modal").val(proposta_item_valor_unitario);
        $(".quantidade_item_modal").val(proposta_item_quantidade);
        $(".valor_total_item_modal").val(proposta_item_valor_total);
        $(".valor_original_item_modal").val(proposta_item_valor_original);
        $(".valor_entrada_item_modal").val(proposta_entrada);
        $(".data_entrada_item_modal").val(proposta_data_entrada);
        $(".data_primeiro_vencimento_item_modal").val(proposta_data_primeiro_vencimento);
        $(".table_atual_item_modal").val(local);

        if(pedido_item_tipo == 1){
            $(".div_display_none").css("display", "none");
            $(".div_display_none_modalidade").css("display", "block");
        } else {
            $(".div_display_none").css("display", "block");
            $(".div_display_none_modalidade").css("display", "none");
        }

        $(".desconto_item_modal").val(desconto_matricula);
        $(".forma_parcelamento_item_modal").val(proposta_item_parcelamento_id);
        $(".dia_vencimento_item_modal").val(proposta_dia_vencimento);
        $(".modalidade_item_modal").val(proposta_item_modalidade);

    }, 200);

});

$('.j_tabela_matricula_estagios_curso').on('click', '.btn_parcelas_simulacao', function (e) {
    e.preventDefault();

    var tabelaNumero = $(this).attr('accesskey').split("_");
    var local = tabelaNumero[1];

    var nome_produto = $('.nome_produto_' + local).val();
    var proposta_item_valor_total = $('.proposta_item_valor_total_' + local).val();
    var desconto_matricula = $('.desconto_matricula_' + local).val();
    var proposta_item_parcelamento_id = $('.proposta_item_parcelamento_id_' + local).val();
    var proposta_data_primeiro_vencimento = $('.proposta_data_primeiro_vencimento_' + local).val();
    //var proposta_data_primeiro_vencimento = $(".j_matricula_data_vencimento").val();

    /*var proposta_estagio_sequencia = $('.proposta_estagio_sequencia_' + local).val();
    var qtd_parcelas = 0;

    for(var i = 1; i <= proposta_estagio_sequencia; i++){

        if($('#proposta_estagio_sequencia_' + i).val() != undefined){
            console.log($('#proposta_estagio_sequencia_' + i).val());
        }
    }*/
    // + "&seq=" + proposta_estagio_sequencia + "&qtd_parcelas=" + qtd_parcelas

    var formData = "action=simularParcelasMatricula&proposta_item_parcelamento_id=" + proposta_item_parcelamento_id + "&proposta_item_valor_total=" + proposta_item_valor_total + "&proposta_data_primeiro_vencimento=" + proposta_data_primeiro_vencimento + "&desconto_matricula=" + desconto_matricula + "&nome_produto=" + nome_produto;

    $.post(base + '_ajax/pedido/Matricula.ajax.php', formData, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {

            var item = "<div id='getCodeModalParcelasSimulacao' class='modal fade in'>";
            item += "<div class='modal-dialog modal-confirm'>";
            item += "<div class='modal-content' style='background-color: #EAEAEA; width: 600px; height: auto'>";
            item += "<div class='modal-header' style='border-bottom: none'><h4 class='card-title  text-center'>SIMULAÇÃO DAS PARCELAS</h4>";
            item += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></div><div class='modal-body text-center'>";
            item += "<table class='table table-hover display table-bordered'>";
            item += "<thead><tr><th>Item</th><th>Parcela</th><th>Data Vencimento</th><th>Valor</th></tr><tbody>";
            item += data.success;
            item += "</tbody></table>";
            item += "</div></div></div></div>";

            $('body').prepend(item);

            $('#getCodeModalParcelasSimulacao').modal('show');

        }

    }, 'json');

});

$(".btn_salvar_aleracoes_matricula").click(function () {

    var local = $(".table_atual_item_modal").val();
    var nome_produto = $(".nome_item_modal").val();
    var proposta_item_valor_unitario = $(".valor_unitario_item_modal").val();
    var proposta_item_quantidade = $(".quantidade_item_modal").val();
    var proposta_item_valor_total = $(".valor_total_item_modal").val();
    var proposta_item_valor_original = $(".valor_original_item_modal").val();
    var proposta_entrada = $(".valor_entrada_item_modal").val();
    var proposta_data_entrada = $(".data_entrada_item_modal").val();
    var proposta_data_primeiro_vencimento = $(".data_primeiro_vencimento_item_modal").val();

    var desconto_matricula = $(".desconto_item_modal").val();
    var proposta_item_parcelamento_id = $(".forma_parcelamento_item_modal").val();
    var proposta_dia_vencimento = $(".dia_vencimento_item_modal").val();
    var proposta_item_modalidade = $(".modalidade_item_modal").val();

    $('.nome_produto_' + local).val(nome_produto);
    $('.proposta_item_valor_total_' + local).val(proposta_item_valor_total);
    $('.proposta_item_valor_original_' + local).val(proposta_item_valor_original);
    $('.proposta_item_valor_unitario_' + local).val(proposta_item_valor_unitario);
    $('.proposta_item_quantidade_' + local).val(proposta_item_quantidade);
    $('.desconto_matricula_' + local).val(desconto_matricula);
    $('.proposta_item_parcelamento_id_' + local).val(proposta_item_parcelamento_id);
    $('.proposta_entrada_' + local).val(proposta_entrada);
    $('.proposta_data_entrada_' + local).val(proposta_data_entrada);
    $('.proposta_dia_vencimento_' + local).val(proposta_dia_vencimento);
    $('.proposta_data_primeiro_vencimento_' + local).val(proposta_data_primeiro_vencimento);
    $('.proposta_item_modalidade_' + local).val(proposta_item_modalidade);

    $('#getCodeModalDetalhesItens').modal('hide');

});

$('.j_tabela_matricula_materia_didaticos_curso').on('click', '.btn_remove', function (e) {
    e.preventDefault();

    if($(".lista_de_materiais").length > 1){
        $("." + $(this).attr('accesskey')).remove();

        setTimeout(function () {

            var valor_total = 0;

            $('.valor_total_tabela').each(function(){

                valor_total += parseFloat($(this).val().replaceAll(".", "").replace(",", "."));
            });

            $('.valor_rateio').each(function(index, value){
                let por = $(this).attr('rel');
                this.value = numberToReal(((valor_total/100) * por ));
            });

            $('.valor_total').text(numberToReal(valor_total));
            $('.pedido_valor_total').val(numberToReal(valor_total));

        }, 100);

    } else {
        swal({
            title: "Opps",
            text: "Você não pode remover todos os itens",
            icon: "warning"
        });
    }

});

$('.j_tabela_matricula_materia_didaticos_curso').on('click', '.btn_parcelas_simulacao', function (e) {
    e.preventDefault();

    var tabelaNumero = $(this).attr('accesskey').split("_");
    var local = tabelaNumero[1];

    var nome_produto = $('.nome_produto_' + local).val();
    var proposta_item_valor_total = $('.proposta_item_valor_total_' + local).val();
    var desconto_matricula = $('.desconto_matricula_' + local).val();
    var proposta_item_parcelamento_id = $('.proposta_item_parcelamento_id_' + local).val();
    var proposta_data_primeiro_vencimento = $('.proposta_data_primeiro_vencimento_' + local).val();

    var formData = "action=simularParcelasMatricula&proposta_item_parcelamento_id=" + proposta_item_parcelamento_id + "&proposta_item_valor_total=" + proposta_item_valor_total + "&proposta_data_primeiro_vencimento=" + proposta_data_primeiro_vencimento + "&desconto_matricula=" + desconto_matricula + "&nome_produto=" + nome_produto;

    $.post(base + '_ajax/pedido/Matricula.ajax.php', formData, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {

            var item = "<div id='getCodeModalParcelasSimulacao' class='modal fade in'>";
            item += "<div class='modal-dialog modal-confirm'>";
            item += "<div class='modal-content' style='background-color: #EAEAEA; width: 600px; height: auto'>";
            item += "<div class='modal-header' style='border-bottom: none'><h4 class='card-title  text-center'>SIMULAÇÃO DAS PARCELAS</h4>";
            item += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></div><div class='modal-body text-center'>";
            item += "<table class='table table-hover display table-bordered'>";
            item += "<thead><tr><th>Item</th><th>Parcela</th><th>Data Vencimento</th><th>Valor</th></tr><tbody>";
            item += data.success;
            item += "</tbody></table>";
            item += "</div></div></div></div>";

            $('body').prepend(item);

            $('#getCodeModalParcelasSimulacao').modal('show');

        }

    }, 'json');

});

$('.j_tabela_matricula_materia_didaticos_curso').on('click', '.btn-editar', function (e) {
    e.preventDefault();

    var tabelaNumero = $(this).attr('accesskey').split("_");
    var local = tabelaNumero[1];

    var pedido_item_tipo = $('.pedido_item_tipo_' + local).val();
    var nome_produto = $('.nome_produto_' + local).val();
    var proposta_item_valor_total = $('.proposta_item_valor_total_' + local).val();
    var proposta_item_valor_unitario = $('.proposta_item_valor_unitario_' + local).val();
    var proposta_item_quantidade = $('.proposta_item_quantidade_' + local).val();
    var desconto_matricula = $('.desconto_matricula_' + local).val();
    var proposta_item_parcelamento_id = $('.proposta_item_parcelamento_id_' + local).val();
    var proposta_entrada = $('.proposta_entrada_' + local).val();
    var proposta_data_entrada = $('.proposta_data_entrada_' + local).val();
    var proposta_dia_vencimento = $('.proposta_dia_vencimento_' + local).val();
    var proposta_data_primeiro_vencimento = $('.proposta_data_primeiro_vencimento_' + local).val();

    $('#getCodeModalDetalhesItens').modal('show');

    setTimeout(function () {
        $(".nome_item_modal").val(nome_produto);
        $(".valor_unitario_item_modal").val(proposta_item_valor_unitario);
        $(".quantidade_item_modal").val(proposta_item_quantidade);
        $(".valor_total_item_modal").val(proposta_item_valor_total);
        $(".valor_entrada_item_modal").val(proposta_entrada);
        $(".data_entrada_item_modal").val(proposta_data_entrada);
        $(".data_primeiro_vencimento_item_modal").val(proposta_data_primeiro_vencimento);
        $(".table_atual_item_modal").val(local);

        if(pedido_item_tipo == 1){
            $(".div_display_none").css("display", "none");
            $(".div_display_none_modalidade").css("display", "block");
        } else {
            $(".div_display_none").css("display", "block");
            $(".div_display_none_modalidade").css("display", "none");
        }

        $(".desconto_item_modal").val(desconto_matricula);
        $(".forma_parcelamento_item_modal").val(proposta_item_parcelamento_id);
        $(".dia_vencimento_item_modal").val(proposta_dia_vencimento);

    }, 200);

});

$('#table_modal_alunos_geral').on('check.bs.table', function (e, row) {

    $('#ocorrencia_pessoa_id').val(row.id);
    $('#txt_aluno_geral').val(row.nome);
    $('#getCodeAlunosModalGeral').modal('hide');
});

$('#table_modal_funcionarios_geral').on('check.bs.table', function (e, row) {

    $('#ocorrencia_encaminha_id').val(row.id);
    $('#txt_encaminha_geral').val(row.nome);
    $('#getCodeEncaminharModalGeral').modal('hide');
});

$("#table_turma_dash").on('click', ".j_abrir_modal_ocorrencia", function () {

    var id = $(this).attr('rel');

    $(".list_ocorrencia_remover").remove();

    $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', {action: 'buscarOcorrencia', ocorrencia_id: id}, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {

            $(".append_ocorrencia").append(data.success)

        }
    }, 'json');


    $("#abrirOcorrenciasGeralDescricao").modal('show');

});
$(".dropdown-menu-right").on('click', ".j_abrir_modal_ocorrencia", function () {

    var id = $(this).attr('rel');

    $(".list_ocorrencia_remover").remove();

    $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', {action: 'buscarOcorrencia', ocorrencia_id: id}, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {

            $(".append_ocorrencia").append(data.success)

        }
    }, 'json');


    $("#abrirOcorrenciasGeralDescricao").modal('show');

    return false;

});

$("#abrirOcorrenciasGeralDescricao").on('click', ".j_altera_status_ocorrencia", function () {

    var id = $(this).attr('rel');
    var status = $(this).attr('data-status');

    $.post(base + '_ajax/Crm/Ocorrencia.ajax.php', {action: 'alteraStatusOcorrencia', ocorrencia_id: id, status: status}, function (data) {

        if (data.error) {
            swal({
                title: "Opps!",
                text: data.error,
                icon: "error",
                button: "Ok!",
            });
        }

        if (data.success) {

            $('#table_turma_dash').bootstrapTable('refreshOptions', {
                showColumns: false,
                search: false,
                showRefresh: false,
                url: base + "_ajax/dashboard/ListOcorrencias.ajax.php?action=list"
            });

            swal({
                title: "Bom trabalho!",
                text: data.success,
                icon: "success",
                button: "Ok!",
            });


            $("#abrirOcorrenciasGeralDescricao").modal('hide');

        }
    }, 'json');


    $("#abrirOcorrenciasGeralDescricao").modal('show');

});