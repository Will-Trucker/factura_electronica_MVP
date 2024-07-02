
<div class="modal fade bd-example-modal-lg" id="modal_modificar{{$emisor['id']}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" style="color: black; text-align:center;">
                Actualizar datos de Emisor
            </h6>
            </div>
      <form method="POST" action="{{route('modificar_emisor')}}">
        @csrf

        <div class="modal-body" id="cont-modal">
            @method('PUT')
            <input type="hidden" name="idemisor" value="{{ $emisor->id }}">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del Emisor:</label>
                <input type="text"  name="nombre" class="form-control" value="{{ $emisor['Nombre']}}" >
                @error('nombre')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Actividad Economica:</label>
                <select class="form-control" name="actividad" id="actividad">
                    <option class="text-center"> Elige una Actividad Económica </option>
                    @foreach ($actividades as $actividad)
                    <option value="{{$actividad['id']}}" {{$emisor['idActividadEconomica'] == $actividad['id'] ? 'selected' : ''}}>{{$actividad['nombreGiro']}}</option>
                    @endforeach
                </select>
                @error('nombrecomercial')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre Comercial:</label>
                <input type="text" name="nombrecomercial" class="form-control" value="{{ $emisor['NombreComercial']}}" >
                @error('nombrecomercial')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">NIT:</label>
                <input type="text" name="nit" class="form-control" value="{{ $emisor['NIT']}}" >
                @error('nit')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>  
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">NRC:</label>
                <input type="text" name="NRC" class="form-control" value="{{ $emisor['NRC']}}" >
                @error('NRC')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>  
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Correo Electronico:</label>
                <input type="email" name="correo" class="form-control" value="{{ $emisor['Correo']}}" >
                @error('correo')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Telefono:</label>
                <input type="tel" name="telefono" class="form-control" value="{{ $emisor['Telefono']}}" >
                @error('telefono')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Departamento:</label>
                <select class="form-control" name="departamento" id="departamento">
                    <option class="text-center"> Elige un departamento </option>
                    @foreach ($departments as $depart)
                        <option value="{{$depart['id']}}" {{$emisor['idDepartamento'] == $depart['id'] ? 'selected' : ''}}>{{$depart['nombreDepartamento']}}</option>
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
                        <option value="{{$municipio['idMunicipio']}}" {{$emisor['idMunicipio'] == $municipio['idMunicipio'] ? 'selected' : ''}}>{{$municipio['nombreMunicipio']}}</option>
                        @endforeach
                    </select>
                    @error('municipio')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Complemento:</label>
                <input type="text" name="complemento" class="form-control" value="{{ $emisor['Complemento']}}" >
                @error('complemento')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" value="{{$emisor['id']}}" name="idemisor">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-primary">Modificar Emisor</button>
            
        </div>

    </form>
      
</div>
  </div>
</div>
