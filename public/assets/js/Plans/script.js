function reset() {
    $("#toggleCSS").attr("href", "alertify.default.css");

    alertify.set({
        labels: {
            ok: "Sim",
            cancel: "Não"
        },
        delay: 5000,
        buttonReverse: true,
        buttonFocus: "ok"
    });
}

function deletaAjax(obj, id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/tenants/delete-plan-detail',
        type: 'post',
        dataType: 'json',
        data: {
            id: id
        },

        beforeSend: function () {
            $('.form_load').css('display', 'flex');
        },

        success: function (json) {
            $('.form_load').fadeOut(500);

            if (json.result == 'true') {
                $(obj).closest('tr').remove();
                alertify.success('Registro excluído com sucesso!')
            } else {
                alertify.error('Falha ao excluir o registro!')
            }
        }
    })
}


function generatePayPal(id) {
    $.ajax({
        url: '/tenants/paypal/generate',
        type: 'get',
        dataType: 'json',
        data: {
            id: id
        },

        beforeSend: function () {
            $('.input-group .form_load').css('display', 'flex');
        },

        success: function (json) {
            $('.input-group .form_load').fadeOut(500);

             if (json.success == true) {
                $('#key_paypal').val(json.id)
                $('#state_paypal').val(json.state)

            } else {
                alertify.error('Falha ao criar a chave do paypal')
            }
        }
    })
}


function removeDetail(obj) {
    reset();

    alertify.confirm("Deseja excluir o registro selecionado?", function (e) {
        if (e) {
            var id = $(obj).closest('tr').attr('data-id');

            if (id <= 0) {
                $(obj).closest('tr').remove();
                alertify.success('Registro excluído com sucesso!')

            } else if (id > 0) {
                deletaAjax(obj, id);
            }
        }
    })
}


$(document).ready(function () {
    $("#btnKeyPayPal").on('click', function (e) {
        e.preventDefault();

        id = $(this).attr('data-id');

        generatePayPal(id)
    })

    var count = 0;

    $('#add_details').on('click', function () {
        var detalhe = $('#detail').val();

        var tr =
            '<tr data-id ="' + count + '">' +
            '<td>' +
            '<input type="hidden" name="details[' + count + '][id]"  value="' + count + '"> ' +
            '<input class="form-control" type="text" name="details[' + count + '][description]" value="' + detalhe + '" >' +
            '</td>' +

            '<td>' +
            '<a class="btn btn-danger" href="javascript:;" onclick="removeDetail(this)">Excluir</a>' +
            '</td>' +
            '</tr>';

        if (detalhe.trim() || '')
            $('#details_table').append(tr);

        count--;

        $('#detail').val('').focus();

    })

    //deleta registro mestre
    $('.j_delete').on('click', function (e) {
        e.preventDefault();

        reset();

        alertify.confirm("Deseja excluir o registro selecionado?", function (e) {
            if (e) {
              $('#formDelete').submit();
            }

        })
    })


})
