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
                                        <input type="text" name="nombrecomercial" id="nombrecomercial" class="form-control form-control-lg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                     <label class="col-sm-3 col-form-label cont-label" for="NCR">Número de Registro de Contribuyente</label> 
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
                                    <label for="departamento" class="col-sm-3 col-form-label cont-label">Departamentos</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="departamento">
                                            <option class="text-center"> Eliga un departamento </option>
                                            @foreach ($departments as $depart)
                                            <option value="{{$depart['Id']}}">{{$depart['Nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr class="mx-n3">
                                <div class="form-group row">
                                    <label for="municipio" class="col-sm-3 col-form-label cont-label">Municipio</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="municipio">
                                            <option class="text-center"> Eliga un Municipio </option>
                                            <option value="Ahuachapán">Ahuachapán</option>
                                            <option value="Apaneca">Apaneca</option>
                                            <option value="Atiquizaya">Atiquizaya</option>
                                            <option value="Concepción de Ataco">Concepción de Ataco</option>
                                            <option value="El Refugio">El Refugio</option>
                                            <option value="Guaymango">Guaymango</option>
                                            <option value="Jujutla">Jujutla</option>
                                            <option value="San Francisco Menéndez">San Francisco Menéndez</option>
                                            <option value="San Lorenzo">San Lorenzo</option>
                                            <option value="San Pedro Puxtla">San Pedro Puxtla</option>
                                            <option value="Tacuba">Tacuba</option>
                                            <option value="Turín">Turín</option>
                                            <option value="Cinquera">Cinquera</option>
                                            <option value="Dolores">Dolores</option>
                                            <option value="Guacotecti">Guacotecti</option>
                                            <option value="Ilobasco">Ilobasco</option>
                                            <option value="Jutiapa">Jutiapa</option>
                                            <option value="San Isidro">San Isidro</option>
                                            <option value="Sensuntepeque">Sensuntepeque</option>
                                            <option value="Tejutepeque">Tejutepeque</option>
                                            <option value="Victoria">Victoria</option>
                                            <option value="Agua Caliente">Agua Caliente</option>
                                            <option value="Arcatao">Arcatao</option>
                                            <option value="Azacualpa">Azacualpa</option>
                                            <option value="Chalatenango">Chalatenango</option>
                                            <option value="Citalá">Citalá</option>
                                            <option value="Comalapa">Comalapa</option>
                                            <option value="Concepción Quezaltepeque">Concepción Quezaltepeque</option>
                                            <option value="Dulce Nombre de María">Dulce Nombre de María</option>
                                            <option value="El Carrizal">El Carrizal</option>
                                            <option value="El Paraíso">El Paraíso</option>
                                            <option value="La Laguna">La Laguna</option>
                                            <option value="La Palma">La Palma</option>
                                            <option value="La Reina">La Reina</option>
                                            <option value="Las Vueltas">Las Vueltas</option>
                                            <option value="Nombre de Jesús">Nombre de Jesús</option>
                                            <option value="Nueva Concepción">Nueva Concepción</option>
                                            <option value="Nueva Trinidad">Nueva Trinidad</option>
                                            <option value="Ojos de Agua">Ojos de Agua</option>
                                            <option value="Potonico">Potonico</option>
                                            <option value="San Antonio de la Cruz">San Antonio de la Cruz</option>
                                            <option value="San Antonio Los Ranchos">San Antonio Los Ranchos</option>
                                            <option value="San Fernando">San Fernando</option>
                                            <option value="San Francisco Lempa">San Francisco Lempa</option>
                                            <option value="San Francisco Morazán">San Francisco Morazán</option>
                                            <option value="San Ignacio">San Ignacio</option>
                                            <option value="San Isidro Labrador">San Isidro Labrador</option>
                                            <option value="San José Cancasque">San José Cancasque</option>
                                            <option value="San José Las Flores">San José Las Flores</option>
                                            <option value="San Luis del Carmen">San Luis del Carmen</option>
                                            <option value="San Miguel de Mercedes">San Miguel de Mercedes</option>
                                            <option value="San Rafael">San Rafael</option>
                                            <option value="Santa Rita">Santa Rita</option>
                                            <option value="Tejutla">Tejutla</option>
                                            <option value="Candelaria">Candelaria</option>
                                            <option value="Cojutepeque">Cojutepeque</option>
                                            <option value="El Carmen">El Carmen</option>
                                            <option value="El Rosario">El Rosario</option>
                                            <option value="Monte San Juan">Monte San Juan</option>
                                            <option value="Oratorio de Concepción">Oratorio de Concepción</option>
                                            <option value="San Bartolomé Perulapía">San Bartolomé Perulapía</option>
                                            <option value="San Cristóbal">San Cristóbal</option>
                                            <option value="San José Guayabal">San José Guayabal</option>
                                            <option value="San Pedro Perulapán">San Pedro Perulapán</option>
                                            <option value="San Rafael Cedros">San Rafael Cedros</option>
                                            <option value="San Ramón">San Ramón</option>
                                            <option value="Santa Cruz Analquito">Santa Cruz Analquito</option>
                                            <option value="Santa Cruz Michapa">Santa Cruz Michapa</option>
                                            <option value="Suchitoto">Suchitoto</option>
                                            <option value="Tenancingo">Tenancingo</option>
                                            <option value="Antiguo Cuscatlán">Antiguo Cuscatlán</option>
                                            <option value="Chiltiupán">Chiltiupán</option>
                                            <option value="Ciudad Arce">Ciudad Arce</option>
                                            <option value="Colón">Colón</option>
                                            <option value="Comasagua">Comasagua</option>
                                            <option value="Huizúcar">Huizúcar</option>
                                            <option value="Jayaque">Jayaque</option>
                                            <option value="Jicalapa">Jicalapa</option>
                                            <option value="La Libertad">La Libertad</option>
                                            <option value="Nuevo Cuscatlán">Nuevo Cuscatlán</option>
                                            <option value="Quezaltepeque">Quezaltepeque</option>
                                            <option value="Sacacoyo">Sacacoyo</option>
                                            <option value="San José Villanueva">San José Villanueva</option>
                                            <option value="San Juan Opico">San Juan Opico</option>
                                            <option value="San Matías">San Matías</option>
                                            <option value="San Pablo Tacachico">San Pablo Tacachico</option>
                                            <option value="Talnique">Talnique</option>
                                            <option value="Tamanique">Tamanique</option>
                                            <option value="Teotepeque">Teotepeque</option>
                                            <option value="Tepecoyo">Tepecoyo</option>
                                            <option value="Zaragoza">Zaragoza</option>
                                            <option value="Cuyultitán">Cuyultitán</option>
                                            <option value="El Rosario">El Rosario</option>
                                            <option value="Jerusalén">Jerusalén</option>
                                            <option value="Mercedes La Ceiba">Mercedes La Ceiba</option>
                                            <option value="Olocuilta">Olocuilta</option>
                                            <option value="Paraíso de Osorio">Paraíso de Osorio</option>
                                            <option value="San Antonio Masahuat">San Antonio Masahuat</option>
                                            <option value="San Emigdio">San Emigdio</option>
                                            <option value="San Francisco Chinameca">San Francisco Chinameca</option>
                                            <option value="San Juan Nonualco">San Juan Nonualco</option>
                                            <option value="San Juan Talpa">San Juan Talpa</option>
                                            <option value="San Juan Tepezontes">San Juan Tepezontes</option>
                                            <option value="San Luis La Herradura">San Luis La Herradura</option>
                                            <option value="San Luis Talpa">San Luis Talpa</option>
                                            <option value="San Miguel Tepezontes">San Miguel Tepezontes</option>
                                            <option value="San Pedro Masahuat">San Pedro Masahuat</option>
                                            <option value="San Pedro Nonualco">San Pedro Nonualco</option>
                                            <option value="San Rafael Obrajuelo">San Rafael Obrajuelo</option>
                                            <option value="Santa María Ostuma">Santa María Ostuma</option>
                                            <option value="Santiago Nonualco">Santiago Nonualco</option>
                                            <option value="Tapalhuaca">Tapalhuaca</option>
                                            <option value="Zacatecoluca">Zacatecoluca</option>
                                            <option value="Anamorós">Anamorós</option>
                                            <option value="Bolívar">Bolívar</option>
                                            <option value="Concepción de Oriente">Concepción de Oriente</option>
                                            <option value="Conchagua">Conchagua</option>
                                            <option value="El Carmen">El Carmen</option>
                                            <option value="El Sauce">El Sauce</option>
                                            <option value="Intipucá">Intipucá</option>
                                            <option value="La Unión">La Unión</option>
                                            <option value="Lislique">Lislique</option>
                                            <option value="Meanguera del Golfo">Meanguera del Golfo</option>
                                            <option value="Nueva Esparta">Nueva Esparta</option>
                                            <option value="Pasaquina">Pasaquina</option>
                                            <option value="Polorós">Polorós</option>
                                            <option value="San Alejo">San Alejo</option>
                                            <option value="San José">San José</option>
                                            <option value="Santa Rosa de Lima">Santa Rosa de Lima</option>
                                            <option value="Yayantique">Yayantique</option>
                                            <option value="Yucuaiquín">Yucuaiquín</option>
                                            <option value="Arambala">Arambala</option>
                                            <option value="Cacaopera">Cacaopera</option>
                                            <option value="Chilanga">Chilanga</option>
                                            <option value="Corinto">Corinto</option>
                                            <option value="Delicias de Concepción">Delicias de Concepción</option>
                                            <option value="El Divisadero">El Divisadero</option>
                                            <option value="El Rosario">El Rosario</option>
                                            <option value="Gualococti">Gualococti</option>
                                            <option value="Guatajiagua">Guatajiagua</option>
                                            <option value="Joateca">Joateca</option>
                                            <option value="Jocoro">Jocoro</option>
                                            <option value="Jocoaitique">Jocoaitique</option>
                                            <option value="Meanguera">Meanguera</option>
                                            <option value="Osicala">Osicala</option>
                                            <option value="Perquín">Perquín</option>
                                            <option value="San Carlos">San Carlos</option>
                                            <option value="San Fernando">San Fernando</option>
                                            <option value="San Francisco Gotera">San Francisco Gotera</option>
                                            <option value="San Isidro">San Isidro</option>
                                            <option value="San Simón">San Simón</option>
                                            <option value="Sensembra">Sensembra</option>
                                            <option value="Sociedad">Sociedad</option>
                                            <option value="Torola">Torola</option>
                                            <option value="Yamabal">Yamabal</option>
                                            <option value="Yoloaiquín">Yoloaiquín</option>
                                            <option value="Carolina">Carolina</option>
                                            <option value="Chapeltique">Chapeltique</option>
                                            <option value="Chinameca">Chinameca</option>
                                            <option value="Chirilagua">Chirilagua</option>
                                            <option value="Ciudad Barrios">Ciudad Barrios</option>
                                            <option value="Comacarán">Comacarán</option>
                                            <option value="El Tránsito">El Tránsito</option>
                                            <option value="Lolotique">Lolotique</option>
                                            <option value="Moncagua">Moncagua</option>
                                            <option value="Nueva Guadalupe">Nueva Guadalupe</option>
                                            <option value="Nuevo Edén de San Juan">Nuevo Edén de San Juan</option>
                                            <option value="Quelepa">Quelepa</option>
                                            <option value="San Antonio">San Antonio</option>
                                            <option value="San Gerardo">San Gerardo</option>
                                            <option value="San Jorge">San Jorge</option>
                                            <option value="San Luis de la Reina">San Luis de la Reina</option>
                                            <option value="San Miguel">San Miguel</option>
                                            <option value="San Rafael Oriente">San Rafael Oriente</option>
                                            <option value="Ses">Sesori</option>
                                            <option value="Uluazapa">Uluazapa</option>
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
                    {{-- @forelse ($emisores as $emisor) --}}
                        <tr>
                                <th>{{--{{ $emisor['nombre'] }}--}}</th> 
                                <th> {{--{{ $emisor['actividad'] }}--}}</th> 
                                <th>{{--{{ $emisor['nit'] }}--}}</th> 
                                <th> {{--{{ $emisor['correo'] }}--}}</th> 
                                <th> {{--{{ $emisor['telefono'] }}--}}</th> 
                            <th>
                                <input type="button" value="Modificar" data-bs-toggle="modal"
                                   data-bs-target="#modal_modificar {{-- {{ $emisor['telefono'] }}--}}" class="btn btn-success"> 
                                <input type="button" value="Eliminar" data-bs-toggle="modal"
                                    data-bs-target="#modal_eliminar{{-- {{ $emisor['telefono'] }}--}}" class="btn btn-danger">
                            </th>

                        </tr>

                        @include('emisor_modificar')
                        @include('emisor_eliminar')

                    {{-- @empty --}}
                        <th colspan="6">Sin datos</th>
                    {{-- @endforelse --}}
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
