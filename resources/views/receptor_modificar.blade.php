<div class="modal fade bd-example-modal-lg" id="modal_modificar{{ $receptor['Id'] }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        <label for="recipient-name" class="col-form-label" style="color:black;">Nombre del
                            Receptor:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $receptor['Nombre'] }}"
                            >
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Tipo de
                            Documento:</label>
                        {{-- @php 
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
                
                {{ Form::select('tipodocumento', $opciones, $receptor['Tipo Documento'], ['class' => 'form-select', 'id'=>'Tipo Documento'])}} --}}
                        <select class="form-control" name="tipodocumento">
                            <option value="FE">Factura Electrónica</option>
                            <option value="CCE">Comprobante de Crédito Fiscal. Electrónico</option>
                            <option value="NR">Nota de Remisión Electrónico</option>
                            <option value="NC">Nota de Crédito Electrónico</option>
                            <option value="ND">Nota de Débito Electrónico</option>
                            <option value="CR">Comprobante de Retención Electrónico</option>
                            <option value="CL">Comprobante de Liquidación Electrónico</option>
                            <option value="DCLE">Documento Contable de Liquidación Electrónico</option>
                            <option value="FEE">Factura de Exportación Electrónica</option>
                            <option value="FSE">Factura de Sujeto Excluido Electrónica</option>
                            <option value="CD">Comprobante de Donación Electrónico</option>
                        </select>
                        @error('tipodocumento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Numero de
                            Documento:</label>
                        <input type="text" name="ndocumento" class="form-control"
                            value="{{ $receptor['Num Documento'] }}" >
                        @error('ndocumento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">NRC:</label>
                        <input type="text" name="nrc" class="form-control" value="{{ $receptor['NRC'] }}"
                            >
                        @error('nrc')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Departamento:</label>
                        <select class="form-control" name="departamento" id="departamento">
                            <option class="text-center"> Elige un departamento </option>
                            @foreach ($departments as $depart)
                                <option value="{{ $depart['Id'] }}"
                                    {{ $depart['Id'] == $receptor['Departamento'] ? 'selected' : '' }}>
                                    {{ $depart['Nombre'] }}</option>
                            @endforeach
                        </select>
                        @error('departamento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Municipio:</label>
                        <select class="form-control" name="municipio">
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
                        <input type="text" name="complemento" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$receptor['Complemento']}}">
                        @error('complemento')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Actividad Economica:</label>
                        <input type="text" name="actividadecono" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$receptor['Actividad Economica']}}">
                        @error('actividadecono')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Télefono:</label>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="telefono" pattern="\+503 [267][0-9]{3}-[0-9]{4}" value="{{$receptor['Telefono']}}">
                        @error('telefono')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>  
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" style="color:black;">Correo Electronico:</label>
                        <input type="text" name="correo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{$receptor['Correo']}}">
                        @error('correo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>    
                    <input type="hidden" value="{{ $receptor['Id'] }}" name="idreceptor">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar Emisor</button>

                    </div>

            </form>

        </div>
    </div>
</div>


<!-- Large modal -->
