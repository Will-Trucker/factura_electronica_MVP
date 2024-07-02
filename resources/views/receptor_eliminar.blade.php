<div class="modal fade bd-example-modal-lg" id="modal_eliminar{{ $receptor['NRC'] }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" style="color: black; text-align:center;">
                    Eliminar emisor
                </h6>
            </div>
            <form method="POST" action="{{ route('eliminar_receptor') }}">
                @csrf
                <div class="modal-body" id="cont-modal">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Desea eliminar el Emisor:
                            <b>{{ $receptor['Nombre'] }} </b>¿Estás seguro de la acción a realizar? </label>
                    </div>
                    <input type="hidden" value="{{ $receptor['id'] }}" name="idreceptor">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>

        </div>
    </div>
</div>
