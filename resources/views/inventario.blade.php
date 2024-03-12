@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inventarios</h1>
@stop

@section('content')
    <div class="card">
        <h2 class="card-title ml-4 mt-4">Productos</h2>
        <div class="card-body">
            <div class="card-text m-2">
                <div class="row">

                    <div class="col-6 mb-4">
                        <label for="selectMonth">Seleccionar Mes:</label>
                        <input type="month" id="selectMonth" class="form-control">
                    </div>
                    <div class="col-6 mb-4">
                        <label style="color: red" for="" id="carros_cantidad">
                        </label>
                    </div>
                </div>
                <table id="tablaProductos" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Ubicacion</th>
                            <th>Inventario</th>
                            <th>Linea</th>
                            <th>Color</th>
                            <th>Buque</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedMonth = ''; // Declarar la variable fuera del evento de cambio

            $('#selectMonth').change(function() {
                selectedMonth = $(this).val();
                console.log(selectedMonth);

                // Vuelve a cargar la tabla con el mes seleccionado
                $('#tablaProductos').DataTable().ajax.reload();
            });
            $('#tablaProductos').DataTable({
                "ajax": {
                    "url": "{{ route('datatable.productos') }}",
                    "data": function() {
                        return {
                            month: selectedMonth
                        };
                    }
                },
                // scrollX: true,
                // scrollY: 650,
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf'
                ],
                "columns": [{
                        data: "id"
                    },
                    {
                        data: "ubicacion"
                    },
                    {
                        data: "inventario"
                    },
                    {
                        data: "linea"
                    },
                    {
                        data: "color"
                    },
                    {
                        data: "buque"
                    },
                ]
            });
            $.ajax({
                url: "{{ route('datatable.cant_carros') }}",
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    if (Object.keys(data).length === 0) {
                        var empieza = "En este momento no tienes carros";
                    } else {
                        var empieza = "En este momento tienes:";
                        for (var key in data) {
                            if (data.hasOwnProperty(key)) {
                                var fieldName = key;
                                var fieldValue = data[key];
                                empieza += " " + fieldValue + " carros " + fieldName;
                            }
                        }
                    }
                    $("#carros_cantidad").append(empieza);
                    console.log(empieza);
                },
                error: function() {
                    alert('Error al cargar los detalles del movimiento.');
                }
            });
        });
    </script>
@stop
