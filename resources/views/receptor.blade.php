@extends('layouts.app')

@section('content')

    <div class="container-md p-5 cont">
        <div class="max-w-md mx-auto" style="margin-top: 4rem">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong class="font-bold">Error</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="cont-p">
            <h1 class="title-1">Receptor</h1>
            <div class="cont-2">
                <button type="button" class="btn btn-info" onclick="cambiarSeccion(3)" id="receptor-button"
                    style="font-weight: bold; font-size: 1rem;">Registrar</button>
            </div>
            <form action="{{ route('storeRe') }}" method="post">
                @csrf
                <div class="mt-3" id="divisiones">
                    <div class="d-none" id="receptorSection">
                        <h2 class="title-2">Ingresar Receptor</h2>
                        <div class="row">
                            <div class="col">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="receptor-nombre"
                                            class="col-sm-3 col-form-label cont-label">Nombre</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nombre" id="nombre"
                                                class="form-control form-control-lg" aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            @error('nombre')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-tipodocumento" class="col-sm-3 col-form-label cont-label">Tipo
                                            de documento</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-lg" name="tipodocumento">
                                                <option class="text-center">Eliga un tipo de DTE a generar</option>
                                                @foreach ($tipos as $tipo)
                                                <option value="{{$tipo['codigoTipoDocumento']}}">{{$tipo['nombreTipoDocumento']}}</option>
                                                @endforeach
                                            </select>
                                            @error('tipodocumento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-ndocumento" class="col-sm-3 col-form-label cont-label">N°
                                            documento</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="ndocumento" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            @error('ndocumento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-nit" class="col-sm-3 col-form-label cont-label">NIT</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nit" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            @error('nit')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-nrc" class="col-sm-3 col-form-label cont-label">NRC</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nrc" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            @error('nrc')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-departamento"
                                            class="col-sm-3 col-form-label cont-label">Departamento</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-lg" name="departamento">
                                                <option class="text-center"> Elige un departamento </option>
                                                @foreach ($departments as $depart)
                                                <option value="{{$depart['id']}}">{{$depart['nombreDepartamento']}}</option>
                                                @endforeach
                                            </select>
                                            @error('departamento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-municipio"
                                            class="col-sm-3 col-form-label cont-label">Municipio</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-lg" name="municipio">
                                                <option class="text-center"> Elige un Municipio </option>
                                                @foreach ($municipios as $municipio)
                                                <option value="{{$municipio['idMunicipio']}}">{{$municipio['nombreMunicipio']}}</option>
                                                @endforeach
                                            </select>
                                            @error('municipio')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-complemento"
                                            class="col-sm-3 col-form-label cont-label">Complemento</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="complemento" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default">
                                            @error('complemento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="receptor-complemento"
                                            class="col-sm-3 col-form-label cont-label">Actividad Económica</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-lg" name="actividadecono">
                                                <option class="text-center"> Elige una Actividad Económica </option>
                                                @foreach ($actividades as $actividad)
                                                <option value="{{$actividad['id']}}">{{$actividad['nombreGiro']}}</option>
                                                @endforeach
                                            </select>
                                            @error('actividadecono')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-3 col-form-label cont-label">Teléfono</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default" name="telefono"
                                                pattern="\+503 [267][0-9]{3}-[0-9]{4}" value="{{ old('telefono') }}">
                                            @error('telefono')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="correo" class="col-sm-3 col-form-label cont-label">Correo</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="correo" class="form-control form-control-lg"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default" value="{{ old('correo') }}">
                                            @error('correo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="px-5 py-4 text-center">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-danger btn-lg">ENVIAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                <input type="text" name="nombre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text"  id="inputGroup-sizing-default">Tipo de Documento</span>
                                <input type="text" name="tipodocumento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                        <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">N° documento</span>
                                <input type="text" name="ndocumento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NRC</span>
                                <input type="text" name="nrc" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="departamento">
                                <option value="1">Departamento</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="municipio">
                                <option value="1">Municipio</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                <input type="text" name="complemento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="ms-3 btn btn-primary">Guardar</button> --}}
                    <!-- fin receptor section -->
                </div>
        </div>
        </form>
        <div class="table-container">
            <div class="table-wrappers-em">
                <table class="flam-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo documento</th>
                            <th>NRC</th>
                            <th>Departamento</th>
                            <th>Municipio</th>
                            <th>Actividad Economica</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($receptores as $receptor)
                            <tr>
                                <th>{{ $receptor->Nombre }}</th>
                                <th>{{ $receptor->tipos->nombreTipoDocumento }}</th>
                                <th>{{ $receptor->NRC }}</th>
                                <th>{{ $receptor->departamento->nombreDepartamento }}</th>
                                <th>{{ $receptor->municipio->nombreMunicipio }}</th>
                                <th>{{ $receptor->actividades->nombreGiro }}</th>
                                <th>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modifyModal{{$receptor->id}}">Modificar</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$receptor->id}}">Eliminar</button>
                                    </th>
                            </tr>

                    <!-- Include Modify Modal -->
                    @include('receptor_modificar', ['receptor' => $receptor])

                    <!-- Include Delete Modal -->
                    @include('receptor_eliminar', ['receptor' => $receptor])
                        @empty
                        <th colspan="10">Sin datos</th>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endsection
