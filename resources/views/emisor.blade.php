@extends('layouts.app')

@section('content')
    <div class="container-md p-5 cont">
        <div class="cont-p">
        <h1 class="title-1">Emisores</h1>
        <div class="cont-2">
            <button type="button" class="btn btn-info button-addem" onclick="cambiarSeccion(2)" id="emisor-button"
                style="font-size: 1.2rem; font-weight:bold;">Registrar</button>
        </div>
        <form action="guardaremisor" method="post">
            @csrf
            <div class="mt-3" id="divisiones">
                <div class="d-none" id="emisorSection">
                    <h2 class="title-2">Ingresar Emisor</h2>
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="emisor-nombre" class="col-sm-3 col-form-label cont-label">Nombre</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">    
                                <div class="form-group row">
                                    <label for="nombrecomercial" class="col-sm-3 col-form-label cont-label">Nombre comercial</label>    
                                    <div class="col-sm-9">
                                        <input type="text" name="nombrecomercial" id="nombrecomercial" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">   
                                <div class="form-group row">
                                     <label for="actividad" class="col-sm-3 col-form-label cont-label">Actividad</label>
                                     <div class="col-sm-9">
                                      <select class="form-control" name="actividad">
                                        <option value="1">Actividad</option>
                                        <option value="2">datos</option>
                                        <option value="3">datos</option>
                                        <option value="4">datos</option>
                                      </select>  
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                     <label class="col-sm-3 col-form-label cont-label" for="NCR">NCR</label> 
                                     <div class="col-sm-9">
                                        <input type="text" name="NRC" id="NRC" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                     </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label cont-label" for="NIT">NIT</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nit" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="departamento" class="col-sm-3 col-form-label cont-label">Departamento</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="departamento">
                                            <option value="1">Departamento</option>
                                            <option value="2">datos</option>
                                            <option value="3">datos</option>
                                            <option value="4">datos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="municipio" class="col-sm-3 col-form-label cont-label">Municipio</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="municipio">
                                            <option value="1">Municipio</option>
                                            <option value="2">datos</option>
                                            <option value="3">datos</option>
                                            <option value="4">datos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="complemento" class="col-sm-3 col-form-label cont-label">Complemento</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="complemento">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="telefono" class="col-sm-3 col-form-label cont-label">Telefono</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="telefono">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="correo" class="col-sm-3 col-form-label cont-label">Correo Electronico</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="correo">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="px-5 py-4 text-center">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-lg">ENVIAR</button>
                                  </div>        
                             </div>
                         </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-6">
                            <select class="form-control" name="actividad">
                                <option value="1">Actividad</option>
                                <option value="2">datos</option>
                                <option value="3">datos</option>
                                <option value="4">datos</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NCR</span>
                                <input type="text" name="NRC" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">NIT</span>
                                <input type="text" name="nit" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>

                    <div class="row ">
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
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Complemento</span>
                                <input type="text" complemento class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">telefono</span>
                                <input type="text" name="telefono" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Correo</span>
                                <input type="text" name="correo" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-default">
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="ms-3 btn btn-primary">Guardar</button> --}}
                    <!-- fin emisor section -->
                </div>
            </div>
        </form>
        <div class="table-container">
        <div class="table-wrappers-em">
            <table class="flam-table">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Actividad</th>
                    <th>NIT</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($emisores as $emisor)
                        <tr>
                            <th>{{ $emisor['nombre'] }}</th>
                            <th>{{ $emisor['actividad'] }}</th>
                            <th>{{ $emisor['nit'] }}</th>
                            <th>{{ $emisor['correo'] }}</th>
                            <th>{{ $emisor['telefono'] }}</th>
                            <th>
                                <input type="button" value="Modificar" data-bs-toggle="modal"
                                    data-bs-target="#modal_modificar{{ $emisor['telefono'] }}" class="btn btn-success">
                                <input type="button" value="Eliminar" data-bs-toggle="modal"
                                    data-bs-target="#modal_eliminar{{ $emisor['telefono'] }}" class="btn btn-danger">
                            </th>

                        </tr>

                        @include('emisor_modificar')
                        @include('emisor_eliminar')

                    @empty
                        <th>Sin datos</th>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection
