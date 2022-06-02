$(function () {

    var $TABLE = $('.table_centro_custo');
    var numero = $('.quantidade_centro_custo').val();
    var base = $('link[rel="base"]').attr('href') + "/";

    $('.table-centro-custo-add').click(function (e) {
        e.preventDefault();
        numero++;
        $('.quantidade_centro_custo').val(numero);

        $.post(base + '_ajax/financeiro/MovimentacaoPagamento.ajax.php', {callback: 'MovimentacaoPagamento', action: 'infos_centro_custo', numero: numero}, function (data) {

            if (data.error) {
                trigger(data.error);
            }

            if (data.success) {
               
                $TABLE.append(data.success);
                $("input.dinheiro").maskMoney({thousands: ".", decimal: ","});
                
            }
        }, 'json');
    });

    $('.table-up').click(function () {
        var $row = $(this).parents('tr');
        if ($row.index() === 1) return; // Don't go above the header
        $row.prev().before($row.get(0));
    });

    $('.table-down').click(function () {
        var $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });

  
});