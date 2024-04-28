


<div class="modal fade bd-example-modal-lg" id="modal_eliminar{{ $emisor['telefono'] }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" style="color: black; text-align:center;">
                Eliminar emisor.
            </h6>
            </div>
      <form method="POST" action="eliminaremisor">
       
      
        @csrf

        <div class="modal-body" id="cont-modal">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:red;" ><b>Estas a punto de eliminar el registro de {{ $emisor['nombre'] }}, ¿Estas seguro que quieres continuar? </b></label>
               
            </div>
            <input type="hidden" value="{{$emisor['id']}}" name="idemisor">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>

    </form>
      
    
  </div>
</div>


<!-- Large modal -->


