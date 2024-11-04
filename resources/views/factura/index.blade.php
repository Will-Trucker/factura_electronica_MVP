@extends('layouts.app')

@section('content')
    <center>
        <h1 class="justify-center text-white" style="margin-top: 3rem;font-size:2rem;">Facturacion</h1>
    </center>
    @if (session('descError'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Error!</span> {{ session('descError') }}
        </div>
    @endif

    @if (session('observaciones'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Observaciones!</span> {{ session('observaciones') }}
        </div>
    @endif
    <form action="{{ route('guardarFactura') }}" method="post">
        @csrf
        <input type="hidden" name="totalLetras" id="totalLetras" value='cero'>
        <div class="flex space-x-3 mb-4 factura-cont justify-center">
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(0)" id="tipodoc-button">Tipo de documento</button>
            <button type="button"
                class="hidden bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(1)" id="token-button">Token</button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(2)" id="emisor-button">Emisor</button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(3)" id="receptor-button">Receptor</button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(4)" id="description-button">Detalle</button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded"
                onclick="cambiarSeccion(5)" id="enviar-button">Enviar</button>
        </div>

        <div id="divisiones">
            <div id="tipodocsection" class="hidden">
                <div class="mb-4 flex justify-center">
                    <div class="w-full max-w-md p-4 rounded-lg" style="margin-top: 3rem;">
                        <label for="tipoDocumento" class="block text-white text-center" style="font-size:1.2rem;">Seleccione
                            un Documento Tributario Electrónico</label>
                        <br>
                        <select
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            name="tipoDeDocumento" id="tipoDocumento" onchange="cambiarTipoDoc()">
                            <option value="FE" class="bg-activo" selected>Factura</option>
                            <option value="CCFE" class="bg-activo">Comprobante de Crédito Fiscal</option>
                            <option value="NRE">Nota de Remisión</option>
                            <option value="NCE">Nota de Crédito</option>
                            <option value="NDE">Nota de Débito</option>
                            <option value="CRE">Comprobante de Retención</option>
                            <option value="CLE">Comprobante de Liquidación</option>
                            <option value="DCLE">Documento Contable de Liquidación</option>
                            <option value="FEXE" class="bg-activo">Factura de Exportación</option>
                            <option value="FSEE" class="bg-activo">Factura de Sujeto Excluido</option>
                            <option value="CDE">Comprobante de Donación</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="tokenSection" class="hidden" style="margin-top: 3rem;">
                <h2 class="text-center mb-4 text-white" style="font-size:1.4rem;">Token</h2>
                <div class="flex justify-center">
                    <div class="w-full max-w-md p-4 rounded-lg">
                        <div class="mb-4">
                            <label for="nit" class="block text-white" style="font-size:1.2rem;">NIT</label>
                            <input type="text" id="nit" name="nit"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                aria-label="NIT">
                        </div>
                        <hr class="my-4">
                        <div class="mb-4">
                            <label for="clave" class="block text-white" style="font-size:1.2rem;">Contraseña</label>
                            <input type="text" id="clave" name="clave"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                aria-label="Contraseña">
                        </div>
                        <hr class="my-4">
                        <div class="mb-4">
                            <label for="apikey" class="block text-white" style="font-size:1.2rem;">API Key</label>
                            <textarea name="apikey" id="apikey" cols="10" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-center">
                            <button type="button"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                onclick="cambiarSeccion(2)">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden" id="emisorSection" style="margin-top: 3rem;">
                <h2 class="text-center mb-4 text-white" style="font-size:1.4rem;">Emisor</h2>
                <div class="flex justify-center">
                    <div class="w-full max-w-md p-4 rounded-lg">
                        <div class="mb-4">
                            <label for="emisor" class="block text-white" style="font-size:1.2rem;">Selecciona
                                Emisor</label>
                            <select name="emisor"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="emisor" onBlur="traerEmisor()">
                                @foreach ($emisores as $emisor)
                                    <option value="{{ $emisor['id'] }}">{{ $emisor['Nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="emisor-nombre" class="block text-white" style="font-size:1.2rem;">Nombre</label>
                            <input name="emisornombre" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="emisorNombre" placeholder="Nombre del emisor" aria-label="Nombre del emisor">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="nombrecomercial" class="block text-white" style="font-size:1.2rem;">Nombre
                                comercial</label>
                            <input name="nombrecomercial" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="nombreComercial" placeholder="Nombre comercial" aria-label="Nombre comercial">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="actividad" class="block text-white" style="font-size:1.2rem;">Actividad</label>
                            <input name="actividademisor" id="actividademisor" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Actividad del emisor">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="NIT" class="block text-white" style="font-size:1.2rem;">NIT</label>
                            <input name="emisornit" id="emisornit" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="NIT del emisor">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="NRC" class="block text-white" style="font-size:1.2rem;">NRC</label>
                            <input name="emisornrc" id="emisornrc" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="NRC del emisor">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="departamento" class="block text-white"
                                style="font-size:1.2rem;">Departamentos</label>
                            <input name="emisordepartamento" id="emisordepartamento" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Departamento">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="municipio" class="block text-white" style="font-size:1.2rem;">Municipio</label>
                            <input name="emisormunicipio" id="emisormunicipio" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Municipio">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="complemento" class="block text-white"
                                style="font-size:1.2rem;">Complemento</label>
                            <input name="complemento" id="complemento" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Complemento">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="telefono" class="block text-white" style="font-size:1.2rem;">Teléfono</label>
                            <input name="emisortelefono" id="emisortelefono" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Teléfono">
                        </div>
                        <hr class="my-4">
                        <div class="form-group mb-4">
                            <label for="correo" class="block text-white" style="font-size:1.2rem;">Correo</label>
                            <input name="emisorcorreo" id="emisorcorreo" type="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Correo electrónico" style="text-transform:none;">
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-center">
                            <button type="button"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                onclick="cambiarSeccion(3)">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
        <div id="receptorSection" class="hidden" style="margin-top: 3rem;">
            <h2 class="text-center mb-4 text-white" style="font-size:1.4rem;">Receptor</h2>
            <div class="flex justify-center">
                <div class="w-full max-w-md p-4 rounded-lg">
                    <div class="mb-4">
                        <label for="receptor" class="block text-white" style="font-size:1.2rem;">Selecciona
                            Receptor</label>
                        <select name="receptor"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            id="receptor" onblur="traerReceptor()">
                            @foreach ($receptores as $receptor)
                                <option value="{{ $receptor['id'] }}">{{ $receptor['Nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptornombre" class="block text-white" style="font-size:1.2rem;">Nombre</label>
                        <input name="receptornombre" id="receptornombre" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nombre del receptor" aria-label="Nombre del receptor">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptorndocumento" class="block text-white" style="font-size:1.2rem;">N°
                            Documento</label>
                        <input name="receptorndocumento" id="receptorndocumento" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Número de documento">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptornrc" class="block text-white" style="font-size:1.2rem;">NRC</label>
                        <input name="receptornrc" id="receptornrc" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="NRC del receptor">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptortelefono" class="block text-white" style="font-size:1.2rem;">Teléfono</label>
                        <input name="receptortelefono" id="receptortelefono" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Teléfono">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptorcorreo" class="block text-white" style="font-size:1.2rem;">Correo</label>
                        <input name="receptorcorreo" id="receptorcorreo" type="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Correo electrónico" style="text-transform:none;">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptordepartamento" class="block text-white"
                            style="font-size:1.2rem;">Departamento</label>
                        <input name="receptordepartamento" id="receptordepartamento" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Departamento">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptormunicipio" class="block text-white"
                            style="font-size:1.2rem;">Municipio</label>
                        <input name="receptormunicipio" id="receptormunicipio" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Municipio">
                    </div>
                    <hr class="my-4">
                    <div class="form-group mb-4">
                        <label for="receptorcomplemento" class="block text-white"
                            style="font-size:1.2rem;">Complemento</label>
                        <input name="receptorcomplemento" id="receptorcomplemento" type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Complemento">
                    </div>
                    <div class="flex justify-center">
                        <button type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                            onclick="cambiarSeccion(4)">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div id="enviarSection" class="hidden">
            <h2 class="text-center mb-4 text-white text-2xl">Enviar</h2>
            <div class="flex justify-center">
                <button type="submit"
                    class="ms-3 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Guardar</button>
            </div>
        </div>
        <input type="hidden" name="detallesfactura" value="" id="detallesfactura">
    </form>
    <div class="flex justify-center mt-12">
        <div class="hidden" id="descripcionSection" style="width: 100%; max-width: 800px;">
            <div id="detallesnormal" class="p-4 ">
                <div class="flex justify-between mb-4">
                    <h2 class="text-white" style="font-size:2rem;">Descripción</h2>
                    <button onclick="agregarDetalle()"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">Agregar
                        detalle</button>
                </div>

                <!-- Primera Tabla -->
                <table class="min-w-full table-auto border border-gray-300 bg-white mb-4">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Cant</th>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Descripción</th>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Precio Unitario</th>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Ventas No Sujetas</th>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Ventas Excentas</th>
                            <th scope="col" class="border border-gray-300 px-4 py-2">Ventas Afectas</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDetalles">
                        @for ($i = 0; $i < 5; $i++)
                            <tr class="hover:bg-blue-100">
                                <th class="border border-gray-300 px-4 py-2">
                                    <input class="border rounded-md w-full p-1 cant" type="number"
                                        onblur="calcularVentas()" value="0" min="0">
                                </th>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="text" value="" onblur="calculoDetalles()"
                                        class="precios border rounded-md p-1">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" name="precio" class="border rounded-md w-full p-1 cant"
                                        onblur="calcularVentas()" value="0">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">0.0</td>
                                <td class="border border-gray-300 px-4 py-2">0.0</td>
                                <td class="border border-gray-300 px-4 py-2">0.0</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <!-- Segunda Tabla -->
                <table class="min-w-full table-auto border border-gray-300 bg-white w-full">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th rowspan="2" colspan="1" class="border border-gray-300 px-4 py-2"
                                id="letras">Son:</th>
                            <th class="border border-gray-300 px-4 py-2" rowspan="2">Sumas</th>
                            <th class="border border-gray-300 px-4 py-2">Venta Excenta</th>
                            <th class="border border-gray-300 px-4 py-2">Venta no sujeta</th>
                            <th class="border border-gray-300 px-4 py-2">Venta gravada</th>
                        </tr>
                        <tr>
                            <th id="vExcenta" class="border border-gray-300 px-4 py-2">$0</th>
                            <th id="vNosujeta" class="border border-gray-300 px-4 py-2">$0</th>
                            <th id="vGravada" class="border border-gray-300 px-4 py-2">$0</th>
                        </tr>
                    </thead>
                    <tbody style="text-align:right;">
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">13% IVA</th>
                            <th id="iva" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">SUB TOTAL</th>
                            <th id="subtotal" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">VENTA EXCENTA</th>
                            <th id="Vexcenta" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">VENTA NO SUJETAS</th>
                            <th id="Vnosujeta" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">SUB TOTAL</th>
                            <th id="subtotal2" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                        <tr class="hover:bg-green-100">
                            <th colspan="2" class="border border-gray-300 px-4 py-2"></th>
                            <th colspan="2" class="border border-gray-300 px-4 py-2">VENTA TOTAL</th>
                            <th id="total" class="border border-gray-300 px-4 py-2">0</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><br>
            <div class="flex justify-center">
                <button type="button"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                    onclick="cambiarSeccion(5)">Siguiente</button>
            </div>
        </div>
    </div>
@endsection
