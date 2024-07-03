<div class="modal fade" id="modifyModal{{$receptor->id}}" tabindex="-1" aria-labelledby="modifyModalLabel{{$receptor->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" style="color: black; text-align:center;">
                    Actualizar datos del Receptor
                </h6>
            </div>
            <form method="POST" action="{{ route('modificar_receptor', $receptor['id']) }}">
                @csrf
                @method('PUT')
                <div class="modal-body" id="cont-modal">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del
                            Receptor:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $receptor['Nombre'] }}">
                        @error('nombre')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Tipo de
                            Documento:</label>
                        <select class="form-control" name="tipodocumento">
                            <option class="text-center">Eliga un tipo de DTE a generar</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{$tipo['codigoTipoDocumento']}}" {{$receptor['TipoDocumento'] == $tipo['codigoTipoDocumento'] ? 'selected' : ''}}>{{$tipo['nombreTipoDocumento']}}</option>
                            @endforeach
                        </select>
                        @error('tipodocumento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Numero de
                            Documento:</label>
                        <input type="text" name="ndocumento" class="form-control"
                            value="{{ $receptor['NumDocumento'] }}">
                        @error('ndocumento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">NRC:</label>
                        <input type="text" name="nit" class="form-control" value="{{ $receptor['NIT'] }}">
                        @error('nit')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">NRC:</label>
                        <input type="text" name="nrc" class="form-control" value="{{ $receptor['NRC'] }}">
                        @error('nrc')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Departamento:</label>
                        <select class="form-control" name="departamento" id="departamento">
                            <option class="text-center"> Elige un departamento </option>
                            @foreach ($departments as $depart)
                                <option value="{{$depart['id']}}" {{$receptor['idDepartamento'] == $depart['id'] ? 'selected' : ''}}>{{$depart['nombreDepartamento']}}</option>
                            @endforeach
                        </select>
                        @error('departamento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Municipio:</label>
                        <select class="form-control" name="municipio" id="municipio">
                            <option class="text-center"> Elige un Municipio </option>
                            @foreach ($municipios as $municipio)
                            <option value="{{$municipio['idMunicipio']}}" {{$receptor['idMunicipio'] == $municipio['idMunicipio'] ? 'selected' : ''}}>{{$municipio['nombreMunicipio']}}</option>
                            @endforeach
                        </select>
                        @error('municipio')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Complemento:</label>
                        <input type="text" name="complemento" class="form-control" value="{{$receptor['Complemento']}}">
                        @error('complemento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Actividad Economica:</label>
                        <select class="form-control" name="actividadecono" id="actividad">
                            <option class="text-center"> Elige una Actividad Económica </option>
                            @foreach ($actividades as $actividad)
                            <option value="{{$actividad['id']}}" {{$receptor['idActividadEconomica'] == $actividad['id'] ? 'selected' : ''}}>{{$actividad['nombreGiro']}}</option>
                            @endforeach
                        </select>
                        @error('actividadecono')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Télefono:</label>
                        <input type="text" class="form-control" name="telefono" pattern="\+503 [267][0-9]{3}-[0-9]{4}" value="{{$receptor['Telefono']}}">
                        @error('telefono')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>  
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Correo Electronico:</label>
                        <input type="text" name="correo" class="form-control" value="{{$receptor['Correo']}}">
                        @error('correo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>    
                    <input type="hidden" value="{{ $receptor['id'] }}" name="idreceptor">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar Emisor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
