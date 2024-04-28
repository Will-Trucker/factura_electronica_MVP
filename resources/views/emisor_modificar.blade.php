


<div class="modal fade bd-example-modal-lg" id="modal_modificar{{ $emisor['telefono'] }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" style="color: black; text-align:center;">
                Actualizar datos de Emisor
            </h6>
            </div>
      <form method="POST" action="modificaremisor">
        @csrf

        <div class="modal-body" id="cont-modal">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del Emisor:</label>
                <input type="text"  name="name" class="form-control" value="{{ $emisor['nombre']}}" required="true">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Actividad:</label>
                <input type="text" name="actividad" class="form-control" value="{{ $emisor['actividad']}}" required="true">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">NIT:</label>
                <input type="text" name="nit" class="form-control" value="{{ $emisor['nit']}}" required="true">
            </div>  
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Correo Electronico:</label>
                <input type="email" name="email" class="form-control" value="{{ $emisor['correo']}}" required="true">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Telefono:</label>
                <input type="tel" name="phone" class="form-control" value="{{ $emisor['telefono']}}" required="true">
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


<!-- Large modal -->


