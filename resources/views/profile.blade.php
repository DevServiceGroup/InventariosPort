@extends('adminlte::page')

@section('title', 'Agenda')

@section('content')

    <div class="row d-flex justify-content-center">
        <div class="col-md-4 mt-4">
            <div class="card h-100">
                <div class="card-body text-center flex-column">
                    <div
                        style="position: absolute; top: 125px; right: 90px; background-color: #f0f0f0; padding: 4px; border-radius: 50%; width: 33px; height: 33px;">
                        {{-- <label for="image" style="cursor: pointer;">
                        <img src=" " style="width: 25px; height: 25px;">
                    </label> --}}
                    </div>
                    <img src=" {{ asset('img/noseempleado.png') }} "
                        class="rounded-circle img-thumbnail mb-3 border border-secondary" style="width: 150px; height: 150px;"
                        data-toggle="modal" data-target="#imgModal">
                    <h3> </h3>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Nombre</th>
                                <td class="text-nowrap">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Gmail</th>
                                <td class="text-nowrap">{{ $user->email }} </td>
                            </tr>
                            <tr>
                                <th>Rol</th>
                                <td class="text-nowrap">{{ $user->rol }} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-5 mt-4">
            <div class="card h-100">
                <div class="card-body">
                    <form action="{{ route('admin.profile.update', ['profile' => $user->id]) }}" method="post">
                        @csrf
                        @method('put')
                        {{-- @method('put') --}}
                        <h3>Actualizar datos</h3>
                        {{-- <div>
                            <input type="file" name="image" id="image" style="display: none">
                        </div> --}}
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="name" class="form-control" maxlength="255">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Gmail:</label>
                            <input type="email" id="email" name="email" class="form-control" maxlength="255">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Contraseña:</label>
                            <input type="password" name="password" class="form-control" maxlength="255">
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label for="documento">Documento:</label>
                            <input type="text" name="document" class="form-control" id="document">
                        </div> --}}
                        <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imgModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src=" " style="max-width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('actualizada') == 'ok')
        <script>
            Swal.fire({
                title: "Actualizado!",
                text: "El usuario se actualizo correctamente!",
                icon: "success"
            });
        </script>
    @endif
@endsection
