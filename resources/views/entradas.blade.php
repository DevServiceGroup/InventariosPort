@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4>Entrada de Productos</h4>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab1">Ingresos Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab2">Ingresar Posiciones</a>
                </li>
                {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab3">Tab 3</a>
                    </li> --}}
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active m-auto" id="tab1">
                <h2 class="card-title ml-4 mt-4">Ingreso</h2>
                <div class="card-body">
                    <div class="card-text">
                        <form action="{{ route('admin.entradas.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row m-2">
                                <div class="form-group col-6">
                                    <label for="">Seleccione el Archivo</label>
                                    <input type="file" class="form-control" name="archivo" id="" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">¿Todos los vehiculos tienen la misma posicion ?</label>
                                    <select name="" id="varios" class="form-control">
                                        <option value="" disabled selected></option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <div class="form-group col-6" style="display: none" id="unico">
                                    <label for="">Indique la posicion</label>
                                    <input type="text" name="unico" id="unico" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="" style="color: red">Deacuerdo a esta informacion realizaremos el
                                        proceso de
                                        ingreso y de inventario</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success col-6">Subir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab2">
                <h5 class="card-title ml-4 mt-4">Ubicaciones</h5>
                <div class="card-body">
                    <div class="card-text">
                        <form action="{{route('admin.entradas.store')}}" method="post">
                            @csrf
                            <div class="row m-2">
                                <div class="form-group col-6">
                                    <label for="">Indique numero de inventario Inicial</label>
                                    <input type="text" name="num_inicial" id="" class="form-control" placeholder=""
                                        aria-describedby="helpId">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Indique numero de inventario Final</label>
                                    <input type="text" name="num_final" id="" class="form-control" placeholder=""
                                        aria-describedby="helpId">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Digite la Ubicacion</label>
                                    <input type="text" name="ubi" id="" class="form-control" placeholder=""
                                        aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success col-6">Asignar Ubicacion</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <h2 class="card-title ml-4 mt-4">Registro de Entradas</h2>
        <div class="card-body">
            <div class="m-2">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Cantidad Vehiculos</th>
                            <th>Motonave</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->id }}</td>
                                <td>{{ $movimiento->created_at }}</td>
                                <td>{{ $movimiento->cant_carros }}</td>
                                <td>{{ $movimiento->motonave }}</td>
                                <td><button type="button" class="btn btn-primary abrir-modal"
                                        data-url="{{ route('datatable.verdetalles', ['id' => $movimiento->id]) }}"
                                        data-detallemovimiento-id="{{ $movimiento->id }}">
                                        Ver
                                    </button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>


    <div id="miModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Contenido del modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalles</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table id="cosas" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ubicacion</th>
                                <th>Inventario</th>
                                <th>Linea</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody id="detallesMovimientoTableBody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén referencias a los elementos después de que el DOM esté listo
            var seleccion = document.getElementById('varios');
            var varios = document.getElementById('unico');

            // Escucha el evento de cambio en el elemento 'varios'
            seleccion.addEventListener('change', function() {
                // Realiza la lógica condicional después de obtener las referencias
                if (seleccion.value === 'SI') {
                    varios.style.display = 'block';
                } else {
                    varios.style.display = 'none'; // Otra opción si deseas ocultarlo en caso contrario
                }
            });
        });
    </script>
    <script>
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: [{
                        extend: 'pdfHtml5',
                        download: 'open'
                    }]
                }
            }
        });


        $(document).ready(function() {
            $('.abrir-modal').on('click', function() {
                var movimientoId = $(this).data('detallemovimiento-id');
                var url = $(this).data('url');

                // Realizar una solicitud AJAX para obtener los detalles del movimiento
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);

                        // Limpiar el contenido actual de la tabla
                        $('#detallesMovimientoTableBody').empty();
                        $('#cosas').DataTable().destroy();

                        // Verificar si data es un array
                        if (Array.isArray(data)) {
                            // Iterar sobre cada objeto en el array y agregar una fila a la tabla por cada objeto
                            data.forEach(function(detalleMovimiento) {
                                var fila = '<tr><td>' + detalleMovimiento.ubicacion +
                                    '</td><td>' + detalleMovimiento.inventario +
                                    '</td><td>' + detalleMovimiento.linea +
                                    '</td><td>' + detalleMovimiento.color +
                                    '</td></tr>';

                                $('#detallesMovimientoTableBody').append(fila);
                            });
                        } else {
                            // Agregar una sola fila a la tabla
                            var fila = '<tr><td>' + data.ubicacion +
                                '</td><td>' + data.inventario +
                                '</td><td>' + data.linea +
                                '</td><td>' + data.color + '</td></tr>';

                            $('#detallesMovimientoTableBody').append(fila);
                        }

                        // Mostrar el modal
                        $('#miModal').modal('show');

                        // Inicializar DataTable después de cargar los datos
                        new DataTable('#cosas', {
                            layout: {
                                topStart: {
                                    buttons: [{
                                        extend: 'pdfHtml5',
                                        download: 'open'
                                    }]
                                }
                            }
                        });
                    },
                    error: function() {
                        alert('Error al cargar los detalles del movimiento.');
                    }
                });
            });
        });
    </script>

    @if (session('duplicado') == 'si')
        <script>
            Swal.fire({
                title: "Error!",
                text: "Alguna registro ya existe!",
                icon: "error"
            });
        </script>
    @endif
    @if (session('error') == 'no')
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Los registros se guardaron con exito!",
                icon: "success"
            });
        </script>
    @endif
    @if (session('error') == 'si')
        <script>
            Swal.fire({
                title: "Error!",
                text: "Por favor verifica los datos!",
                icon: "error"
            });
        </script>
    @endif
@stop
