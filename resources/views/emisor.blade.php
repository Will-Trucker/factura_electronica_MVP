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
            <h1 class="title-1">Emisores</h1>
            <div class="cont-2">
                <button type="button" class="btn btn-info button-addem" onclick="cambiarSeccion(2)" id="emisor-button"
                    style="font-size: 1.2rem; font-weight:bold;">Registrar</button>
            </div>
            <form action="{{route('storeEm')}}" method="post">
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
                                            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('nombre')}}">
                                            @error('nombre')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">    
                                    <div class="form-group row">
                                        <label for="nombrecomercial" class="col-sm-3 col-form-label cont-label">Nombre comercial</label>    
                                        <div class="col-sm-9">
                                            <input type="text" name="nombrecomercial" id="nombrecomercial" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('nombrecomercial')}}">
                                            @error('nombrecomercial')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">   
                                    <div class="form-group row">
                                        <label for="actividad" class="col-sm-3 col-form-label cont-label">Actividad</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="actividad" id="actividad" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('actividad')}}">
                                            @error('actividad')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label cont-label" for="NCR">Número de Registro de Contribuyente</label> 
                                        <div class="col-sm-9">
                                            <input type="text" name="NRC" id="NRC" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('NRC')}}">
                                            @error('NRC')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label cont-label" for="NIT">NIT</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nit" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('nit')}}">
                                            @error('nit')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="departamento" class="col-sm-3 col-form-label cont-label">Departamentos</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="departamento" id="departamento">
                                                <option class="text-center"> Elige un departamento </option>
                                                @foreach ($departments as $depart)
                                                <option value="{{$depart['Id']}}">{{$depart['Nombre']}}</option>
                                                @endforeach
                                            </select>
                                            @error('departamento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="municipio" class="col-sm-3 col-form-label cont-label">Municipio</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="municipio" id="municipio">
                                                <option class="text-center"> Elige un Municipio </option>
                                                <option value="01">Aguilares</option>
                                                <option value="02">Apopa</option>
                                                <option value="03">Ayutuxtepeque</option>
                                                <option value="04">Cuscatancingo</option>
                                                <option value="05">Delgado</option>
                                                <option value="06">El Paisnal</option>
                                                <option value="07">Guazapa</option>
                                                <option value="08">Ilopango</option>
                                                <option value="09">Mejicanos</option>
                                                <option value="10">Nejapa</option>
                                                <option value="11">Panchimalco</option>
                                                <option value="12">Rosario de Mora</option>
                                                <option value="13">San Marcos</option>
                                                <option value="14">San Martín</option>
                                                <option value="15">San Salvador</option>
                                                <option value="16">Santiago Texacuangos</option>
                                                <option value="17">Santo Tomás</option>
                                                <option value="18">Soyapango</option>
                                                <option value="19">Tonacatepeque</option>
                                            </select>
                                            @error('municipio')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="complemento" class="col-sm-3 col-form-label cont-label">Complemento</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="complemento" id="complemento" cols="20" rows="3" class="form-control form-control-lg" value="{{old('complemento')}}">
                                            @error('complemento')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-3 col-form-label cont-label">Teléfono</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="telefono" pattern="\+503 [267][0-9]{3}-[0-9]{4}" value="{{old('telefono')}}">
                                            @error('telefono')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="form-group row">
                                        <label for="correo" class="col-sm-3 col-form-label cont-label">Correo</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="correo" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{old('correo')}}">
                                            @error('correo')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="mx-n3">
                                    <div class="px-5 py-4 text-center">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-lg">ENVIAR</button>
                                      </div>        
                                 </div>
                             </div>
                        </div>
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
                                <th>{{ $emisor['Nombre'] }}</th> 
                                <th> {{ $emisor['Actividad Economica'] }}</th> 
                                <th>{{ $emisor['NIT'] }}</th> 
                                <th> {{ $emisor['Correo'] }}</th> 
                                <th> {{ $emisor['Telefono'] }}</th> 
                            <th>
                                <input type="button" value="Modificar" data-bs-toggle="modal" data-bs-target="#modal_modificar{{ $emisor['Id'] }}" class="btn btn-success"> 
                                {{-- <input type="button" value="Eliminar" data-bs-toggle="modal" data-bs-target="#modal_eliminar{{ $emisor['Id'] }}" class="btn btn-danger">  --}}
                            
                            </th>

                        </tr>

                        @include('emisor_modificar')
                        {{-- @include('emisor_eliminar') --}}

                    @empty
                        <th colspan="6">Sin datos</th>
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

