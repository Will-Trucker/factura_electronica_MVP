<!-- receptor_eliminar.blade.php -->

<div class="modal fade" id="deleteModal{{$receptor->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$receptor->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" style="color: black; text-align:center;">
                    Eliminar Receptor
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
