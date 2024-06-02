
<div class="modal fade bd-example-modal-lg" id="modal_modificar{{$emisor['Id']}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del Emisor:</label>
                <input type="text"  name="nombre" class="form-control" value="{{ $emisor['Nombre']}}" >
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Actividad Economica:</label>
                <input type="text"  name="nombrecomercial" class="form-control" value="{{ $emisor['Actividad Economica']}}" >
                @error('nombrecomercial')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre Comercial:</label>
                <input type="text" name="actividad" class="form-control" value="{{ $emisor['Nombre Comercial']}}" >
                @error('actividad')
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
                    <option value="{{$depart['Id']}}" {{$depart['Id'] == $emisor['Departamento'] ?  'selected' : '' }}>{{$depart['Nombre']}}</option>
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
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Complemento:</label>
                <input type="text" name="complemento" class="form-control" value="{{ $emisor['Complemento']}}" >
                @error('complemento')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" value="{{$emisor['Id']}}" name="idemisor">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-primary">Modificar Emisor</button>
            
        </div>

    </form>
      
</div>
  </div>
</div>
