$.validator.addMethod("validarDominio", function(value, element) {
    return this.optional( element ) || /^[a-zA-Z0-9.]+$/.test( value );
}, 'Informe um subdomínio válido.');

function domainExists() {
    var subdomain = $("#subdomain").val();

    $.ajax({
        url: '/tenants/verify-domain',
        type: 'get',
        dataType: 'json',
        data: {subdomain: subdomain},

        beforeSend: function () {
            $('.form_load').css('display', 'flex');
        },

        success: function (result) {
            if (result == 'false') {
                $('#domainexists').html('Domínio disponível')
                $('.form_load').fadeOut(500);
                return false
            } else {
                $('#domainexists').html('Domínio indisponível')
                $('.form_load').fadeOut(500);
                return true
            }
        }
    })
}

$(document).ready(function () {
    $("#cellphone").mask("(00) 0000-00009");
    $("#cpf").mask('000.000.000-00', {reverse: true});

    $('#formRegister').each(function () {
        $(this).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },

                cellphone: {
                    required: true,
                    maxlength: 15
                },

                cpf: {
                    required: true,
                    cpfBR: true
                },

                oab: {
                    required: true,
                    maxlength: 8,
                    number: true
                },

                uf_oab: {
                    required: true,
                    maxlength: 2,
                },

                qtd_processes: {
                    required: true,
                },

                email: {
                    required: true,
                    email: true
                },

                email_confirmation: {
                    required: true,
                    email: true
                },

                subdomain: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    validarDominio: true
                }
            },

            submitHandler: function (form) {
                form.submit();
            }
        })

    });


    $("#subdomain").change(function () {
        if ($(this).val())
            domainExists();
    });

});
