$(document).ready(function() {
    $('#tabela').DataTable({
        "processing": true,
        "serverSide": true,

        "ajax": {
            url: "/tenants/plans",
        },

        "columns": [
            {data: "id"},
            {data: "description"},
            {data: "price"},
            {data: "state_paypal"},
            {
                data: 'action',
                orderable: false
            }
        ],


        paging: true,
        searching: true,
        ordering: true,
        dom: 'Bfrtip',
        stateSave: true,


        buttons: [
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i>',
                titleAttr: 'Copiar',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i>',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],

        language: {
            sProcessing: "Processando...",
            sLengthMenu: "Mostrar MENU registos",
            sZeroRecords: "Não foram encontrados resultados",
            sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registos",
            sInfoEmpty: "Mostrando de 0 até 0 de 0 registos",
            sInfoFiltered: "(filtrado de _MAX_ registos no total)",
            sInfoPostFix: "",
            sSearch: "Procurar:",
            sUrl: "",
            oPaginate: {
                sFirst: "Primeiro",
                sPrevious: "Anterior",
                sNext: "Seguinte",
                sLast: "Último",
            },
            buttons: {
                colvis: 'Selecionar colunas',
                copyTitle: 'Copiar',
                copySuccess: {
                    1: "Copiado 1 linha para área de transferência",
                    _: "Copiado %d linhas para área de transferência"
                }
            }
        }
    })
})
