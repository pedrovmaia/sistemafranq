$(function () {

    var $TABLE = $('.table_parcelas');
    var numero = 0;

    $('.table-add').click(function (e) {
        e.preventDefault();
        numero++;
        $('.quantidade_parcelas').val(numero);
        var $clone = "<tr><td class='pt-3-half'><input type='text' name='id_"+numero+"' placeholder='Nº do titulo' class='form-control'></td>";
        $clone += "<td class='pt-3-half'><input type='text' name='parcela_"+numero+"' placeholder='Parcela' class='form-control'></td>";
        $clone += "<td class='pt-3-half'><input type='date' name='vencimento_"+numero+"' placeholder='Data vencimento' class='form-control'></td>";
        $clone += "<td class='pt-3-half'><input type='date' name='pagamento_"+numero+"' placeholder='Data pagamento' class='form-control'></td>";
        $clone += "<td class='pt-3-half'><input type='number' step='0.01' min='0' name='valor_"+numero+"' placeholder='Valor' class='form-control dinheiro'></td>";
        $clone += "<td><span class='table-remove'><button type='button' class='btn btn-danger btn-rounded btn-sm my-0'><i class='material-icons'>clear</i></button></span></td></tr>";
                                
        $TABLE.append($clone);
    });

    $('.table_parcelas').on('click', '.table-remove', function () {
        $(this).parents('tr').detach();
    });

    /*$('.table-up').click(function () {
        var $row = $(this).parents('tr');
        if ($row.index() === 1) return; // Don't go above the header
        $row.prev().before($row.get(0));
    });

    $('.table-down').click(function () {
        var $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });*/


    var $TABLEFORMAPAGAMENTOENTRADAMATRICULA = $('.table_forma_pagamento_entrada_matricula');
    var numero_entrada_matricula = 0;

    $('.table_entrada_itens_matricula_add').click(function (e) {
        e.preventDefault();
        numero_entrada_matricula = $('.quantidade_entrada_itens_matricula').val();
        numero_entrada_matricula++;
        $('.quantidade_entrada_itens_matricula').val(numero_entrada_matricula);

        $.post(base + '_ajax/pedido/Matricula.ajax.php', {callback: 'Matricula', action: 'infos_parcelas', numero: numero_entrada_matricula}, function (data) {

            if (data.error) {
                trigger(data.error);
            }

            if (data.success) {
                $TABLEFORMAPAGAMENTOENTRADAMATRICULA.append(data.success);
                $('.formMoney').mask('#.##0,00', {reverse: true});
                $(".formDate").mask("99/99/9999");
                $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
            }
        }, 'json');

    });

    $TABLEFORMAPAGAMENTOENTRADAMATRICULA.on('click', '.table-remove', function () {
        $(this).parents('tr').detach();
    });
  

  
});