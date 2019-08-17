var table;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
    dateEntry();
    SelectSeller();
    //Generate();
});


function Generate() {
    if($("#seller_id").val()== null){
        toastr.warning("Debe Seleccionar un Vendedor.");
    }
    else if($("#minimum_date").val()==0){
        toastr.warning("Debe Seleccionar una Fecha minima.");
    }
     else if($("#maximum_date").val()==0){
        toastr.warning("Debe seleccionar una Fecha Maxima.");
    }
    else{
        table = $('#table').DataTable({
            dom: 'lfBrtip',
            processing: true,
            serverSide: true,
            "paging": true,
            language: {
                "url": "/js/Spanish.json"
            },
            ajax: {
                url: '/getsellers',
                data: function (obj) {
                    obj.seller_id = $("#seller_id").val();
                    obj.minimum_date = $("#minimum_date").val();
                    obj.maximum_date = $("#maximum_date").val();
                   
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'date'
                },
                {
                    data: 'client_name'
                },
                {
                    data: 'total'
                },
                {
                    data: 'discount'
                },
                {
                    data: 'total_discount'
                },
            ],
            buttons: [
                {
                    text: '<i class="icon-eye"></i> ',
                    className: 'rounded btn-dark m-2',
                    titleAttr: 'Columnas',
                    extend: 'colvis'
                },
                {
                    text: '<i class="icon-download"></i><i class="icon-file-excel"></i>',
                    className: 'rounded btn-dark m-2',
                    titleAttr: 'Excel',
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
                    className: 'rounded btn-dark m-2',
                    titleAttr: 'PDF',
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    text: '<i class="icon-download"></i><i class="icon-print"></i> ',
                    className: 'rounded btn-dark m-2',
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                //btn Refresh
                {
                    text: '<i class="icon-arrows-cw"></i>',
                    className: 'rounded btn-info m-2',
                    action: function () {
                        table.ajax.reload();
                    }
                }
            ],
        });


    }
}


function ListDataTable() {
    
    table = $('#table').DataTable({
        dom: 'lfBrtip',
        processing: true,
        serverSide: true,
        "paging": true,
        language: {
            "url": "/js/Spanish.json"
        },
        ajax: {
            url: '../DataTableCatalogos',
            data: function (obj) {
                obj.id_tipo_catalogo = id_tipo_catalogo;
            }
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'nombre'
            },
            {
                data: 'estado'
            },
            {
                data: 'editar',
                orderable: false,
                searchable: false
            },
            {
                data: 'eliminar',
                orderable: false,
                searchable: false
            },
        ],
        buttons: [
            {
                text: '<i class="icon-eye"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Columnas',
                extend: 'colvis'
            },
            {
                text: '<i class="icon-download"></i><i class="icon-file-excel"></i>',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Excel',
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'PDF',
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-print"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Imprimir',
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            //btn Refresh
            {
                text: '<i class="icon-arrows-cw"></i>',
                className: 'rounded btn-info m-2',
                action: function () {
                    table.ajax.reload();
                }
            }
        ],
    });
};

function ListDatatable() {
    table = $('#table').DataTable({
        dom: 'lfBrtip',
        processing: true,
        serverSide: true,
        "paging": true,
        language: {
            "url": "/js/assets/Spanish.json"
        },
        ajax: {
            url: 'batch'

        },
        columns: [{
                data: 'id'
            },
            {
                data: 'code'
            },
            {
                data: 'sanitary_registration'
            },
            {
                data: 'product_name'
            },
            {
                data: 'wholesaler_price'
            },
            {
                data: 'stock'
            },
            { data: 'state',
            "render": function (data, type, row) {
                    if (row.state === 'ACTIVO') {
                        return '<center><p class="bg-success text-white"><b>ACTIVO</b></p></center>';
                    }
                    else if (row.state === 'INACTIVO') {          
                        return '<center><p class="bg-warning text-white"><b>INACTIVO</b></p></center>';
                    }
                    else if (row.state === 'ELIMINADO') {          
                        return '<center><p class="bg-danger text-white"><b>ELIMINADO</b></p></center>';
                    }
                }
            },
            {
                data: 'Detalle',
                orderable: false,
                searchable: false
            },
            {
                data: 'Editar',
                orderable: false,
                searchable: false
            },
            {
                data: 'Eliminar',
                orderable: false,
                searchable: false
            },
        ],
        buttons: [{
                text: '<i class="icon-eye"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Columnas',
                extend: 'colvis'
            },
            {
                text: '<i class="icon-download"></i><i class="icon-file-excel"></i>',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Excel',
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-file-pdf"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'PDF',
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                text: '<i class="icon-download"></i><i class="icon-print"></i> ',
                className: 'rounded btn-dark m-2',
                titleAttr: 'Imprimir',
                footer: true,
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            },
            //btn Refresh
            {
                text: '<i class="icon-arrows-cw"></i>',
                className: 'rounded btn-info m-2',
                action: function () {
                    table.ajax.reload();
                }
            }
        ],

        //Metodo para Sumar todos los stock
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                pageTotal +' ( '+ total +' total)'
            );
        }
    });
};








function SelectSeller() {
    $.ajax({
        url: "listseller",
        method: 'get',
        data: {
            by: "all"
        },
        success: function (result) {
            var code = '<select class="form-control border-primary" name="seller_id" id="seller_id" required>';
            $.each(result, function (key, value) {
                code += '<option selected value="' + value.id + '">' + value.name + '</option>';
                code += '<option disabled value="" selected>(Seleccionar)</option>';
            });
            code += '</select>';
            $("#select_seller").html(code);
        },
        error: function (result) {
            toastr.error(result.msg + ' CONTACTE A SU PROVEEDOR POR FAVOR.');
            console.log(result);
        },

    });
}
//fecha de entrada
function dateEntry() {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker({
            useCurrent: false
        });
        $("#datetimepicker1").on("change.datetimepicker", function (e) {
            $('#datetimepicker2').datetimepicker('minDate', e.date);
        });
        $("#datetimepicker2").on("change.datetimepicker", function (e) {
            $('#datetimepicker1').datetimepicker('maxDate', e.date);
        });
}