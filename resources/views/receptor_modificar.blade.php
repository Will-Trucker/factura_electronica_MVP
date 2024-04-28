


<div class="modal fade bd-example-modal-lg" id="modal_modificar{{ $receptor['nrc'] }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" style="color: black; text-align:center;">
                Actualizar datos del Receptor
            </h6>
            </div>
      <form method="POST" action="modificarreceptor">
        @csrf

        <div class="modal-body" id="cont-modal">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del Receptor:</label>
                <input type="text"  name="name" class="form-control" value="{{ $receptor['nombre']}}" required="true">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">Tipo de Documento:</label>
                @php 
                use Collective\Html\FormFacade as Form;

                $opciones= array(
                                "FE"=> 'Factura Electrónica',
                                "CCE"=>'Comprobante de Crédito Fiscal. Electrónico',
                                "NR"=> 'Nota de Remisión Electrónico',
                                "NC"=> 'Nota de Crédito Electrónico.vv',
                                "ND"=> 'Nota de Débito Electrónico',
                                "CR"=> 'Comprobante de Retención Electrónico',
                                "CL"=> 'Comprobante de Liquidación Electrónico',
                                "DCLE"=>'Documento Contable de Liquidación Electrónico',
                                "FEE"=>'Factura de Exportación Electrónica',
                                "FSE"=>'Factura de Sujeto Excluido Electrónica',
                                "CD"=> 'Comprobante de Donación Electrónico'
                                );
                                
                @endphp
                
                {{ Form::select('tipodocumento', $opciones, $receptor['tipodocumento'], ['class' => 'form-select', 'id'=>'tipodocumento'])}}
                                
                           
                          
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label" style="color:black;">NRC:</label>
                <input type="text"  name="nrc" class="form-control" value="{{ $receptor['nrc']}}" required="true">
            </div>

            <input type="hidden" value="{{$receptor['id']}}" name="idreceptor">
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


